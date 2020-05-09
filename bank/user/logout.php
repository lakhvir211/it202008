<?php
include_once '../core/connection.php';
unset($_SESSION["bankLogin"]);
unset($_SESSION["id"]);
header("Location: index.php");

echo('logout Success Redirecting to home page');
exit;

?>