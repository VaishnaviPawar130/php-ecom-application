<?php
session_start();
include __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?auth=open");
    exit();
}

$user_id = (int) $_SESSION['user_id'];

$user_stmt = $conn->prepare("SELECT full_name, email, phone FROM users WHERE id = ?");
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user = $user_result->fetch_assoc();

if (!$user) {
    die("User not found");
}

$cart_stmt = $conn->prepare("
    SELECT c.product_id, c.quantity, p.product_name, p.price, p.image
    FROM cart c
    INNER JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
");
$cart_stmt->bind_param("i", $user_id);
$cart_stmt->execute();
$cart_result = $cart_stmt->get_result();

$cart_items = [];
$total = 0;

while ($row = $cart_result->fetch_assoc()) {
    $row['subtotal'] = (float) $row['price'] * (int) $row['quantity'];
    $total += $row['subtotal'];
    $cart_items[] = $row;
}

if (count($cart_items) === 0) {
    die("Your cart is empty");
}

$image_base_url = "/php_application/admin-portal/uploads/";
include __DIR__ . '/header.php';
?>

<main class="min-h-screen bg-slate-50 pb-12">
    <section class="relative overflow-hidden border-b border-slate-200 bg-white">
        <div class="pointer-events-none absolute -left-16 -top-16 h-40 w-40 rounded-full bg-blue-100 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-20 top-8 h-48 w-48 rounded-full bg-cyan-100 blur-3xl"></div>

        <div class="mx-auto max-w-7xl px-6 py-10">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-600">Secure Checkout</p>
            <h1 class="mt-3 text-3xl font-bold text-slate-900 md:text-4xl">Complete Your Order</h1>
            <p class="mt-2 max-w-2xl text-sm text-slate-500 md:text-base">
                Review your details, choose payment method, and place the order in one step.
            </p>
        </div>
    </section>

    <section class="mx-auto grid max-w-7xl gap-6 px-6 py-8 lg:grid-cols-[1.15fr,0.85fr]">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm md:p-7">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-xl font-bold text-slate-900">Delivery Details</h2>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">Step 1 of
                    1</span>
            </div>

            <form action="viewcheckout.php" method="POST" class="space-y-5">
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Full Name</label>
                        <input type="text" name="full_name"
                            value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>" required
                            class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Phone</label>
                        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>"
                            required
                            class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100">
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>"
                        required
                        class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100">
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Address</label>
                    <textarea name="address" required rows="4"
                        class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100"></textarea>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">City</label>
                        <input type="text" name="city" required
                            class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">State</label>
                        <input type="text" name="state" required
                            class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Pincode</label>
                        <input type="text" name="pincode" required
                            class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100">
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Payment Method</label>
                    <select name="payment_method" required
                        class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100">
                        <option value="">Select Payment Method</option>
                        <option value="COD">Cash on Delivery</option>
                        <option value="Online">Online Payment</option>
                    </select>
                </div>

                <button type="submit"
                    class="inline-flex w-full items-center justify-center rounded-xl bg-blue-600 px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Continue
                </button>
            </form>
        </div>

        <aside class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm md:p-7 lg:sticky lg:top-24 lg:h-fit">
            <h2 class="text-xl font-bold text-slate-900">Order Summary</h2>
            <p class="mt-1 text-sm text-slate-500"><?php echo count($cart_items); ?> item(s) in your cart</p>

            <div class="mt-6 space-y-4">
                <?php foreach ($cart_items as $item): ?>
                    <div class="flex gap-3 rounded-xl border border-slate-200 p-3">
                        <div class="h-16 w-16 shrink-0 overflow-hidden rounded-lg bg-slate-100">
                            <?php if (!empty($item['image'])): ?>
                                <img src="<?php echo $image_base_url . htmlspecialchars($item['image']); ?>"
                                    alt="<?php echo htmlspecialchars($item['product_name']); ?>"
                                    class="h-full w-full object-contain">
                            <?php else: ?>
                                <div
                                    class="flex h-full w-full items-center justify-center text-xs font-semibold text-slate-500">
                                    No Image</div>
                            <?php endif; ?>
                        </div>

                        <div class="flex-1">
                            <p class="truncate text-sm font-semibold text-slate-900">
                                <?php echo htmlspecialchars($item['product_name']); ?>
                            </p>
                            <p class="mt-1 text-xs text-slate-500">Qty: <?php echo (int) $item['quantity']; ?></p>
                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                &#8377; <?php echo number_format((float) $item['subtotal'], 2); ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-6 space-y-3 border-t border-slate-200 pt-4 text-sm">
                <div class="flex items-center justify-between text-slate-600">
                    <span>Subtotal</span>
                    <span>&#8377; <?php echo number_format((float) $total, 2); ?></span>
                </div>
                <div class="flex items-center justify-between text-slate-600">
                    <span>Shipping</span>
                    <span class="font-medium text-emerald-600">Free</span>
                </div>
                <div
                    class="flex items-center justify-between border-t border-slate-200 pt-3 text-lg font-bold text-slate-900">
                    <span>Total</span>
                    <span>&#8377; <?php echo number_format((float) $total, 2); ?></span>
                </div>
            </div>
        </aside>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>