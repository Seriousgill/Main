<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container card">
    <h2>Admin Dashboard</h2>

    <a href="add_book.php">Add Book</a> |
    <a href="manage_books.php">Manage Books</a> |
    <a href="logout.php">Logout</a>
</div>
</body>
</html>
