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
            <div editable="rich">
                <h2 class="fw-bolder display-5">Welcome Admin</h2><br>
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
            include("../config/connect.php");

            $sql = "SELECT product.*, vendor.vendor_name FROM product INNER JOIN vendor ON product.vendor_id = vendor.vendor_id";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
            ?>
                <table class="table align-middle mb-0 bg-white">
                    <thead class="bg-light">
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Create Date</th>
                            <th>Seller Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><img src="../uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['product_name']; ?>" class="image img-fluid product-thumbnail" style="width: 50px; height: 50px;"></td>
                                <td>
                                    <p style="width: 100px; max-height: 20px; overflow: hidden; margin: 0;"><?php echo $row['product_name']; ?></p>
                                </td>
                                <td>
                                    <p style="width: 200px; max-height: 20px; overflow: hidden; margin: 0;"><?php echo $row['description']; ?></p>
                                </td>
                                <td><?php echo $row['price'] . " DZD"; ?></td>
                                <td>
                                    <select name="product_status[<?php echo $row['product_id']; ?>]" class="form-select">
                                        <option value="awaiting" <?php echo ($row['status'] == 'awaiting') ? 'selected' : ''; ?>>Awaiting</option>
                                        <option value="active" <?php echo ($row['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                                        <option value="inactive" <?php echo ($row['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                </td>
                                <td><?php echo $row['create_date']; ?></td>
                                <td><?php echo $row['vendor_name']; ?></td>
                                <td>
                                    <button type="submit" name="submit_product" class="btn btn-primary mx-2"><i class="fas fa-save"></i></button>
                                    <a href="product.php?product_id=<?php echo $row['product_id']; ?>" class="btn btn-primary"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            <?php
            } else {
                echo "No products found.";
            }
            ?>
        </form>
    </div>
</div>

<!-- Start Footer -->
<br><br><br><br><br><br><br>
<?php include("../inc/footer.php") ?>
<!-- End Footer -->