<?php
session_start();

include("../config/connect.php");
include("../config/function.php");

// Check if admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../client/index.php");
    exit();
}
// Include the head
include("../inc/head.php");

// Include the header
include("../inc/header.php");
?>
<link rel="stylesheet" href="../css/dash.css">
<div class="container">
    <!-- Start Welcome -->
    <div class="py-5 lc-block">
        <div class="lc-block">
            <div editable="rich"><br>
                <h2 class="fw-bolder display-5">Welcome Admin</h2><br>
            </div>
        </div>
        <div class="lc-block col-md-8">
            <div editable="rich">
                <p class="lead">Welcome to your dashboard, Admin! This is your central hub for managing users and announcements. Here, you can efficiently oversee user accounts, update information, and ensure smooth operations. Additionally, you have the power to create and distribute announcements to keep your community informed and engaged!
                </p><br>
            </div>
        </div>
    </div>
    <!-- End Welcome -->

    <!-- Users Table -->
    <div class="container">
        <h1 class="mt-4">Users</h1><br><br>
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
                        ?>
                                <tr>
                                    <td><?php echo $row["vendor_name"]; ?></td>
                                    <td><?php echo $row["vendor_email"]; ?></td>
                                    <td><?php echo $row["register_date"]; ?></td>
                                    <td>
                                        <select name="vendor_status[<?php echo $row['vendor_id']; ?>]" class="form-select" <?php echo ($row["role"] == "admin" ? "disabled" : ""); ?>>
                                            <option value="active" <?php echo ($row["vendor_status"] == "active" ? "selected" : ""); ?>>Active</option>
                                            <option value="inactive" <?php echo ($row["vendor_status"] == "inactive" ? "selected" : ""); ?>>Inactive</option>
                                        </select>
                                    </td>
                                    <td><?php echo $row["role"]; ?></td>
                                    <td><?php echo $row["points"]; ?></td>
                                    <td><?php echo $row["balance"]; ?></td>
                                    <td><button type="submit" name="submit_vendor" class="btn btn-primary custom-btn">Save</button></td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='8'>No vendors found.</td></tr>";
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
<br><br><br><br><br>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/tiny-slider.js"></script>
<script src="../js/custom.js"></script>