<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../config/connect.php");
include("../config/function.php");

// Start session
session_start();

// Check if cart data exists in session, initialize if not
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if the registration form is submitted
if (isset($_POST['register'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    register($firstName, $lastName, $email, $password, $conn); // Pass $conn as the last argument
}

// Close the database connection
$conn->close();
?>


<!-- Start Header/Navigation -->
<?php include("../inc/header.php") ?>
<!-- End Header/Navigation -->

<!-- Start Contact Form -->
<div class="container mt-5 mb-5">
	<h2 class="text-center">Create your account</h2>
	<br>
	<div class="row justify-content-center">
		<div class="col-md-6">
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<div class="mb-3">
					<div class="row">
						<div class="col">
							<label for="firstName" class="form-label">First Name</label>
							<input type="text" class="form-control" name="firstName" required>
						</div>
						<div class="col">
							<label for="lastName" class="form-label">Last Name</label>
							<input type="text" class="form-control" name="lastName" required>
						</div>
					</div>
				</div>
				<div class="mb-3">
					<label for="email" class="form-label">Email</label>
					<input type="email" class="form-control" name="email" required>
				</div>
				<div class="mb-3">
					<label for="password" class="form-label">Password</label>
					<input type="password" class="form-control" name="password" required>
				</div>
				<button type="submit" class="btn btn-primary w-100" name="register">Sign up</button>
			</form>
		</div>
	</div>
	<div class="text-center mt-3 mb-5">
		<p>Already have an account? <a href="login.php">Log in</a></p>
	</div>
</div>
<br><br><br><br><br>
<!-- End Contact Form -->

<!-- Start Footer Section -->
<?php include("../inc/footer.php") ?>
<!-- End Footer Section -->
