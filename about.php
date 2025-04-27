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
  <title>About Us | Animistic University</title>
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

    .about-box {
      padding: 20px;
      margin-top: 30px;
      background-color: rgba(255, 255, 255, 0.2);
      border-radius: 10px;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }

    .about-box h2 {
      font-size: 28px;
      color: #8e0000;
    }

    .box-container {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
    }

    .box {
      background-color: #b71c1c;
      color: white;
      padding: 20px;
      border-radius: 10px;
      width: 30%;
      text-align: center;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .box:hover {
      background-color: #ff5252;
    }

    .content-box {
      display: none;
      margin-top: 20px;
      padding: 20px;
      background-color: rgba(255, 255, 255, 0.3);
      border-radius: 10px;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

  </style>
</head>
<body>
  <div class="top-navbar">
    <h1>AnimisticU Library</h1>
    <div class="nav-links">
      <a href="dashboard.php">Home</a>
      <a href="#about">About</a>
      <a href="#contact">Contact</a>
    </div>
  </div>

  <div class="main-content">
    <h1>About Animistic University</h1>
    <div class="about-box">
      <p>
        Animistic University, founded in 1985, is a pioneering institution dedicated to nurturing students who are passionate about discovering and exploring the deep connections between nature, spirituality, and education. At Animistic University, we believe that knowledge goes beyond the classroom—our approach blends the ancient teachings of animism with modern educational practices to foster a harmonious relationship between humanity and the environment.
      </p>

      <div class="box-container">
        <div class="box" onclick="toggleContent('mission')">Mission</div>
        <div class="box" onclick="toggleContent('vision')">Vision</div>
        <div class="box" onclick="toggleContent('core-values')">Core Values</div>
      </div>

      <div id="mission" class="content-box">
        <p>To create a transformative educational experience that integrates the principles of animism into all disciplines, empowering students to become not just experts in their fields but also mindful stewards of the Earth. We aim to nurture critical thinking, creativity, and compassion, producing graduates who are leaders in sustainability, ecology, and spiritual well-being.</p>
      </div>

      <div id="vision" class="content-box">
        <p>Animistic University envisions a world where education transcends conventional boundaries, guiding individuals to understand the interconnectedness of all life. We strive to become a global hub for spiritual, environmental, and academic innovation, promoting values of respect, balance, and sustainability.</p>
      </div>

      <div id="core-values" class="content-box">
        <ul>
          <li>Holistic Learning</li>
          <li>Sustainability</li>
          <li>Cultural Respect</li>
          <li>Innovation for Good</li>
        </ul>
      </div>
    </div>
  </div>

  <script>
    function toggleContent(contentId) {
      const contentBoxes = document.querySelectorAll('.content-box');
      contentBoxes.forEach(box => {
        if (box.id === contentId) {
          box.style.display = box.style.display === 'block' ? 'none' : 'block';
        } else {
          box.style.display = 'none';
        }
      });
    }
  </script>
</body>
</html>
