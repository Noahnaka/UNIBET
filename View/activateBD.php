<?php
    $username = "root";
    $passwordData = "";
    $database = "unibet";
    $host = "127.0.0.1:3306";

    $mySql = new mysqli($host , $username, $passwordData, $database);

    if ($mySql->connect_error) {
        die("Connection failed: " . $mySql->connect_error);
    }
?>
