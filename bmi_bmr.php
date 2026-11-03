<?php
require_once "db.php"; require_once "auth.php"; include "header.php";
$user_id = $_SESSION['user_id'];
$stmt = $mysqli->prepare("SELECT gender, age, height_cm, weight_kg FROM profiles WHERE user_id = ?");
$stmt->bind_param("i", $user_id); $stmt->execute(); $stmt->bind_result($gender, $age, $height_cm, $weight_kg); $stmt->fetch(); $stmt->close();
function calc_bmi($w,$h){ if(!$w||!$h) return null; $m=$h/100.0; return $m>0?round($w/($m*$m),1):null; }
function calc_bmr($g,$w,$h,$a){
  if(!$w||!$h||!$a) return null;
  if($g==="male"){ return round(10*$w + 6.25*$h - 5*$a + 5); }
  else if($g==="female"){ return round(10*$w + 6.25*$h - 5*$a - 161); }
  else { return round(10*$w + 6.25*$h - 5*$a - 78); }
}
$bmi = calc_bmi($weight_kg,$height_cm); $bmr = calc_bmr($gender,$weight_kg,$height_cm,$age);
?>
<h2>BMI & BMR Calculator</h2>
<div class="grid">
  <div class="card">
    <h3>Your Numbers</h3>
    <ul class="stats">
      <li><strong>BMI:</strong> <?= $bmi ? $bmi : "—" ?></li>
      <li><strong>BMR:</strong> <?= $bmr ? $bmr : "—" ?> kcal/day</li>
    </ul>
    <p class="muted">Update your <a href="profile.php">Profile</a> to change inputs.</p>
  </div>
  <div class="card">
    <h3>Diet & Activity suggestion</h3>
    <ul>
      <li>If BMI &lt; 18.5: add nutrient-dense foods; strength training 3x/week.</li>
      <li>18.5–24.9: maintain balanced diet; 150+ min moderate activity/week.</li>
      <li>25–29.9: create ~300–500 kcal/day deficit; brisk walking 30–45 min.</li>
      <li>≥ 30: consult a professional; focus on gradual, sustainable changes.</li>
    </ul>
    <p class="muted">This is educational content, not medical advice.</p>
  </div>
</div>
<?php include "footer.php"; ?>
