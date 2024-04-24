<?php
// Start session
session_start();

// Include necessary files
include("../config/connect.php"); // Include database connection
include("../config/function.php"); // Include custom functions

// Fetch categories from the database
$categories = fetchCategories($conn);

$filteredProducts = getProducts($conn); // Call the getProducts function to fetch all products

// Include the head
include("../inc/head.php");

// Include the header
include("../inc/header.php");

// Display welcome to vendor if he logged in
if (isset($_SESSION['vendorName'])) {
	echo '<h2 class="text-center my-3 fw-bolder display-8">Welcome, ';
	echo $_SESSION['vendorName'];
	echo '</h2>';
}
?>
<!-- Some styles in Home -->
<style>
	.image {
		height: 300px;
		object-fit: contain;
	}

	.product-home {
		display: none;
	}

	/* Assuming each product card has the class 'product-card' */
	.product-section .row {
		display: flex;
		/* Use flexbox layout */
		flex-wrap: nowrap;
		/* Prevent wrapping to next row */
		overflow-x: auto;
		/* Enable horizontal scrolling */
		-ms-overflow-style: none;
		/* Hide scrollbar in IE and Edge */
		scrollbar-width: none;
		/* Hide scrollbar in Firefox */
	}

	.product-section .row::-webkit-scrollbar {
		display: none;
		/* Hide scrollbar in WebKit browsers */
	}
</style>

<!-- Start Hero Section -->
<div class="hero">
	<div class="container">
		<div class="row justify-content-between">
			<div class="col-lg-5">
				<div class="intro-excerpt">
					<h1>BRICO DZ .. Find Your Missing Piece</span></h1>
					<p class="mb-4">BricoDZ Is The Best Place For Your Repair Needs BricoDz is an online platform
						that allows users to buy and sell replacement parts for various equipment. It offers a wide
						range of parts for different sectors such as automotive, electronics, appliances,
						informatics and more...</p>
					<p><a href="shop.php" class="btn btn-secondary me-2">Shop Now</a><a href="about.php" class="btn btn-white-outline">Explore</a></p>
				</div>
			</div>
			<div class="col-lg-7">
				<div class="hero-img-wrap">
					<img src="../images/couch.png" class="img-fluid">
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Hero Section -->

<!-- Start Product Section -->
<div class="product-section">
	<div class="container">
		<div class="row">
			<!-- Start Column 1 -->
			<div class="col-md-12 col-lg-3 mb-5 mb-lg-0">
				<h2 class="mb-4 section-title">The Right Place For Your Repair Needs</h2>
				<p class="mb-4">Our Website offer a wide range of parts for different sectors such as automotive,
					electronics, appliances, informatics and more. </p>
				<p><a style="background-color: #0c0347;" href="shop.php" class="btn">Explore</a></p>
			</div>
			<!-- End Column 1 -->
			<!-- Start Column  -->
			<?php include("../inc/product_card.php") ?>
			<!-- End Column  -->
		</div>
	</div>
</div>
<!-- End Product Section -->

<!-- Start Why Choose Us Section -->
<?php include("../inc/why.php") ?>
<!-- End Why Choose Us Section -->

<!-- Start Testimonial Slider -->
<?php include("../inc/comments.php") ?>
<!-- End Testimonial Slider -->

<!-- Start Footer Section -->
<?php include("../inc/footer.php") ?>
<!-- End Footer Section -->

<script>
	// Get the <li> element with the ID "contact"
	var contactLi = document.getElementById('home');

	// Add classes "nav-item" and "active" to the <li> element
	contactLi.classList.add('nav-item', 'active');
</script>