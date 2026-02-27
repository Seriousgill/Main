<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'shri_balaji';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

$conn->set_charset('utf8mb4');
?>
