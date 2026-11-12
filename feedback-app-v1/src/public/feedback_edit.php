<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/db.php';
require_login();

$user = current_user();
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$returnPage = max(1, (int)($_GET['return_page'] ?? $_POST['return_page'] ?? 1));

$stmt = $conn->prepare("SELECT * FROM feedbacks WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$feedback = $res->fetch_assoc();
$stmt->close();

if (!$feedback || $user['role'] === 'admin' || (int)$feedback['user_id'] !== (int)$user['id']) {
    header('Location: dashboard.php?page=' . $returnPage);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $stmt = $conn->prepare("UPDATE feedbacks SET title = ?, content = ? WHERE id = ?");
    $stmt->bind_param('ssi', $title, $content, $id);
    $stmt->execute();
    $stmt->close();
    header('Location: dashboard.php?page=' . $returnPage);
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sửa phản hồi | Feedback Hub</title>
<script src="assets/theme.js?v=<?= filemtime(__DIR__ . '/assets/theme.js') ?>"></script>
<link rel="stylesheet" href="assets/style.css?v=<?= filemtime(__DIR__ . '/assets/style.css') ?>">
</head>
<body>
<header class="navbar">
  <a class="brand" href="dashboard.php" aria-label="Feedback Hub - trang chủ">
    <span class="brand-mark" aria-hidden="true">F</span>
    <span>Feedback<span class="brand-accent">Hub</span></span>
  </a>
  <div class="nav-right">
    <span class="badge"><?= htmlspecialchars($user['role']) ?></span>
    <span class="user-greeting">Xin chào, <strong><?= htmlspecialchars($user['nickname']) ?></strong></span>
    <button class="btn btn-ghost theme-toggle" type="button" data-theme-toggle>Giao diện</button>
    <a href="dashboard.php?page=<?= $returnPage ?>" class="btn btn-ghost">&larr; Quay lại</a>
  </div>
</header>
<main class="container">
  <section class="page-intro">
    <div>
      <p class="eyebrow">CHỈNH SỬA</p>
      <h1>Sửa phản hồi #<?= (int)$feedback['id'] ?></h1>
      <p class="intro-copy">Cập nhật nội dung rồi lưu thay đổi của bạn.</p>
    </div>
  </section>
  <div class="card edit-card">
    <form method="POST" action="feedback_edit.php?id=<?= (int)$feedback['id'] ?>" accept-charset="UTF-8">
      <input type="hidden" name="id" value="<?= (int)$feedback['id'] ?>">
      <input type="hidden" name="return_page" value="<?= $returnPage ?>">
      <label for="title">Tiêu đề</label>
      <input type="text" id="title" name="title" value="<?= htmlspecialchars($feedback['title']) ?>" required>

      <label for="content">Nội dung</label>
      <textarea id="content" name="content" rows="5" required><?= htmlspecialchars($feedback['content']) ?></textarea>

      <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
    </form>
  </div>
</main>
<footer class="note">Feedback Hub <span aria-hidden="true">·</span> Không gian tiếp nhận phản hồi</footer>
</body>
</html>
