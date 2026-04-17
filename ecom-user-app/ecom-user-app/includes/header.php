<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecom Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-800">

    <header class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/80 backdrop-blur-xl shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">

            <a href="index.php" class="flex items-center gap-3">
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-600 via-indigo-600 to-violet-600 text-lg font-bold text-white shadow-lg shadow-blue-200">
                    E
                </div>
                <div>
                    <h1 class="text-xl font-bold tracking-tight text-slate-900">Ecom Store</h1>
                    <p class="text-xs text-slate-500">Shop smarter, faster</p>
                </div>
            </a>

            <nav class="hidden ml-auto items-center gap-2 md:flex">
                <a href="index.php"
                    class="rounded-full px-4 py-2 text-sm font-medium transition <?php echo $current_page === 'index.php' ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-slate-700 hover:bg-slate-100'; ?>">
                    Home
                </a>

                <a href="shop.php"
                    class="rounded-full px-4 py-2 text-sm font-medium transition <?php echo $current_page === 'shop.php' ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-slate-700 hover:bg-slate-100'; ?>">
                    Shop
                </a>

                <a href="cart.php"
                    class="rounded-full px-4 py-2 text-sm font-medium transition <?php echo $current_page === 'cart.php' ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-slate-700 hover:bg-slate-100'; ?>">
                    Cart
                </a>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="rounded-full px-4 py-2 text-sm font-medium text-slate-700">
                        Hi, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                    </span>

                    <a href="logout.php"
                        class="rounded-full px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100">
                        Logout
                    </a>
                <?php else: ?>
                    <button type="button" id="openAuthModal"
                        class="rounded-full px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100">
                        Login
                    </button>
                <?php endif; ?>
            </nav>

            <div class="flex items-center gap-3">
                <a href="cart.php"
                    class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:shadow-md transition">
                    <span>Cart</span>
                    <span
                        class="inline-flex h-6 min-w-[24px] items-center justify-center rounded-full bg-blue-600 px-2 text-xs font-semibold text-white">
                        0
                    </span>
                </a>
            </div>
        </div>
    </header>

    <?php if (!empty($_SESSION['auth_success'])): ?>
        <div class="mx-auto mt-4 max-w-7xl px-6">
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                <?php
                echo $_SESSION['auth_success'];
                unset($_SESSION['auth_success']);
                ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['auth_error'])): ?>
        <div class="mx-auto mt-4 max-w-7xl px-6">
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700">
                <?php
                echo $_SESSION['auth_error'];
                unset($_SESSION['auth_error']);
                ?>
            </div>
        </div>
    <?php endif; ?>