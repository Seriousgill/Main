<?php
session_start();
include '../includes/db.php';

$error = '';
if (isset($_POST['login'])) {
    $username = trim($_POST['username'] ?? '');
    $password = md5($_POST['password'] ?? '');

    $stmt = $conn->prepare('SELECT id, username FROM admin_users WHERE username = ? AND password = ? LIMIT 1');
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user) {
        $_SESSION['admin'] = $user['username'];
        header('Location: dashboard.php');
        exit;
    }

    $error = 'Invalid login credentials.';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-3">Admin Login</h4>
                    <?php if ($error !== '') { ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php } ?>
                    <form method="post">
                        <input type="text" class="form-control mb-2" name="username" placeholder="Username" required>
                        <input type="password" class="form-control mb-3" name="password" placeholder="Password" required>
                        <button class="btn btn-primary w-100" name="login" type="submit">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
