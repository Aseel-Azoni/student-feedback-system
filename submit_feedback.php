<?php
session_start();
include "db.php";
include "auth.php";
require_login();
if ($_SESSION['role'] === 'admin') { header("Location: admin_dashboard.php"); exit; }

$message = "";
if (isset($_POST['submit'])) {
    $title = trim($_POST['title']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);

    if ($title !== "" && $category !== "" && $description !== "") {
        $stmt = $pdo->prepare("INSERT INTO feedback (user_id, title, category, description, status) VALUES (?, ?, ?, ?, 'Pending')");
        $stmt->execute([$_SESSION['user_id'], $title, $category, $description]);
        $message = "Feedback submitted successfully.";
    } else {
        $message = "Please complete all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Feedback</title>
    <link rel="stylesheet" href="../css/feedback.css">
</head>
<body>
<header>
    <div class="container">
        <h1 class="site-title">Submit Feedback</h1>
        <nav><ul class="nav-list"><li><a href="dashboard.php">Dashboard</a></li><li><a href="submit_feedback.php">Submit Feedback</a></li><li><a href="view_feedback.php">My Feedback</a></li><li><a href="logout.php">Logout</a></li></ul></nav>
    </div>
</header>
<main class="form-section">
    <div class="form-container">
        <h2>Submit Feedback</h2>
        <p>Help us improve by sharing your experience</p>
        <?php if ($message): ?><p class="success-message"><?php echo e($message); ?></p><?php endif; ?>
        <form method="POST">
            <label>Title</label>
            <input type="text" name="title" placeholder="Feedback title" required>
            <label>Category</label>
            <select name="category" required>
                <option value="">Select Category</option>
                <option>Course</option><option>Instructor</option><option>Grading</option><option>Exams</option><option>Campus</option><option>Service</option>
            </select>
            <label>Description</label>
            <textarea name="description" placeholder="Write your feedback here..." required></textarea>
            <button type="submit" name="submit">Submit</button>
        </form>
    </div>
</main>
<footer><div class="container"><p>&copy; 2026 Yanbu Industrial College - CS381 Project</p></div></footer>
</body>
</html>
