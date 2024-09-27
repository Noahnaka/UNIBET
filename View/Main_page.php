<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MENU | UNIBET</title>
    <link rel="icon" href="images/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/logo.png" alt="Logo">
        </div>
        <nav class="nav-buttons">
            <a href="#jogos-ao-vivo" class="btn-nav">Jogos ao Vivo</a>
            <a href="#placares-lideres" class="btn-nav">Placares Líderes</a>
            <a href="#sobre-nos" class="btn-nav">Como funciona</a>
        </nav>
        <div class="auth-buttons">
            <a href="Index.html" class="btn-auth">Registrar</a>
            <a href="Index.html" class="btn-auth">Login</a>
        </div>
    </header>

    <main>
        <section id="jogos-ao-vivo" class="jogos-ao-vivo">
            <section id="bolao" class="bolao">
                <?php
                require_once "../Model/activateBD.php";

                $sql = "SELECT * FROM bolao WHERE status = 0";
                $result = $mySql->query($sql);

                if ($result->num_rows > 0) {
                    echo "<fieldset>";
                    echo "<legend><b>Jogos ao vivo</b></legend>";
                    echo "<div class='live-games-container'>";
                    while($row = $result->fetch_assoc()) {
                        $dataFinalFormatada = date("d-M-Y H:i", strtotime($row["dataFinal"]));
                        echo "<div class='live-game'>";
                        echo "<div class='game-info'>";
                        echo "<h3>Bolão ID: " . $row["idBolao"] . "</h3>";
                        echo "<p><strong>Jogo 1:</strong> " . $row["jogo1_time1"] . " vs " . $row["jogo1_time2"] . "</p>";
                        echo "<p><strong>Jogo 2:</strong> " . $row["jogo2_time1"] . " vs " . $row["jogo2_time2"] . "</p>";
                        echo "<p><strong>Jogo 3:</strong> " . $row["jogo3_time1"] . " vs " . $row["jogo3_time2"] . "</p>";
                        echo "<p><strong>Data Final:</strong> " . $dataFinalFormatada . "</p>";
                        echo "<p><a class='vote-link' href='votar.php?idBolao=" . $row["idBolao"] . "'>Votar</a></p>";
                        echo "</div>";            
                        echo "</div>";
                    }
                    echo "</div>";
                    echo "</fieldset>";
                } else {
                    echo "<p>Não tem bolão disponível.</p>";
                }

                $mySql->close();
                ?>
            </section>
        </section>

        <section id="placares-lideres" class="placares-lideres">
    <h2>Placares Líderes</h2>
    <div class="ranking-container">
        <?php
        // Include the topPontos.php to get user scores
        $pontuacoesUsuarios = require '../Model/topPontos.php';

        // Limit to top 10 results
        $topScores = array_slice($pontuacoesUsuarios, 0, 10);

        foreach ($topScores as $idUsuario => $pontos) {
            echo "<div class='ranking-item'>";
            echo "<span class='ranking-position'>" . (array_search($idUsuario, array_keys($topScores)) + 1) . "º</span>";
            echo "<div class='ranking-info'>";
            echo "<h3>{$pontos[2]}</h3>";
            echo "<p>Pontos: {$pontos[0]} ({$pontos[1]} acertos exatos)</p>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
</section>


        <section id="sobre-nos" class="sobre-nos">
            <h2>Regras</h2>
            <div class="about-container">
                <div class="creator">
                    <div class="creator-info">
                        <h3>Pontos</h3>
                        <p>Time vencedor = 5 pontos<br>
                        Acertar pontuação = 5 pontos<br>
                        Empate = 0 pontos</p>
                    </div>
                </div>
                <div class="creator">
                    <div class="creator-info">
                        <h3>Empate</h3>
                        <p>Caso haja empate entre usuários de pontos, para determinar quem está acima do outro no leaderboard, o que <br> acertar mais placares inteiro terá a maior prioridade acima dos outros com o mesmo quantidade de ponto. E caso <br> haja empate disso, o número maior de placares acertados na última rodada, terá a maior prioridade.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <p class="footer-text">&copy; 2024 Matheus Cassiano. Todos os direitos reservados.</p>
</body>
</html>
