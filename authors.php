<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}
include 'db_connect.php';

// Handle Add Author
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_author'])) {
    $first = $_POST['first_name'];
    $middle = $_POST['middle_initial'];
    $last = $_POST['last_name'];
    $nationality = $_POST['nationality'];
    $gender = $_POST['gender'];

    $stmt = $conn->prepare("INSERT INTO authors (first_name, middle_initial, last_name, nationality, gender) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $first, $middle, $last, $nationality, $gender);
    $stmt->execute();
    $stmt->close();
    header("Location: authors.php");
    exit();
}

// Handle Delete Author
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM authors WHERE author_id=$id");
    header("Location: authors.php");
    exit();
}

// Fetch authors
$result = $conn->query("SELECT * FROM authors ORDER BY author_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Authors | Library System</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

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
    }

    h2 {
      color: #8e0000;
      font-size: 28px;
      margin-bottom: 20px;
    }

    form {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
      flex-wrap: wrap;
    }

    .form-control {
      padding: 10px;
      border-radius: 8px;
      border: none;
      flex: 1;
      min-width: 160px;
    }

    .btn {
      background-color: #b71c1c;
      color: white;
      padding: 10px 18px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .btn:hover {
      background-color: #ff5252;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: rgba(255, 255, 255, 0.3);
      border-radius: 12px;
      overflow: hidden;
    }

    th, td {
      padding: 14px;
      text-align: left;
      border-bottom: 1px solid #ddd;
      color: #333;
    }

    th {
      background-color: rgba(255, 255, 255, 0.5);
      color: #8e0000;
      font-weight: bold;
    }

    tr:hover {
      background-color: rgba(255, 255, 255, 0.4);
    }

    .action-icons {
      display: flex;
      gap: 12px;
      justify-content: center;
    }

    .action-icons a {
      color: #b71c1c;
      font-size: 18px;
      transition: transform 0.2s ease;
    }

    .action-icons a:hover {
      transform: scale(1.2);
      color: #ff5252;
    }
  </style>
</head>
<body>

<div class="top-navbar">
  <h1>AnimisticU Library</h1>
  <div class="nav-links">
    <a href="#">Home</a>
    <a href="#">About</a>
    <a href="#">Contact</a>
  </div>
</div>

<div class="container">
  <div class="sidebar">
    <h2>Menu</h2>
    <ul>
      <li><a href="/library_system/dashboard.php"><i class="fas fa-home"></i>Dashboard</a></li>
      <li><a href="/library_system/authors.php" class="active"><i class="fas fa-user-edit"></i>Authors</a></li>
      <li><a href="/library_system/books.php"><i class="fas fa-book"></i>Books</a></li>
      <li><a href="/library_system/borrowing.php"><i class="fas fa-exchange-alt"></i>Borrowing Records</a></li>
      <li><a href="/library_system/members.php"><i class="fas fa-users"></i>Members</a></li>
    </ul>
  </div>

  <div class="main-content">
    <h2>Manage Authors</h2>
    <form method="POST">
      <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
      <input type="text" name="middle_initial" class="form-control" placeholder="M.I." maxlength="1">
      <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
      <input type="text" name="nationality" class="form-control" placeholder="Nationality" required>
      <select name="gender" class="form-control" required>
        <option value="">Select Gender</option>
        <option>Male</option>
        <option>Female</option>
        <option>Other</option>
      </select>
      <button type="submit" name="add_author" class="btn"><i class="fas fa-plus"></i> Add Author</button>
    </form>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Full Name</th>
          <th>Nationality</th>
          <th>Gender</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['author_id'] ?></td>
          <td><?= $row['first_name'] . ' ' . $row['middle_initial'] . '. ' . $row['last_name'] ?></td>
          <td><?= $row['nationality'] ?></td>
          <td><?= $row['gender'] ?></td>
          <td class="action-icons">
            <a href="edit_author.php?id=<?= $row['author_id'] ?>"><i class="fas fa-edit"></i></a>
            <a href="?delete=<?= $row['author_id'] ?>" onclick="return confirm('Delete this author?')"><i class="fas fa-trash"></i></a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
