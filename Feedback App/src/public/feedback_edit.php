<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/db.php';
require_login();

$user = current_user();
$isAdmin = $user['role'] === 'admin';
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

$stmt = $conn->prepare("SELECT * FROM feedbacks WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$feedback = $res->fetch_assoc();
$stmt->close();

if (!$feedback || (!$isAdmin && (int)$feedback['user_id'] !== (int)$user['id'])) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $stmt = $conn->prepare("UPDATE feedbacks SET title = ?, content = ? WHERE id = ?");
    $stmt->bind_param('ssi', $title, $content, $id);
    $stmt->execute();
    $stmt->close();
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sửa phản hồi | FeedbackHub</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="navbar">
  <div class="brand"><span class="dot"></span> FeedbackHub</div>
  <div class="nav-right"><a href="dashboard.php" class="btn btn-ghost" style="padding:6px 12px;">&larr; Quay lại</a></div>
</div>
<div class="container">
  <h2 class="section-title">Sửa phản hồi #<?= (int)$feedback['id'] ?></h2>
  <div class="card">
    <form method="POST" action="feedback_edit.php?id=<?= (int)$feedback['id'] ?>">
      <input type="hidden" name="id" value="<?= (int)$feedback['id'] ?>">
      <label for="title">Tiêu đề</label>
      <input type="text" id="title" name="title" value="<?= htmlspecialchars($feedback['title']) ?>" required>

      <label for="content">Nội dung</label>
      <textarea id="content" name="content" rows="5" required><?= htmlspecialchars($feedback['content']) ?></textarea>

      <button type="submit" class="btn btn-orange">Lưu thay đổi</button>
    </form>
  </div>
</div>
</body>
</html>
