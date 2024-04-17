<?php
session_start();

// Include database connection and functions
include("../config/connect.php");
include("../config/function.php");

// Function to unset or destroy the cart session variable
function resetCart()
{
    if (isset($_SESSION['cart'])) {
        unset($_SESSION['cart']); // Unset the cart session variable
        // Alternatively, you can destroy the entire session using session_destroy()
        // session_destroy();
    }
}

// Check if the reset button is clicked
if (isset($_POST['reset_cart'])) {
    resetCart();
}

// Check if the checkout form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get client information from the form
    $client_name = $_POST['client_name'];
    $wilaya = $_POST['wilaya'];
    $city = $_POST['city'];
    $phone = $_POST['phone'];

    // Initialize points to add for each order
    $pointsToAdd = 5;

    // Store each product in the cart as a separate order
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product_id => $product) {
            // Fetch product details from database
            $sql = "SELECT product_id, product_name, description, price, image, seller_name, quantity FROM product WHERE product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row) {
                $product_id = $row['product_id'];
                $product_name = $row['product_name'];
                $description = $row['description'];
                $price = $row['price'];
                $image = $row['image'];
                $seller_name = $row['seller_name'];
                $quantity = $product['quantity'];

                // Define default status
                $status = "pending";

                // Insert order into the database
                $sql = "INSERT INTO orders (product_id, name, description, price, image, seller, client_name, city, wilaya, phone, order_date, quantity, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("isssssssssis", $product_id, $product_name, $description, $price, $image, $seller_name, $client_name, $city, $wilaya, $phone, $quantity, $status);
                $stmt->execute();

                // Update vendor points
                $newPoints = getVendorPoints($seller_name, $conn) + $pointsToAdd;
                updateVendorPoints($seller_name, $newPoints, $conn);
            }
        }
    }

    updateQuantity($product_id, $quantity, $status, $conn);

    // Clear the cart after placing the order
    unset($_SESSION['cart']);

    // Redirect to the order confirmation page
    header("Location: order_confirmation.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>

<body>
    <h2>Enter Your Information</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="client_name">Name:</label><br>
        <input type="text" id="client_name" name="client_name" required><br>

        <label for="wilaya">Wilaya:</label><br>
        <input type="text" id="wilaya" name="wilaya" required><br>

        <label for="city">City:</label><br>
        <input type="text" id="city" name="city" required><br>

        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone" required><br><br>

        <input type="submit" value="Submit Order">
    </form>
</body>

</html>