<?php
require_once("PHP_CREDS.php");
$pdo= new PDO("mysql:host=$host;port=$port;dbname=GRIP;",$user,$pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_SILENT);
?>
