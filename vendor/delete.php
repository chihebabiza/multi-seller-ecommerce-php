<?php
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['vendorName'])) {
    header("Location: ../client/login.php");
    exit();
}

// Include database connection
include("../config/connect.php");
include("../config/function.php");

// Check if product ID is provided in the POST request
if (isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];

    // Delete the product from the database
    if (deleteProduct($productId, $conn)) {
        echo "Product deleted successfully.";
    } else {
        echo "Error deleting product.";
    }

    // Redirect back to the dashboard
    header("Location: annoucements.php");
    exit();
} else {
    // Redirect to dashboard if product ID is not provided
    header("Location: dashboard.php");
    exit();
}
