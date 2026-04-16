<?php
include "includes/auth.php";
include "config/db.php";

$product_name = trim($_POST['product_name'] ?? '');
$product_code = trim($_POST['product_code'] ?? '');
$category = trim($_POST['category'] ?? '');
$brand = trim($_POST['brand'] ?? '');
$price = trim($_POST['price'] ?? '');
$stock = trim($_POST['stock'] ?? '');
$status = trim($_POST['status'] ?? 'Active');
$description = trim($_POST['description'] ?? '');

$image_name = '';

if ($product_name === '' || $price === '') {
    $_SESSION['product_error'] = "Product name and price are required.";
    header("Location: addproduct.php");
    exit();
}

if (!empty($_FILES['product_image']['name'])) {
    $upload_dir = "uploads/";

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $original_name = basename($_FILES['product_image']['name']);
    $image_name = time() . "_" . preg_replace("/[^A-Za-z0-9._-]/", "_", $original_name);
    $target_file = $upload_dir . $image_name;

    if (!move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file)) {
        $_SESSION['product_error'] = "Product image upload failed.";
        header("Location: addproduct.php");
        exit();
    }
}

$sql = "INSERT INTO products 
        (product_name, product_code, category, brand, price, stock, status, description, image) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    $_SESSION['product_error'] = "Database prepare failed: " . $conn->error;
    header("Location: addproduct.php");
    exit();
}

$stmt->bind_param(
    "ssssdisss",
    $product_name,
    $product_code,
    $category,
    $brand,
    $price,
    $stock,
    $status,
    $description,
    $image_name
);

if ($stmt->execute()) {
    $_SESSION['product_success'] = "Product saved successfully.";
    header("Location: products.php");
    exit();
} else {
    $_SESSION['product_error'] = "Failed to save product.";
    header("Location: addproduct.php");
    exit();
}
?>