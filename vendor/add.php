<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['vendorName'])) {
    header("Location: ../client/login.php");
    exit();
}

// Include database connection
include("../config/connect.php");

// Include functions file
include("../config/function.php");

// Check if the form is submitted
if (isset($_POST['addProduct'])) {
    // Get form data
    $productName = $_POST['productName'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Image upload handling
    $image = ''; // Initialize image variable
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Specify directory for image uploads
        $targetDir = "../uploads/";

        // Generate a unique name for the image
        $image = uniqid() . '_' . basename($_FILES["image"]["name"]);

        // Set the file path
        $targetFilePath = $targetDir . $image;

        // Check if file type is allowed
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        if (in_array($fileType, array("jpg", "jpeg", "png", "gif"))) {
            // Upload file to server
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                // File uploaded successfully
            } else {
                echo "Error uploading image.";
            }
        } else {
            echo "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
        }
    }

    // Get vendor name from session
    $vendorName = $_SESSION['vendorName'];

    // Use the registerProduct function
    registerProduct($productName, $description, $price, $image, $vendorName, $conn);
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form style="text-align: center;" method="post" action="">
        <h1>Add Product</h1><br><br>
        <label>Product Name</label>
        <input type="text" name="productName"><br><br>
        <label>Description</label>
        <textarea name="description"></textarea><br><br>
        <label>Price</label>
        <input type="text" name="price"><br><br>
        <label>Image</label>
        <input type="file" name="image"><br><br>
        <input type="submit" name="addProduct" value="Add Product">
    </form>
</body>

</html>