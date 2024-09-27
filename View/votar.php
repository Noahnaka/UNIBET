<?php
require_once "../Controllers/activateBD.php";

if (isset($_GET['idBolao'])) {
    $idBolao = $_GET['idBolao'];

    session_start(); 
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../PaginaLogin.html");
        exit;
    }
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT * FROM bolao WHERE idBolao = ?";
    $stmt = $mySql->prepare($sql);
    $stmt->bind_param("i", $idBolao);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        ?>

        <!DOCTYPE HTML>
        <html>
        <head>
            <title>Votar no Bolão</title>
            <script>
                function autoFormatScore(input) {
                    let value = input.value.replace(/[^0-9]/g, '');
                    if (value.length >= 2) {
                        input.value = value.slice(0, 1) + 'x' + value.slice(1, 2);
                    } else {
                        input.value = value;
                    }
                }
            </script>
        </head>
        <body>
        <h1>Votar no Bolão</h1>
        <form action="../Controllers/ApostaController.php" method="post">
            <input type="hidden" name="idBolao" value="<?php echo $idBolao; ?>">
            <div>
                <h3>Jogo 1: <?php echo $row['jogo1_time1']; ?> vs <?php echo $row['jogo1_time2']; ?></h3>
                <label>Vencedor:</label>
                <label>Resultado:</label>
                <input type="text" name="jogo1_resultado" placeholder="0x0" maxlength="3" oninput="autoFormatScore(this)" required>
            </div>
            <div>
                <h3>Jogo 2: <?php echo $row['jogo2_time1']; ?> vs <?php echo $row['jogo2_time2']; ?></h3>
                <label>Vencedor:</label>
                <label>Resultado:</label>
                <input type="text" name="jogo2_resultado" placeholder="0x0" maxlength="3" oninput="autoFormatScore(this)" required>
            </div>
            <div>
                <h3>Jogo 3: <?php echo $row['jogo3_time1']; ?> vs <?php echo $row['jogo3_time2']; ?></h3>
                <label>Vencedor:</label>
                <label>Resultado:</label>
                <input type="text" name="jogo3_resultado" placeholder="0x0" maxlength="3" oninput="autoFormatScore(this)" required>
            </div>
            <input type="submit" value="Votar">
        </form>
        </body>
        </html>

        <?php
    } else {
        echo "Bolão não encontrado.";
    }

    $stmt->close();
} else {
    echo "ID do bolão não especificado.";
}

$mySql->close();
?>
