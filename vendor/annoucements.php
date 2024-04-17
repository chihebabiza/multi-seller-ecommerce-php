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
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="favicon.png">

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <!-- Bootstrap CSS && Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="../css/tiny-slider.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/dash.css" rel="stylesheet">
    <title>Furni Free Bootstrap 5 Template for Furniture and Interior Design Websites by Untree.co </title>
</head>

<body>
    <!-- Start Header/Navigation -->
    <?php include("../inc/dash.php") ?>
    <!-- End Header/Navigation -->

    <div class="container mb-5">
        <!-- Start Welcome -->
        <div class="py-5 mb-2 lc-block">
            <div class="lc-block">
                <div editable="rich">
                    <h2 class="fw-bolder display-5">Welcome Vendor</h2>
                </div>
            </div>
            <div class="lc-block col-md-8">
                <div editable="rich">
                    <p class="lead">Welcome to your dashboard! This is your space to manage your products, view sales data, and keep track of your business. If you need any assistance or have any questions, feel free to reach out to our support team. We're here to help you succeed!
                    </p>
                </div>
            </div>
        </div>
        <!-- End Welcome -->

        <section class="py-2">
            <div class="container">
                <h1 class="mt-4">My Announcements</h1><br>
                <div class="row">
                    <?php
                    // Check if $products is set and not empty before iterating
                    if (isset($products) && !empty($products)) {
                        foreach ($products as $product) : ?>
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <img src="../uploads/<?php echo $product['image']; ?>" alt="<?php echo $product['product_name']; ?>" class="card-img-top">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $product['product_name']; ?></h5>
                                        <p class="card-text"><?php echo $product['description']; ?></p>
                                        <p class="card-text">Price: <?php echo $product['price']; ?></p>
                                        <p class="card-text">Status: <span class="badge bg-<?php echo getStatusColorClass($product['status']); ?>"><?php echo ucfirst($product['status']); ?></span></p>
                                        <div class="row">
                                            <div class="col">
                                                <!-- Edit button with link to edit.php -->
                                                <a href="edit.php?product_id=<?php echo $product['product_id']; ?>" class="btn btn-primary btn-block">Edit</a>
                                            </div>
                                            <div class="col">
                                                <!-- Delete button with form submission -->
                                                <form method="post" action="delete.php">
                                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                                    <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php endforeach;
                    } else {
                        echo "<p class='col'>No products found.</p>";
                    }
                    ?>
                </div>






            </div>
        </section>

        <?php
        function getStatusColorClass($status)
        {
            switch ($status) {
                case 'active':
                    return 'success'; // Bootstrap success color
                case 'awaiting':
                    return 'warning'; // Bootstrap warning color
                default:
                    return 'danger'; // Bootstrap danger color for other statuses
            }
        }
        ?>

    </div>
    <!-- Start Footer -->
    <br><br><br>
    <?php include("../inc/footer.php") ?>
    <!-- End Footer -->
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>