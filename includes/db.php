<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'crop_disease_diagnostic_tool';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

?>