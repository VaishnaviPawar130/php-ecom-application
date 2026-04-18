<?php
session_start();
include __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?auth=open");
    exit();
}

include __DIR__ . '/header.php';

$user_id = (int) $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT cart.id AS cart_id, cart.quantity, products.id AS product_id, products.product_name,
           products.price, products.image, products.stock, products.category, products.brand
    FROM cart
    INNER JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = ?
    ORDER BY cart.id DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$image_base_url = "/php_application/admin-portal/uploads/";
$total = 0;
$item_count = 0;
?>

<main class="min-h-screen bg-slate-50 pb-12">
    <section class="relative overflow-hidden border-b border-slate-200 bg-white">
        <div class="pointer-events-none absolute -left-10 top-0 h-40 w-40 rounded-full bg-blue-100 blur-3xl"></div>
        <div class="pointer-events-none absolute right-0 top-8 h-48 w-48 rounded-full bg-cyan-100 blur-3xl"></div>

        <div class="mx-auto max-w-7xl px-6 py-10">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-600">Cart Overview</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-900 md:text-4xl">My Cart</h1>
            <p class="mt-2 max-w-2xl text-sm text-slate-500 md:text-base">Review your selected items before moving to
                checkout.</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-8">
        <?php if ($result->num_rows > 0): ?>
            <div class="grid gap-6 lg:grid-cols-[1.25fr,0.75fr]">
                <div class="space-y-4">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php $subtotal = (float) $row['price'] * (int) $row['quantity']; ?>
                        <?php $total += $subtotal; ?>
                        <?php $item_count += (int) $row['quantity']; ?>

                        <article
                            class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:shadow-md md:p-5">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-slate-100">
                                        <?php if (!empty($row['image'])): ?>
                                            <img src="<?php echo $image_base_url . htmlspecialchars($row['image']); ?>"
                                                alt="<?php echo htmlspecialchars($row['product_name']); ?>"
                                                class="h-full w-full object-contain">
                                        <?php else: ?>
                                            <span class="text-xs font-semibold text-slate-500">No Image</span>
                                        <?php endif; ?>
                                    </div>

                                    <div>
                                        <p class="text-[11px] font-semibold uppercase tracking-[0.14em] text-blue-600">
                                            <?php echo htmlspecialchars($row['brand']); ?>
                                        </p>
                                        <h3 class="mt-1 text-lg font-bold text-slate-900">
                                            <?php echo htmlspecialchars($row['product_name']); ?>
                                        </h3>
                                        <div class="mt-2 flex flex-wrap items-center gap-2">
                                            <span
                                                class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                                Qty: <?php echo (int) $row['quantity']; ?>
                                            </span>
                                            <span
                                                class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                                Unit: &#8377;<?php echo number_format((float) $row['price'], 2); ?>
                                            </span>

                                            <form action="<?php echo $base_path; ?>includes/removefromcart.php" method="POST"
                                                onsubmit="return confirm('Remove this item from cart?');">
                                                <input type="hidden" name="cart_id" value="<?php echo (int) $row['cart_id'] ?>">
                                                <button type="submit"
                                                    class="rounded-full border border-rose-200 bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-600 transition hover:bg-rose-100">
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-xl bg-slate-100 px-4 py-3 text-left sm:text-right">
                                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Subtotal</p>
                                    <p class="mt-1 text-xl font-bold text-slate-900">
                                        &#8377;<?php echo number_format($subtotal, 2); ?>
                                    </p>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <aside class="h-fit rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:sticky lg:top-24">
                    <h2 class="text-xl font-bold text-slate-900">Order Summary</h2>
                    <p class="mt-1 text-sm text-slate-500"><?php echo $item_count; ?> item(s) selected</p>

                    <div class="mt-6 space-y-3 border-t border-slate-200 pt-4 text-sm">
                        <div class="flex items-center justify-between text-slate-600">
                            <span>Subtotal</span>
                            <span>&#8377;<?php echo number_format($total, 2); ?></span>
                        </div>
                        <div class="flex items-center justify-between text-slate-600">
                            <span>Shipping</span>
                            <span class="font-semibold text-emerald-600">Free</span>
                        </div>
                        <div
                            class="flex items-center justify-between border-t border-slate-200 pt-3 text-lg font-bold text-slate-900">
                            <span>Total</span>
                            <span>&#8377;<?php echo number_format($total, 2); ?></span>
                        </div>
                    </div>

                    <a href="<?php echo $base_path; ?>includes/checkout.php"
                        class="mt-6 inline-flex w-full items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                        Proceed to Checkout
                    </a>

                    <a href="<?php echo $base_path; ?>shop.php"
                        class="mt-3 inline-flex w-full items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Continue Shopping
                    </a>
                </aside>
            </div>
        <?php else: ?>
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center shadow-sm">
                <div
                    class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-sm font-semibold text-slate-500">
                    Empty
                </div>
                <h3 class="mt-4 text-2xl font-bold text-slate-900">Your cart is empty</h3>
                <p class="mt-2 text-sm text-slate-500">Looks like you have not added anything yet. Start exploring products
                    now.</p>
                <a href="<?php echo $base_path; ?>shop.php"
                    class="mt-6 inline-flex rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                    Continue Shopping
                </a>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>