<?php
require_once 'Controllers/activateBD.php';
require_once 'apostaClass.php';

session_start(); 
if (!isset($_SESSION['user_id'])) {
    header("Location: ./View/Login_page.html");
    exit;
}
$user_id = $_SESSION['user_id'];

$SQL = "SELECT * FROM bolao INNER join apostas on bolao.idBolao = apostas.idBolao where apostas.idUsuario = ? and bolao.status = 1 order by bolao.idBolao;";

$prepareSQL = $mySql->prepare($SQL);
#$user_id
$prepareSQL->bind_param("i", $user_id);

$executou = $prepareSQL->execute();

$matrizTuplas = $prepareSQL->get_result();

$vetorApostas = [];
$i = 0;

$pontuacaoFinal = 0;

while ($tupla = $matrizTuplas->fetch_object()) {
    $idBolao = $tupla->idBolao;
    echo "<h1>Bolão $idBolao</h1>";

    $vetorApostas[$i] = new Aposta();

    $vetorApostas[$i]->setVars($tupla->jogo1_resultado, $tupla->jogo2_resultado, $tupla->jogo3_resultado,
    $tupla->jogo1_previsao, $tupla->jogo2_previsao, $tupla->jogo3_previsao);
    $pontos = 0;

    for($a = 0; $a < 3; $a++){
        $pontosAtual = 0;
        $as = ($a + 1) . "_time1";
        $as2 = ($a + 1) . "_time2";
        $time1 = $tupla->{"jogo{$as}"};
        $time2 = $tupla->{"jogo{$as2}"};

        echo "<h2>$time1 x $time2</h2><h3>Resultado</h3><p>| ";
        for($b = 0; $b < 2; $b++){
            echo $vetorApostas[$i]->jogo_resultados[$a][$b]." | ";
        }
        echo "</p><br><h3>Aposta</h3>";

        echo "<p>| ";
        for($b = 0; $b < 2; $b++){
            echo $vetorApostas[$i]->jogo_apostas[$a][$b]." | ";
        }

        for($b = 0; $b < 2; $b++){
            if($vetorApostas[$i]->jogo_apostas[$a] == $vetorApostas[$i]->jogo_resultados[$a]){
                $pontosAtual = 10;
            }else if($vetorApostas[$i]->jogo_apostas[$a][2] == $vetorApostas[$i]->jogo_resultados[$a][2]){
                $pontosAtual = 5;
            }
        }

        echo "</p><br><h3>Pontuação Jogo</h3>";
        echo "$pontosAtual </p>";

        $pontos += $pontosAtual;

        echo "</p><br>";
    }
    echo "</p><br><h3>Pontuação Bolão</h3>";
    echo "$pontos </p><br>";

    $pontuacaoFinal += $pontos;

    $i++;
}
echo "<br><h2>PONTUAÇÃO TOTAL</h2><h3>$pontuacaoFinal</h3>";