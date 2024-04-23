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
        <h1 class="mt-4">Vendors</h1><br><br>
        <form action="update_vendor_status.php" method="post">
            <div class="table-responsive">
                <table class="table align-middle mb-0 bg-white">
                    <thead class="bg-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Register Date</th>
                            <th>Status</th>
                            <th>Role</th>
                            <th>Points</th>
                            <th>Balance</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch vendors from the database
                        $sql = "SELECT * FROM vendor";
                        $result = mysqli_query($conn, $sql);

                        // Check if there are any vendors
                        if (mysqli_num_rows($result) > 0) {
                            // Output data of each row
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row["vendor_name"] . "</td>";
                                echo "<td>" . $row["vendor_email"] . "</td>";
                                echo "<td>" . $row["register_date"] . "</td>";
                                // Display a dropdown for status with options: Active, Inactive
                                echo "<td><select name='vendor_status[" . $row['vendor_id'] . "]' class='form-select'>";
                                echo "<option value='active' " . ($row["vendor_status"] == "active" ? "selected" : "") . ">Active</option>";
                                echo "<option value='inactive' " . ($row["vendor_status"] == "inactive" ? "selected" : "") . ">Inactive</option>";
                                echo "<option value='awaiting' " . ($row["vendor_status"] == "awaiting" ? "selected" : "") . ">Awaiting</option>";
                                echo "</select></td>";
                                // Display password
                                // Display role, points, and balance
                                echo "<td>" . $row["role"] . "</td>";
                                echo "<td>" . $row["points"] . "</td>";
                                echo "<td>" . $row["balance"] . "</td>";
                                // Display Save button to update status
                                echo "<td><button type='submit' name='submit_vendor' class='btn btn-primary custom-btn'>Save</button></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='10'>No vendors found.</td></tr>";
                        }

                        // Close database connection
                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </form>


    </div>
</div>

<!-- Start Footer -->
<br><br><br><br><br>
<?php include("../inc/footer.php") ?>
<!-- End Footer -->