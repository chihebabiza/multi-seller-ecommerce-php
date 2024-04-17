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

// Check if product ID is provided in the URL
if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    // Fetch product details from the database
    $product = getProductById($productId, $conn);

    // Check if the product exists and belongs to the logged-in vendor
    if ($product && $product['seller_name'] == $_SESSION['vendorName']) {
        // Handle form submission
        if (isset($_POST['submit'])) {
            // Retrieve form data
            $productName = $_POST['productName'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            // Check if an image is uploaded
            if ($_FILES['image']['size'] > 0) {
                $image = $_FILES['image']['name'];
                // Move the uploaded image to the desired location
                move_uploaded_file($_FILES['image']['tmp_name'], "../images/" . $image);
            } else {
                // Keep the existing image if no new image is uploaded
                $image = $product['image'];
            }

            // Update the product in the database
            if (updateProduct($productId, $productName, $description, $price, $image, $conn)) {
                echo "Product updated successfully.";
                // Redirect to the dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Error updating product.";
            }
        }
    } else {
        // Redirect to dashboard if the product does not exist or does not belong to the vendor
        header("Location: dashboard.php");
        exit();
    }
} else {
    // Redirect to dashboard if product ID is not provided
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>

<body style="text-align: center;">
    <h2>Edit Product</h2>
    <form method="post" enctype="multipart/form-data">
        <label for="productName">Product Name:</label><br>
        <input type="text" id="productName" name="productName" value="<?php echo $product['product_name']; ?>"><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description"><?php echo $product['description']; ?></textarea><br>
        <label for="price">Price:</label><br>
        <input type="number" id="price" name="price" value="<?php echo $product['price']; ?>"><br>
        <label for="image">Image:</label><br>
        <input type="file" id="image" name="image"><br>
        <input type="submit" name="submit" value="Update">
    </form>
</body>

</html>