<?php
session_start();
include "auth.php";
require_login();
if ($_SESSION['role'] === 'admin') {
    header("Location: admin_dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Student Feedback System</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
<header>
    <div class="container">
        <h1 class="site-title">Student Dashboard</h1>
        <nav><ul class="nav-list"><li><a href="dashboard.php">Dashboard</a></li><li><a href="submit_feedback.php">Submit Feedback</a></li><li><a href="view_feedback.php">My Feedback</a></li><li><a href="logout.php">Logout</a></li></ul></nav>
    </div>
</header>
<main>
    <section class="hero">
        <div class="container">
            <h2>Welcome Back, <?php echo e($_SESSION['name']); ?>!</h2>
            <p>Manage your feedback and help improve YIC services.</p>
            <div class="button-group">
                <a href="submit_feedback.php" class="btn">Submit New Feedback</a>
                <a href="view_feedback.php" class="btn secondary-btn">View My Feedback</a>
            </div>
        </div>
    </section>
</main>
<footer><div class="container"><p>&copy; 2026 Yanbu Industrial College - CS381 Project</p></div></footer>
</body>
</html>
