<?php

$email = $_GET['email'];

if ($email != '') {
?>
    <!DOCTYPE HTML>
    <html>

    <body style="font-size: large;">

    <a href="escolher_bolao.php">Resultados dos jogos</a><br><br>
    <a href="bolao_insert.php?email=noah@gmail.com">Comecar bolao</a>

    </html>

<?php
}

?>