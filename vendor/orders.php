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

$totalOrders = count($orders);

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

$totalShipped = 0;
$totalCancelled = 0;
$totalPending = 0;

foreach ($orders as $order) {
    switch ($order['status']) {
        case 'shipped':
            $totalShipped++;
            break;
        case 'cancelled':
            $totalCancelled++;
            break;
        case 'pending':
            $totalPending++;
            break;
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="favicon.png">

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <!-- Bootstrap CSS && Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="../css/tiny-slider.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/dash.css" rel="stylesheet">
    <title>Furni Free Bootstrap 5 Template for Furniture and Interior Design Websites by Untree.co </title>
</head>

<body>
    <!-- Start Header/Navigation -->
    <?php include("../inc/dash.php") ?>
    <!-- End Header/Navigation -->

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
            <h1 class="mt-4">My Orders</h1><br>
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
                                    <td class="fw-bold mb-1"><?php echo $order['name']; ?></td>
                                    <td><?php echo $order['quantity'] * $order['price']; ?></td>
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
                                        <button type="submit">Save</button>
                                        <button type="submit">delete</button>
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
</body>

</html>