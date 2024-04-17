<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include("../config/connect.php");
include("../config/function.php");

if (isset($_POST['login'])) {
	$vendorEmail = $_POST['email']; // Change to email field name
	$vendorPassword = $_POST['password']; // Change to password field name
	login($vendorEmail, $vendorPassword, $conn);
}

// Close connection
$conn->close();
?>

<!-- Start Header/Navigation -->
<?php include("../inc/header.php") ?>
<!-- End Header/Navigation -->

<!-- Start Contact Form -->
<div class="container mt-5">
	<h2 class="text-center">Log in to your account</h2>
	<br>
	<div class="row justify-content-center">
		<div class="col-md-8 col-lg-8 pb-4">
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> <!-- Form action points to the same page for processing -->
				<div class="form-group">
					<label class="text-black" for="email">Email address</label>
					<input type="email" class="form-control" id="email" name="email" required> <!-- Add name attribute to input field -->
				</div>
				<div class="form-group">
					<label class="text-black" for="password">Password</label>
					<input type="password" class="form-control" id="password" name="password" required> <!-- Add name attribute to input field -->
				</div>
				<br>
				<button type="submit" class="btn btn-primary w-100" name="login">Login</button> <!-- Add name attribute to submit button -->
			</form>
			<div class="text-center mt-3">
				<p>Don't have an account? <a href="register.php">Sign up</a></p>
			</div>
		</div>
	</div>
</div>
<br><br><br><br><br>
<!-- End Contact Form -->

<!-- Start Footer Section -->
<?php include("../inc/footer.php") ?>
<!-- End Footer Section -->