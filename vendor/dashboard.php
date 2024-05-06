<?php
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['vendorName'])) {
    header("Location: ../client/login.php");
    exit();
}

// Include functions and database connection
include("../config/connect.php");
include("../config/function.php");

// Fetch products for the logged-in vendor by vendor name
$vendorName = $_SESSION['vendorName'];
$vendor_id = $_SESSION['vendor_id']; // Assuming vendor_id is stored in session
$products = getProductsByVendorName($vendorName, $conn);
$totalShippedAmount = getVendorTotalShippedOrders($vendorName, $conn);

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

    <!-- Stats Points && Balance -->
    <div class="header-body">
        <div class="row">
            <div class="col-xl-4 col-lg-4">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Total Shipped Amount</h5>
                                <br>
                                <span class="h2 font-weight-bold mb-0"><?php echo $totalShippedAmount; ?> DZD</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                    <i class="fa-solid fa-dollar-sign"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Points</h5>
                                <br>
                                <span class="h2 font-weight-bold mb-0"><?php echo getVendorPoints($vendorName, $conn); ?></span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                    <i class="fa-solid fa-flag-checkered"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card for Balance -->
            <div class="col-xl-4 col-lg-4">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Balance</h5>
                                <br>
                                <span class="h2 font-weight-bold mb-0"><?php echo getVendorBalance($vendorName, $conn); ?> DZD</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                    <i class="fa-solid fa-wallet"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br><br>
    <!-- End Stats -->

    <!-- Stats Ortders -->
    <div class="header-body">
        <div class="row">
            <!-- All Orders -->
            <div class="col-xl-3 col-lg-6 mb-3 mb-xl-0">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Vendor Orders</h5>
                                <br>
                                <span class="h2 font-weight-bold mb-0"><?php echo getVendorOrders($conn, $vendor_id); ?></span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                    <i class="fa-solid fa-cart-arrow-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipped Orders -->
            <div class="col-xl-3 col-lg-6 mb-3 mb-xl-0">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Shipped</h5>
                                <br>
                                <span class="h2 font-weight-bold mb-0"><?php echo getShippedOrders($conn, $vendor_id); ?></span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                                    <i class="fa-solid fa-truck-fast"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Orders -->
            <div class="col-xl-3 col-lg-6 mb-3 mb-xl-0">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Pending</h5>
                                <br>
                                <span class="h2 font-weight-bold mb-0"><?php echo getPendingOrders($conn, $vendor_id); ?></span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                    <i class="fa-solid fa-hourglass-half"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cancelled Orders -->
            <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Cancelled</h5>
                                <br>
                                <span class="h2 font-weight-bold mb-0"><?php echo getCancelledOrders($conn, $vendor_id); ?></span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                    <i class="fa-solid fa-ban"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br><br>
    <!-- End Stats Orders -->
</div>
<!-- Start Footer -->
<br><br><br>
<?php include("../inc/footer.php") ?>
<!-- End Footer -->