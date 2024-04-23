<?php
session_start();

// Check if admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../client/index.php");
    exit();
}
include("../config/connect.php");

if (isset($_POST['submit_vendor'])) {
    $vendor_status = $_POST['vendor_status'];
    foreach ($vendor_status as $vendor_id => $status) {
        $sql = "UPDATE vendor SET vendor_status='$status' WHERE vendor_id=$vendor_id";
        mysqli_query($conn, $sql);
    }
    echo "Vendor status updated successfully!";
    header("Location: users.php");
}

mysqli_close($conn);
