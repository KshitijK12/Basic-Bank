<?php


$host=getenv('host');
$port=getenv('port');
$user=getenv('user');
$pass=getenv('pass');
$dbname=getenv('dbname');

$pdo= new PDO("mysql:host=$host;port=$port;dbname=$dbname;",$user,$pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_SILENT);
?>
