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
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
	<link href="../css/tiny-slider.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
	<title>BRICO DZ</title>
	<style>
		.cart-number {
			width: 20px;
			position: absolute;
			height: 20px;
			line-height: 20px;
			border-radius: 50%;
			text-align: center;
			font-size: 13px;
			background-color: #ff4500;
			color: #ffffff;
		}

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
</head>

<body>
	<!-- Start Header/Navigation -->
	<?php include("../inc/header.php") ?>
	<!-- End Header/Navigation -->

	<?php
	if (isset($_SESSION['vendorName'])) {
		echo '<h2 class="text-center my-3 fw-bolder display-8">Welcome, ';
		echo $_SESSION['vendorName'];
		echo '</h2>';
	}
	?>

	<!-- Start Hero Section -->
	<div class="hero">
		<div class="container">
			<div class="row justify-content-between">
				<div class="col-lg-5">
					<div class="intro-excerpt">
						<h1>Modern Interior <span clsas="d-block">Design Studio</span></h1>
						<p class="mb-4">Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam
							vulputate velit imperdiet dolor tempor tristique.</p>
						<p><a href="" class="btn btn-secondary me-2">Shop Now</a><a href="#" class="btn btn-white-outline">Explore</a></p>
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
	<?php include("../inc/why.php") ?>
	<!-- End Why Choose Us Section -->

	<!-- Start We Help Section -->
	<?php include("../inc/help.php") ?>
	<!-- End We Help Section -->

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