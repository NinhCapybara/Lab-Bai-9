<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/db.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = current_user();    
    $title   = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';

    $stmt = $conn->prepare(
        "INSERT INTO feedbacks (user_id, title, content) VALUES (?, ?, ?)"
    );
    $stmt->bind_param('iss', $user['id'], $title, $content);
    $stmt->execute();
    $stmt->close();
}

header('Location: dashboard.php');
exit;
