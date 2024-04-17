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
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="Untree.co">
	<link rel="shortcut icon" href="favicon.png">

	<meta name="description" content="" />
	<meta name="keywords" content="bootstrap, bootstrap4" />

	<!-- Bootstrap CSS -->
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
	<link href="../css/tiny-slider.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
	<title>Furni Free Bootstrap 5 Template for Furniture and Interior Design Websites by Untree.co </title>
</head>

<body>

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

	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/tiny-slider.js"></script>
	<script src="js/custom.js"></script>
</body>

</html>