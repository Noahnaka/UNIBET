<?php

$email = $_GET['email'];

if ($email != '') {
    ?>

    <!DOCTYPE HTML>
    <html>
        <head>
            <style>
                .submit-button {
                    margin-top: 1em;
                    width: 200px;
                    height: 50px;
                    font-size: 18px;
                    padding: 10px;
                    background-color: #4CAF50;
                    color: white;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                }
            </style>
        </head>
        <body>
        <script>
            function setMinDateTime() {
                const today = new Date();
                const year = today.getFullYear();
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const day = String(today.getDate()).padStart(2, '0');
                const hours = String(today.getHours()).padStart(2, '0');
                const minutes = String(today.getMinutes()).padStart(2, '0');
                
                const formattedDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
                document.getElementById('datetime').min = formattedDateTime;
            }

            window.onload = setMinDateTime;
        </script>
    
        <form action="bolao.php?email=<?php echo $email; ?>" method="post">
            <h3 style="color: red;">! Enviando bolão cancela o atual se tiver!</h3>
            <div>
                <h4>Jogo 1</h4>
                <h3>Time 1 :</h3>
                <input type="text" name="jogo1_time1" placeholder="Time1" required>
                <h3>Time 2 :</h3>
                <input type="text" name="jogo1_time2" placeholder="Time2" required>
                <br><br><h4>Jogo 2</h4>
                <h3>Time 1 :</h3>
                <input type="text" name="jogo2_time1" placeholder="Time1" required>
                <h3>Time 2 :</h3>
                <input type="text" name="jogo2_time2" placeholder="Time2" required>
                <br><br><h4>Jogo 3</h4>
                <h3>Time 1 :</h3>
                <input type="text" name="jogo3_time1" placeholder="Time1" required>
                <h3>Time 2 :</h3>
                <input type="text" name="jogo3_time2" placeholder="Time2" required>
                <h3>Fim do bolao :</h3>
                <input type="datetime-local" id="dataFinal" name="dataFinal" required><br>
            </div>
            <div class="submit-container">
                <input class="submit-button" type="submit" value="Enviar">
            </div>
        </form>
        </body>
    </html>

<?php
}
?>
