<?php
session_start();

// Check if admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../client/index.php");
    exit();
}
// Include database connection and function file
include("../config/connect.php");
include("../config/function.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_product'])) {
    // Check if product statuses are set and not empty
    if (isset($_POST['product_status']) && !empty($_POST['product_status'])) {
        // Loop through each product status
        foreach ($_POST['product_status'] as $productId => $status) {
            // Update product status in the database
            if (!updateProductStatus($productId, $status, $conn)) {
                // Handle error if update failed
                echo "Error updating status for product with ID: $productId";
                // Optionally, you can log the error for further investigation
            }
        }
        echo "Product statuses updated successfully.";
        // Redirect to a new page after updating statuses
        header("Location: announcements.php");
        exit(); // Add exit to stop further execution
    } else {
        echo "No status selected.";
    }
} else {
    echo "Invalid request.";
}
