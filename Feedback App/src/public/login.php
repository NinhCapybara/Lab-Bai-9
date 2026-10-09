<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/db.php';

if (!empty($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $query = "SELECT * FROM users WHERE username = '$username' AND password = SHA2('$password', 512) LIMIT 1";
    $result = $conn->query($query);

    if ($result === false) {
        $error = 'Loi truy van CSDL: ' . $conn->error;
    } elseif ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['nickname'] = $user['nickname'];
        $_SESSION['role']     = $user['role'];
        if ($user['role'] === 'admin') {
            setrawcookie('token', 'flag{xss_c00ki3_st34l_vi4_d0cum3nt_c00ki3_129ea645a115ae7813d99c35aff3b76a347f40422c3aa085f851c7c33722659bc5cce9bcbf4d0a965be2bba101e1c52b98fc9e738168614bebdf7e256e958c1e}', time() + 3600, '/', '', false, false);
        } else {
            setrawcookie('token', '', time() - 3600, '/', '', false, false);
        }
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Sai ten dang nhap hoac mat khau.';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Đăng nhập | FeedbackHub</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="center-wrap">
  <div class="card login-card">
    <h1>FeedbackHub</h1>
    <div class="sub">Hệ thống quản lý phản hồi khách hàng</div>

    <?php if ($error): ?>
      <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
      <label for="username">Tên đăng nhập</label>
      <input type="text" id="username" name="username" autocomplete="off" required>

      <label for="password">Mật khẩu</label>
      <input type="password" id="password" name="password" required>

      <button type="submit" class="btn btn-primary">Đăng nhập</button>
    </form>
  </div>
</div>
</body>
</html>
