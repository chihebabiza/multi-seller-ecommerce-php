<?php
session_start();

include("../config/connect.php");
include("../config/function.php");

if (!isset($_SESSION['vendorName'])) {
    header("Location: ../client/login.php");
    exit();
}

$name = $_SESSION['vendorName'];
$email = isset($_SESSION['vendorEmail']) ? $_SESSION['vendorEmail'] : '';

if (isset($_POST['updateProfile'])) {
    $newName = $_POST['newName'];
    $newEmail = $_POST['newEmail'];
    $newPassword = $_POST['newPassword'];

    updateProfile($_SESSION['vendor_id'], $newName, $newEmail, $newPassword);
    // Update session variables with new name and email
    $_SESSION['vendorName'] = $newName;
    $_SESSION['vendorEmail'] = $newEmail;
    header("Location: vendor.php");
}

?>
<!-- Start Header/Navigation -->
<?php include("../inc/header.php") ?>
<!-- End Header/Navigation -->

<!-- Start Contact Form -->
<div class="container mt-5 mb-5">
    <h2 class="text-center">Edit your profile</h2>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Name</label>
                    <input type="text" class="form-control" value="<?php echo $name; ?>" name="newName" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" value="<?php echo $email; ?>" name="newEmail" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control" name="newPassword" required>
                </div>
                <input type="submit" class="btn btn-primary w-100" value="Update" name="updateProfile">
            </form>
        </div>
    </div>
</div>
<br><br><br><br><br>
<!-- End Contact Form -->

<!-- Start Footer Section -->
<?php include("../inc/footer.php") ?>
<!-- End Footer Section -->
