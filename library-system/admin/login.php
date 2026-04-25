<?php
session_start();
include("../config/db.php");

if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container">
    <form method="POST" class="card">
        <h2>Admin Login</h2>
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button name="login">Login</button>
    </form>

    <?php
    if (isset($_POST['login'])) {
        $u = $_POST['username'];
        $p = $_POST['password'];

        $q = mysqli_query($conn, "SELECT * FROM admins WHERE username='$u' AND password='$p'");

        if (mysqli_num_rows($q)) {
            $admin = mysqli_fetch_assoc($q);
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header("Location: dashboard.php");
            exit;
        } else {
            echo "<p class='error'>Invalid Login</p>";
        }
    }
    ?>
</div>
</body>
</html>
