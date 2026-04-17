<?php
$auth_success = $_SESSION['auth_success'] ?? '';
$auth_error = $_SESSION['auth_error'] ?? '';
$auth_tab = $_SESSION['auth_tab'] ?? 'login';

unset($_SESSION['auth_success'], $_SESSION['auth_error'], $_SESSION['auth_tab']);
?>

<div id="authModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">
    <div class="relative w-full max-w-4xl overflow-hidden rounded-2xl bg-white shadow-2xl">

        <button id="closeAuthModal"
            class="absolute right-4 top-4 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-white text-xl font-bold text-slate-700 shadow hover:bg-slate-100">
            ×
        </button>

        <div class="grid md:grid-cols-2">
            <div class="bg-blue-600 px-8 py-10 text-white">
                <h2 id="authTitle" class="text-3xl font-bold">
                    <?php echo $auth_tab === 'register' ? 'Register' : 'Login'; ?>
                </h2>

                <p id="authSubtitle" class="mt-4 text-lg text-blue-100">
                    <?php
                    echo $auth_tab === 'register'
                        ? 'Create your account and start shopping with ease'
                        : 'Get access to your Orders, Wishlist and Recommendations';
                    ?>
                </p>
            </div>

            <div class="p-8">
                <?php if ($auth_success !== ''): ?>
                    <div
                        class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                        <?php echo htmlspecialchars($auth_success); ?>
                    </div>
                <?php endif; ?>

                <?php if ($auth_error !== ''): ?>
                    <div
                        class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700">
                        <?php echo htmlspecialchars($auth_error); ?>
                    </div>
                <?php endif; ?>

                <div class="mb-6 flex gap-3">
                    <button type="button" id="showLoginTab"
                        class="auth-tab-btn rounded-xl <?php echo $auth_tab === 'login' ? 'bg-blue-600 text-white' : 'border border-slate-300 text-slate-700'; ?> px-4 py-2 text-sm font-semibold">
                        Login
                    </button>

                    <button type="button" id="showRegisterTab"
                        class="auth-tab-btn rounded-xl <?php echo $auth_tab === 'register' ? 'bg-blue-600 text-white' : 'border border-slate-300 text-slate-700'; ?> px-4 py-2 text-sm font-semibold">
                        Register
                    </button>
                </div>

                <form id="loginForm" action="login_action.php" method="POST"
                    class="space-y-4 <?php echo $auth_tab === 'register' ? 'hidden' : ''; ?>">
                    <input type="email" name="email" placeholder="Enter Email"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-blue-500"
                        required>

                    <input type="password" name="password" placeholder="Enter Password"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-blue-500"
                        required>

                    <button type="submit"
                        class="w-full rounded-xl bg-orange-500 px-4 py-3 text-sm font-semibold text-white hover:bg-orange-600">
                        Login
                    </button>
                </form>

                <form id="registerForm" action="register_action.php" method="POST"
                    class="space-y-4 <?php echo $auth_tab === 'register' ? '' : 'hidden'; ?>">
                    <input type="text" name="full_name" placeholder="Enter Full Name"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-blue-500"
                        required>

                    <input type="email" name="email" placeholder="Enter Email"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-blue-500"
                        required>

                    <input type="text" name="phone" placeholder="Enter Phone Number"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-blue-500">

                    <input type="password" name="password" placeholder="Enter Password"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-blue-500"
                        required>

                    <button type="submit"
                        class="w-full rounded-xl bg-orange-500 px-4 py-3 text-sm font-semibold text-white hover:bg-orange-600">
                        Create Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>