<?php
include "db.php";

$email = "admin@yic.edu.sa";
$password = password_hash("123456", PASSWORD_DEFAULT);

$stmt = $pdo->prepare("
    UPDATE users 
    SET password = ?, role = 'admin'
    WHERE email = ?
");

$stmt->execute([$password, $email]);

echo "Admin password reset successfully. Password is 123456";
?>