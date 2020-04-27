<?php
//starting session
session_start();
// defualt time zone 
date_default_timezone_set('US/Eastern');


$dsn = 'mysql:host=localhost; dbname=id13444038_bank';
$user = 'id13444038_root';
$pass = 'iUF74_=]^Z-D-Zuw';
try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    echo "Connection Error" . $e->getMessage();
}