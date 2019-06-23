<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$db_host = 'localhost';
$db_name = 'trickortrip';
$db_user = 'root';
$db_pass = '';


$dsn = 'mysql:host='. $db_host .';dbname=' . $db_name;
$db = new PDO($dsn, $db_user, $db_pass);
$db->exec('SET CHARACTER SET UTF8MB4');
$db->exec('SET NAMES UTF8MB4');

session_start();