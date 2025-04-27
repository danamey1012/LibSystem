<?php
// Database connection
$servername = "localhost";
$username = 'root';
$password = '';
$dbname = "library_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to count the total members
$sql = "SELECT COUNT(*) as total FROM members";
$result = $conn->query($sql);

// Fetch the count result
$row = $result->fetch_assoc();
$totalMembers = $row['total'];

// Close the database connection
$conn->close();

// Return the total count as the response
echo $totalMembers;
?>
