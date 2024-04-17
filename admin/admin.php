<?php
session_start();

// Check if admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../client/index.php");
    exit();
}
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/tiny-slider.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/dash.css" rel="stylesheet">
    <title>Furni Free Bootstrap 5 Template for Furniture and Interior Design Websites by Untree.co </title>
</head>

<body>
    <!-- Start Header/Navigation -->
    <?php include("../inc/dash.php") ?>
    <!-- End Header/Navigation -->

    <br><br><br>
    <div class="container">
        <form action="update_status.php" method="post">
            <?php
            // Include database connection file
            include("../config/connect.php");

            // Fetch products from the database
            $sql = "SELECT * FROM product";
            $result = mysqli_query($conn, $sql);

            // Check if there are any products
            if (mysqli_num_rows($result) > 0) {
                // Start the HTML table
                echo "<table class='table align-middle mb-0 bg-white'>";
                echo "<thead class='bg-light'>";
                echo "<tr>";
                echo "<th>Name</th>";
                echo "<th>Description</th>";
                echo "<th>Price</th>";
                echo "<th>Status</th>";
                echo "<th>Create Date</th>";
                echo "<th>Update Date</th>";
                echo "<th>Seller Name</th>";
                echo "<th>Action</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                // Output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["product_name"] . "</td>";
                    echo "<td>" . $row["description"] . "</td>";
                    echo "<td>" . $row["price"] . "</td>";
                    echo "<td><select name='product_status[" . $row['product_id'] . "]' class='form-select'>";
                    echo "<option value='awaiting' " . ($row["status"] == "awaiting" ? "selected" : "") . ">Awaiting</option>";
                    echo "<option value='active' " . ($row["status"] == "active" ? "selected" : "") . ">Active</option>";
                    echo "<option value='inactive' " . ($row["status"] == "inactive" ? "selected" : "") . ">Inactive</option>";
                    echo "</select></td>";
                    echo "<td>" . $row["create_date"] . "</td>";
                    echo "<td>" . $row["update_date"] . "</td>";
                    echo "<td>" . $row["seller_name"] . "</td>";
                    // Display Save button to update status and Delete button
                    echo "<td>";
                    echo "<button type='submit' name='submit_product' class='btn btn-primary custom-btn'><i class='fas fa-save'></i></button>";
                    echo "<button type='submit' name='view_product' class='btn btn-info custom-btn' onclick='viewProduct(" . $row['product_id'] . ")'><i class='fas fa-eye'></i></button>";
                    echo "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "No products found.";
            }

            // Close database connection
            ?>
        </form>
        <section class="bsb-fact-5 py-3">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                        <h3 class="fs-5 mb-2 text-secondary text-center text-uppercase">Our Success</h3>
                        <h2 class="display-5 mb-5 mb-xl-9 text-center">We have a proven track record of success.</h2>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="container-fluid bg-light border shadow">
                            <div class="row">
                                <div class="col-12 col-md-6 p-0">
                                    <div class="card border-0 bg-transparent">
                                        <div class="card-body text-center p-4 p-xxl-5">
                                            <h3 class="display-4 fw-bold mb-2">60+</h3>
                                            <p class="fs-5 mb-0 text-secondary">Finished Projects</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 p-0 border-top border-bottom border-start border-end">
                                    <div class="card border-0 bg-transparent">
                                        <div class="card-body text-center p-4 p-xxl-5">
                                            <h3 class="display-4 fw-bold mb-2">18k+</h3>
                                            <p class="fs-5 mb-0 text-secondary">Issues Solved</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>


    <!-- Start Footer -->
    <br><br><br>
    <?php include("../inc/footer.php") ?>
    <!-- End Footer -->
</body>

</html>