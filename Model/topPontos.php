<?php 
require_once 'activateBD.php'; 
require_once 'apostaClass.php';

$username = "root";
$passwordData = "";
$database = "unibet";
$host = "127.0.0.1:3306";

$mySql = new mysqli($host, $username, $passwordData, $database);

if ($mySql->connect_error) {
    die("Connection failed: " . $mySql->connect_error);
}

$SQL = "SELECT * FROM bolao INNER JOIN apostas ON bolao.idBolao = apostas.idBolao WHERE bolao.status = 1 ORDER BY bolao.idBolao;";
$prepareSQL = $mySql->prepare($SQL);

if ($prepareSQL === false) {
    die("Prepare failed: " . $mySql->error);
}

$executou = $prepareSQL->execute();
if (!$executou) {
    die("Execute failed: " . $prepareSQL->error);
}

$matrizTuplas = $prepareSQL->get_result();
$pontuacoesUsuarios = [];

while ($tupla = $matrizTuplas->fetch_object()) {
    $idUsuario = $tupla->idUsuario;

    // Fetch user name if not already done
    if (!isset($pontuacoesUsuarios[$idUsuario])) {
        $SQL = "SELECT usuario_nome FROM informacao_do_login WHERE Id_usuario = ?";
        $prepareSQL = $mySql->prepare($SQL);
        $prepareSQL->bind_param("i", $idUsuario);
        $executou = $prepareSQL->execute();

        if (!$executou) {
            die("Execute failed: " . $prepareSQL->error);
        }

        $user = $prepareSQL->get_result()->fetch_object();
        $nomeUsuario = $user->usuario_nome;

        $pontuacoesUsuarios[$idUsuario] = [0, 0, $nomeUsuario]; // Initialize if new
    }

    $aposta = new Aposta();
    $aposta->setVars($tupla->jogo1_resultado, $tupla->jogo2_resultado, $tupla->jogo3_resultado,
                     $tupla->jogo1_previsao, $tupla->jogo2_previsao, $tupla->jogo3_previsao);
    $pontos = 0;

    for ($a = 0; $a < 3; $a++) {
        $pontosAtual = 0;
        if ($aposta->jogo_apostas[$a][0] == $aposta->jogo_resultados[$a][0] &&
            $aposta->jogo_apostas[$a][1] == $aposta->jogo_resultados[$a][1]) {
            $pontosAtual = 10;
            $pontuacoesUsuarios[$idUsuario][1]++;
        } else if ($aposta->jogo_apostas[$a][2] == $aposta->jogo_resultados[$a][2]) {
            $pontosAtual = 5;
        }

        $pontos += $pontosAtual;
    }
    $pontuacoesUsuarios[$idUsuario][0] += $pontos;
}

// Sort the scores
uasort($pontuacoesUsuarios, function($a, $b) {
    return $b[0] - $a[0]; // Sort by score
});

// Return the results as an array
return $pontuacoesUsuarios;
?>
