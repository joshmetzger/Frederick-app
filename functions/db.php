<?php

$host = 'localhost';
$user = 'root';
$password = 'root';
$db = 'frederick';
$port = 8889;

$connect = mysqli_init();
if (!$connect) {
    die('mysqli_init failed');
}

$success = mysqli_real_connect($connect, $host, $user, $password, $db, $port);

if (!$success) {
    die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}

?>