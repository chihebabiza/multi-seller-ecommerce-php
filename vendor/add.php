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
include("../config/function.php");

// Check if the form is submitted
if (isset($_POST['addProduct'])) {

    // Get form data
    $productName = $_POST['productName'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];

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
    registerProduct($productName, $description, $price, $image, $vendorName, $quantity, $category, $conn);
}

// Include the head
include("../inc/head.php");

// Include the header
include("../inc/header.php");
?>

<!-- Start Contact Form -->
<div class="container mt-5">
    <h2 class="text-center">Add new product</h2>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-8 pb-4">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="text-black" for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="productName" required placeholder="Enter product name">
                </div>
                <div class="form-group">
                    <label for="description" class="text-black">Description</label>
                    <textarea name="description" id="description" cols="30" rows="5" class="form-control" placeholder="Write your description here" required></textarea>
                </div>
                <div class="form-group mb-4">
                    <label class="text-black" for="price">Price</label>
                    <input type="number" class="form-control" id="price" name="price" required placeholder="Enter product price">
                </div>
                <div>
                    <input class="form-control form-control-lg mb-4" id="formFileLg" type="file" name="image">
                </div>
                <div class="form-group">
                    <label class="text-black" for="quantity">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required placeholder="Enter product quantity">
                </div>
                <div class="form-group">
                    <label class="text-black" for="category">Category</label>
                    <select name="category" id="category" class="form-control" required>
                        <option value="" disabled selected>Select a category</option>
                        <option value="Computer Components">Computer Components</option>
                        <option value="Home Appliances">Home Appliances</option>
                        <option value="Auto Parts">Auto Parts</option>
                    </select>
                </div>
                <br>
                <input type="submit" class="btn btn-primary w-100" name="addProduct" value="Add Product">
            </form>
        </div>
    </div>
</div>
<br><br><br>
<!-- End Contact Form -->
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/tiny-slider.js"></script>
<script src="../js/custom.js"></script>