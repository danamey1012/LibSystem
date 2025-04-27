<?php
$host = "localhost";
$user = "root";
$pass = ""; // default walang password sa XAMPP
$dbname = "library_system"; // pangalan ng database mo (palitan kung iba)

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
