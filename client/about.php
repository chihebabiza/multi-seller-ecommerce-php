<?php

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
// Include database connection and other necessary files
include("../config/connect.php");
include("../config/function.php");
// Check if cart data exists in session, initialize if not
if (!isset($_SESSION['cart'])) {
	$_SESSION['cart'] = [];
}

// include the head
include("../inc/head.php");

// include the header
include("../inc/header.php") ?>

<!-- Start Hero Section -->
<div class="hero">
	<div class="container">
		<div class="row justify-content-between">
			<div class="col-lg-5">
				<div class="intro-excerpt">
					<h1>About Us</h1><br>
					<p class="mb-4">Our online platform is designed to simplify the process of buying and selling replacement parts across a multitude of sectors. From automotive to electronics, appliances to informatics, we offer a comprehensive range of high-quality parts sourced from trusted suppliers. No matter how intricate or obscure the component you're searching for, chances are, you'll find it here at BricoDZ.</p>
					<br><br>
					<p><a href="shop.php" class="btn btn-secondary me-2">Shop Now</a><a href="#" class="btn btn-white-outline">Explore</a></p>
					<br>
				</div>
			</div>
			<div class="col-lg-7">
				<div class="hero-img-wrap">
					<img src="../images/couch.png" class="img-fluid">
				</div>
			</div>
		</div>
	</div>
</div> <!-- End Hero Section -->

<!-- Start Why Choose Us Section -->
<?php include("../inc/why.php") ?>
<!-- End Why Choose Us Section -->

<!-- Start Team Section -->
<?php include("../inc/team.php") ?>
<!-- End Team Section -->

<!-- Start Testimonial Slider -->
<?php include("../inc/comments.php") ?>
<!-- End Testimonial Slider -->

<!-- Start Footer Section -->
<?php include("../inc/footer.php") ?>
<!-- End Footer Section -->

<script>
	// Get the <li> element with the ID "contact"
	var contactLi = document.getElementById('about');

	// Add classes "nav-item" and "active" to the <li> element
	contactLi.classList.add('nav-item', 'active');
</script>