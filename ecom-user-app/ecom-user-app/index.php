<?php include 'includes/header.php'; ?>

<main class="min-h-screen bg-[radial-gradient(circle_at_top,_#f8fbff,_#eef4ff_35%,_#f8fafc_70%)]">


    <section class="mx-auto max-w-7xl px-6 py-10 md:py-12">
        <div
            class="relative overflow-hidden rounded-[36px] bg-gradient-to-br from-slate-950 via-slate-900 to-blue-950 px-8 py-10 text-white shadow-[0_25px_80px_rgba(15,23,42,0.28)] md:px-10 md:py-12">
            <div class="absolute -left-10 top-10 h-40 w-40 rounded-full bg-blue-500/20 blur-3xl"></div>
            <div class="absolute right-0 top-0 h-56 w-56 rounded-full bg-indigo-400/20 blur-3xl"></div>
            <div class="absolute bottom-0 left-1/3 h-52 w-52 rounded-full bg-cyan-300/10 blur-3xl"></div>

            <div class="relative flex flex-col gap-10 md:flex-row md:items-center md:justify-between">
                <div class="max-w-2xl">
                    <span
                        class="inline-flex rounded-full border border-white/10 bg-white/10 px-4 py-1 text-[11px] font-semibold uppercase tracking-[0.22em] text-blue-100 backdrop-blur">
                        Premium Shopping Experience
                    </span>

                    <h1 class="mt-5 text-4xl font-bold leading-tight md:text-6xl">
                        Shopping Made
                        <span class="bg-gradient-to-r from-white to-blue-200 bg-clip-text text-transparent">Simple &
                            Premium</span>
                    </h1>

                    <p class="mt-5 max-w-xl text-sm leading-7 text-slate-300 md:text-base">
                        Discover trusted products, polished browsing, clean pricing, and a premium shopping flow built
                        for modern customers.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="shop.php"
                            class="rounded-xl bg-white px-5 py-3 text-sm font-semibold text-slate-900 shadow-lg transition hover:bg-slate-100">
                            Shop Now
                        </a>
                        <a href="shop.php"
                            class="rounded-xl border border-white/15 bg-white/5 px-5 py-3 text-sm font-semibold text-white backdrop-blur transition hover:bg-white/10">
                            Browse Categories
                        </a>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 md:min-w-[320px]">
                    <div class="rounded-3xl border border-white/10 bg-white/10 p-5 backdrop-blur-md shadow-lg">
                        <p class="text-xs uppercase tracking-[0.16em] text-blue-100">Fast Delivery</p>
                        <p class="mt-2 text-3xl font-bold text-white">24-48h</p>
                        <p class="mt-2 text-sm text-slate-300">Quick shipping on selected products.</p>
                    </div>

                    <div class="rounded-3xl border border-white/10 bg-slate-900/40 p-5 backdrop-blur-md shadow-lg">
                        <p class="text-xs uppercase tracking-[0.16em] text-blue-100">Support</p>
                        <p class="mt-2 text-3xl font-bold text-white">7 Days</p>
                        <p class="mt-2 text-sm text-slate-300">Fast help for orders and product queries.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/hero-slider.php'; ?>

    <!-- Premium Highlights -->
    <section class="mx-auto max-w-7xl px-6 py-8">
        <div class="grid gap-6 md:grid-cols-3">
            <article
                class="group rounded-[28px] border border-slate-200/80 bg-white/80 p-6 shadow-sm backdrop-blur transition hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(15,23,42,0.08)]">
                <div
                    class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-100 to-blue-200 text-2xl shadow-sm">
                    ✅</div>
                <h3 class="mt-5 text-xl font-bold text-slate-900">Reliable Quality</h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Every product is selected for consistent quality, strong utility, and lasting value.
                </p>
            </article>

            <article
                class="group rounded-[28px] border border-slate-200/80 bg-white/80 p-6 shadow-sm backdrop-blur transition hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(15,23,42,0.08)]">
                <div
                    class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-100 to-emerald-200 text-2xl shadow-sm">
                    🔒</div>
                <h3 class="mt-5 text-xl font-bold text-slate-900">Secure Payments</h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Clear pricing, smooth checkout, and secure handling designed for customer trust.
                </p>
            </article>

            <article
                class="group rounded-[28px] border border-slate-200/80 bg-white/80 p-6 shadow-sm backdrop-blur transition hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(15,23,42,0.08)]">
                <div
                    class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-100 to-violet-200 text-2xl shadow-sm">
                    💬</div>
                <h3 class="mt-5 text-xl font-bold text-slate-900">Fast Support</h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Quick assistance for order updates, product details, and shopping support.
                </p>
            </article>
        </div>
    </section>

    <!-- Premium Categories -->
    <section class="mx-auto max-w-7xl px-6 pb-16 pt-6">
        <div class="mb-6 flex items-end justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600">Collections</p>
                <h2 class="mt-1 text-3xl font-bold text-slate-900">Popular Categories</h2>
            </div>

            <a href="shop.php" class="text-sm font-semibold text-blue-600 hover:text-blue-700">
                View all
            </a>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <a href="shop.php?category=Fashion"
                class="group relative overflow-hidden rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                <div class="absolute right-0 top-0 h-24 w-24 rounded-full bg-pink-100 blur-2xl"></div>
                <div class="relative">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-pink-100 text-2xl">👕</div>
                    <p class="mt-5 text-lg font-bold text-slate-900">Fashion</p>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Style, trend, and daily wear essentials.</p>
                </div>
            </a>

            <a href="shop.php?category=Mobiles"
                class="group relative overflow-hidden rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                <div class="absolute right-0 top-0 h-24 w-24 rounded-full bg-emerald-100 blur-2xl"></div>
                <div class="relative">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-100 text-2xl">📱</div>
                    <p class="mt-5 text-lg font-bold text-slate-900">Mobiles</p>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Smartphones and modern mobile picks.</p>
                </div>
            </a>

            <a href="shop.php?category=Accessories"
                class="group relative overflow-hidden rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                <div class="absolute right-0 top-0 h-24 w-24 rounded-full bg-violet-100 blur-2xl"></div>
                <div class="relative">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-violet-100 text-2xl">⌚</div>
                    <p class="mt-5 text-lg font-bold text-slate-900">Accessories</p>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Smart accessories and lifestyle add-ons.</p>
                </div>
            </a>

            <a href="shop.php?category=Home%20%26%20Kitchen"
                class="group relative overflow-hidden rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                <div class="absolute right-0 top-0 h-24 w-24 rounded-full bg-amber-100 blur-2xl"></div>
                <div class="relative">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-100 text-2xl">🏠</div>
                    <p class="mt-5 text-lg font-bold text-slate-900">Home & Kitchen</p>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Useful essentials for modern living spaces.</p>
                </div>
            </a>
        </div>
    </section>

</main>
<?php include 'includes/auth-modal.php'; ?>
<script>
    const authModal = document.getElementById('authModal');
    const openAuthModal = document.getElementById('openAuthModal');
    const closeAuthModal = document.getElementById('closeAuthModal');

    const showLoginTab = document.getElementById('showLoginTab');
    const showRegisterTab = document.getElementById('showRegisterTab');

    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    const authTitle = document.getElementById('authTitle');
    const authSubtitle = document.getElementById('authSubtitle');
    const params = new URLSearchParams(window.location.search);

    if (params.get('auth') === 'open' && authModal) {
        authModal.classList.remove('hidden');
        authModal.classList.add('flex');
    }

    if (openAuthModal) {
        openAuthModal.addEventListener('click', () => {
            authModal.classList.remove('hidden');
            authModal.classList.add('flex');
        });
    }

    if (closeAuthModal) {
        closeAuthModal.addEventListener('click', () => {
            authModal.classList.add('hidden');
            authModal.classList.remove('flex');
        });
    }

    if (authModal) {
        authModal.addEventListener('click', (e) => {
            if (e.target === authModal) {
                authModal.classList.add('hidden');
                authModal.classList.remove('flex');
            }
        });
    }

    if (showLoginTab) {
        showLoginTab.addEventListener('click', () => {
            loginForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
            authTitle.textContent = 'Login';
            authSubtitle.textContent = 'Get access to your Orders, Wishlist and Recommendations';
            showLoginTab.className = 'auth-tab-btn rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white';
            showRegisterTab.className = 'auth-tab-btn rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700';
        });
    }

    if (showRegisterTab) {
        showRegisterTab.addEventListener('click', () => {
            registerForm.classList.remove('hidden');
            loginForm.classList.add('hidden');
            authTitle.textContent = 'Register';
            authSubtitle.textContent = 'Create your account and start shopping with ease';
            showRegisterTab.className = 'auth-tab-btn rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white';
            showLoginTab.className = 'auth-tab-btn rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700';
        });
    }
</script>
<?php include 'includes/footer.php'; ?>