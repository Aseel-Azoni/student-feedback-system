<?php
session_start();
include "db.php";
$message = "";

if (isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $check = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
    $check->execute([$email]);

    if ($check->fetch()) {
        $message = "This email is already registered.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'student')");
        $stmt->execute([$name, $email, $hashedPassword]);
        $message = "Registration successful. You can login now.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Student Feedback System</title>
    <link rel="stylesheet" href="../css/register.css">
</head>
<body>
<header>
    <div class="container">
        <h1 class="site-title">Student Feedback System</h1>
        <nav><ul class="nav-list"><li><a href="../index.html">Home</a></li><li><a href="login.php">Login</a></li><li><a href="register.php">Register</a></li></ul></nav>
    </div>
</header>
<main class="form-section">
    <div class="form-container">
        <h2>Create Account</h2>
        <p>Register to start submitting feedback</p>
        <?php if ($message): ?><p class="success-message"><?php echo $message; ?></p><?php endif; ?>
        <form method="POST">
            <label>Name</label>
            <input type="text" name="name" placeholder="Enter your name" required>
            <label>Email</label>
            <input type="email" name="email" placeholder="Enter your email" required>
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter password" required>
            <button type="submit" name="register">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</main>
<footer><div class="container"><p>&copy; 2026 Yanbu Industrial College - CS381 Project</p></div></footer>
</body>
</html>
