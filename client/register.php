<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection file
include("../config/connect.php");

// Include custom function file
include("../config/function.php");

// Start session to manage user data
session_start();

// Check if cart data exists in session, initialize if not
if (!isset($_SESSION['cart'])) {
	$_SESSION['cart'] = [];
}

// Check if the registration form is submitted
if (isset($_POST['register'])) {
	// Retrieve user registration data from the form
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$email = $_POST['email'];
	$password = $_POST['password'];

	// Call the register function to create a new user account
	register($firstName, $lastName, $email, $password, $conn); // Pass $conn as the last argument
}

// Close the database connection
$conn->close();

// Include the head section of the HTML document
include("../inc/head.php");

// Include the header section of the HTML document
include("../inc/header.php");
?>

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
					<div class="input-group">
						<input type="password" class="form-control" id="password" name="password" required>
						<button type="button" id="togglePassword" class="btn btn-primary px-3 py-2"><i class="bi bi-eye fs-5"></i></button>
					</div>
				</div>
				<button type="submit" class="btn btn-primary w-100" name="register">Sign up</button>
			</form>
		</div>
	</div>
	<div class="text-center mt-3 mb-5">
		<p>Already have an account? <a href="login.php">Log in</a></p>
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