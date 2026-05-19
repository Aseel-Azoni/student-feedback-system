<?php
session_start();
include "db.php";
$message = "";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: dashboard.php");
        }
        exit;
    } else {
        $message = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student Feedback System</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
<header>
    <div class="container">
        <h1 class="site-title">Student Feedback System</h1>
        <nav><ul class="nav-list"><li><a href="../index.html">Home</a></li><li><a href="login.php">Login</a></li><li><a href="register.php">Register</a></li></ul></nav>
    </div>
</header>
<main>
    <section class="form-section">
        <div class="form-container">
            <h2>Student Login</h2>
            <p>Please enter your email and password to access your account.</p>
            <?php if ($message): ?><p class="error-message"><?php echo $message; ?></p><?php endif; ?>
            <form method="POST">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter your email" required>
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
                <button type="submit" name="login">Login</button>
            </form>
            <p>Do not have an account? <a href="register.php">Register here</a></p>
        </div>
    </section>
</main>
<footer><div class="container"><p>&copy; 2026 Yanbu Industrial College - CS381 Project</p></div></footer>
</body>
</html>
