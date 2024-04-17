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
            if (updateProduct($productId, $productName, $description, $price, $image, $quantity, $category, $conn)) {
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
<!-- Start Header/Navigation -->
<?php include("../inc/header.php") ?>
<!-- End Header/Navigation -->
<div class="container mt-5">
    <h2 class="text-center">Edit product</h2>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-8 pb-4">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="text-black" for="productName">Product Name:</label>
                    <input type="text" class="form-control" id="productName" name="productName" required placeholder="Enter product name" value="<?php echo isset($product['product_name']) ? $product['product_name'] : ''; ?>">
                </div>
                <div class="form-group">
                    <label class="text-black" for="description">Description:</label>
                    <textarea name="description" id="description" cols="30" rows="5" class="form-control" placeholder="Write your description here" required><?php echo isset($product['description']) ? $product['description'] : ''; ?></textarea>
                </div>
                <div class="form-group mb-4">
                    <label class="text-black" for="price">Price:</label>
                    <input type="number" class="form-control" id="price" name="price" required placeholder="Enter product price" value="<?php echo isset($product['price']) ? $product['price'] : ''; ?>">
                </div>
                <div class="form-group mb-4">
                    <label class="text-black" for="image">Image:</label>
                    <input class="form-control form-control-lg" id="image" type="file" name="image">
                </div>
                <div class="form-group mb-4">
                    <label class="text-black" for="quantity">Quantity:</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required placeholder="Enter product quantity" value="<?php echo isset($product['quantity']) ? $product['quantity'] : ''; ?>">
                </div>
                <div class="form-group mb-4">
                    <label class="text-black" for="category">Category:</label>
                    <select name="category" id="category" class="form-control" required>
                        <option value="" disabled selected>Select a category</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Fashion">Fashion</option>
                        <option value="Home & Garden">Home & Garden</option>
                        <option value="Books, Movies & Music">Books, Movies & Music</option>
                        <option value="Collectibles & Antiques">Collectibles & Antiques</option>
                        <option value="Sports & Outdoors">Sports & Outdoors</option>
                        <option value="Toys & Games">Toys & Games</option>
                        <option value="Health & Beauty">Health & Beauty</option>
                        <option value="Automotive">Automotive</option>
                        <option value="Miscellaneous">Miscellaneous</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <input type="submit" class="btn btn-primary w-100" name="submit" value="Update">
            </form>
        </div>
    </div>
</div>
<br><br><br><br><br>
<!-- Start Footer Section -->
<?php include("../inc/footer.php") ?>
<!-- End Footer Section -->
</body>

</html>