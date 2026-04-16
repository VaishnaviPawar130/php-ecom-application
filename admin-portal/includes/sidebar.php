<?php
$current_page = basename($_SERVER['PHP_SELF']);

function menu_class($page_name, $current_page)
{
    if ($page_name === $current_page) {
        return "group flex items-center gap-3 px-4 py-3 rounded-2xl bg-blue-100 text-blue-950 font-semibold border border-blue-200 shadow-sm transition";
    }

    return "group flex items-center gap-3 px-4 py-3 rounded-2xl text-blue-50 hover:bg-blue-900/80 hover:text-white transition";
}
?>

<div
    class="fixed top-0 left-0 w-64 h-screen bg-gradient-to-b from-[#020617] via-[#031525] to-[#061a2f] border-r border-blue-950 overflow-y-auto shadow-xl">

    <div class="px-6 py-6 border-b border-blue-950 sticky top-0 bg-[#020617]/95 backdrop-blur z-10">
        <div class="flex items-center gap-3">
            <div
                class="h-11 w-11 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-lg font-bold shadow-md">
                A
            </div>
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-white">Admin Panel</h1>
                <p class="text-sm text-blue-200">Management System</p>
            </div>
        </div>
    </div>

    <nav class="px-4 py-6 space-y-2">
        <a href="dashboard.php" class="<?php echo menu_class('dashboard.php', $current_page); ?>">
            <span class="text-lg"></span>
            <span>Dashboard</span>
        </a>

        <a href="addproduct.php" class="<?php echo menu_class('addproduct.php', $current_page); ?>">
            <span class="text-lg"></span>
            <span>Add Product</span>
        </a>

        <a href="products.php" class="<?php echo menu_class('products.php', $current_page); ?>">
            <span class="text-lg"></span>
            <span>Product List</span>
        </a>

        <a href="register.php" class="<?php echo menu_class('register.php', $current_page); ?>">
            <span class="text-lg"></span>
            <span>Register Admin</span>
        </a>

        <a href="profile.php" class="<?php echo menu_class('profile.php', $current_page); ?>">
            <span class="text-lg"></span>
            <span>Profile</span>
        </a>

        <a href="change_password.php" class="<?php echo menu_class('change_password.php', $current_page); ?>">
            <span class="text-lg"></span>
            <span>Change Password</span>
        </a>

        <div class="pt-5 mt-5 border-t border-blue-950">
            <a href="logout.php"
                class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-rose-500/10 text-rose-200 font-medium hover:bg-rose-500/20 hover:text-white transition">
                <span class="text-lg">↩</span>
                <span>Logout</span>
            </a>
        </div>
    </nav>
</div>