<?php
session_start();

include("../config/connect.php");
include("../config/function.php");

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['vendorName'])) {
    header("Location: ../client/login.php");
    exit();
}

// Check if product ID is provided in the URL
if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    // Fetch product details from the database
    $product = getProductById($productId, $conn);

    // Check if the product exists and belongs to the logged-in vendor
    if ($product && $product['vendor_id'] == getVendorIdByName($_SESSION['vendorName'], $conn)) {
        // Handle form submission
        if (isset($_POST['submit'])) {
            // Retrieve form data
            $productName = $_POST['productName'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
            $category = $_POST['category'];

            // Check if an image is uploaded
            $image = $product['image']; // Keep the existing image by default
            if ($_FILES['image']['size'] > 0) {
                $image = uploadImage($_FILES['image']);
            }

            // Update the product in the database
            if (updateProduct($productId, $productName, $description, $price, $image, $quantity, $category, $conn)) {
                echo "Product updated successfully.";
                // Redirect to the dashboard
                header("Location: annoucements.php");
                exit();
            } else {
                echo "Error updating product.";
            }
        }
    } else {
        // Redirect to dashboard if the product does not exist or does not belong to the vendor
        header("Location: annoucements.php");
        exit();
    }
} else {
    // Redirect to dashboard if product ID is not provided
    header("Location: dashboard.php");
    exit();
}

// Include the head
include("../inc/head.php");

// Include the header
include("../inc/header.php");
?>
<!-- Product update form -->
<div class="container mt-5">
    <h2 class="text-center">Edit product</h2>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-8 pb-4">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?product_id=' . $productId; ?>" method="post" enctype="multipart/form-data">
                <!-- Product name field -->
                <div class="form-group">
                    <label class="text-black" for="productName">Product Name:</label>
                    <input type="text" class="form-control" id="productName" name="productName" required placeholder="Enter product name" value="<?php echo isset($product['product_name']) ? $product['product_name'] : ''; ?>">
                </div>
                <!-- Description field -->
                <div class="form-group">
                    <label class="text-black" for="description">Description:</label>
                    <textarea name="description" id="description" cols="30" rows="5" class="form-control" placeholder="Write your description here" required><?php echo isset($product['description']) ? $product['description'] : ''; ?></textarea>
                </div>
                <!-- Price field -->
                <div class="form-group mb-4">
                    <label class="text-black" for="price">Price:</label>
                    <input type="number" class="form-control" id="price" name="price" required placeholder="Enter product price" value="<?php echo isset($product['price']) ? $product['price'] : ''; ?>">
                </div>
                <!-- Image field -->
                <div class="form-group mb-4">
                    <label class="text-black" for="image">Image:</label>
                    <input class="form-control form-control-lg" id="image" type="file" name="image">
                </div>
                <!-- Quantity field -->
                <div class="form-group mb-4">
                    <label class="text-black" for="quantity">Quantity:</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required placeholder="Enter product quantity" value="<?php echo isset($product['quantity']) ? $product['quantity'] : ''; ?>">
                </div>
                <!-- Category field -->
                <div class="form-group mb-4">
                    <label class="text-black" for="category">Category:</label>
                    <select name="category" id="category" class="form-control" required>
                        <option value="" disabled>Select a category</option>
                        <?php
                        // Fetch categories from the database
                        $categories = ['Electronics', 'Fashion', 'Home & Garden', 'Books, Movies & Music', 'Collectibles & Antiques', 'Sports & Outdoors', 'Toys & Games', 'Health & Beauty', 'Automotive', 'Miscellaneous', 'Other'];
                        foreach ($categories as $cat) {
                            $selected = ($cat == $product['category']) ? 'selected' : '';
                            echo '<option value="' . $cat . '" ' . $selected . '>' . $cat . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <!-- Submit button -->
                <input type="submit" class="btn btn-primary w-100" name="submit" value="Update">
            </form>
        </div>
    </div>
    <br><br><br><br>
</div>
<!-- Footer -->
<?php include("../inc/footer.php") ?>