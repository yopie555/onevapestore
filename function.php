<?php 
session_start();

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'onevapestore';

$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$connection) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit();
}
?>