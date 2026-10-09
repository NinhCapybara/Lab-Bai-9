<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/db.php';
require_login();

$user = current_user();
$isAdmin = $user['role'] === 'admin';

$result = $conn->query("SELECT f.*, u.username FROM feedbacks f JOIN users u ON f.user_id = u.id ORDER BY f.id DESC");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bảng điều khiển | FeedbackHub</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="navbar">
  <div class="brand"><span class="dot"></span> FeedbackHub</div>
  <div class="nav-right">
    <span class="badge"><?= htmlspecialchars($user['role']) ?></span>
    <span>Xin chào, <?= htmlspecialchars($user['nickname']) ?></span>
    <a href="logout.php" class="btn btn-ghost" style="padding:6px 12px;">Đăng xuất</a>
  </div>
</div>

<div class="container">

  <h2 class="section-title">Gửi phản hồi mới</h2>
  <div class="card">
    <form method="POST" action="feedback_add.php">
      <label for="title">Tiêu đề</label>
      <input type="text" id="title" name="title" required maxlength="150">

      <label for="content">Nội dung</label>
      <textarea id="content" name="content" rows="4" required></textarea>

      <button type="submit" class="btn btn-orange">Gửi phản hồi</button>
    </form>
  </div>

  <h2 class="section-title">Danh sách phản hồi</h2>

  <?php if ($result && $result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="feedback-item">
        <div class="meta">#<?= (int)$row['id'] ?> • bởi <?= htmlspecialchars($row['username']) ?> • <?= htmlspecialchars($row['created_at']) ?></div>
        <div class="title"><?= htmlspecialchars($row['title']) ?></div>
        <div class="content">
          <?php echo $row['content']; ?>
        </div>
        <div class="feedback-actions">
          <?php if ($isAdmin || (int)$row['user_id'] === (int)$user['id']): ?>
            <a href="feedback_edit.php?id=<?= (int)$row['id'] ?>">Sửa</a>
            <a href="feedback_delete.php?id=<?= (int)$row['id'] ?>" class="btn-danger" onclick="return confirm('Xóa phản hồi này?');">Xóa</a>
          <?php endif; ?>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>Chưa có phản hồi nào.</p>
  <?php endif; ?>

  <h2 class="section-title">Công cụ hệ thống</h2>
  <div class="tools-grid">
    <div class="tool-card">
      <h3>Tài liệu nội bộ</h3>
      <p>Xem tài liệu được đính kèm trong hệ thống.</p>
      <a href="attachment.php?doc=internal_memo_482.txt" class="btn btn-ghost" style="display:inline-block;">Mở tài liệu</a>
    </div>
    <div class="tool-card">
      <h3>Kiểm tra kết nối máy chủ</h3>
      <p>Ping thử một địa chỉ để kiểm tra tình trạng mạng nội bộ.</p>
      <form method="GET" action="diagnostic.php">
        <input type="text" name="host" placeholder="vd: 127.0.0.1" style="margin-bottom:8px;">
        <button type="submit" class="btn btn-ghost" style="width:100%;">Ping</button>
      </form>
    </div>
  </div>

</div>

<footer class="note">FeedbackHub Demo &middot; CTF / Security Research Lab</footer>
</body>
</html>
