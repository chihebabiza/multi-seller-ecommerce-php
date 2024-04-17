<?php
session_start();

// Include database connection and other necessary files
include("../config/connect.php");
include("../config/function.php");

// Function to remove a product from the cart and restore its quantity
function removeProduct($product_id, $conn)
{
    if (isset($_SESSION['cart'][$product_id])) {
        $quantity = $_SESSION['cart'][$product_id]['quantity']; // Get the quantity of the product being removed

        // Remove the product from the cart
        unset($_SESSION['cart'][$product_id]);

    }
}

// Check if the remove button is clicked
if (isset($_POST['remove_product'])) {
    $product_id = $_POST['product_id'];
    removeProduct($product_id, $conn);
}

// Check if the cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo '<h2>Your cart is empty</h2>';
} else {
    // Display cart items
    echo '<h2>Your Cart</h2>';
    echo '<table border="1">';
    echo '<tr><th>Product Name</th><th>Price</th><th>Quantity</th><th>Total</th><th>Action</th></tr>';

    // Calculate total price
    $total_price = 0;

    foreach ($_SESSION['cart'] as $product_id => $product) {
        // Fetch product details from database
        $sql = "SELECT product_name, price FROM product WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $product_name = $row['product_name'];
            $price = $row['price'];
            $quantity = $product['quantity'];
            $total = $price * $quantity;

            // Display cart item
            echo '<tr>';
            echo '<td>' . $product_name . '</td>';
            echo '<td>$' . $price . '</td>';
            echo '<td>' . $quantity . '</td>';
            echo '<td>$' . $total . '</td>';
            echo '<td>';
            echo '<form method="post">';
            echo '<input type="hidden" name="product_id" value="' . $product_id . '">';
            echo '<button type="submit" name="remove_product">Remove</button>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';

            // Add to total price
            $total_price += $total;
        }
    }

    echo '</table>';

    // Display total price
    echo '<h3>Total Price: $' . $total_price . '</h3>';

    // Links to go to home and checkout pages
    echo '<a href="checkout.php?total_price=' . $total_price . '">Go to Checkout</a><br>';
}
echo '<a href="vendor.php">Go to Home</a><br>';
