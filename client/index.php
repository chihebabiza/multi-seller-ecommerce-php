<?php
session_start();

include("../config/connect.php");
include("../config/function.php");

$categories = [];
$filteredProducts = [];

$sql = "SELECT DISTINCT category FROM product";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_assoc($result)) {
		$categories[] = $row['category'];
	}
}
if (isset($_POST['add_to_cart'])) {
	$product_id = $_POST['product_id'];
	$selected_quantity = $_POST['selected_quantity'];

	if (isset($_SESSION['cart'][$product_id])) {
		$_SESSION['cart'][$product_id]['quantity'] += $selected_quantity;
	} else {
		$_SESSION['cart'][$product_id] = array(
			'quantity' => $selected_quantity
		);
	}
}

if (isset($_GET['category'])) {
	$selectedCategory = $_GET['category'];

	// Check if the selected category is not empty
	if (!empty($selectedCategory)) {
		// Fetch products based on the selected category
		$sql = "SELECT * FROM product WHERE category = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $selectedCategory);
		$stmt->execute();
		$result = $stmt->get_result();

		// Fetch the filtered products
		$filteredProducts = $result->fetch_all(MYSQLI_ASSOC);
	} else {
		// If no category is selected, fetch all products
		$filteredProducts = getProducts($conn);
	}
} else {
	$filteredProducts = getProducts($conn);
}

?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="Untree.co">
	<meta name="description" content="" />
	<meta name="keywords" content="bootstrap, bootstrap4" />

	<!-- Bootstrap CSS -->
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
	<link href="../css/tiny-slider.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
	<title>Furni Free Bootstrap 5 Template for Furniture and Interior Design Websites by Untree.co </title>
	<style>
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
</head>

<body>
	<!-- Start Header/Navigation -->
	<?php include("../inc/header.php") ?>
	<!-- End Header/Navigation -->

	<!-- Start Hero Section -->
	<div class="hero">
		<div class="container">
			<div class="row justify-content-between">
				<div class="col-lg-5">
					<div class="intro-excerpt">
						<h1>Modern Interior <span clsas="d-block">Design Studio</span></h1>
						<p class="mb-4">Welcome to our vibrant multivendor marketplace, where creativity knows no
							bounds. Uncover a world of unique products and services crafted with passion by talented
							artisans and sellers from around the globe. Whether you're seeking handcrafted goods,
							vintage finds, or bespoke creations, your journey starts here. Embrace the diversity,
							support independent creators, and find something truly special that speaks to your soul.
							Start exploring today!"</p>
						<p><a href="" class="btn btn-secondary me-2">Become a vendor</a><a href="#" class="btn btn-white-outline">Explore</a></p>
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
				<div class="col-md-12 col-lg-3 mb-5 mb-lg-0">
					<h2 class="mb-4 section-title">Crafted with excellent material.</h2>
					<p class="mb-4">Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam
						vulputate velit imperdiet dolor tempor tristique. </p>
					<p><a href="shop.php" class="btn">Explore</a></p>
				</div>
				<!-- Start Column  -->
				<?php include("../inc/product_card.php") ?>
				<!-- End Column  -->
			</div>
		</div>
	</div>
	<!-- End Product Section -->

	<!-- Start Why Choose Us Section -->
	<div class="why-choose-section">
		<div class="container">
			<div class="row justify-content-between">
				<div class="col-lg-6">
					<h2 class="section-title">Why Choose Us</h2>
					<p>Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate velit
						imperdiet dolor tempor tristique.</p>

					<div class="row my-5">
						<div class="col-6 col-md-6">
							<div class="feature">
								<div class="icon">
									<img src="../images/truck.svg" alt="Image" class="imf-fluid">
								</div>
								<h3>Fast Shipping</h3>
								<p>Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam
									vulputate.</p>
							</div>
						</div>

						<div class="col-6 col-md-6">
							<div class="feature">
								<div class="icon">
									<img src="../images/bag.svg" alt="Image" class="imf-fluid">
								</div>
								<h3>Easy to Shop</h3>
								<p>Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam
									vulputate.</p>
							</div>
						</div>

						<div class="col-6 col-md-6">
							<div class="feature">
								<div class="icon">
									<img src="../images/support.svg" alt="Image" class="imf-fluid">
								</div>
								<h3>24/7 Support</h3>
								<p>Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam
									vulputate.</p>
							</div>
						</div>

						<div class="col-6 col-md-6">
							<div class="feature">
								<div class="icon">
									<img src="../images/return.svg" alt="Image" class="imf-fluid">
								</div>
								<h3>Hassle Free Returns</h3>
								<p>Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam
									vulputate.</p>
							</div>
						</div>

					</div>
				</div>

				<div class="col-lg-5">
					<div class="img-wrap">
						<img src="../images/why-choose-us-img.jpg" alt="Image" class="img-fluid">
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- End Why Choose Us Section -->

	<!-- Start We Help Section -->
	<div class="we-help-section">
		<div class="container">
			<div class="row justify-content-between">
				<div class="col-lg-7 mb-5 mb-lg-0">
					<div class="imgs-grid">
						<div class="grid grid-1"><img src="../images/img-grid-1.jpg" alt="Untree.co"></div>
						<div class="grid grid-2"><img src="../images/img-grid-2.jpg" alt="Untree.co"></div>
						<div class="grid grid-3"><img src="../images/img-grid-3.jpg" alt="Untree.co"></div>
					</div>
				</div>
				<div class="col-lg-5 ps-lg-5">
					<h2 class="section-title mb-4">We Help You Make Modern Interior Design</h2>
					<p>Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio quis nisl dapibus malesuada.
						Nullam ac aliquet velit. Aliquam vulputate velit imperdiet dolor tempor tristique. Pellentesque
						habitant morbi tristique senectus et netus et malesuada</p>

					<ul class="list-unstyled custom-list my-4">
						<li>Donec vitae odio quis nisl dapibus malesuada</li>
						<li>Donec vitae odio quis nisl dapibus malesuada</li>
						<li>Donec vitae odio quis nisl dapibus malesuada</li>
						<li>Donec vitae odio quis nisl dapibus malesuada</li>
					</ul>
					<p><a herf="#" class="btn">Explore</a></p>
				</div>
			</div>
		</div>
	</div>
	<!-- End We Help Section -->

	<!-- Start Testimonial Slider -->
	<div class="testimonial-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-7 mx-auto text-center">
					<h2 class="section-title">Testimonials</h2>
				</div>
			</div>

			<div class="row justify-content-center">
				<div class="col-lg-12">
					<div class="testimonial-slider-wrap text-center">

						<div id="testimonial-nav">
							<span class="prev" data-controls="prev"><span class="fa fa-chevron-left"></span></span>
							<span class="next" data-controls="next"><span class="fa fa-chevron-right"></span></span>
						</div>

						<div class="testimonial-slider">

							<div class="item">
								<div class="row justify-content-center">
									<div class="col-lg-8 mx-auto">

										<div class="testimonial-block text-center">
											<blockquote class="mb-5">
												<p>&ldquo;Donec facilisis quam ut purus rutrum lobortis. Donec vitae
													odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam
													vulputate velit imperdiet dolor tempor tristique. Pellentesque
													habitant morbi tristique senectus et netus et malesuada fames ac
													turpis egestas. Integer convallis volutpat dui quis
													scelerisque.&rdquo;</p>
											</blockquote>

											<div class="author-info">
												<div class="author-pic">
													<img src="../images/person-1.png" alt="Maria Jones" class="img-fluid">
												</div>
												<h3 class="font-weight-bold">Maria Jones</h3>
												<span class="position d-block mb-3">CEO, Co-Founder, XYZ Inc.</span>
											</div>
										</div>

									</div>
								</div>
							</div>
							<!-- END item -->

							<div class="item">
								<div class="row justify-content-center">
									<div class="col-lg-8 mx-auto">

										<div class="testimonial-block text-center">
											<blockquote class="mb-5">
												<p>&ldquo;Donec facilisis quam ut purus rutrum lobortis. Donec vitae
													odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam
													vulputate velit imperdiet dolor tempor tristique. Pellentesque
													habitant morbi tristique senectus et netus et malesuada fames ac
													turpis egestas. Integer convallis volutpat dui quis
													scelerisque.&rdquo;</p>
											</blockquote>

											<div class="author-info">
												<div class="author-pic">
													<img src="../images/person-1.png" alt="Maria Jones" class="img-fluid">
												</div>
												<h3 class="font-weight-bold">Maria Jones</h3>
												<span class="position d-block mb-3">CEO, Co-Founder, XYZ Inc.</span>
											</div>
										</div>

									</div>
								</div>
							</div>
							<!-- END item -->

							<div class="item">
								<div class="row justify-content-center">
									<div class="col-lg-8 mx-auto">

										<div class="testimonial-block text-center">
											<blockquote class="mb-5">
												<p>&ldquo;Donec facilisis quam ut purus rutrum lobortis. Donec vitae
													odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam
													vulputate velit imperdiet dolor tempor tristique. Pellentesque
													habitant morbi tristique senectus et netus et malesuada fames ac
													turpis egestas. Integer convallis volutpat dui quis
													scelerisque.&rdquo;</p>
											</blockquote>

											<div class="author-info">
												<div class="author-pic">
													<img src="../images/person-1.png" alt="Maria Jones" class="img-fluid">
												</div>
												<h3 class="font-weight-bold">Maria Jones</h3>
												<span class="position d-block mb-3">CEO, Co-Founder, XYZ Inc.</span>
											</div>
										</div>

									</div>
								</div>
							</div>
							<!-- END item -->

						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<br>
	<!-- End Testimonial Slider -->

	<!-- Start Footer Section -->
	<?php include("../inc/footer.php") ?>
	<!-- End Footer Section -->

	<script src="../js/bootstrap.bundle.min.js"></script>
	<script src="../js/tiny-slider.js"></script>
	<script src="../js/custom.js"></script>
	<script>
		// Get the <li> element with the ID "contact"
		var contactLi = document.getElementById('home');

		// Add classes "nav-item" and "active" to the <li> element
		contactLi.classList.add('nav-item', 'active');
	</script>
</body>

</html>