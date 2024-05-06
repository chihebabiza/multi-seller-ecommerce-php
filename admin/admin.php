<?php
session_start();

include("../config/connect.php");
include("../config/function.php");

// Check if admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../client/index.php");
    exit();
}

$totalUsers = countUsers($conn);
$totalProducts = countProducts($conn);
$totalOrders = countOrders($conn);

// Include the head
include("../inc/head.php");

// Include the header
include("../inc/header.php");
?>
<link rel="stylesheet" href="../css/dash.css">
<div class="container">
    <!-- Start Welcome -->
    <div class="py-5 mb-2 lc-block">
        <div class="lc-block">
            <div editable="rich"><br>
                <h2 class="fw-bolder display-5">Welcome Admin</h2><br>
            </div>
        </div>
        <div class="lc-block col-md-8">
            <div editable="rich">
                <p class="lead">Welcome to your dashboard, Admin! This is your central hub for managing users and announcements. Here, you can efficiently oversee user accounts, update information, and ensure smooth operations. Additionally, you have the power to create and distribute announcements to keep your community informed and engaged!
                </p><br>
            </div>
        </div>
    </div>
    <!-- End Welcome -->

    <!-- Stats Users && Orders -->
    <div class="header-body">
        <div class="row">
            <div class="col-xl-4 col-lg-4">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Total Users</h5>
                                <br>
                                <span class="h2 font-weight-bold mb-0"><?php echo countUsers($conn); ?></span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                                    <i class="fa-solid fa-users"></i>
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
                                <h5 class="card-title text-uppercase text-muted mb-0">Total Announcements</h5>
                                <br>
                                <span class="h2 font-weight-bold mb-0"><?php echo countProducts($conn); ?></span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                    <i class="fa-solid fa-bag-shopping"></i>
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
                                <h5 class="card-title text-uppercase text-muted mb-0">Total Orders</h5>
                                <br>
                                <span class="h2 font-weight-bold mb-0"><?php echo countOrders($conn); ?></span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                    <i class="fa-solid fa-truck-fast"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Stats -->
</div>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/tiny-slider.js"></script>
<script src="../js/custom.js"></script>