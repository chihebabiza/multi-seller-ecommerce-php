<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session to manage user login state
session_start();

// Include database connection
include("../config/connect.php");

// Include custom functions
include("../config/function.php");

// Check if login form is submitted
if (isset($_POST['login'])) {
	// Get vendor's email and password from the form
	$vendorEmail = $_POST['email']; // Change to email field name
	$vendorPassword = $_POST['password']; // Change to password field name

	// Call the login function to authenticate the user
	login($vendorEmail, $vendorPassword, $conn);
}

// Close database connection
$conn->close();

// Include the head section of the HTML document
include("../inc/head.php");

// Include the header section of the HTML document
include("../inc/header.php");
?>


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
					<div class="input-group">
						<input type="password" class="form-control" id="password" name="password" required> <!-- Add name attribute to input field -->
						<button type="button" id="togglePassword" class="btn btn-primary px-3 py-2"><i class="bi bi-eye fs-5"></i></button>
					</div>
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
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/tiny-slider.js"></script>
<script src="../js/custom.js"></script>
<!-- End Contact Form -->

<script>
	const passwordInput = document.getElementById('password');
	const togglePassword = document.getElementById('togglePassword');

	togglePassword.addEventListener('click', function() {
		const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
		passwordInput.setAttribute('type', type);
		// Change button icon based on password visibility
		togglePassword.querySelector('i').classList.toggle('bi-eye');
		togglePassword.querySelector('i').classList.toggle('bi-eye-slash');
	});
</script>