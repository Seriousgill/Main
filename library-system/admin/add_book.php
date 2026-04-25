<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
include("../config/db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container">
    <form method="POST" class="card">
        <h2>Add Book</h2>
        <input type="text" name="name" placeholder="Book Name" required><br>
        <input type="text" name="category" placeholder="Category" required><br>
        <input type="text" name="author" placeholder="Author" required><br>
        <input type="number" name="qty" placeholder="Quantity" min="1" required><br>
        <button name="add">Add Book</button>
    </form>

    <?php
    if (isset($_POST['add'])) {
        $n = $_POST['name'];
        $c = $_POST['category'];
        $a = $_POST['author'];
        $q = $_POST['qty'];

        mysqli_query($conn, "INSERT INTO books(book_name,category,author,quantity,available)
        VALUES('$n','$c','$a','$q','$q')");

        echo "<p class='success'>Book Added!</p>";
    }
    ?>

    <a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>
