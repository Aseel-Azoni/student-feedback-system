<?php
session_start();
include "db.php";
include "auth.php";
require_login();
if ($_SESSION['role'] === 'admin') { header("Location: admin_dashboard.php"); exit; }

$message = "";
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM feedback WHERE feedback_id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$feedback = $stmt->fetch();

if (!$feedback) {
    die("Feedback not found or access denied.");
}

if (isset($_POST['update'])) {
    $title = trim($_POST['title']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);

    if ($title !== "" && $category !== "" && $description !== "") {
        $update = $pdo->prepare("UPDATE feedback SET title = ?, category = ?, description = ? WHERE feedback_id = ? AND user_id = ?");
        $update->execute([$title, $category, $description, $id, $_SESSION['user_id']]);
        header("Location: view_feedback.php?updated=1");
        exit;
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
    <title>Edit Feedback</title>
    <link rel="stylesheet" href="../css/feedback.css">
</head>
<body>
<header>
    <div class="container">
        <h1 class="site-title">Edit Feedback</h1>
        <nav><ul class="nav-list"><li><a href="dashboard.php">Dashboard</a></li><li><a href="submit_feedback.php">Submit Feedback</a></li><li><a href="view_feedback.php">My Feedback</a></li><li><a href="logout.php">Logout</a></li></ul></nav>
    </div>
</header>
<main class="form-section">
    <div class="form-container">
        <h2>Edit Feedback</h2>
        <p>Update your submitted feedback details.</p>
        <?php if ($message): ?><p class="success-message"><?php echo e($message); ?></p><?php endif; ?>
        <form method="POST">
            <label>Title</label>
            <input type="text" name="title" value="<?php echo e($feedback['title']); ?>" required>
            <label>Category</label>
            <select name="category" required>
                <?php
                $categories = ['Course','Instructor','Grading','Exams','Campus','Service'];
                foreach ($categories as $cat) {
                    $selected = ($feedback['category'] === $cat) ? 'selected' : '';
                    echo "<option $selected>" . e($cat) . "</option>";
                }
                ?>
            </select>
            <label>Description</label>
            <textarea name="description" required><?php echo e($feedback['description']); ?></textarea>
            <button type="submit" name="update">Update Feedback</button>
            <a class="cancel-link" href="view_feedback.php">Cancel</a>
        </form>
    </div>
</main>
<footer><div class="container"><p>&copy; 2026 Yanbu Industrial College - CS381 Project</p></div></footer>
</body>
</html>
