<?php
//starting session

session_start();
// defualt time zone 
date_default_timezone_set('US/Eastern');


$dsn = 'mysql:host=sql1.njit.edu; dbname=lk268';
$user = 'lk268@webhost01.ucs.njit.edu';
$pass = 'Lovefamily2$';
try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    echo "Connection Error" . $e->getMessage();
}
