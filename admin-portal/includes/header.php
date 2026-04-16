<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <?php if (isset($_SESSION['admin_id'])): ?>
        <nav class="bg-gray-900 text-white px-6 py-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <h1 class="text-xl font-bold">Admin Panel</h1>
                <div class="space-x-3">
                    <a href="dashboard.php" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">Dashboard</a>
                    <a href="add_product.php" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg">Add Product</a>
                    <a href="products.php" class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg">Products</a>
                    <a href="logout.php" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg">Logout</a>
                </div>
            </div>
        </nav>
    <?php endif; ?>