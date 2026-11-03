<?php
require_once "db.php";
include "header.php";
$name = $email = $password = $confirm = "";
$errors = [];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm = $_POST["confirm"] ?? "";
    if ($name === "") $errors[] = "Name is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
    if ($password !== $confirm) $errors[] = "Passwords do not match.";
    if (empty($errors)) {
        $stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email); $stmt->execute(); $stmt->store_result();
        if ($stmt->num_rows > 0) { $errors[] = "Email already registered."; }
        $stmt->close();
        if (empty($errors)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $mysqli->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hash);
            if ($stmt->execute()) {
                $user_id = $stmt->insert_id;
                $stmt2 = $mysqli->prepare("INSERT INTO profiles (user_id) VALUES (?)");
                $stmt2->bind_param("i", $user_id); $stmt2->execute(); $stmt2->close();
                $_SESSION["user_id"] = $user_id; $_SESSION["user_name"] = $name;
                header("Location: dashboard.php"); exit;
            } else { $errors[] = "Registration failed. Please try again."; }
            $stmt->close();
        }
    }
}
?>
<h2>Create your account</h2>
<?php if (!empty($errors)): ?><div class="alert error"><ul><?php foreach($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form method="post" class="card form">
  <label>Name <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" required/></label>
  <label>Email <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required/></label>
  <label>Password <input type="password" name="password" required/></label>
  <label>Confirm Password <input type="password" name="confirm" required/></label>
  <button class="btn" type="submit">Register</button>
</form>
<?php include "footer.php"; ?>
