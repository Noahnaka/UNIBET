<?php
require_once "../Controllers/activateBD.php";

$sql = "SELECT idBolao, jogo1_time1, jogo1_time2, jogo2_time1, jogo2_time2, jogo3_time1, jogo3_time2 FROM bolao WHERE status = false";
$result = $mySql->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Escolha o bolão para inserir resultados:</h2>";
    echo "<form action='input_resultados.php' method='get'>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<input type='radio' name='idBolao' value='" . $row['idBolao'] . "' required>";
        echo "Bolão ID: " . $row['idBolao'] . " - ";
        echo "Jogo 1: " . $row['jogo1_time1'] . " vs " . $row['jogo1_time2'] . ", ";
        echo "Jogo 2: " . $row['jogo2_time1'] . " vs " . $row['jogo2_time2'] . ", ";
        echo "Jogo 3: " . $row['jogo3_time1'] . " vs " . $row['jogo3_time2'] . "<br><br>";
    }
    
    echo "<input type='submit' value='Escolher'>";
    echo "</form>";
} else {
    echo "Não há bolões disponíveis para inserir resultados.";
}

$mySql->close();
?>
