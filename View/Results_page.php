<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bolões</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional: add your CSS -->
</head>
<body>
    <?php 
    require_once "../Model/activateBD.php";
    require_once '../Model/apostaClass.php';

    session_start(); 
    if (!isset($_SESSION['user_id'])) {
        header("Location: ./View/Login_page.html");
        exit;
    }

    // Fetch all bolão entries
    $sql = "SELECT * FROM bolao WHERE status = 1";
    $result = $mySql->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_object()) {
            $idBolao = $row->idBolao;
            $sqlApostas = "SELECT * FROM apostas WHERE idBolao = ?";
            $prepareSQL = $mySql->prepare($sqlApostas);
            $prepareSQL->bind_param("i", $idBolao);
            $prepareSQL->execute();
            $matrizTuplas = $prepareSQL->get_result();

            // Display each bolão and associated apostas
            echo "<h2>Bolão ID: $idBolao</h2>";

            while ($tupla = $matrizTuplas->fetch_object()) {
                $idUsuario = $tupla->idUsuario;
                $userSQL = "SELECT usuario_nome FROM informacao_do_login WHERE Id_usuario = ?";
                $userPrepareSQL = $mySql->prepare($userSQL);
                $userPrepareSQL->bind_param("i", $idUsuario);
                $userPrepareSQL->execute();
                $user = $userPrepareSQL->get_result()->fetch_object();
                $nomeUsuario = $user->usuario_nome;

                echo "<h3>$nomeUsuario</h3>";

                $aposta = new Aposta();
                $aposta->setVars('0x0', '0x0', '0x0',
                                 $tupla->jogo1_previsao, $tupla->jogo2_previsao, $tupla->jogo3_previsao);
                
                $pontos = 0;

                for ($a = 0; $a < 3; $a++) {
                    $as = ($a + 1) . "_time1";
                    $as2 = ($a + 1) . "_time2";
                    $time1 = '0';
                    $time2 = '0';

                    echo "<h4>$time1 x $time2</h4>";
                    echo "<h5>Aposta</h5><p>| " . implode(" | ", $aposta->jogo_apostas[$a]) . " |</p>";

                    $pontosAtual = 0;
                    if ($aposta->jogo_apostas[$a] == $aposta->jogo_resultados[$a]) {
                        $pontosAtual = 10;
                    } else if ($aposta->jogo_apostas[$a][2] == $aposta->jogo_resultados[$a][2]) {
                        $pontosAtual = 5;
                    }

                    echo "<h5>Pontuação Jogo</h5><p>$pontosAtual</p>";
                    $pontos += $pontosAtual;
                }
                echo "<h4>Pontuação Bolão</h4><p>$pontos</p>";
            }
        }
    } else {
        echo "<p>Nenhum bolão disponível.</p>";
    }

    $mySql->close(); // Close the database connection
    ?>
</body>
</html>
