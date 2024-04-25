<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

function login($email, $password, $conn)
{
    $sql = "SELECT vendor_id, vendor_name, vendor_password, points, role FROM vendor WHERE vendor_email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['vendor_password'])) {
                $role = $row['role'];
                if ($role == 'vendor') {
                    $_SESSION['vendor_id'] = $row['vendor_id'];
                    $_SESSION['vendorName'] = $row['vendor_name'];
                    $_SESSION['points'] = $row['points'];
                    header("Location: index.php");
                    exit();
                } elseif ($role == 'admin') {
                    $_SESSION['admin_logged_in'] = true;
                    header("Location: ../admin/admin.php");
                    exit();
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">Incorrect password</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">No user found with the given email</div>';
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

function register($firstName, $lastName, $email, $password, $conn)
{
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $points = 0;
    $role = 'vendor';

    $checkEmailQuery = "SELECT * FROM vendor WHERE vendor_email = '$email'";
    $result = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($result) > 0) {
        echo '<div class="alert alert-warning" role="alert">Email already exists</div>';
    } else {
        $sql = "INSERT INTO vendor (vendor_name, vendor_email, vendor_password, register_date, vendor_status, points, role) 
                VALUES ('$firstName $lastName', '$email', '$hashedPassword', NOW(), 'active', $points, '$role')";

        if (mysqli_query($conn, $sql)) {
            $vendorId = mysqli_insert_id($conn);

            session_start();
            $_SESSION['vendor_id'] = $vendorId;
            $_SESSION['vendorName'] = $firstName . ' ' . $lastName;
            $_SESSION['points'] = $points;

            header("Location: ../vendor/vendor.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

function registerProduct($productName, $description, $price, $image, $vendorName, $quantity, $category, $conn)
{
    // Check if image upload was successful
    if ($image !== '' && file_exists('../uploads/' . $image)) {
        // SQL query to insert product into database
        $sql = "INSERT INTO product (product_name, description, price, image, status, create_date, update_date, seller_name, quantity, category) 
                VALUES ('$productName', '$description', $price, '$image', 'awaiting', NOW(), NOW(), '$vendorName', $quantity, '$category')";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Product added successfully.
                  </div>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Error adding product to the database: ' . mysqli_error($conn) . '
                  </div>';
        }
    } else {
        // Image upload failed or no image was selected
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Error uploading image or no image selected.
              </div>';
    }
}

function getProducts($conn)
{
    // Initialize an empty array to store active products
    $activeProducts = array();

    // SQL query to fetch active products with quantity greater than 0
    $sql = "SELECT * FROM product WHERE status = 'active' AND quantity > 0";
    $result = mysqli_query($conn, $sql);

    // Check if active products exist in the database
    if (mysqli_num_rows($result) > 0) {
        // Output each active product
        while ($row = mysqli_fetch_assoc($result)) {
            $activeProducts[] = $row; // Add active product to the array
        }
    }

    // Close database connection

    // Return the array of active products
    return $activeProducts;
}

function updateProfile($vendorId, $newName, $newEmail, $newPassword)
{
    global $conn;

    // Check if a new password is provided and hash it
    if (!empty($newPassword)) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE vendor SET vendor_name = ?, vendor_email = ?, vendor_password = ? WHERE vendor_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $newName, $newEmail, $hashedPassword, $vendorId);
    } else {
        $sql = "UPDATE vendor SET vendor_name = ?, vendor_email = ? WHERE vendor_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $newName, $newEmail, $vendorId);
    }

    // Execute the query
    if ($stmt->execute()) {
        echo "Profile updated successfully.";
    } else {
        echo "Error updating profile: " . $stmt->error;
    }

    $stmt->close();
}

// In config/function.php

function getProductsByVendorName($vendorName, $conn)
{
    // Initialize an empty array to store products
    $products = array();

    // SQL query to fetch products for a specific vendor by vendor name
    $sql = "SELECT * FROM product WHERE seller_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $vendorName);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if products exist in the database
    if ($result->num_rows > 0) {
        // Output each product
        while ($row = $result->fetch_assoc()) {
            $products[] = $row; // Add product to the array
        }
    }

    // Close statement
    $stmt->close();

    // Return the array of products
    return $products;
}


function updateProduct($productId, $productName, $description, $price, $image, $quantity, $category, $conn)
{
    // SQL query to update the product
    $sql = "UPDATE product SET product_name = ?, description = ?, price = ?, image = ?, quantity = ?, category = ?, update_date = NOW() WHERE product_id = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("ssdsisi", $productName, $description, $price, $image, $quantity, $category, $productId);

    // Execute the statement
    if ($stmt->execute()) {
        // Product updated successfully
        return true;
    } else {
        // Error updating product
        return false;
    }

    // Close the statement
    $stmt->close();
}

function getProductById($productId, $conn)
{
    // Prepare SQL query
    $sql = "SELECT * FROM product WHERE product_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        // Handle query preparation error
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("i", $productId);

    // Execute the query
    if (!$stmt->execute()) {
        // Handle query execution error
        die("Error executing statement: " . $stmt->error);
    }

    // Get the result
    $result = $stmt->get_result();

    // Check if product exists
    if ($result->num_rows == 1) {
        // Fetch product data
        $product = $result->fetch_assoc();
        return $product;
    } else {
        return null; // Product not found
    }
}



function deleteProduct($productId, $conn)
{
    // Prepare and execute SQL statement to delete the product
    $sql = "DELETE FROM product WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);

    // Check if the deletion was successful
    if ($stmt->execute()) {
        // Product deleted successfully
        return true;
    } else {
        // Error deleting product
        return false;
    }
}

// Function to update product status by product ID
function updateProductStatus($productId, $status, $conn)
{
    $sql = "UPDATE product SET status = ? WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $productId);
    $stmt->execute();
    $stmt->close();
}
// Function to update vendor status in the database

// Function to update vendor status
function updateVendorStatus($conn)
{
    // Check if admin is not logged in, redirect to login page
    if (!isset($_SESSION['admin_logged_in'])) {
        header("Location: ../client/index.php");
        exit();
    }

    // Check if the form is submitted
    if (isset($_POST['submit_vendor'])) {
        // Get vendor status from the form
        $vendor_status = $_POST['vendor_status'];

        // Loop through each vendor and update status
        foreach ($vendor_status as $vendor_id => $status) {
            $sql = "UPDATE vendor SET vendor_status='$status' WHERE vendor_id=$vendor_id";
            mysqli_query($conn, $sql);
        }

        // Redirect to users.php after updating vendor status
        header("Location: users.php");
        exit();
    }
}
// Function to validate admin login
function adminLogin($email, $password, $conn)
{
    $sql = "SELECT admin_id, admin_email, admin_password FROM admin WHERE admin_email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['admin_password'])) {
                $_SESSION['admin_id'] = $row['admin_id'];
                $_SESSION['admin_email'] = $row['admin_email'];
                header("Location: admin.php");
                exit();
            }
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    echo "Incorrect email or password";
}

function getOrdersByVendorName($vendorName, $conn)
{
    // Prepare SQL statement to fetch orders
    $sql = "SELECT * FROM orders WHERE seller = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $vendorName);

    // Execute the prepared statement
    $stmt->execute();

    // Get result set
    $result = $stmt->get_result();

    // Initialize an empty array to store orders
    $orders = array();

    // Fetch orders and add them to the array
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    // Close the statement
    $stmt->close();

    // Return the array of orders
    return $orders;
}

function updateQuantity($productId, $selectedQuantity, $status, $conn)
{
    if ($status == 'pending') {
        // Decrease the quantity in the product table by the selected quantity
        $sql_update_quantity = "UPDATE product SET quantity = quantity - ? WHERE product_id = ?";
        $stmt_update_quantity = $conn->prepare($sql_update_quantity);
        $stmt_update_quantity->bind_param("ii", $selectedQuantity, $productId);
        $stmt_update_quantity->execute();
        echo "Quantity updated successfully (Decreased).";
    } else if ($status == 'cancelled') {
        // Increase the quantity in the product table by the selected quantity
        $sql_update_quantity = "UPDATE product SET quantity = quantity + ? WHERE product_id = ?";
        $stmt_update_quantity = $conn->prepare($sql_update_quantity);
        $stmt_update_quantity->bind_param("ii", $selectedQuantity, $productId);
        $stmt_update_quantity->execute();
        echo "Quantity updated successfully (Increased).";
    } else {
        echo "Product status is neither pending nor cancelled. Quantity not updated.";
    }
}

function changeStatus($orderId, $status, $conn)
{
    // Prepare and execute SQL query to update order status
    $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $orderId);
    $stmt->execute();
    $stmt->close();

    // If the status is 'cancelled', update the product quantity
    if ($status == 'cancelled') {
        // Fetch the product ID associated with the cancelled order
        $productId = getProductIDByOrderID($orderId, $conn);

        // Fetch the current quantity of the product
        $currentQuantity = getCurrentProductQuantity($productId, $conn);

        // Fetch the quantity of the cancelled order
        $cancelledOrderQuantity = getOrderQuantity($orderId, $conn);

        // Calculate the new quantity after cancellation
        $newQuantity = $currentQuantity + $cancelledOrderQuantity;

        // Update the product quantity in the product table
        $sql = "UPDATE product SET quantity = ? WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $newQuantity, $productId);
        $stmt->execute();
        $stmt->close();
    }
}

// Function to retrieve the product ID associated with a given order ID
function getProductIDByOrderID($orderId, $conn)
{
    $sql = "SELECT product_id FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $productId = $row['product_id'];
    $stmt->close();
    return $productId;
}

// Function to retrieve the current quantity of a product based on its product ID
function getCurrentProductQuantity($productId, $conn)
{
    $sql = "SELECT quantity FROM product WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query returned any rows
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentQuantity = $row['quantity'];
    } else {
        // If no rows were returned, set quantity to null or any other appropriate value
        $currentQuantity = null;
    }

    $stmt->close();
    return $currentQuantity;
}


// Function to retrieve the quantity of a cancelled order based on its order ID
function getOrderQuantity($orderId, $conn)
{
    $sql = "SELECT quantity FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $cancelledOrderQuantity = $row['quantity'];
    $stmt->close();
    return $cancelledOrderQuantity;
}

function getVendorBalance($vendorName, $conn)
{
    // Prepare and execute SQL query to retrieve vendor balance
    $sql = "SELECT balance FROM vendor WHERE vendor_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $vendorName);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query returned any rows
    if ($result->num_rows > 0) {
        // Fetch balance from the result set
        $row = $result->fetch_assoc();
        $balance = $row['balance'];
        return $balance;
    } else {
        // Return 0 if vendor balance not found
        return 0;
    }
}

function addBalanceToVendor($vendorName, $balanceToAdd, $conn)
{
    // Retrieve current balance
    $currentBalance = getVendorBalance($vendorName, $conn);

    // Calculate new balance
    $newBalance = $currentBalance + $balanceToAdd;

    // Update balance in the database
    $sql = "UPDATE vendor SET balance = ? WHERE vendor_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ds", $newBalance, $vendorName);
    $stmt->execute();
    $stmt->close();
}

// Function to reset vendor points to 0 by vendor name
function resetVendorPoints($vendorName, $conn)
{
    $sql = "UPDATE vendor SET points = 0 WHERE vendor_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $vendorName);
    $stmt->execute();
    $stmt->close();
}

function getVendorPoints($vendorName, $conn)
{
    // Prepare and execute SQL query to retrieve vendor points
    $sql = "SELECT points FROM vendor WHERE vendor_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $vendorName);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query returned any rows
    if ($result->num_rows > 0) {
        // Fetch points from the result set
        $row = $result->fetch_assoc();
        $points = $row['points'];
        return $points;
    } else {
        // Return 0 if vendor points not found
        return 0;
    }
}

function getVendorTotalShippedOrders($vendorName, $conn)
{
    // SQL query to get the total order value for a specific vendor where the status is 'shipped'
    $sql = "SELECT SUM(quantity * price) AS total_amount FROM orders WHERE seller = ? AND status = 'shipped'";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("s", $vendorName);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Fetch the row
    $row = $result->fetch_assoc();

    // Close the statement
    $stmt->close();

    // Return the total amount or 0 if it's null
    return $row['total_amount'] ?? 0;
}

// Function to get shipped orders
function getShippedOrders($conn)
{
    $sql = "SELECT COUNT(*) as shipped_orders FROM orders WHERE status = 'shipped'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['shipped_orders'];
    } else {
        return 0;
    }
}

// Function to get cancelled orders
function getCancelledOrders($conn)
{
    $sql = "SELECT COUNT(*) as cancelled_orders FROM orders WHERE status = 'cancelled'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['cancelled_orders'];
    } else {
        return 0;
    }
}

// Function to get all orders
function getVendorOrders($conn, $vendor_name)
{
    $sql = "SELECT COUNT(*) as vendor_orders FROM orders WHERE seller = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $vendor_name);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['vendor_orders'];
    } else {
        return 0;
    }
}

// Function to get pending orders
function getPendingOrders($conn)
{
    $sql = "SELECT COUNT(*) as pending_orders FROM orders WHERE status = 'pending'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['pending_orders'];
    } else {
        return 0;
    }
}

function addVendorPoints($vendorName, $pointsToAdd, $conn)
{
    // Retrieve current points for the vendor
    $currentPoints = getVendorPoints($vendorName, $conn);

    // Calculate new points by adding pointsToAdd
    $newPoints = $currentPoints + $pointsToAdd;

    // Update vendor points in the database
    $sql = "UPDATE vendor SET points = ? WHERE vendor_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $newPoints, $vendorName);
    $stmt->execute();

    // Check for errors or successful execution
    if ($stmt->affected_rows > 0) {
        // Return new points if update was successful
        return $newPoints;
    } else {
        // Return false or handle the error accordingly
        return false;
    }
}

// Function to calculate the number of users
function countUsers($conn)
{
    $sql = "SELECT COUNT(*) AS total_users FROM vendor";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total_users'];
}

// Function to calculate the number of products
function countProducts($conn)
{
    $sql = "SELECT COUNT(*) AS total_products FROM product";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total_products'];
}

// Function to calculate the number of orders
function countOrders($conn)
{
    $sql = "SELECT COUNT(*) AS total_orders FROM orders";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total_orders'];
}

function fetchCategories($conn)
{
    $categories = []; // Initialize an array to store categories

    $sql = "SELECT DISTINCT category FROM product"; // SQL query to select distinct categories
    $result = mysqli_query($conn, $sql); // Execute the query

    // Populate the categories array with fetched categories
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row['category']; // Store each category in the array
        }
    }

    return $categories; // Return the array of categories
}

// Function to add items to the cart
function addToCart($conn, $product_id, $selected_quantity)
{
    // Check if the product ID and selected quantity are not empty
    if (!empty($product_id) && !empty($selected_quantity)) {
        // Check if the product already exists in the cart
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += $selected_quantity; // Update the quantity if the product is already in the cart
        } else {
            $_SESSION['cart'][$product_id] = array( // Add the product to the cart with the selected quantity
                'quantity' => $selected_quantity
            );
        }
    } else {
        // Handle the case where either product ID or quantity is empty
        // You can throw an error, log a message, or handle it as per your requirement
        // For example:
        // throw new Exception('Product ID or quantity is empty');
        // or
        // error_log('Product ID or quantity is empty', 0);
    }
}


// Function to filter products by category
function filterProductsByCategory($conn, $selectedCategory)
{
    // Check if a category is selected
    if (!empty($selectedCategory)) {
        // Fetch products based on the selected category
        $sql = "SELECT * FROM product WHERE category = ?"; // SQL query to select products based on category
        $stmt = $conn->prepare($sql); // Prepare the SQL statement
        $stmt->bind_param("s", $selectedCategory); // Bind the category parameter
        $stmt->execute(); // Execute the prepared statement
        $result = $stmt->get_result(); // Get the result of the query

        // Fetch the filtered products and store them in the filteredProducts array
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        // If no category is selected, fetch all products
        return getProducts($conn); // Call the getProducts function to fetch all products
    }
}

// Function to remove a product from the cart and restore its quantity
function removeProduct($product_id, $conn)
{
    if (isset($_SESSION['cart'][$product_id])) {
        $quantity = $_SESSION['cart'][$product_id]['quantity']; // Get the quantity of the product being removed

        // Remove the product from the cart
        unset($_SESSION['cart'][$product_id]);
    }
}

function resetCart()
{
    if (isset($_SESSION['cart'])) {
        unset($_SESSION['cart']); // Unset the cart session variable
        // Alternatively, you can destroy the entire session using session_destroy()
        // session_destroy();
    }
}

function getProductDetails($product_id, $conn)
{
    $sql = "SELECT * FROM product WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return false; // Product not found
    }
}

// Function to insert order into the database
function insertOrder($product_id, $product_name, $description, $price, $image, $seller_name, $client_name, $city, $wilaya, $phone, $quantity, $status, $conn)
{
    $sql = "INSERT INTO orders (product_id, name, description, price, image, seller, client_name, city, wilaya, phone, order_date, quantity, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssssssis", $product_id, $product_name, $description, $price, $image, $seller_name, $client_name, $city, $wilaya, $phone, $quantity, $status);
    $stmt->execute();
}

// Function to fetch seller information based on seller name
function getSellerInfo($conn, $sellerName)
{
    $sql = "SELECT * FROM vendor WHERE vendor_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $sellerName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return false; // Seller not found
    }
}

function getProduct($conn, $product_id)
{
    $sql = "SELECT * FROM product WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return false; // Product not found
    }
}

function getRelatedProducts($conn, $product)
{
    $relatedProducts = [];

    if (!empty($product['category'])) {
        $sql = "SELECT * FROM product WHERE category = ? AND product_id != ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $product['category'], $product['product_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $relatedProducts = $result->fetch_all(MYSQLI_ASSOC);
    }

    return $relatedProducts;
}
