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
$password = ''; // Initialize password variable

// Fetch email and password for the current user
$vendorId = $_SESSION['vendor_id'];
$sql = "SELECT vendor_email, vendor_password FROM vendor WHERE vendor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $vendorId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
if ($row) {
    $email = $row['vendor_email']; // Update email with value from database
    $password = $row['vendor_password']; // Update password with value from database
}

if (isset($_POST['updateProfile'])) {
    $newName = $_POST['newName'];
    $newEmail = $_POST['newEmail'];
    $newPassword = $_POST['newPassword'];

    updateProfile($_SESSION['vendor_id'], $newName, $newEmail, $newPassword);
    // Update session variables with new name and email
    $_SESSION['vendorName'] = $newName;
    $_SESSION['vendorEmail'] = $newEmail;
    header("Location: ../client/index.php");
}

// Include the head
include("../inc/head.php");

// Include the header
include("../inc/header.php");
?>
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet"> -->
<!-- Start Contact Form -->
<div class="container mt-5 mb-5">
    <h2 class="text-center">Edit your profile</h2>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="newName" value="<?php echo htmlspecialchars($name); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="newEmail" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" id="passwordInput" class="form-control" name="newPassword" required>
                        <button type="button" id="togglePassword" class="btn btn-primary py-2 px-3"><i class="bi bi-eye fs-5"></i></button>
                    </div>
                </div><br>
                <input type="submit" class="btn btn-primary w-100" value="Update" name="updateProfile">
            </form>
        </div>
    </div>
</div>
<!-- End Contact Form -->
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/tiny-slider.js"></script>
<script src="../js/custom.js"></script>
<script>
    const passwordInput = document.getElementById('passwordInput');
    const togglePassword = document.getElementById('togglePassword');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        // Change button icon based on password visibility
        togglePassword.querySelector('i').classList.toggle('bi-eye');
        togglePassword.querySelector('i').classList.toggle('bi-eye-slash');
    });
</script>