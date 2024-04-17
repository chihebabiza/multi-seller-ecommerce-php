<?php
session_start();

if (!isset($_SESSION['vendorName'])) {
    header("Location: ../client/login.php");
    exit();
}

include("../config/connect.php");
include("../config/function.php");


$categories = [];
$filteredProducts = [];

$sql = "SELECT DISTINCT category FROM product";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row['category'];
    }
}
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $selected_quantity = $_POST['selected_quantity'];

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $selected_quantity;
    } else {
        $_SESSION['cart'][$product_id] = array(
            'quantity' => $selected_quantity
        );
    }
}

if (isset($_GET['category'])) {
    $selectedCategory = $_GET['category'];

    // Check if the selected category is not empty
    if (!empty($selectedCategory)) {
        // Fetch products based on the selected category
        $sql = "SELECT * FROM product WHERE category = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $selectedCategory);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch the filtered products
        $filteredProducts = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        // If no category is selected, fetch all products
        $filteredProducts = getProducts($conn);
    }
} else {
    $filteredProducts = getProducts($conn);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Page</title>
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
    </style>
</head>

<body>
    <nav>
        <h3>Welcome, <?php echo $_SESSION['vendorName']; ?></h3>
        <span><a href="add.php">Add Product</a></span>
        <span><a href="logout.php">Logout</a></span>
        <span><a href="profile.php">profile</a></span>
        <span><a href="dashboard.php">Dashboard</a></span>
        <a id="cartLink" href="cart.php">Cart <sup id="cartCount"><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></sup></a>
        <br><br>
        <form action="" method="get">
            <label for="categoryFilter">Filter by Category:</label>
            <select name="category" id="categoryFilter">
                <option value="">All Categories</option>
                <?php
                foreach ($categories as $category) {
                    $selected = ($category == $selectedCategory) ? 'selected' : '';
                    echo '<option value="' . $category . '" ' . $selected . '>' . $category . '</option>';
                }
                ?>
            </select>
            <button type="submit">Apply</button>
        </form>
    </nav>
    <br>

    <div class="products">
        <?php
        foreach ($filteredProducts as $product) {
            echo '<div class="product">';
            echo '<img src="' . $product['image'] . '" alt="' . $product['product_name'] . '">';
            echo '<h3>' . $product['product_name'] . '</h3>';
            echo '<p class="price">$' . $product['price'] . '</p>';
            echo '<p class="quantity">Quantity in Stock: ' . $product['quantity'] . '</p>';
            echo '<p class="category">Category: ' . $product['category'] . '</p>';
            echo '<p class="seller">Seller: ' . $product['seller_name'] . '</p>';
            echo '<form method="post">';
            echo '<input type="hidden" name="product_id" value="' . $product['product_id'] . '">';
            echo '<select name="selected_quantity">';
            for ($i = 1; $i <= $product['quantity']; $i++) {
                echo '<option value="' . $i . '">' . $i . '</option>';
            }
            echo '</select>';
            echo '<button type="submit" name="add_to_cart">Add to Cart</button>';
            echo '</form>';
            echo '</div>';
        }
        ?>
    </div>
</body>

</html>