<?php
session_start();

if (!isset($_SESSION['vendorName'])) {
    header("Location: ../client/login.php");
    exit();
}

include("../config/connect.php");
include("../config/function.php");

$vendorName = $_SESSION['vendorName'];
$orders = getOrdersByVendorName($vendorName, $conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    if (!is_numeric($order_id)) {
        die("Invalid order ID");
    }

    $allowed_statuses = ['pending', 'shipped', 'cancelled', 'returned'];
    if (!in_array($status, $allowed_statuses)) {
        die("Invalid status");
    }

    changeStatus($order_id, $status, $conn);

    $orders = getOrdersByVendorName($vendorName, $conn);
}

// Include the head
include("../inc/head.php");

// Include the header
include("../inc/header.php");
?>
<link rel="stylesheet" href="../css/dash.css">
<div class="container mb-5">
    <!-- Start Welcome -->
    <div class="py-5 mb-2 lc-block">
        <div class="lc-block">
            <div editable="rich">
                <h2 class="fw-bolder display-5">Welcome Vendor</h2>
            </div>
        </div>
        <div class="lc-block col-md-8">
            <div editable="rich">
                <p class="lead">Welcome to your dashboard! This is your space to manage your products, view sales data, and keep track of your business. If you need any assistance or have any questions, feel free to reach out to our support team. We're here to help you succeed!
                </p>
            </div>
        </div>
    </div>
    <!-- End Welcome -->

    <section class="py-2">
        <h1 class="mt-4">My Orders</h1><br><br>
        <div class="orders">
            <?php if (isset($orders) && !empty($orders)) : ?>
                <table class="table align-middle mb-0 bg-white">
                    <thead class="bg-light">
                        <tr>
                            <th>Client Name</th>
                            <th>City</th>
                            <th>Wilaya</th>
                            <th>Phone</th>
                            <th>Order Date</th>
                            <th>Product</th>
                            <th>Total</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order) : ?>
                            <tr>
                                <td><?php echo $order['client_name']; ?></td>
                                <td><?php echo $order['city']; ?></td>
                                <td><?php echo $order['wilaya']; ?></td>
                                <td><?php echo $order['phone']; ?></td>
                                <td><?php echo $order['order_date']; ?></td>
                                <td class="fw-bold mb-1"><?php echo $order['product_name']; ?></td>
                                <td><?php echo $order['price'] * $order['quantity']; ?></td>
                                <td><?php echo $order['quantity']; ?></td>
                                <td>
                                    <form action="orders.php" method="post">
                                        <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                        <div class="input-group">
                                            <select name="status" class="form-select" <?php echo ($order['status'] == 'cancelled') ? 'disabled' : ''; ?>>
                                                <option value="pending" <?php echo ($order['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                                <option value="shipped" <?php echo ($order['status'] == 'shipped') ? 'selected' : ''; ?>>Shipped</option>
                                                <option value="cancelled" <?php echo ($order['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                            </select>
                                        </div>
                                </td>
                                <td>
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-save"></i> <!-- Font Awesome save icon -->
                                    </button>
                                    <a class="btn btn-primary" href="product.php?product_id=<?php echo $order['product_id']; ?>">
                                        <i class="fas fa-eye"></i> <!-- Font Awesome eye icon -->
                                    </a>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No orders found.</p>
            <?php endif; ?>
        </div>
    </section>
</div>
<!-- Start Footer -->
<br><br><br>
<?php include("../inc/footer.php") ?>
<!-- End Footer -->
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</html>