<?php
require __DIR__ . '/../includes/auth.php';
require_login();

$host = $_GET['host'] ?? '';
$output = '';

if ($host !== '') {
    $cmd = "ping -c 1 " . $host . " 2>&1";
    $output = shell_exec($cmd);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Kiểm tra kết nối | FeedbackHub</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="navbar">
  <div class="brand"><span class="dot"></span> FeedbackHub</div>
  <div class="nav-right"><a href="dashboard.php" class="btn btn-ghost" style="padding:6px 12px;">&larr; Quay lại</a></div>
</div>
<div class="container">
  <h2 class="section-title">Kiểm tra kết nối máy chủ</h2>
  <div class="card">
    <form method="GET" action="diagnostic.php">
      <label for="host">Địa chỉ host</label>
      <input type="text" id="host" name="host" value="<?= htmlspecialchars($host) ?>" placeholder="vd: 127.0.0.1">
      <button type="submit" class="btn btn-orange">Ping</button>
    </form>

    <?php if ($output !== ''): ?>
      <h3 style="color:var(--green); font-size:14px; margin-top:18px;">Kết quả:</h3>
      <pre><?= htmlspecialchars($output) ?></pre>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
