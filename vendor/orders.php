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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <style>
        body {
            padding: 20px 100px;
        }

        nav {
            text-align: center;
            font-size: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <nav>
        <h3>Welcome, <?php echo $_SESSION['vendorName']; ?></h3>
        <span><a href="add.php">Add Product</a></span>
        <span><a href="orders.php">Orders</a></span>
        <span><a href="logout.php">Logout</a></span>
        <span><a href="profile.php">Profile</a></span>
        <span><a href="dashboard.php">Dashboard</a></span>
        <span>Points: <?php echo getVendorPoints($_SESSION['vendorName'], $conn); ?></span>
        <span><a href="convert.php">convert to balance</a></span>
        <span>Balance: <?php echo getVendorBalance($_SESSION['vendorName'], $conn); ?> DA</span>
        <br><br>
        <span>Total Orders: <?php echo $totalOrders; ?></span>
        <span>Shipped: <?php echo $totalShipped; ?></span>
        <span>Cancelled: <?php echo $totalCancelled; ?></span>
        <span>Pending: <?php echo $totalPending; ?></span>
    </nav>
    <h2>My Orders</h2>
    <div class="orders">
        <?php if (isset($orders) && !empty($orders)) : ?>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Client Name</th>
                    <th>City</th>
                    <th>Wilaya</th>
                    <th>Phone</th>
                    <th>Order Date</th>
                    <th>Product</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($orders as $order) : ?>
                    <tr>
                        <td><?php echo $order['order_id']; ?></td>
                        <td><?php echo $order['client_name']; ?></td>
                        <td><?php echo $order['city']; ?></td>
                        <td><?php echo $order['wilaya']; ?></td>
                        <td><?php echo $order['phone']; ?></td>
                        <td><?php echo $order['order_date']; ?></td>
                        <td><?php echo $order['name']; ?></td>
                        <td><?php echo $order['description']; ?></td>
                        <td><?php echo $order['price']; ?></td>
                        <td><?php echo $order['quantity']; ?></td>
                        <td>
                            <form action="orders.php" method="post">
                                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                <select name="status" <?php echo ($order['status'] == 'cancelled') ? 'disabled' : ''; ?>>
                                    <option value="pending" <?php echo ($order['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                    <option value="shipped" <?php echo ($order['status'] == 'shipped') ? 'selected' : ''; ?>>Shipped</option>
                                    <option value="cancelled" <?php echo ($order['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                </select>
                        </td>
                        <td>
                            <button type="submit">Save</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else : ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </div>
</body>

</html>