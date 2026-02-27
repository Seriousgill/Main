<?php
include 'includes/db.php';

if (!isset($_POST['submit_enquiry'])) {
    header('Location: contact.php');
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$message = trim($_POST['message'] ?? '');
$productName = trim($_POST['product_name'] ?? '');
$productId = null;

if ($productName !== '') {
    $stmtProduct = $conn->prepare('SELECT id FROM products WHERE title = ? LIMIT 1');
    $stmtProduct->bind_param('s', $productName);
    $stmtProduct->execute();
    $row = $stmtProduct->get_result()->fetch_assoc();
    if ($row) {
        $productId = (int) $row['id'];
    }
}

$stmt = $conn->prepare('INSERT INTO enquiries (name, email, phone, message, product_id) VALUES (?, ?, ?, ?, ?)');
$stmt->bind_param('ssssi', $name, $email, $phone, $message, $productId);
$stmt->execute();

header('Location: contact.php?success=1');
exit;
