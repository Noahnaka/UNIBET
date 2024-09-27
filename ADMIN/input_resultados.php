<?php
require_once "../Controllers/activateBD.php";

$idBolao = $_GET['idBolao'];

$sql = "SELECT * FROM bolao WHERE idBolao = $idBolao";
$result = $mySql->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    echo "<h2>Inserir resultados para o bolão ID: " . $row['idBolao'] . "</h2>";
    echo "<form action='set_resultados.php' method='post'>";
    echo "<h3>Jogo 1: " . $row['jogo1_time1'] . " vs " . $row['jogo1_time2'] . "</h3>";
    echo "<input type='text' name='resultado1' placeholder='Resultado' required><br>";

    echo "<h3>Jogo 2: " . $row['jogo2_time1'] . " vs " . $row['jogo2_time2'] . "</h3>";
    echo "<input type='text' name='resultado2' placeholder='Resultado' required><br>";

    echo "<h3>Jogo 3: " . $row['jogo3_time1'] . " vs " . $row['jogo3_time2'] . "</h3>";
    echo "<input type='text' name='resultado3' placeholder='Resultado' required><br>";

    echo "<input type='hidden' name='idBolao' value='" . $row['idBolao'] . "'>";
    echo "<input type='submit' value='Enviar Resultados'>";
    echo "</form>";
} else {
    echo "Bolão não encontrado.";
}

$mySql->close();
?>

