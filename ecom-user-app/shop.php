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

<main class="min-h-screen bg-slate-100">
    <section class="mx-auto max-w-7xl px-6 py-10">
        <div class="relative overflow-hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm md:p-8">
            <div class="pointer-events-none absolute -left-20 -top-24 h-52 w-52 rounded-full bg-cyan-100 blur-3xl"></div>
            <div class="pointer-events-none absolute -right-14 top-0 h-44 w-44 rounded-full bg-blue-100 blur-3xl"></div>
            <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                <div class="relative">
                    <p class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.14em] text-blue-700">Shop</p>
                    <h1 class="mt-3 text-3xl font-bold text-slate-900 md:text-4xl">Simple, Smart Shopping</h1>
                    <p class="mt-3 max-w-2xl text-sm text-slate-600 md:text-base">
                        Browse quality products with clear pricing and quick category filters.
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-center">
                        <p class="text-xs uppercase tracking-[0.12em] text-slate-500">Products</p>
                        <p class="mt-1 text-xl font-bold text-slate-900"><?php echo $total_products; ?></p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-center">
                        <p class="text-xs uppercase tracking-[0.12em] text-slate-500">In Stock</p>
                        <p class="mt-1 text-xl font-bold text-slate-900"><?php echo $in_stock_count; ?></p>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex flex-wrap gap-2 border-t border-slate-200 pt-5">
                <a href="shop.php"
                    class="rounded-full border px-3.5 py-1.5 text-xs font-semibold uppercase tracking-[0.08em] transition <?php echo $selected_category === '' ? 'border-blue-600 bg-blue-600 text-white shadow-sm' : 'border-slate-300 bg-white text-slate-700 hover:border-blue-300 hover:bg-blue-50 hover:text-blue-600'; ?>">
                    All Products
                </a>
                <?php foreach ($categories as $category): ?>
                    <a href="shop.php?category=<?php echo urlencode($category); ?>"
                        class="rounded-full border px-3.5 py-1.5 text-xs font-semibold uppercase tracking-[0.08em] transition <?php echo $selected_category === $category ? 'border-blue-600 bg-blue-600 text-white shadow-sm' : 'border-slate-300 bg-white text-slate-700 hover:border-blue-300 hover:bg-blue-50 hover:text-blue-600'; ?>">
                        <?php echo htmlspecialchars($category); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $row): ?>
                    <article
                        class="group overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="relative flex h-56 items-center justify-center overflow-hidden bg-gradient-to-br from-slate-100 via-slate-50 to-slate-200 p-4">
                            <button type="button"
                                class="wishlist-btn absolute left-3 top-3 inline-flex h-7 w-7 items-center justify-center rounded-full border border-slate-200 bg-white/90 text-slate-500 shadow-sm backdrop-blur transition hover:text-rose-500"
                                aria-label="Add to wishlist"
                                title="Add to wishlist">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.8" class="wishlist-icon h-4 w-4 transition">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21.435 4.582a5.94 5.94 0 0 0-8.4 0L12 5.618l-1.035-1.036a5.94 5.94 0 1 0-8.4 8.4L12 22.416l9.435-9.434a5.94 5.94 0 0 0 0-8.4Z" />
                                </svg>
                            </button>
                            <?php if (!empty($row['image'])): ?>
                                <img src="<?php echo $image_base_url . htmlspecialchars($row['image']); ?>"
                                    alt="<?php echo htmlspecialchars($row['product_name']); ?>"
                                    class="h-full w-full object-contain transition duration-300 group-hover:scale-105">
                            <?php else: ?>
                                <div class="text-center text-slate-400">
                                    <span class="text-3xl">&#128230;</span>
                                    <p class="mt-1 text-xs font-semibold uppercase">No Image</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="p-5">
                            <div class="flex items-center justify-between gap-3">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.1em] text-blue-600">
                                    <?php echo htmlspecialchars($row['brand']); ?>
                                </p>
                                <span
                                    class="rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.08em] text-slate-600">
                                    <?php echo htmlspecialchars($row['category']); ?>
                                </span>
                            </div>

                            <h3 class="mt-2 text-lg font-bold leading-snug text-slate-900">
                                <?php echo htmlspecialchars($row['product_name']); ?>
                            </h3>

                            <p class="mt-2 min-h-[44px] text-sm leading-relaxed text-slate-600">
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
                                    class="view-details-btn flex-1 rounded-xl border border-slate-200 px-3 py-2.5 text-center text-sm font-semibold text-slate-700 transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700"
                                    data-name="<?php echo htmlspecialchars($row['product_name']); ?>"
                                    data-brand="<?php echo htmlspecialchars($row['brand']); ?>"
                                    data-category="<?php echo htmlspecialchars($row['category']); ?>"
                                    data-price="<?php echo number_format((float) $row['price'], 2); ?>"
                                    data-description="<?php echo htmlspecialchars($row['description']); ?>"
                                    data-stock="<?php echo (int) $row['stock']; ?>"
                                    data-image="<?php echo $image_base_url . htmlspecialchars($row['image']); ?>">
                                    View Details
                                </button>

                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="addtocart.php?id=<?php echo $row['id']; ?>"
                                        class="rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-blue-700 hover:shadow-lg">
                                        Buy Now
                                    </a>
                                <?php else: ?>
                                    <a href="index.php?auth=open"
                                        class="rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-blue-700 hover:shadow-lg">
                                        Add
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full rounded-3xl border border-dashed border-slate-300 bg-white p-10 text-center shadow-sm">
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
    const wishlistButtons = document.querySelectorAll('.wishlist-btn');

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

    wishlistButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const icon = button.querySelector('.wishlist-icon');
            const active = button.classList.toggle('is-active');

            button.classList.toggle('text-slate-500', !active);
            button.classList.toggle('text-rose-500', active);
            button.classList.toggle('border-slate-200', !active);
            button.classList.toggle('border-rose-200', active);
            button.classList.toggle('bg-white/90', !active);
            button.classList.toggle('bg-rose-50', active);

            if (icon) {
                icon.setAttribute('fill', active ? 'currentColor' : 'none');
            }

            button.setAttribute('aria-label', active ? 'Added to wishlist' : 'Add to wishlist');
            button.setAttribute('title', active ? 'Added to wishlist' : 'Add to wishlist');
        });
    });
</script>

<?php include 'includes/footer.php'; ?>
