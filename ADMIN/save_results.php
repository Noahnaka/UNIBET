<?php
require_once "../Controllers/activateBD.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        if (preg_match('/resultado_jogo(\d)_(\d+)/', $key, $matches)) {
            $jogoNumber = $matches[1]; 
            $idBolao = $matches[2]; 

            $sql = "UPDATE bolao SET jogo{$jogoNumber}_resultado = ?, results_entered = 1 WHERE idBolao = ?";
            $stmt = $mySql->prepare($sql);
            $stmt->bind_param("si", $value, $idBolao);
            $stmt->execute();
            $stmt->close();
        }
    }
    echo "Resultados salvos com sucesso!";
} else {
    echo "Método de requisição inválido.";
}

$mySql->close();
?>
