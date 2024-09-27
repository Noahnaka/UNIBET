<?php

require_once "../Controllers/activateBD.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idBolao = $_POST['idBolao'];
    $resultado1 = $_POST['resultado1'];
    $resultado2 = $_POST['resultado2'];
    $resultado3 = $_POST['resultado3'];

    $sql = "UPDATE bolao SET 
            jogo1_resultado = '$resultado1', 
            jogo2_resultado = '$resultado2', 
            jogo3_resultado = '$resultado3', 
            status = 1 
            WHERE idBolao = $idBolao";

    if ($mySql->query($sql) === TRUE) {
        echo "Resultados inseridos com sucesso e status atualizado.";
    } else {
        echo "Erro ao inserir os resultados: " . $mySql->error;
    }

    $mySql->close();
}
?>