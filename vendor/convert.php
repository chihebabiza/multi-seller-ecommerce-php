<?php
session_start();

if (!isset($_SESSION['vendorName'])) {
    header("Location: ../client/login.php");
    exit();
}

include("../config/connect.php");
include("../config/function.php");

$vendorName = $_SESSION['vendorName'];
$points = getVendorPoints($vendorName, $conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add vendor's points to their balance (you might adjust this logic)
    $balanceToAdd = $points;
    addBalanceToVendor($vendorName, $balanceToAdd, $conn);

    // Reset vendor's points to zero
    resetVendorPoints($vendorName, $conn);

    // Redirect to orders page or any other page as needed
    header("Location: dashboard.php");
    exit();
}

// Include the head
include("../inc/head.php");

// Include the header
include("../inc/header.php");
?>
<div class="container mt-5">
    <h3 class="text-center">Convert Points to Balance</h3>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-8 pb-4">
            <p class="text-center display-7">Are you sure you want to convert your points to balance?</p>
            <br>
            <form action="" method="post">
                <button class="btn btn-primary w-100" type="submit">Convert</button>
            </form>
        </div>
    </div>
</div>

<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/tiny-slider.js"></script>
<script src="../js/custom.js"></script>