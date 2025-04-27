<?php
include 'db.php';

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM authors WHERE author_id = $id");
$author = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $middle_initial = $_POST['middle_initial'];
    $last_name = $_POST['last_name'];
    $nationality = $_POST['nationality'];
    $gender = $_POST['gender'];

    $sql = "UPDATE authors SET 
        first_name='$first_name', 
        middle_initial='$middle_initial', 
        last_name='$last_name', 
        nationality='$nationality', 
        gender='$gender' 
        WHERE author_id=$id";

    if (mysqli_query($conn, $sql)) {
        header("Location: authors.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Author</title>
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f4f4f4;
      padding: 2rem;
    }
    .container {
      max-width: 600px;
      margin: auto;
      background: #fff;
      padding: 2rem;
      border-radius: 10px;
    }
    label {
      display: block;
      margin-top: 10px;
    }
    input, select {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
    }
    button {
      margin-top: 20px;
      padding: 10px 20px;
      background: #0077cc;
      color: white;
      border: none;
      border-radius: 6px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Edit Author</h1>
    <form method="POST">
      <label>First Name</label>
      <input type="text" name="first_name" value="<?= $author['first_name'] ?>" required>

      <label>Middle Initial</label>
      <input type="text" name="middle_initial" value="<?= $author['middle_initial'] ?>" maxlength="1">

      <label>Last Name</label>
      <input type="text" name="last_name" value="<?= $author['last_name'] ?>" required>

      <label>Nationality</label>
      <input type="text" name="nationality" value="<?= $author['nationality'] ?>" required>

      <label>Gender</label>
      <select name="gender" required>
        <option value="Male" <?= $author['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
        <option value="Female" <?= $author['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
        <option value="Other" <?= $author['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
      </select>

      <button type="submit">Update Author</button>
    </form>
  </div>
</body>
</html>
