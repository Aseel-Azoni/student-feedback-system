<?php
session_start();

include "db.php";
include "auth.php";

require_admin();

$message = "";

/* Update Feedback Status */
if (isset($_POST['update_status'])) {

    $feedback_id = $_POST['feedback_id'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("
        UPDATE feedback
        SET status = ?
        WHERE feedback_id = ?
    ");

    $stmt->execute([
        $status,
        $feedback_id
    ]);

    $message = "Feedback status updated.";
}

/* Delete Feedback */
if (isset($_POST['delete_feedback'])) {

    $feedback_id = $_POST['feedback_id'];

    $stmt = $pdo->prepare("
        DELETE FROM feedback
        WHERE feedback_id = ?
    ");

    $stmt->execute([
        $feedback_id
    ]);

    $message = "Feedback deleted.";
}

/* Get All Feedback */
$stmt = $pdo->query("
    SELECT
        feedback.*,
        users.name,
        users.email
    FROM feedback
    JOIN users
    ON feedback.user_id = users.user_id
    ORDER BY feedback.feedback_id DESC
");

$feedbacks = $stmt->fetchAll();

/* Statistics */
$countUsers = $pdo->query("
    SELECT COUNT(*) AS total
    FROM users
    WHERE role='student'
")->fetch()['total'];

$countFeedback = $pdo->query("
    SELECT COUNT(*) AS total
    FROM feedback
")->fetch()['total'];

$countPending = $pdo->query("
    SELECT COUNT(*) AS total
    FROM feedback
    WHERE status='Pending'
")->fetch()['total'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard</title>

    <link rel="stylesheet"
          href="../css/style.css">

    <link rel="stylesheet"
          href="../css/admin.css">
</head>

<body>

<header>

    <div class="container">

        <h1 class="site-title">
            Admin Dashboard
        </h1>

        <nav>

            <ul class="nav-list">

                <li>
                    <a href="admin_dashboard.php">
                        Dashboard
                    </a>
                </li>

                <li>
                    <a href="logout.php">
                        Logout
                    </a>
                </li>

            </ul>

        </nav>

    </div>

</header>

<main class="container">

    <section class="admin-hero">

        <h2>
            Welcome,
            <?php echo htmlspecialchars($_SESSION['name']); ?>!
        </h2>

        <p>
            Review, update,
            and manage student feedback.
        </p>

    </section>

    <section class="stats-grid">

        <div class="stat-card">
            <h3><?php echo $countUsers; ?></h3>
            <p>Students</p>
        </div>

        <div class="stat-card">
            <h3><?php echo $countFeedback; ?></h3>
            <p>Total Feedback</p>
        </div>

        <div class="stat-card">
            <h3><?php echo $countPending; ?></h3>
            <p>Pending</p>
        </div>

    </section>

    <?php if ($message): ?>

        <div class="success-message">
            <?php echo htmlspecialchars($message); ?>
        </div>

    <?php endif; ?>

    <section class="table-section">

        <h2>All Feedback</h2>

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>
                        <th>Student</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>

                </thead>

                <tbody>

                <?php foreach ($feedbacks as $row): ?>

                    <tr>

                        <td>

                            <?php echo htmlspecialchars($row['name']); ?>

                            <br>

                            <small>
                                <?php echo htmlspecialchars($row['email']); ?>
                            </small>

                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['title']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['category']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['description']); ?>
                        </td>

                        <td>

                            <span class="status <?php echo strtolower(htmlspecialchars($row['status'])); ?>">

                                <?php echo htmlspecialchars($row['status']); ?>

                            </span>

                        </td>

                        <td>

                            <!-- Update Status -->

                            <form method="POST"
                                  class="action-form">

                                <input type="hidden"
                                       name="feedback_id"
                                       value="<?php echo $row['feedback_id']; ?>">

                                <select name="status">

                                    <option value="Pending"
                                    <?php if($row['status']=='Pending') echo 'selected'; ?>>
                                        Pending
                                    </option>

                                    <option value="Reviewed"
                                    <?php if($row['status']=='Reviewed') echo 'selected'; ?>>
                                        Reviewed
                                    </option>

                                    <option value="Resolved"
                                    <?php if($row['status']=='Resolved') echo 'selected'; ?>>
                                        Resolved
                                    </option>

                                    <option value="Rejected"
                                    <?php if($row['status']=='Rejected') echo 'selected'; ?>>
                                        Rejected
                                    </option>

                                </select>

                                <button type="submit"
                                        name="update_status">
                                    Update
                                </button>

                            </form>

                            <!-- Delete -->

                            <form method="POST"
                                  class="action-form"
                                  onsubmit="return confirm('Delete this feedback?');">

                                <input type="hidden"
                                       name="feedback_id"
                                       value="<?php echo $row['feedback_id']; ?>">

                                <button type="submit"
                                        name="delete_feedback"
                                        class="delete-btn">
                                    Delete
                                </button>

                            </form>

                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

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