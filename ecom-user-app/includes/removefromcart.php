<?php
session_start();
include __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?auth=open");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: cart.php");
    exit();
}

$user_id = (int) $_SESSION['user_id'];
$cart_id = isset($_POST['cart_id']) ? (int) $_POST['cart_id'] : 0;

if ($cart_id <= 0) {
    header("Location: cart.php");
    exit();
}

$delete_stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
$delete_stmt->bind_param("ii", $cart_id, $user_id);
$delete_stmt->execute();

header("Location: cart.php");
exit();
?>
