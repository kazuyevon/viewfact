<?php
$dsn = 'mysql:host=127.0.0.1:3388;dbname=dbfacture';
$username = 'dbaccess';
$password = 'dbaccess';
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
);
?>