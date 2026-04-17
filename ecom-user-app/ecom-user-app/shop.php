<?php
include 'config/db.php';
include 'includes/header.php';

$image_base_url = "/php_application/admin-portal/uploads/";
$selected_category = isset($_GET['category']) ? trim((string) $_GET['category']) : '';

$categories = [];
$category_sql = "SELECT DISTINCT category FROM products WHERE status = 'Active' AND category IS NOT NULL AND category != '' ORDER BY category ASC";
$category_result = $conn->query($category_sql);
if ($category_result && $category_result->num_rows > 0) {
    while ($category_row = $category_result->fetch_assoc()) {
        $categories[] = $category_row['category'];
    }
}

if ($selected_category !== '') {
    $stmt = $conn->prepare("SELECT * FROM products WHERE status = 'Active' AND category = ? ORDER BY id DESC");
    $stmt->bind_param('s', $selected_category);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM products WHERE status = 'Active' ORDER BY id DESC";
    $result = $conn->query($sql);
}

$products = [];
$in_stock_count = 0;

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
        if ((int) $row['stock'] > 0) {
            $in_stock_count++;
        }
    }
}

$total_products = count($products);
?>

<main class="min-h-screen bg-slate-50">
    <section class="mx-auto max-w-7xl px-6 py-10">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm md:p-8">
            <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.14em] text-blue-600">Shop</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900 md:text-4xl">Simple, Smart Shopping</h1>
                    <p class="mt-3 max-w-2xl text-sm text-slate-600 md:text-base">
                        Browse quality products with clear pricing and quick category filters.
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="rounded-xl bg-slate-100 px-4 py-3 text-center">
                        <p class="text-xs uppercase tracking-[0.12em] text-slate-500">Products</p>
                        <p class="mt-1 text-xl font-bold text-slate-900"><?php echo $total_products; ?></p>
                    </div>
                    <div class="rounded-xl bg-slate-100 px-4 py-3 text-center">
                        <p class="text-xs uppercase tracking-[0.12em] text-slate-500">In Stock</p>
                        <p class="mt-1 text-xl font-bold text-slate-900"><?php echo $in_stock_count; ?></p>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex flex-wrap gap-2 border-t border-slate-200 pt-5">
                <a href="shop.php"
                    class="rounded-full border px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.08em] transition <?php echo $selected_category === '' ? 'border-blue-600 bg-blue-600 text-white' : 'border-slate-300 bg-white text-slate-700 hover:border-blue-300 hover:text-blue-600'; ?>">
                    All Products
                </a>
                <?php foreach ($categories as $category): ?>
                    <a href="shop.php?category=<?php echo urlencode($category); ?>"
                        class="rounded-full border px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.08em] transition <?php echo $selected_category === $category ? 'border-blue-600 bg-blue-600 text-white' : 'border-slate-300 bg-white text-slate-700 hover:border-blue-300 hover:text-blue-600'; ?>">
                        <?php echo htmlspecialchars($category); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $row): ?>
                    <article
                        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md">
                        <div class="flex h-56 items-center justify-center overflow-hidden bg-slate-100 p-4">
                            <?php if (!empty($row['image'])): ?>
                                <img src="<?php echo $image_base_url . htmlspecialchars($row['image']); ?>"
                                    alt="<?php echo htmlspecialchars($row['product_name']); ?>"
                                    class="h-full w-full object-contain">
                            <?php else: ?>
                                <div class="text-center text-slate-400">
                                    <span class="text-3xl">&#128230;</span>
                                    <p class="mt-1 text-xs font-semibold uppercase">No Image</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="p-4">
                            <div class="flex items-center justify-between gap-3">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.1em] text-blue-600">
                                    <?php echo htmlspecialchars($row['brand']); ?>
                                </p>
                                <span
                                    class="rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.08em] text-slate-600">
                                    <?php echo htmlspecialchars($row['category']); ?>
                                </span>
                            </div>

                            <h3 class="mt-2 text-lg font-bold text-slate-900">
                                <?php echo htmlspecialchars($row['product_name']); ?>
                            </h3>

                            <p class="mt-2 min-h-[44px] text-sm text-slate-600">
                                <?php echo htmlspecialchars($row['description']); ?>
                            </p>

                            <div class="mt-4 flex items-center justify-between gap-3">
                                <span class="text-2xl font-bold text-slate-900">
                                    &#8377;<?php echo number_format((float) $row['price'], 2); ?>
                                </span>
                                <?php if ((int) $row['stock'] > 0): ?>
                                    <span
                                        class="rounded-full bg-emerald-100 px-2.5 py-1 text-[11px] font-semibold text-emerald-700">
                                        In Stock
                                    </span>
                                <?php else: ?>
                                    <span class="rounded-full bg-rose-100 px-2.5 py-1 text-[11px] font-semibold text-rose-700">
                                        Out of Stock
                                    </span>
                                <?php endif; ?>
                            </div>


                            <div class="mt-4 flex items-center gap-2">

                                <button type="button"
                                    class="view-details-btn flex-1 rounded-xl border border-slate-200 px-3 py-2.5 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                                    data-name="<?php echo htmlspecialchars($row['product_name']); ?>"
                                    data-brand="<?php echo htmlspecialchars($row['brand']); ?>"
                                    data-category="<?php echo htmlspecialchars($row['category']); ?>"
                                    data-price="<?php echo number_format((float) $row['price'], 2); ?>"
                                    data-description="<?php echo htmlspecialchars($row['description']); ?>"
                                    data-stock="<?php echo (int) $row['stock']; ?>"
                                    data-image="<?php echo $image_base_url . htmlspecialchars($row['image']); ?>">
                                    View Details
                                </button>


                                <button
                                    class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
                                    Add
                                </button>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-xl bg-slate-100 text-2xl">
                        &#128230;
                    </div>
                    <h3 class="mt-4 text-xl font-bold text-slate-900">No Products Found</h3>
                    <p class="mt-2 text-sm text-slate-600">
                        <?php if ($selected_category !== ''): ?>
                            No products are currently available in this category.
                        <?php else: ?>
                            Products added from the admin panel will appear here.
                        <?php endif; ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php include 'includes/product-modal.php'; ?>

<script>
    const modal = document.getElementById('productModal');
    const closeModal = document.getElementById('closeModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const buttons = document.querySelectorAll('.view-details-btn');

    const modalImage = document.getElementById('modalImage');
    const modalBrand = document.getElementById('modalBrand');
    const modalName = document.getElementById('modalName');
    const modalCategory = document.getElementById('modalCategory');
    const modalStock = document.getElementById('modalStock');
    const modalPrice = document.getElementById('modalPrice');
    const modalDescription = document.getElementById('modalDescription');

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            const name = button.dataset.name;
            const brand = button.dataset.brand;
            const category = button.dataset.category;
            const price = button.dataset.price;
            const description = button.dataset.description;
            const stock = parseInt(button.dataset.stock, 10);
            const image = button.dataset.image;

            modalImage.src = image;
            modalBrand.textContent = brand;
            modalName.textContent = name;
            modalCategory.textContent = category;
            modalPrice.textContent = '₹' + price;
            modalDescription.textContent = description;

            if (stock > 0) {
                modalStock.textContent = 'In Stock';
                modalStock.className = 'rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700';
            } else {
                modalStock.textContent = 'Out of Stock';
                modalStock.className = 'rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700';
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    function hideModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    closeModal.addEventListener('click', hideModal);
    closeModalBtn.addEventListener('click', hideModal);

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            hideModal();
        }
    });
</script>
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

    if (openAuthModal) {
        openAuthModal.addEventListener('click', () => {
            authModal.classList.remove('hidden');
            authModal.classList.add('flex');
        });
    }

    closeAuthModal.addEventListener('click', () => {
        authModal.classList.add('hidden');
        authModal.classList.remove('flex');
    });

    authModal.addEventListener('click', (e) => {
        if (e.target === authModal) {
            authModal.classList.add('hidden');
            authModal.classList.remove('flex');
        }
    });

    showLoginTab.addEventListener('click', () => {
        loginForm.classList.remove('hidden');
        registerForm.classList.add('hidden');

        authTitle.textContent = 'Login';
        authSubtitle.textContent = 'Get access to your Orders, Wishlist and Recommendations';

        showLoginTab.className = 'auth-tab-btn rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white';
        showRegisterTab.className = 'auth-tab-btn rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700';
    });

    showRegisterTab.addEventListener('click', () => {
        registerForm.classList.remove('hidden');
        loginForm.classList.add('hidden');

        authTitle.textContent = 'Register';
        authSubtitle.textContent = 'Create your account and start shopping with ease';

        showRegisterTab.className = 'auth-tab-btn rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white';
        showLoginTab.className = 'auth-tab-btn rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700';
    });
</script>
<?php include 'includes/footer.php'; ?>