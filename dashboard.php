<?php
require_once "db.php"; require_once "auth.php"; include "header.php";
$user_id = $_SESSION['user_id'];
$pstmt = $mysqli->prepare("SELECT gender, age, height_cm, weight_kg FROM profiles WHERE user_id = ?");
$pstmt->bind_param("i", $user_id); $pstmt->execute(); $pstmt->bind_result($gender, $age, $height_cm, $weight_kg); $pstmt->fetch(); $pstmt->close();
$today = date('Y-m-d');
$lstmt = $mysqli->prepare("SELECT water_ml, steps, calories FROM health_logs WHERE user_id = ? AND log_date = ?");
$lstmt->bind_param("is", $user_id, $today); $lstmt->execute(); $lstmt->bind_result($water_ml, $steps, $calories); $lstmt->fetch(); $lstmt->close();
function calc_bmi($w,$h){ if(!$w||!$h) return null; $m=$h/100.0; return $m>0?round($w/($m*$m),1):null; }
$bmi = calc_bmi($weight_kg, $height_cm);
?>
<h2>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?> 👋</h2>
<div class="grid">
  <div class="card">
    <h3>Quick Stats</h3>
    <ul class="stats">
      <li><strong>BMI:</strong> <?= $bmi ? $bmi : "—" ?></li>
      <li><strong>Water (today):</strong> <?= $water_ml ? $water_ml : 0 ?> ml</li>
      <li><strong>Steps (today):</strong> <?= $steps ? $steps : 0 ?></li>
      <li><strong>Calories (today):</strong> <?= $calories ? $calories : 0 ?></li>
    </ul>
    <a class="btn" href="track.php">Update today’s log</a>
  </div>
  <div class="card">
    <h3>Health Tips</h3>
    <p>Stay hydrated, aim for 7–8 hours of sleep, and include protein & veggies in each meal. Walk 30 minutes daily.</p>
    <a class="btn outline" href="bmi_bmr.php">Calculate BMI & BMR</a>
  </div>
</div>
<?php include "footer.php"; ?>
