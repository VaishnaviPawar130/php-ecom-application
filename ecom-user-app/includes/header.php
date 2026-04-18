<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($base_path)) {
    $base_path = '/php_application/ecom-user-app/';
}

$header_cart_count = 0;

if (isset($_SESSION['user_id']) && isset($conn)) {
    $header_user_id = (int) $_SESSION['user_id'];

    $cart_count_stmt = $conn->prepare("
        SELECT COALESCE(SUM(quantity), 0) AS cart_count
        FROM cart
        WHERE user_id = ?
    ");
    $cart_count_stmt->bind_param("i", $header_user_id);
    $cart_count_stmt->execute();
    $cart_count_result = $cart_count_stmt->get_result();
    $cart_count_row = $cart_count_result->fetch_assoc();

    $header_cart_count = (int) ($cart_count_row['cart_count'] ?? 0);
}

$current_page = basename($_SERVER['PHP_SELF']);
$is_cart_flow_page = in_array($current_page, ['cart.php', 'checkout.php', 'viewcheckout.php'], true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecom Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'ui-sans-serif', 'system-ui', 'sans-serif']
                    }
                }
            }
        };
    </script>
</head>

<body class="bg-slate-100 text-slate-800">

    <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="mx-auto max-w-7xl px-4 py-4 md:px-6">
            <div class="flex items-center justify-between gap-4">
                <a href="<?php echo $base_path; ?>index.php" class="group flex items-center gap-3">
                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-rose-500 to-orange-400 text-lg font-bold text-white shadow-sm transition group-hover:scale-105">
                        E
                    </div>
                    <div>
                        <h1 class="text-[38px] font-extrabold leading-none text-slate-900">ecom</h1>
                        <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-500">store</p>
                    </div>
                </a>

                <nav class="hidden items-center gap-1 md:flex">
                    <a href="<?php echo $base_path; ?>index.php"
                        class="rounded-lg px-4 py-2 text-sm font-semibold transition <?php echo $current_page === 'index.php' ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-100'; ?>">
                        Home
                    </a>
                    <a href="<?php echo $base_path; ?>shop.php"
                        class="rounded-lg px-4 py-2 text-sm font-semibold transition <?php echo $current_page === 'shop.php' ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-100'; ?>">
                        Shop
                    </a>
                    <a href="<?php echo $base_path; ?>empty.php"
                        class="rounded-lg px-4 py-2 text-sm font-semibold transition <?php echo $current_page === 'empty.php' ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-100'; ?>">
                        About Us
                    </a>
                    <a href="<?php echo $base_path; ?>includes/cart.php"
                        class="rounded-lg px-4 py-2 text-sm font-semibold transition <?php echo $is_cart_flow_page ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-100'; ?>">
                        Cart
                    </a>
                </nav>

                <div class="flex items-center gap-3">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <span
                            class="hidden rounded-lg bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-700 lg:inline-flex">
                            Hi, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                        </span>
                        <a href="<?php echo $base_path; ?>logout.php"
                            class="hidden rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 md:inline-flex">
                            Logout
                        </a>
                    <?php else: ?>
                        <a href="<?php echo $base_path; ?>index.php?auth=open"
                            class="hidden rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 md:inline-flex">
                            Login
                        </a>
                    <?php endif; ?>

                    <div class="group relative">
                        <button type="button"
                            class="inline-flex flex-col items-center justify-center text-slate-700 transition hover:text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.8" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 1 1 15 0" />
                            </svg>
                            <span class="text-[12px] font-medium leading-none">Profile</span>
                        </button>

                        <div
                            class="invisible absolute right-0 top-full z-50 w-56 rounded-xl border border-slate-200 bg-white p-3.5 opacity-0 shadow-lg transition duration-150 group-hover:visible group-hover:opacity-100 group-focus-within:visible group-focus-within:opacity-100">
                            <p class="text-lg font-bold text-slate-900">Hello
                                <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'User'; ?>
                            </p>
                            <p class="mt-0.5 text-xs font-medium text-slate-500">Manage your profile and orders</p>

                            <a href="<?php echo $base_path; ?>index.php?auth=open"
                                class="mt-3 inline-flex w-full items-center justify-center rounded-lg bg-blue-600 px-3 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                                <?php echo isset($_SESSION['user_id']) ? 'Account' : 'Sign Up'; ?>
                            </a>

                            <div class="mt-3 border-t border-slate-200 pt-2">
                                <a href="<?php echo $base_path; ?>empty.php"
                                    class="block rounded-md px-2 py-1.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 hover:text-blue-600">
                                    My Orders
                                </a>
                            </div>
                            <div class="mt-1.5 border-t border-slate-200 pt-2">
                                <a href="<?php echo $base_path; ?>empty.php"
                                    class="block rounded-md px-2 py-1.5 text-sm font-semibold text-slate-700 transition hover:bg-rose-50 hover:text-rose-600">
                                    Delete Account
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="<?php echo $base_path; ?>includes/cart.php"
                        class="group relative inline-flex flex-col items-center justify-center text-slate-700 transition hover:text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386a1.5 1.5 0 0 1 1.455 1.14L5.8 7.5m0 0h12.96a1.5 1.5 0 0 1 1.47 1.796l-1.05 5.25a1.5 1.5 0 0 1-1.47 1.204H8.19a1.5 1.5 0 0 1-1.47-1.204L5.8 7.5Zm0 0L4.5 3.75M9.75 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm7.5 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                        <?php if ($header_cart_count > 0): ?>
                            <span
                                class="absolute -right-2 -top-1 inline-flex h-4 min-w-[16px] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-semibold text-white">
                                <?php echo $header_cart_count; ?>
                            </span>
                        <?php endif; ?>
                        <span class="text-[12px] font-medium leading-none">Cart</span>
                    </a>
                </div>
            </div>

            <div class="mt-3 flex items-center gap-2 md:hidden">
                <a href="<?php echo $base_path; ?>index.php"
                    class="inline-flex rounded-lg px-3 py-2 text-xs font-semibold <?php echo $current_page === 'index.php' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700'; ?>">
                    Home
                </a>
                <a href="<?php echo $base_path; ?>shop.php"
                    class="inline-flex rounded-lg px-3 py-2 text-xs font-semibold <?php echo $current_page === 'shop.php' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700'; ?>">
                    Shop
                </a>
                <a href="<?php echo $base_path; ?>empty.php"
                    class="inline-flex rounded-lg px-3 py-2 text-xs font-semibold <?php echo $current_page === 'empty.php' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700'; ?>">
                    About
                </a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="<?php echo $base_path; ?>logout.php"
                        class="inline-flex rounded-lg bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-700">
                        Logout
                    </a>
                <?php else: ?>
                    <a href="<?php echo $base_path; ?>index.php?auth=open"
                        class="inline-flex rounded-lg bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-700">
                        Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>