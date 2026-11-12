<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/db.php';
require_login();

$user = current_user();
$isAdmin = $user['role'] === 'admin';

$perPage = 3;
$page = max(1, (int)($_GET['page'] ?? 1));
$countResult = $conn->query("SELECT COUNT(*) AS total FROM feedbacks");
$totalFeedbacks = (int)$countResult->fetch_assoc()['total'];
$totalPages = max(1, (int)ceil($totalFeedbacks / $perPage));
$page = min($page, $totalPages);
$offset = ($page - 1) * $perPage;
$result = $conn->query(
    "SELECT f.*, u.username FROM feedbacks f JOIN users u ON f.user_id = u.id ORDER BY f.id DESC LIMIT $perPage OFFSET $offset"
);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Quản lý và theo dõi phản hồi khách hàng trong Feedback Hub.">
<title>Bảng điều khiển | Feedback Hub</title>
<script src="assets/theme.js?v=<?= filemtime(__DIR__ . '/assets/theme.js') ?>"></script>
<link rel="stylesheet" href="assets/style.css?v=<?= filemtime(__DIR__ . '/assets/style.css') ?>">
</head>
<body class="dashboard-page">
<header class="navbar">
  <a class="brand" href="dashboard.php" aria-label="Feedback Hub - trang chủ">
    <span class="brand-mark" aria-hidden="true">F</span>
    <span>Feedback<span class="brand-accent">Hub</span></span>
  </a>
  <div class="nav-right">
    <span class="badge"><?= htmlspecialchars($user['role']) ?></span>
    <span class="user-greeting">Xin chào, <strong><?= htmlspecialchars($user['nickname']) ?></strong></span>
    <button class="btn btn-ghost theme-toggle" type="button" data-theme-toggle>Giao diện</button>
    <a href="logout.php" class="btn btn-ghost">Đăng xuất</a>
  </div>
</header>

<main class="container dashboard-container">
  <section class="page-intro">
    <div>
      <p class="eyebrow">KHÔNG GIAN LÀM VIỆC</p>
      <h1>Phản hồi khách hàng</h1>
      <p class="intro-copy">Chia sẻ ý kiến của bạn hoặc xem những phản hồi mới nhất từ cộng đồng.</p>
    </div>
  </section>

  <section class="workspace" aria-label="Quản lý phản hồi">
    <div class="composer card">
      <div class="section-heading">
        <div>
          <h2>Gửi phản hồi mới</h2>
          <p>Hãy cho chúng tôi biết trải nghiệm của bạn.</p>
        </div>
      </div>
      <form method="POST" action="feedback_add.php" accept-charset="UTF-8">
        <label for="title">Tiêu đề <span class="required">Bắt buộc</span></label>
        <input type="text" id="title" name="title" required maxlength="150" placeholder="Tóm tắt ý kiến của bạn">

        <label for="content">Nội dung <span class="required">Bắt buộc</span></label>
        <textarea id="content" name="content" rows="5" required placeholder="Chia sẻ thêm chi tiết..."></textarea>

        <button type="submit" class="btn btn-primary">Gửi phản hồi <span aria-hidden="true">→</span></button>
      </form>
      <p class="form-hint">Các trường có nhãn “Bắt buộc” cần được điền trước khi gửi.</p>
      <a class="report-link" href="/report?file=report.pdf">
        <span class="report-icon" aria-hidden="true">PDF</span>
        <span><strong>Xem báo cáo</strong><small>Báo cáo tổng quan dạng PDF</small></span>
        <span class="report-arrow" aria-hidden="true">→</span>
      </a>
    </div>

  <?php if ($totalFeedbacks > 0): ?>
    <section class="feedback-section" aria-labelledby="feedback-heading">
      <div class="section-heading list-heading">
        <div>
          <p class="eyebrow">CẬP NHẬT MỚI NHẤT</p>
          <h2 id="feedback-heading">Danh sách phản hồi</h2>
        </div>
        <span class="count-pill"><?= $totalFeedbacks ?> phản hồi</span>
      </div>
      <div class="feedback-list">
      <?php while ($row = $result->fetch_assoc()): ?>
        <article class="feedback-item">
          <div class="feedback-topline">
            <div class="meta">
              <span class="avatar" aria-hidden="true"><?= htmlspecialchars(strtoupper(substr($row['username'], 0, 1))) ?></span>
              <span><strong><?= htmlspecialchars($row['username']) ?></strong><br><time><?= htmlspecialchars($row['created_at']) ?></time></span>
            </div>
            <span class="feedback-id">#<?= (int)$row['id'] ?></span>
          </div>
          <h3 class="feedback-title"><?= htmlspecialchars($row['title']) ?></h3>
          <div class="content"><?php echo $row['content']; ?></div>
          <?php
          $isOwner = (int)$row['user_id'] === (int)$user['id'];
          $canEdit = !$isAdmin && $isOwner;
          $canDelete = $isAdmin || $isOwner;
          ?>
          <?php if ($canEdit || $canDelete): ?>
            <div class="feedback-actions">
              <?php if ($canEdit): ?>
                <a href="feedback_edit.php?id=<?= (int)$row['id'] ?>&amp;return_page=<?= $page ?>" class="action-link">Sửa phản hồi</a>
              <?php endif; ?>
              <?php if ($canDelete): ?>
                <a href="feedback_delete.php?id=<?= (int)$row['id'] ?>&amp;page=<?= $page ?>" class="action-link action-delete" onclick="return confirm('Xóa phản hồi này?');">Xóa</a>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </article>
      <?php endwhile; ?>
      </div>
        <?php if ($totalPages > 1): ?>
        <nav class="pagination" aria-label="Phân trang phản hồi">
          <?php if ($page > 1): ?>
            <a class="page-link" href="dashboard.php?page=<?= $page - 1 ?>" aria-label="Trang trước">&larr; Trước</a>
          <?php else: ?>
            <span class="page-link disabled" aria-disabled="true">&larr; Trước</span>
          <?php endif; ?>
          <span class="page-status">Trang <strong><?= $page ?></strong> / <?= $totalPages ?></span>
          <?php if ($page < $totalPages): ?>
            <a class="page-link" href="dashboard.php?page=<?= $page + 1 ?>" aria-label="Trang tiếp theo">Tiếp &rarr;</a>
          <?php else: ?>
            <span class="page-link disabled" aria-disabled="true">Tiếp &rarr;</span>
          <?php endif; ?>
        </nav>
      <?php endif; ?>
    </section>
  <?php else: ?>
    <section class="feedback-section empty-state" aria-labelledby="feedback-heading">
      <div class="section-heading">
        <div>
          <p class="eyebrow">CẬP NHẬT MỚI NHẤT</p>
          <h2 id="feedback-heading">Danh sách phản hồi</h2>
        </div>
      </div>
      <div class="empty-message">
        <span class="empty-icon" aria-hidden="true">✦</span>
        <h3>Chưa có phản hồi nào</h3>
        <p>Hãy gửi phản hồi đầu tiên bằng biểu mẫu bên cạnh.</p>
      </div>
    </section>
  <?php endif; ?>
  </section>
</main>

<footer class="note">Feedback Hub <span aria-hidden="true">·</span> Không gian tiếp nhận phản hồi</footer>
</body>
</html>
