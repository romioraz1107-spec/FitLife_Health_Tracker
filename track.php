<?php
require_once "db.php"; require_once "auth.php"; include "header.php";
$user_id = $_SESSION['user_id']; $today = date('Y-m-d');
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $water_ml = intval($_POST["water_ml"] ?? 0);
  $steps = intval($_POST["steps"] ?? 0);
  $calories = intval($_POST["calories"] ?? 0);
  $chk = $mysqli->prepare("SELECT id FROM health_logs WHERE user_id = ? AND log_date = ?");
  $chk->bind_param("is", $user_id, $today); $chk->execute(); $chk->bind_result($existing_id);
  $exists = $chk->fetch(); $chk->close();
  if ($exists) {
    $stmt = $mysqli->prepare("UPDATE health_logs SET water_ml = ?, steps = ?, calories = ? WHERE id = ?");
    $stmt->bind_param("iiii", $water_ml, $steps, $calories, $existing_id); $stmt->execute(); $stmt->close(); $msg = "Updated today's log.";
  } else {
    $stmt = $mysqli->prepare("INSERT INTO health_logs (user_id, log_date, water_ml, steps, calories) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isiii", $user_id, $today, $water_ml, $steps, $calories); $stmt->execute(); $stmt->close(); $msg = "Saved today's log.";
  }
}
$log = ["water_ml"=>0,"steps"=>0,"calories"=>0];
$stmt = $mysqli->prepare("SELECT water_ml, steps, calories FROM health_logs WHERE user_id = ? AND log_date = ?");
$stmt->bind_param("is", $user_id, $today); $stmt->execute(); $stmt->bind_result($log['water_ml'], $log['steps'], $log['calories']); $stmt->fetch(); $stmt->close();
?>
<h2>Daily Log (<?= htmlspecialchars($today) ?>)</h2>
<?php if(isset($msg)): ?><div class="alert"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
<form method="post" class="card form">
  <label>Water (ml) <input type="number" name="water_ml" min="0" value="<?= (int)$log['water_ml'] ?>" /></label>
  <label>Steps <input type="number" name="steps" min="0" value="<?= (int)$log['steps'] ?>" /></label>
  <label>Calories (intake) <input type="number" name="calories" min="0" value="<?= (int)$log['calories'] ?>" /></label>
  <button class="btn" type="submit">Save</button>
</form>
<?php include "footer.php"; ?>
