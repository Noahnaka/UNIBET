<?php
require_once "../Controllers/activateBD.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jogo1_time1 = $_POST['jogo1_time1'];
    $jogo1_time2 = $_POST['jogo1_time2'];
    $jogo2_time1 = $_POST['jogo2_time1'];
    $jogo2_time2 = $_POST['jogo2_time2'];
    $jogo3_time1 = $_POST['jogo3_time1'];
    $jogo3_time2 = $_POST['jogo3_time2'];
    $DateBolao = $_POST['dataFinal'];

    $status = 0;

    $sql = "INSERT INTO bolao (jogo1_time1, jogo1_time2, jogo2_time1, jogo2_time2, jogo3_time1, jogo3_time2, dataFinal, status)
            VALUES ('$jogo1_time1', '$jogo1_time2', '$jogo2_time1', '$jogo2_time2', '$jogo3_time1', '$jogo3_time2', '$DateBolao', '$status')";

    if ($mySql->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $mySql->error;
    }

    $mySql->close();
}
?>