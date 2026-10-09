<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/db.php';
require_login();

$user = current_user();
$isAdmin = $user['role'] === 'admin';
$id = (int)($_GET['id'] ?? 0);
if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM feedbacks WHERE id = ? AND (user_id = ? OR ? = 1)");
    $userId = (int)$user['id'];
    $adminAccess = $isAdmin ? 1 : 0;
    $stmt->bind_param('iii', $id, $userId, $adminAccess);
    $stmt->execute();
    $stmt->close();
}

header('Location: dashboard.php');
exit;
