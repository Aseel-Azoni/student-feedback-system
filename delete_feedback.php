<?php
session_start();
include "db.php";
include "auth.php";
require_login();
if ($_SESSION['role'] === 'admin') { header("Location: admin_dashboard.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM feedback WHERE feedback_id = ? AND user_id = ?");
    $stmt->execute([$id, $_SESSION['user_id']]);
}

header("Location: view_feedback.php?deleted=1");
exit;
