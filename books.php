<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Books | Library System</title>
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
    }

    .form-control {
      padding: 10px;
      border-radius: 8px;
      border: none;
      flex: 1;
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
      <li><a href="/library_system/authors.php"><i class="fas fa-user-edit"></i>Authors</a></li>
      <li><a href="/library_system/books.php" class="active"><i class="fas fa-book"></i>Books</a></li>
      <li><a href="/library_system/borrowing.php"><i class="fas fa-exchange-alt"></i>Borrowing Records</a></li>
      <li><a href="/library_system/members.php"><i class="fas fa-users"></i>Members</a></li>
    </ul>
  </div>

  <div class="main-content">
    <h2>Manage Books</h2>

    <!-- Book Form -->
    <form method="POST" action="add_book.php">
      <input type="text" name="title_name" placeholder="Title" class="form-control" required />
      <input type="text" name="category" placeholder="Category" class="form-control" required />
      <input type="date" name="publication_date" class="form-control" required />
      <button type="submit" class="btn"><i class="fas fa-plus"></i></button>
    </form>

    <!-- Book Table -->
    <table>
      <thead>
        <tr>
          <th>Title</th>
          <th>Category</th>
          <th>Publication Date</th>
          <th style="text-align:center;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM books");
        if ($result && mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['title_name']) . "</td>
                    <td>" . htmlspecialchars($row['category']) . "</td>
                    <td>" . htmlspecialchars($row['publication_date']) . "</td>
                    <td class='action-icons'>
                      <a href='view_book.php?id=" . $row['book_id'] . "'><i class='fas fa-eye'></i></a>
                      <a href='edit_book.php?id=" . $row['book_id'] . "'><i class='fas fa-pen-to-square'></i></a>
                      <a href='delete_book.php?id=" . $row['book_id'] . "' onclick=\"return confirm('Are you sure?')\"><i class='fas fa-trash'></i></a>
                    </td>
                  </tr>";
          }
        } else {
          echo "<tr><td colspan='4'>No books found</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
