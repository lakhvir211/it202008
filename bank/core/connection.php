<?php
//starting session

session_start();
// defualt time zone 
date_default_timezone_set('US/Eastern');

<?php

$dbuser = "lk268";//your ucid
$dbpass = "Lovefamily2$";//your phpMyAdmin password
$dbhost = "sql1.njit.edu";//whichever server you login to from web.njit.edu/mysql/phpMyAdmin
$dbdatabase = "lk268";//your ucid

$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";



try {
    $pdo = new PDO($connection_string, $dbuser, $dbpass);
} catch (PDOException $e) {
    echo "Connection Error new" . $e->getMessage();
}



?>
