<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="UTF-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>FitLife Health Tracker</title>
<link rel="stylesheet" href="assets/css/styles.css"/>
</head><body>
<nav class="nav">
  <div class="brand"><a href="index.php">FitLife</a></div>
  <ul class="nav-links">
    <?php if(isset($_SESSION['user_id'])): ?>
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="profile.php">Profile</a></li>
      <li><a href="bmi_bmr.php">BMI & BMR</a></li>
      <li><a href="track.php">Daily Log</a></li>
      <li><a href="logout.php">Logout</a></li>
    <?php else: ?>
      <li><a href="register.php">Register</a></li>
      <li><a href="login.php">Login</a></li>
    <?php endif; ?>
  </ul>
</nav>
<main class="container">
