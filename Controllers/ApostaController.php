<?php
require_once "../Controllers/activateBD.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start(); 
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../PaginaLogin.html");
    exit;
    }
    $user_id = $_SESSION['user_id'];

    $idBolao = $_POST['idBolao'];
    $jogo1_vencedor = $_POST['jogo1_vencedor'];
    $jogo1_resultado = $_POST['jogo1_resultado'];
    $jogo2_vencedor = $_POST['jogo2_vencedor'];
    $jogo2_resultado = $_POST['jogo2_resultado'];
    $jogo3_vencedor = $_POST['jogo3_vencedor'];
    $jogo3_resultado = $_POST['jogo3_resultado'];

    $sql = "INSERT INTO apostas (idBolao, idUsuario, jogo1_vencedor, jogo1_resultado, jogo2_vencedor, jogo2_resultado, jogo3_vencedor, jogo3_resultado)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mySql->prepare($sql);
    $stmt->bind_param("iissssss", $idBolao, $user_id, $jogo1_vencedor, $jogo1_resultado, $jogo2_vencedor, $jogo2_resultado, $jogo3_vencedor, $jogo3_resultado);

    if ($stmt->execute()) {
        echo "Voto registrado com sucesso!";
    } else {
        echo "Erro ao registrar o voto: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Método de requisição inválido.";
}

$mySql->close();
?>
