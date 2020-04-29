<?php
//starting session

session_start();
// defualt time zone 
date_default_timezone_set('US/Eastern');


require("https://usmansadi.000webhostapp.com/config.php");
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";



try {
    $pdo = new PDO($connection_string, $dbuser, $dbpass);
} catch (PDOException $e) {
    echo "Connection Error new" . $e->getMessage();
}



?>
