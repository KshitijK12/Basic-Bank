<?php
$pdo= new PDO("mysql:host=ENV['host'];port=ENV['port'];dbname=ENV['dbname'];",ENV['user'],ENV['pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_SILENT);
?>
