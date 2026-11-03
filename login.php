<?php
require_once "db.php";
include "header.php";
$email = ""; $errors = [];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? ""); $password = $_POST["password"] ?? "";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (empty($errors)) {
        $stmt = $mysqli->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email); $stmt->execute(); $stmt->bind_result($id, $name, $hash);
        if ($stmt->fetch()) {
            if (password_verify($password, $hash)) {
                $_SESSION["user_id"] = $id; $_SESSION["user_name"] = $name; header("Location: dashboard.php"); exit;
            } else { $errors[] = "Invalid credentials."; }
        } else { $errors[] = "Account not found."; }
        $stmt->close();
    }
}
?>
<h2>Login</h2>
<?php if(isset($_GET['msg']) && $_GET['msg']==='please_login'): ?><div class="alert">Please login to continue.</div><?php endif; ?>
<?php if (!empty($errors)): ?><div class="alert error"><ul><?php foreach($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form method="post" class="card form">
  <label>Email <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required/></label>
  <label>Password <input type="password" name="password" required/></label>
  <button class="btn" type="submit">Login</button>
</form>
<p>No account? <a href="register.php">Register</a></p>
<?php include "footer.php"; ?>
