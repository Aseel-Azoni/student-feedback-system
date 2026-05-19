<?php
session_start();

include "db.php";
include "auth.php";

require_login();

if ($_SESSION['role'] === 'admin') {
    header("Location: admin_dashboard.php");
    exit;
}

$stmt = $pdo->prepare("
    SELECT * FROM feedback
    WHERE user_id = ?
    ORDER BY feedback_id DESC
");

$stmt->execute([$_SESSION['user_id']]);

$feedbacks = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Feedback</title>

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/feedbacks.css">
</head>

<body>

<header>
    <div class="container">

        <h1 class="site-title">My Feedback</h1>

        <nav>
            <ul class="nav-list">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="submit_feedback.php">Submit Feedback</a></li>
                <li><a href="view_feedback.php">My Feedback</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>

    </div>
</header>

<main>

<section class="hero">
    <div class="container">

        <h2>Your Submitted Feedback</h2>

        <p>
            Here you can view, edit, or delete
            the feedback you submitted.
        </p>

    </div>
</section>

<section class="feedback-section container">

    <?php if (isset($_GET['updated'])): ?>
        <div class="alert success">
            Feedback updated successfully.
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert danger">
            Feedback deleted successfully.
        </div>
    <?php endif; ?>

    <?php if (!$feedbacks): ?>

        <div class="feedback-card">
            <p>No feedback submitted yet.</p>
        </div>

    <?php endif; ?>

    <?php foreach ($feedbacks as $row): ?>

        <div class="feedback-card">

            <h3><?php echo htmlspecialchars($row['title']); ?></h3>

            <p>
                <strong>Category:</strong>
                <?php echo htmlspecialchars($row['category']); ?>
            </p>

            <p>
                <strong>Description:</strong>
                <?php echo htmlspecialchars($row['description']); ?>
            </p>

            <p>
                <strong>Status:</strong>
                <?php echo htmlspecialchars($row['status']); ?>
            </p>

            <div class="card-actions">

                <a class="edit-btn"
                   href="edit_feedback.php?id=<?php echo $row['feedback_id']; ?>">
                    Edit
                </a>

                <form method="POST"
                      action="delete_feedback.php"
                      onsubmit="return confirm('Delete this feedback?');">

                    <input type="hidden"
                           name="id"
                           value="<?php echo $row['feedback_id']; ?>">

                    <button class="delete-btn"
                            type="submit">
                        Delete
                    </button>

                </form>

            </div>

        </div>

    <?php endforeach; ?>

</section>

</main>

<footer>
    <div class="container">
        <p>
            &copy; 2026 Yanbu Industrial College - CS381 Project
        </p>
    </div>
</footer>

</body>
</html>