<?php include("../config/db.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Books</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container card">
    <h2>Available Books</h2>

    <?php
    $res = mysqli_query($conn, "SELECT * FROM books");

    while ($row = mysqli_fetch_assoc($res)) {
        echo "<p>{$row['book_name']} - {$row['author']}</p>";
    }
    ?>
</div>
</body>
</html>
