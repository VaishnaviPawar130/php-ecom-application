<?php
include "includes/auth.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

    <?php include "includes/sidebar.php"; ?>

    <div class="ml-64 min-h-screen p-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Dashboard</h1>
                <p class="text-slate-500 mt-1">
                    Welcome back, <?php echo htmlspecialchars($_SESSION['admin_name'] ?? 'Admin'); ?>
                </p>
            </div>

            <div class="mt-4 md:mt-0">
                <a href="add_product.php"
                    class="inline-flex items-center rounded-xl bg-amber-600 px-5 py-3 text-sm font-semibold text-white shadow hover:bg-amber-700 transition">
                    + Add New Product
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Products</p>
                        <h2 class="text-3xl font-bold text-slate-800 mt-2">0</h2>
                    </div>
                    <div class="h-14 w-14 rounded-2xl bg-blue-100 flex items-center justify-center">
                        <span class="text-2xl">📦</span>
                    </div>
                </div>
                <p class="text-xs text-slate-400 mt-4">Products available in catalog</p>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Admins</p>
                        <h2 class="text-3xl font-bold text-slate-800 mt-2">1</h2>
                    </div>
                    <div class="h-14 w-14 rounded-2xl bg-emerald-100 flex items-center justify-center">
                        <span class="text-2xl">👤</span>
                    </div>
                </div>
                <p class="text-xs text-slate-400 mt-4">Active admin accounts</p>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Orders</p>
                        <h2 class="text-3xl font-bold text-slate-800 mt-2">0</h2>
                    </div>
                    <div class="h-14 w-14 rounded-2xl bg-violet-100 flex items-center justify-center">
                        <span class="text-2xl">🛒</span>
                    </div>
                </div>
                <p class="text-xs text-slate-400 mt-4">Orders processed in system</p>
            </div>
        </div>




    </div>
    </div>
    </div>

</body>

</html>