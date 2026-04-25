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
    <title>Manage Books</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container card">
    <h2>Books List</h2>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Author</th>
            <th>Qty</th>
        </tr>

        <?php
        $res = mysqli_query($conn, "SELECT * FROM books");

        while ($row = mysqli_fetch_assoc($res)) {
            echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['book_name']}</td>
            <td>{$row['category']}</td>
            <td>{$row['author']}</td>
            <td>{$row['quantity']}</td>
            </tr>";
        }
        ?>
    </table>

    <a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>
