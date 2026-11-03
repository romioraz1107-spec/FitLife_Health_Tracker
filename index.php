<?php include "header.php"; ?>
<section class="hero">
  <h1>Track your health, simply.</h1>
  <p>FitLife is a minimal health tracker with login/register, BMI/BMR calculator, and daily logs (water, steps, calories).</p>
  <?php if(!isset($_SESSION['user_id'])): ?>
    <div class="cta">
      <a class="btn" href="register.php">Create account</a>
      <a class="btn outline" href="login.php">Login</a>
    </div>
  <?php else: ?>
    <div class="cta"><a class="btn" href="dashboard.php">Go to Dashboard</a></div>
  <?php endif; ?>
</section>
<?php include "footer.php"; ?>
