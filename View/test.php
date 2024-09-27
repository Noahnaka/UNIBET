<?php
require_once "../Controllers/activateBD.php";

session_start(); 
if (!isset($_SESSION['user_id'])) {
    header("Location: ../PaginaLogin.html");
    exit;
}
$user_id = $_SESSION['user_id'];

$sql_results = "SELECT * FROM bolao WHERE results_entered = 1";
$result_results = $mySql->query($sql_results);

if ($result_results->num_rows > 0) {
    echo "<h1>Resultados dos Jogos e Apostas Corretas</h1>";
    echo "<table border='1'>";
    echo "<tr><th>Rodada</th><th>Jogo 1</th><th>Resultado</th><th>Jogo 2</th><th>Resultado</th><th>Jogo 3</th><th>Resultado</th><th>Votos Corretos</th></tr>";

    while($game = $result_results->fetch_assoc()) {
        $idBolao = $game["idBolao"];
        echo "<tr>";
        echo "<td>" . $game["idBolao"] . "</td>";
        echo "<td>" . $game["jogo1_time1"] . " vs " . $game["jogo1_time2"] . "</td>";
        echo "<td>" . $game["jogo1_resultado"] . "</td>";
        echo "<td>" . $game["jogo2_time1"] . " vs " . $game["jogo2_time2"] . "</td>";
        echo "<td>" . $game["jogo2_resultado"] . "</td>";
        echo "<td>" . $game["jogo3_time1"] . " vs " . $game["jogo3_time2"] . "</td>";
        echo "<td>" . $game["jogo3_resultado"] . "</td>";

        // Fetch the user's bets for the game
        $sql_user_bets = "SELECT * FROM apostas WHERE idBolao = ? AND idUsuario = ?";
        $stmt_user_bets = $mySql->prepare($sql_user_bets);
        $stmt_user_bets->bind_param("ii", $idBolao, $user_id);
        $stmt_user_bets->execute();
        $result_user_bets = $stmt_user_bets->get_result();

        $correct_votes = 0;

        // Check the user's bet against the actual results
        if ($bet = $result_user_bets->fetch_assoc()) {
            // Debugging output
            echo "<td colspan='3'>Debugging: User Bet - Jogo 1: " . $bet["jogo1_vencedor"] . " (Expected: " . get_winner($game["jogo1_resultado"]) . ")<br>";
            echo "Jogo 2: " . $bet["jogo2_vencedor"] . " (Expected: " . get_winner($game["jogo2_resultado"]) . ")<br>";
            echo "Jogo 3: " . $bet["jogo3_vencedor"] . " (Expected: " . get_winner($game["jogo3_resultado"]) . ")</td>";
            
            if ($bet["jogo1_vencedor"] == get_winner($game["jogo1_resultado"])) {
                $correct_votes++;
            }
            if ($bet["jogo2_vencedor"] == get_winner($game["jogo2_resultado"])) {
                $correct_votes++;
            }
            if ($bet["jogo3_vencedor"] == get_winner($game["jogo3_resultado"])) {
                $correct_votes++;
            }
        }

        echo "<td>" . $correct_votes . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Nenhum resultado encontrado.";
}

$mySql->close();

function get_winner($resultado) {
    if (strpos($resultado, '-') !== false) {
        $scores = explode('-', $resultado);

        if (count($scores) == 2) {
            if ($scores[0] > $scores[1]) {
                return 'Time 1'; 
            } elseif ($scores[0] < $scores[1]) {
                return 'Time 2'; 
            } else {
                return 'Empate'; 
            }
        }
    }
    
    return 'N/A';
}
?>
