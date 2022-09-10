<?php
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();
$_SESSION = array();
session_destroy();
var_dump($_SESSION) ;

header('Location: top.php');

?>