<?php
include "includes/auth.php";
include "config/db.php";

$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

    <?php include "includes/sidebar.php"; ?>

    <div class="ml-64 min-h-screen p-6">
        <div class="max-w-7xl mx-auto">
            <div class="mb-6 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-800">Product List</h1>
                    <p class="text-sm text-slate-500 mt-1">View all saved products in the system.</p>
                </div>

                <a href="addproduct.php"
                    class="inline-flex items-center justify-center rounded-xl bg-amber-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-amber-700 transition">
                    + Add Product
                </a>
            </div>

            <?php if (isset($_SESSION['product_success'])): ?>
                <div
                    class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                    <?php
                    echo $_SESSION['product_success'];
                    unset($_SESSION['product_success']);
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['product_error'])): ?>
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                    <?php
                    echo $_SESSION['product_error'];
                    unset($_SESSION['product_error']);
                    ?>
                </div>
            <?php endif; ?>

            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
                    <h2 class="text-lg font-semibold text-slate-800">Saved Products</h2>
                    <p class="text-sm text-slate-500 mt-1">All products added by admin will appear here.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-slate-700">
                        <thead class="bg-slate-100 text-slate-600">
                            <tr>
                                <th class="px-4 py-3 font-semibold">ID</th>
                                <th class="px-4 py-3 font-semibold">Image</th>
                                <th class="px-4 py-3 font-semibold">Product Name</th>
                                <th class="px-4 py-3 font-semibold">Code</th>
                                <th class="px-4 py-3 font-semibold">Category</th>
                                <th class="px-4 py-3 font-semibold">Brand</th>
                                <th class="px-4 py-3 font-semibold">Price</th>
                                <th class="px-4 py-3 font-semibold">Stock</th>
                                <th class="px-4 py-3 font-semibold">Status</th>
                                <th class="px-4 py-3 font-semibold">Description</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            <?php if ($result && $result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-4 py-3">
                                            <?php echo $row['id']; ?>
                                        </td>

                                        <td class="px-4 py-3">
                                            <?php if (!empty($row['image'])): ?>
                                                <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>"
                                                    alt="Product Image"
                                                    class="h-12 w-12 rounded-lg object-cover border border-slate-200">
                                            <?php else: ?>
                                                <span class="text-slate-400">No Image</span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="px-4 py-3 font-medium text-slate-800">
                                            <?php echo htmlspecialchars($row['product_name']); ?>
                                        </td>

                                        <td class="px-4 py-3">
                                            <?php echo htmlspecialchars($row['product_code']); ?>
                                        </td>
                                        <td class="px-4 py-3">
                                            <?php echo htmlspecialchars($row['category']); ?>
                                        </td>
                                        <td class="px-4 py-3">
                                            <?php echo htmlspecialchars($row['brand']); ?>
                                        </td>
                                        <td class="px-4 py-3">₹
                                            <?php echo htmlspecialchars($row['price']); ?>
                                        </td>
                                        <td class="px-4 py-3">
                                            <?php echo htmlspecialchars($row['stock']); ?>
                                        </td>

                                        <td class="px-4 py-3">
                                            <?php if (($row['status'] ?? '') === 'Active'): ?>
                                                <span
                                                    class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                                    Active
                                                </span>
                                            <?php else: ?>
                                                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                                    Inactive
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="px-4 py-3 max-w-xs truncate">
                                            <?php echo htmlspecialchars($row['description']); ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="px-4 py-8 text-center text-slate-500">
                                        No products found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>