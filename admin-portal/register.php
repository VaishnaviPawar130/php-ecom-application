<?php
session_start();

if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<?php include "includes/head.php"; ?>

<div class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Admin Registration</h2>

        <?php if (isset($_SESSION['register_error'])): ?>
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-4">
                <?php
                echo $_SESSION['register_error'];
                unset($_SESSION['register_error']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['register_success'])): ?>
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-4">
                <?php
                echo $_SESSION['register_success'];
                unset($_SESSION['register_success']);
                ?>
            </div>
        <?php endif; ?>

        <form action="save_register.php" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <input type="password" name="confirm_password" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg">
                Register
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-4">
            Already have an account?
            <a href="login.php" class="text-blue-600 font-medium">Login</a>
        </p>
    </div>
</div>

<?php include "includes/footer.php"; ?>