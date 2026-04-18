<?php
session_start();
include __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?auth=open");
    exit();
}

include __DIR__ . '/header.php';

$user_id = (int) $_SESSION['user_id'];

/*
|---------------------------------------------------------
| Save checkout form data into session when coming from
| checkout.php
|---------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['checkout_data'] = [
        'full_name' => trim($_POST['full_name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'address' => trim($_POST['address'] ?? ''),
        'city' => trim($_POST['city'] ?? ''),
        'state' => trim($_POST['state'] ?? ''),
        'pincode' => trim($_POST['pincode'] ?? ''),
        'payment_method' => trim($_POST['payment_method'] ?? '')
    ];
}

if (empty($_SESSION['checkout_data'])) {
    header("Location: " . $base_path . "includes/checkout.php");
    exit();
}

$checkout_data = $_SESSION['checkout_data'];

/*
|---------------------------------------------------------
| Basic validation
|---------------------------------------------------------
*/
if (
    $checkout_data['full_name'] === '' ||
    $checkout_data['email'] === '' ||
    $checkout_data['phone'] === '' ||
    $checkout_data['address'] === '' ||
    $checkout_data['city'] === '' ||
    $checkout_data['state'] === '' ||
    $checkout_data['pincode'] === '' ||
    $checkout_data['payment_method'] === ''
) {
    header("Location: " . $base_path . "includes/checkout.php");
    exit();
}

/*
|---------------------------------------------------------
| Fetch cart items
|---------------------------------------------------------
*/
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
$cart_items = [];

while ($row = $result->fetch_assoc()) {
    $row['subtotal'] = (float) $row['price'] * (int) $row['quantity'];
    $total += $row['subtotal'];
    $item_count += (int) $row['quantity'];
    $cart_items[] = $row;
}

if (count($cart_items) === 0) {
    header("Location: " . $base_path . "includes/cart.php");
    exit();
}

$mrp_total = $total;
$fees = 0;
$discount = 0;
$payable_total = $mrp_total + $fees - $discount;
?>

<main class="min-h-screen bg-[#f1f3f6] pb-10">
    <section class="mx-auto max-w-6xl px-4 py-6 md:px-6">
        <div class="mb-4 rounded-sm border border-slate-200 bg-white px-4 py-4">
            <div
                class="mx-auto flex max-w-xl items-center justify-between text-xs font-semibold text-slate-500 md:text-sm">
                <div class="flex items-center gap-2">
                    <span
                        class="inline-flex h-6 w-6 items-center justify-center rounded-full border border-slate-300 bg-white">1</span>
                    <span>Address</span>
                </div>
                <div class="h-[2px] w-10 bg-slate-200 md:w-20"></div>
                <div class="flex items-center gap-2 text-blue-600">
                    <span
                        class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-blue-600 text-white">2</span>
                    <span>Order Summary</span>
                </div>
                <div class="h-[2px] w-10 bg-slate-200 md:w-20"></div>
                <div class="flex items-center gap-2 text-slate-400">
                    <span
                        class="inline-flex h-6 w-6 items-center justify-center rounded-full border border-slate-300 bg-white">3</span>
                    <span>Payment</span>
                </div>
            </div>
        </div>

        <div class="grid gap-4 lg:grid-cols-[1.45fr,0.75fr]">
            <div class="space-y-4">
                <div class="rounded-sm border border-slate-200 bg-white p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-700">Deliver to:</p>
                            <h2 class="mt-1 text-lg font-semibold text-slate-900">
                                <?php echo htmlspecialchars($checkout_data['full_name']); ?>
                            </h2>
                            <p class="mt-2 text-sm leading-6 text-slate-700">
                                <?php echo htmlspecialchars($checkout_data['address']); ?>,
                                <?php echo htmlspecialchars($checkout_data['city']); ?>,
                                <?php echo htmlspecialchars($checkout_data['state']); ?> -
                                <?php echo htmlspecialchars($checkout_data['pincode']); ?>
                            </p>
                            <p class="mt-1 text-sm text-slate-700">
                                <?php echo htmlspecialchars($checkout_data['phone']); ?>
                            </p>
                            <p class="mt-1 text-sm text-slate-700">
                                <?php echo htmlspecialchars($checkout_data['email']); ?>
                            </p>
                        </div>
                        <a href="<?php echo $base_path; ?>includes/checkout.php"
                            class="inline-flex rounded-sm border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-blue-600 hover:bg-slate-50">
                            Change
                        </a>
                    </div>
                </div>

                <div class="rounded-sm border border-slate-200 bg-white p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Payment Method</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">
                        <?php echo htmlspecialchars($checkout_data['payment_method']); ?>
                    </p>
                </div>

                <div class="space-y-2">
                    <?php foreach ($cart_items as $item): ?>
                        <article class="rounded-sm border border-slate-200 bg-white p-3">
                            <div class="flex gap-3">
                                <div
                                    class="flex h-20 w-16 shrink-0 items-center justify-center overflow-hidden rounded-sm border border-slate-200 bg-white">
                                    <?php if (!empty($item['image'])): ?>
                                        <img src="<?php echo $image_base_url . htmlspecialchars($item['image']); ?>"
                                            alt="<?php echo htmlspecialchars($item['product_name']); ?>"
                                            class="h-full w-full object-contain">
                                    <?php else: ?>
                                        <span class="text-xs text-slate-500">No Image</span>
                                    <?php endif; ?>
                                </div>

                                <div class="flex-1">
                                    <p class="line-clamp-1 text-[17px] font-medium text-slate-900">
                                        <?php echo htmlspecialchars($item['product_name']); ?>
                                    </p>
                                    <p class="mt-0.5 text-sm text-slate-500"><?php echo htmlspecialchars($item['brand']); ?>
                                    </p>

                                    <div class="mt-2 flex items-center gap-2 text-sm text-slate-700">
                                        <span class="rounded-sm border border-slate-300 px-2 py-1">Qty:
                                            <?php echo (int) $item['quantity']; ?></span>
                                        <span>Unit: &#8377;<?php echo number_format((float) $item['price'], 2); ?></span>
                                    </div>

                                    <div class="mt-2">
                                        <span
                                            class="text-xl font-semibold text-slate-900">&#8377;<?php echo number_format((float) $item['subtotal'], 2); ?></span>
                                    </div>

                                    <p class="mt-2 text-sm text-emerald-700">Delivery in 2 days</p>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <p class="px-1 text-xs text-slate-500">By continuing, you confirm that all order details are correct.
                </p>
            </div>

            <aside class="space-y-4 lg:sticky lg:top-24 lg:h-fit">
                <div class="rounded-sm border border-slate-200 bg-white p-4">
                    <h2
                        class="border-b border-slate-200 pb-3 text-sm font-semibold uppercase tracking-wide text-slate-500">
                        Price Details</h2>

                    <div class="mt-4 space-y-3 text-sm">
                        <div class="flex items-center justify-between text-slate-700">
                            <span>Price (<?php echo $item_count; ?> item)</span>
                            <span>&#8377;<?php echo number_format((float) $mrp_total, 2); ?></span>
                        </div>
                        <div class="flex items-center justify-between text-slate-700">
                            <span>Fees</span>
                            <span>&#8377;<?php echo number_format((float) $fees, 2); ?></span>
                        </div>
                        <div class="flex items-center justify-between text-slate-700">
                            <span>Discount</span>
                            <span class="font-semibold text-emerald-600">-
                                &#8377;<?php echo number_format((float) $discount, 2); ?></span>
                        </div>
                        <div
                            class="flex items-center justify-between border-t border-slate-200 pt-3 text-base font-semibold text-slate-900">
                            <span>Total Amount</span>
                            <span>&#8377;<?php echo number_format((float) $payable_total, 2); ?></span>
                        </div>
                    </div>

                    <div class="mt-4 rounded-sm bg-emerald-50 px-3 py-2 text-sm font-medium text-emerald-700">
                        You will save &#8377;<?php echo number_format((float) $discount, 2); ?> on this order
                    </div>
                </div>

                <div class="rounded-sm border border-slate-200 bg-white p-4 text-sm text-slate-600">
                    Safe and secure payments. Easy returns. 100% authentic products.
                </div>

                <div class="rounded-sm border border-slate-200 bg-white p-4">
                    <p class="text-xs text-slate-500">Total Payable</p>
                    <p class="mt-1 text-2xl font-semibold text-slate-900">
                        &#8377;<?php echo number_format((float) $payable_total, 2); ?></p>
                    <form action="<?php echo $base_path; ?>includes/place_order.php" method="POST" class="mt-3">
                        <button type="submit"
                            class="inline-flex w-full items-center justify-center rounded-sm bg-amber-400 px-4 py-3 text-sm font-semibold text-slate-900 transition hover:bg-amber-300">
                            Continue
                        </button>
                    </form>
                    <a href="<?php echo $base_path; ?>includes/checkout.php"
                        class="mt-2 inline-flex w-full items-center justify-center rounded-sm border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Back
                    </a>
                </div>
            </aside>
        </div>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>