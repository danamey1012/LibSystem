<?php
session_start();


// Hardcoded users (for now)
$valid_username = "admin";
$valid_password = "admin123"; // dapat secure in real-world, pero simple muna tayo ngayon

// Kunin yung data galing sa form
$username = $_POST['username'];
$password = $_POST['password'];

// I-check kung tugma
if ($username === $valid_username && $password === $valid_password) {
    $_SESSION['username'] = $username;
    header("Location: dashboard.php"); // redirect to dashboard
    exit();
} else {
    // Kung mali
    echo "<script>
            alert('Invalid Username or Password!');
            window.location.href = 'login.html'; // balik sa login page
          </script>";
    exit();
}
?>
