<?php
session_start();

include("../config/connect.php");
include("../config/function.php");

// Check if admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../client/index.php");
    exit();
}
?>

<!-- Start Header/Navigation -->
<?php include("../inc/header.php") ?>
<!-- End Header/Navigation -->

<div class="container">
    <!-- Start Welcome -->
    <div class="py-5 lc-block">
        <div class="lc-block">
            <div editable="rich">
                <h2 class="fw-bolder display-5">Welcome Admin</h2>
            </div>
        </div>
        <div class="lc-block col-md-8">
            <div editable="rich">
                <p class="lead">Welcome to your dashboard, Admin! This is your central hub for managing users and announcements. Here, you can efficiently oversee user accounts, update information, and ensure smooth operations. Additionally, you have the power to create and distribute announcements to keep your community informed and engaged!
                </p>
            </div>
        </div>
    </div>
    <!-- End Welcome -->

    <div class="container">
        <h1 class="mt-4">Announcements</h1><br><br>
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
                echo "<th>Image</th>"; // Empty cell for the image
                echo "<th>Name</th>";
                echo "<th>Description</th>";
                echo "<th>Price</th>";
                echo "<th>Status</th>";
                echo "<th>Create Date</th>";
                echo "<th>Seller Name</th>";
                echo "<th>Action</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                // Output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td><img src='../uploads/" . $row['image'] . "' alt='" . $row['product_name'] . "' class='image img-fluid product-thumbnail' style='width: 50px; height: 50px;'></td>";
                    echo "<td>" . $row["product_name"] . "</td>";
                    echo "<td class='desc-admin' style='overflow: hidden;'>";
                    echo "<p style='height: 100px; width: 300px;'>" . $row["description"] . "</p>";
                    echo "</td>";
                    echo "<td>" . $row["price"] . "</td>";
                    echo "<td><select name='product_status[" . $row['product_id'] . "]' class='form-select'>";
                    echo "<option value='awaiting' " . ($row["status"] == "awaiting" ? "selected" : "") . ">Awaiting</option>";
                    echo "<option value='active' " . ($row["status"] == "active" ? "selected" : "") . ">Active</option>";
                    echo "<option value='inactive' " . ($row["status"] == "inactive" ? "selected" : "") . ">Inactive</option>";
                    echo "</select></td>";
                    echo "<td>" . $row["create_date"] . "</td>";
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
    </div>
</div>

<!-- Start Footer -->
<br><br><br><br><br>
<?php include("../inc/footer.php") ?>
<!-- End Footer -->