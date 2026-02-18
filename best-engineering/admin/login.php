<?php
require_once __DIR__ . '/_init.php';
if (is_admin_logged_in()) {
    header('Location: dashboard.php');
    exit;
}
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf($_POST['csrf_token'] ?? null)) {
        $error = 'Invalid token.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $stmt = $pdo->prepare('SELECT * FROM admin_users WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        $admin = $stmt->fetch();
        if ($admin && password_verify($password, $admin['password'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = (int) $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header('Location: dashboard.php');
            exit;
        }
        $error = 'Invalid credentials.';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="admin-layout d-flex align-items-center">
<div class="container" style="max-width:420px">
    <div class="section-card">
        <h3 class="mb-3">Admin Login</h3>
        <?php if ($error): ?><div class="alert alert-danger"><?= e($error); ?></div><?php endif; ?>
        <form method="post">
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()); ?>">
            <div class="mb-3"><input class="form-control" name="username" placeholder="Username" required></div>
            <div class="mb-3"><input class="form-control" type="password" name="password" placeholder="Password" required></div>
            <button class="btn btn-warning w-100">Login</button>
        </form>
    </div>
</div>
</body>
</html>
