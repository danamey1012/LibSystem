<?php
$host = 'localhost';
$username = 'root';
$password = ''; // or your DB password
$database = 'library_system'; // make sure this matches your actual database name

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
