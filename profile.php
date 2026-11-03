<?php
require_once "db.php"; require_once "auth.php"; include "header.php";
$user_id = $_SESSION['user_id']; $notice = $error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $gender = $_POST["gender"] ?? null;
    $age = intval($_POST["age"] ?? 0);
    $height_cm = floatval($_POST["height_cm"] ?? 0);
    $weight_kg = floatval($_POST["weight_kg"] ?? 0);
    $stmt = $mysqli->prepare("UPDATE profiles SET gender = ?, age = ?, height_cm = ?, weight_kg = ? WHERE user_id = ?");
    $stmt->bind_param("siddi", $gender, $age, $height_cm, $weight_kg, $user_id);
    if ($stmt->execute()) { $notice = "Profile updated."; } else { $error = "Failed to update profile."; }
    $stmt->close();
}
$stmt = $mysqli->prepare("SELECT gender, age, height_cm, weight_kg FROM profiles WHERE user_id = ?");
$stmt->bind_param("i", $user_id); $stmt->execute(); $stmt->bind_result($gender, $age, $height_cm, $weight_kg); $stmt->fetch(); $stmt->close();
?>
<h2>Your Profile</h2>
<?php if($notice): ?><div class="alert"><?= htmlspecialchars($notice) ?></div><?php endif; ?>
<?php if($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post" class="card form">
  <label>Gender
    <select name="gender">
      <option value="" <?= $gender===""?"selected":""; ?>>Select</option>
      <option value="male" <?= $gender==="male"?"selected":""; ?>>Male</option>
      <option value="female" <?= $gender==="female"?"selected":""; ?>>Female</option>
      <option value="other" <?= $gender==="other"?"selected":""; ?>>Other</option>
    </select>
  </label>
  <label>Age <input type="number" name="age" value="<?= htmlspecialchars((string)$age) ?>" min="0" /></label>
  <label>Height (cm) <input type="number" step="0.1" name="height_cm" value="<?= htmlspecialchars((string)$height_cm) ?>" min="0" /></label>
  <label>Weight (kg) <input type="number" step="0.1" name="weight_kg" value="<?= htmlspecialchars((string)$weight_kg) ?>" min="0" /></label>
  <button class="btn" type="submit">Save</button>
</form>
<?php include "footer.php"; ?>
