<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "users_db";
$port = 3307;
$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die("CONNECTION FAILED: " . $conn->connect_error);
}

?>