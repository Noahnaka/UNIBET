<?php
require_once 'activateBD.php';

$sql = "SELECT Time1, Time2, dataTime, idBolao FROM bolao"; 
$result = $mySql->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        date_default_timezone_set('America/Sao_Paulo');

        $dateTime = new DateTime($row["dataTime"]);
        $formattedTime = $dateTime->format('H:i');
        
        $now = new DateTime();
        $interval = $now->diff($dateTime);
        $timeLeft = $interval->format('%d dias, %h horas, %i minutos');



        echo "<form action='../View/Vote_page.php' method='post'>
                " . $row["Time1"] . " <b>VS</b> " . $row["Time2"] . " | <b> " . $timeLeft . " restando</b> " ."
                <input type='hidden' name='game_id' value='" . htmlspecialchars($row["idBolao"]) . "'>
                <input type='submit' value='Votar'> 
              </form> <br>" ;
    }
} else {
    echo "Hoje não está tendo bolão!";
}
$mySql->close();
?>
