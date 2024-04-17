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

// Fetch products for the logged-in vendor by vendor name
$vendorName = $_SESSION['vendorName'];
$products = getProductsByVendorName($vendorName, $conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            padding: 20px 100px;
        }

        nav {
            text-align: center;
            font-size: 20px;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-gap: 20px;
        }

        .product {
            background-color: green;
            padding: 20px;
        }

        button {
            font-size: 20px;
        }

        .price {
            background-color: red;
        }
    </style>
</head>

<body>
    <nav>
        <h3>Welcome, <?php echo $_SESSION['vendorName']; ?></h3>
        <span><a href="add.php">Add Product</a></span>
        <span><a href="orders.php">Orders</a></span> <!-- Link to the orders page -->
        <span><a href="logout.php">Logout</a></span>
        <span><a href="profile.php">Profile</a></span>
        <span><a href="dashboard.php">Dashboard</a></span>
    </nav>
    <h2>My Products</h2>
    <div class="products">
        <?php
        // Check if $products is set and not empty before iterating
        if (isset($products) && !empty($products)) {
            foreach ($products as $product) : ?>
                <div class="product">
                    <h3><?php echo $product['product_name']; ?></h3>
                    <p><?php echo $product['description']; ?></p>
                    <h3 class="price">Price: <?php echo $product['price']; ?></h3> <!-- Display product price -->
                    <h3 class="status">Status: <?php echo $product['status']; ?></h3> <!-- Display product status -->
                    <!-- Edit button with link to edit.php -->
                    <a href="edit.php?product_id=<?php echo $product['product_id']; ?>"><button>Edit</button></a>
                    <!-- Delete button with form submission -->
                    <form method="post" action="delete.php">
                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                    </form>
                    <hr>
                    <h4><?php echo $product['seller_name']; ?></h4>
                </div>
        <?php endforeach;
        } else {
            echo "<p>No products found.</p>";
        }
        ?>
    </div>

</body>

</html>