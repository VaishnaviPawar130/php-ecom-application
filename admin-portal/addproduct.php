<?php
include "includes/auth.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

    <?php include "includes/sidebar.php"; ?>

    <div class="ml-64 min-h-screen p-6">
        <div class="max-w-6xl mx-auto">
            <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <div
                        class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 ring-1 ring-blue-200">
                        <span>📦</span>
                        <span>Product Management</span>
                    </div>

                    <h1 class="mt-3 text-3xl font-bold tracking-tight text-slate-800">Add Product</h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Fill in the product details below and save it to your catalog.
                    </p>
                </div>

                <a href="products.php"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-800 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-slate-900 transition">
                    <span>📋</span>
                    <span>View Product List</span>
                </a>
            </div>

            <?php if (isset($_SESSION['product_success'])): ?>
                <div
                    class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 shadow-sm">
                    <?php
                    echo $_SESSION['product_success'];
                    unset($_SESSION['product_success']);
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['product_error'])): ?>
                <div
                    class="mb-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700 shadow-sm">
                    <?php
                    echo $_SESSION['product_error'];
                    unset($_SESSION['product_error']);
                    ?>
                </div>
            <?php endif; ?>

            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 bg-gradient-to-r from-slate-50 to-blue-50 px-6 py-5">
                    <h2 class="text-lg font-semibold text-slate-800">Product Information</h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Fields marked with <span class="font-semibold text-red-500">*</span> are required.
                    </p>
                </div>

                <form action="save_product.php" method="POST" enctype="multipart/form-data" class="p-6 space-y-8">

                    <div class="rounded-2xl border border-slate-200 bg-slate-50/60 p-5">
                        <h3
                            class="mb-4 flex items-center gap-2 text-sm font-semibold uppercase tracking-wide text-slate-600">
                            <span>📝</span>
                            <span>Basic Details</span>
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Product Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="product_name" required placeholder="Enter product name"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100">
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Product Code
                                </label>
                                <input type="text" name="product_code" placeholder="Enter product code"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100">
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50/60 p-5">
                        <h3
                            class="mb-4 flex items-center gap-2 text-sm font-semibold uppercase tracking-wide text-slate-600">
                            <span>🏷️</span>
                            <span>Classification</span>
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Category</label>
                                <input type="text" name="category" placeholder="Enter category"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100">
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Brand</label>
                                <input type="text" name="brand" placeholder="Enter brand name"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100">
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50/60 p-5">
                        <h3
                            class="mb-4 flex items-center gap-2 text-sm font-semibold uppercase tracking-wide text-slate-600">
                            <span>💰</span>
                            <span>Pricing & Stock</span>
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Price <span class="text-red-500">*</span>
                                </label>
                                <input type="number" step="0.01" name="price" required placeholder="Enter price"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100">
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Stock Quantity</label>
                                <input type="number" name="stock" placeholder="Enter stock quantity"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100">
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Status</label>
                                <select name="status"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50/60 p-5">
                        <h3
                            class="mb-4 flex items-center gap-2 text-sm font-semibold uppercase tracking-wide text-slate-600">
                            <span>🧾</span>
                            <span>Description</span>
                        </h3>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Short Description</label>
                            <textarea name="description" rows="4" placeholder="Enter short description"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100"></textarea>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50/60 p-5">
                        <h3
                            class="mb-4 flex items-center gap-2 text-sm font-semibold uppercase tracking-wide text-slate-600">
                            <span>🖼️</span>
                            <span>Media</span>
                        </h3>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Product Image</label>
                            <input type="file" name="product_image"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm file:mr-4 file:rounded-lg file:border-0 file:bg-blue-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-blue-800 hover:file:bg-blue-200 focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100">
                            <p class="mt-2 text-xs text-slate-500">
                                Upload a clear product image for better product listing display.
                            </p>
                        </div>
                    </div>

                    <div class="sticky bottom-0 -mx-6 border-t border-slate-200 bg-white/95 px-6 py-4 backdrop-blur">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <p class="text-sm text-slate-500">
                                Review the details before saving the product.
                            </p>

                            <div class="flex flex-wrap items-center gap-3">
                                <button type="reset"
                                    class="inline-flex items-center justify-center rounded-xl bg-slate-200 px-6 py-3 text-sm font-semibold text-slate-800 hover:bg-slate-300 transition">
                                    Clear
                                </button>

                                <button type="submit"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">
                                    <span>💾</span>
                                    <span>Save Product</span>
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

</body>

</html>