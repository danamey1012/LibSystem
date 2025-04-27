<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location:login.php");
    exit();
}
include 'db_connect.php'; 
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard | Library System</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    

    body {
      font-family: 'Inter', sans-serif;
      background: url('library-bg.jpg.jpg') no-repeat center center fixed;
      background-size: cover;
      backdrop-filter: blur(6px);
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .top-navbar {
      width: 100%;
      background: linear-gradient(90deg, #8e0000, #b71c1c, #ff5252);
      padding: 14px 50px;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 3px 10px rgba(0,0,0,0.25);
      clip-path: polygon(0 0, 100% 0, 98% 100%, 0% 100%);
    }

    .top-navbar h1 {
      font-size: 30px;
      font-weight: bold;
      letter-spacing: 1px;
      color: #fff;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.6);
    }

    .nav-links a {
      color: white;
      margin-left: 25px;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s ease, box-shadow 0.3s ease;
    }

    .nav-links a:hover {
      text-decoration: underline;
      color: #ffe5e5;
      box-shadow: 0 4px 10px rgba(255,255,255,0.3);
    }

    .container {
      display: flex;
      flex: 1;
    }

    .sidebar {
      width: 260px;
      background: linear-gradient(180deg, #8e0000 0%, #b71c1c 50%, #ff5252 100%);
      color: white;
      padding: 2rem 1rem;
      box-shadow: 2px 0 12px rgba(0,0,0,0.2);
      position: relative;
      z-index: 2;
      backdrop-filter: blur(12px);
    }

    .sidebar h2 {
      text-align: center;
      font-size: 22px;
      margin-bottom: 2rem;
    }

    .sidebar ul {
      list-style: none;
    }

    .sidebar ul li {
      margin-bottom: 12px;
    }

    .sidebar a {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 14px;
      color: white;
      text-decoration: none;
      border-radius: 10px;
      font-weight: 600;
      transition: background 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
    }

    .sidebar a:hover, .sidebar a.active {
      background-color: rgba(255, 255, 255, 0.15);
      transform: translateX(6px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .main-content {
      flex: 1;
      padding: 2rem;
      background: rgba(255, 255, 255, 0.15);
      margin: 2rem;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(10px);
      animation: fadeIn 1s ease;
    }

    h1 {
      color: #8e0000;
      font-size: 40px;
    }

    p {
      margin-top: 1rem;
      color: #333;
      font-size: 17px;
    }

    .stats {
      display: flex;
      flex-wrap: wrap;
      margin-top: 2rem;
      gap: 20px;
    }

    .stat-card {
      flex: 1 1 200px;
      background: rgba(255,255,255,0.3);
      padding: 20px;
      border-radius: 16px;
      text-align: center;
      box-shadow: 0 8px 18px rgba(0,0,0,0.15);
      backdrop-filter: blur(8px);
      color: #000000;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 24px rgba(0,0,0,0.2);
    }

    .stat-card i {
      font-size: 32px;
      margin-bottom: 10px;
      color: #b71c1c;
    }

    .stat-card h3 {
      font-size: 24px;
      margin-bottom: 5px;
    }

    .stat-card p {
      font-size: 14px;
      color: #000000;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    <style>
  .stat-card.new-style {
    background: rgba(255, 255, 255, 0.5);
    border: 2px solid #b71c1c;
    border-radius: 20px;
    padding: 25px;
    color: #222;
    transition: all 0.3s ease;
  }

  .stat-card.new-style:hover {
    background: rgba(255, 82, 82, 0.2);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
  }
  



</style>

  </style>
</head>
<body>
<div class="top-navbar">
  <h1>AnimisticU Library</h1>
  <div class="nav-links">
    <a href="#home">Home</a>
    <a href="about.php">About</a>
    <a href="#contact">Contact</a>
  </div>
</div>



<div class="container">
  <div class="sidebar">
    <h2>Menu</h2>
    <ul>
      <li><a href="/library_system/dashboard.php" class="active"><i class="fas fa-home"></i>Dashboard</a></li>
      <li><a href="/library_system/authors.php"><i class="fas fa-user-edit"></i>Authors</a></li>
      <li><a href="/library_system/books.php"><i class="fas fa-book"></i>Books</a></li>
      <li><a href="/library_system/borrowing.php"><i class="fas fa-exchange-alt"></i>Borrowing Records</a></li>
      <li><a href="/library_system/members.php"><i class="fas fa-users"></i>Members</a></li>
    </ul>
  </div>

  <div class="main-content">
  <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
  <p style="color: black;">You have successfully logged in to the AnimisticU Library System Dashboard. Explore the sidebar to manage authors, books, borrowings, and members.</p>

  <div class="stats">

    <div class="stat-card new-style">
      <i class="fas fa-users"></i>
      <h3>
        <?php
          $studentCount = mysqli_query($conn, "SELECT COUNT(*) AS total FROM members");
          $row = mysqli_fetch_assoc($studentCount);
          echo $row['total'];
        ?>
      </h3>
      <p>Total Students</p>
    </div>

    <div class="stat-card new-style">
      <i class="fas fa-book-open"></i>
      <h3>
        <?php
          $bookCount = mysqli_query($conn, "SELECT COUNT(*) AS total FROM books");
          $row = mysqli_fetch_assoc($bookCount);
          echo $row['total'];
        ?>
      </h3>
      <p>Total Books</p>
    </div>

    <div class="stat-card new-style">
      <i class="fas fa-user-edit"></i>
      <h3>
        <?php
          $authorCount = mysqli_query($conn, "SELECT COUNT(*) AS total FROM authors");
          $row = mysqli_fetch_assoc($authorCount);
          echo $row['total'];
        ?>
      </h3>
      <p>Authors</p>
    </div>

    <div class="stat-card new-style">
      <i class="fas fa-exchange-alt"></i>
      <h3>
        <?php
          $borrowedCount = mysqli_query($conn, "SELECT COUNT(*) AS total FROM borrowing_records");
          $row = mysqli_fetch_assoc($borrowedCount);
          echo $row['total'];
        ?>
      </h3>
      <p>Borrowed Books</p>
    </div>

  </div>
</div>


    </div>
  </div>
</div>

</body>
</html>