<?php
$host = "localhost";
$dbname = "admin_portal";
$user = "root";
$pass = "root";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>