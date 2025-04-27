<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}
include 'db_connect.php';

// Handle Add and Update
$edit_mode = false;
$edit_data = [];

if (isset($_GET['edit'])) {
    $edit_mode = true;
    $id = $_GET['edit'];
    $res = $conn->query("SELECT * FROM members WHERE member_id = $id");
    $edit_data = $res->fetch_assoc();
}

if (isset($_POST['add'])) {
    $stmt = $conn->prepare("INSERT INTO members (first_name, middle_initial, last_name, department, gender) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $_POST['first_name'], $_POST['middle_initial'], $_POST['last_name'], $_POST['department'], $_POST['gender']);
    $stmt->execute();
    header("Location: members.php");
}

if (isset($_POST['update'])) {
    $stmt = $conn->prepare("UPDATE members SET first_name=?, middle_initial=?, last_name=?, department=?, gender=? WHERE member_id=?");
    $stmt->bind_param("sssssi", $_POST['first_name'], $_POST['middle_initial'], $_POST['last_name'], $_POST['department'], $_POST['gender'], $_POST['member_id']);
    $stmt->execute();
    header("Location: members.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM members WHERE member_id = $id");
    header("Location: members.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Members | Library System</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    /* Same styling as previous pages... (copy from Books section) */
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

    .sidebar ul { list-style: none; }

    .sidebar ul li { margin-bottom: 12px; }

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

    h1 {
      color: #8e0000;
      font-size: 32px;
      margin-bottom: 20px;
    }

    form {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 20px;
    }

    input, select {
      padding: 10px;
      border-radius: 6px;
      border: none;
      width: calc(33.33% - 10px);
    }

    .form-actions {
      width: 100%;
      margin-top: 10px;
    }

    button {
      padding: 10px 20px;
      background-color: #b71c1c;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
      transition: background 0.3s ease;
    }

    button:hover {
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
      <li><a href="/library_system/books.php"><i class="fas fa-book"></i>Books</a></li>
      <li><a href="/library_system/borrowing.php"><i class="fas fa-exchange-alt"></i>Borrowing Records</a></li>
      <li><a href="/library_system/members.php" class="active"><i class="fas fa-users"></i>Members</a></li>
    </ul>
  </div>

  <div class="main-content">
    <h1>Members</h1>

    <form method="POST">
      <input type="hidden" name="member_id" value="<?= $edit_mode ? $edit_data['member_id'] : '' ?>">
      <input type="text" name="first_name" placeholder="First Name" required value="<?= $edit_mode ? $edit_data['first_name'] : '' ?>">
      <input type="text" name="middle_initial" placeholder="M.I." maxlength="1" required value="<?= $edit_mode ? $edit_data['middle_initial'] : '' ?>">
      <input type="text" name="last_name" placeholder="Last Name" required value="<?= $edit_mode ? $edit_data['last_name'] : '' ?>">
      <input type="text" name="department" placeholder="Department" required value="<?= $edit_mode ? $edit_data['department'] : '' ?>">
      <select name="gender" required>
        <option value="">Gender</option>
        <option value="Male" <?= $edit_mode && $edit_data['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
        <option value="Female" <?= $edit_mode && $edit_data['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
        <option value="Other" <?= $edit_mode && $edit_data['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
      </select>
      <div class="form-actions">
        <?php if ($edit_mode): ?>
          <button type="submit" name="update">Update Member</button>
        <?php else: ?>
          <button type="submit" name="add">Add Member</button>
        <?php endif; ?>
      </div>
    </form>

    <table>
      <thead>
        <tr>
          <th>First Name</th>
          <th>M.I.</th>
          <th>Last Name</th>
          <th>Department</th>
          <th>Gender</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result = $conn->query("SELECT * FROM members");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['first_name']}</td>
                        <td>{$row['middle_initial']}</td>
                        <td>{$row['last_name']}</td>
                        <td>{$row['department']}</td>
                        <td>{$row['gender']}</td>
                        <td class='action-icons'>
                          <a href='members.php?edit={$row['member_id']}' title='Edit'><i class='fas fa-edit'></i></a>
                          <a href='members.php?delete={$row['member_id']}' title='Delete' onclick='return confirm(\"Delete this member?\")'><i class='fas fa-trash-alt'></i></a>
                          <a href='#' title='View'><i class='fas fa-eye'></i></a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No members found.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
