<?php
session_start();

// Include database connection and other necessary files
include("../config/connect.php");
include("../config/function.php");

// Function to remove a product from the cart and restore its quantity
function removeProduct($product_id, $conn)
{
	if (isset($_SESSION['cart'][$product_id])) {
		$quantity = $_SESSION['cart'][$product_id]['quantity']; // Get the quantity of the product being removed

		// Remove the product from the cart
		unset($_SESSION['cart'][$product_id]);
	}
}

// Check if the remove button is clicked
if (isset($_POST['remove_product'])) {
	$product_id = $_POST['product_id'];
	removeProduct($product_id, $conn);
}

?>

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

	<!-- Start Cart -->
	<div class="untree_co-section before-footer-section">
		<div class="container">
			<!-- Start Cart Table -->
			<div class="row mb-5">
				<?php
				if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
					echo '<h2>Your cart is empty</h2>
					<div class="row mb-5">
					<div class="col-md-6 mb-3 mb-md-0">
						<br><a href="shop.php"><button class="btn btn-black btn-sm btn-block">Continue Shopping</button></a>
					</div>
				</div>';
				} else {
				?>
					<form class="col-md-12" method="post">
						<div class="site-blocks-table">
							<table class="table">
								<thead>
									<tr>
										<th class="product-thumbnail">Image</th>
										<th class="product-name">Product</th>
										<th class="product-price">Price</th>
										<th class="product-quantity">Quantity</th>
										<th class="product-total">Total</th>
										<th class="product-remove">Remove</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$total_price = 0;
									foreach ($_SESSION['cart'] as $product_id => $product) {
										// Fetch product details from database
										$sql = "SELECT product_name, price FROM product WHERE product_id = ?";
										$stmt = $conn->prepare($sql);
										$stmt->bind_param("i", $product_id);
										$stmt->execute();
										$result = $stmt->get_result();
										$row = $result->fetch_assoc();

										if ($row) {
											$product_name = $row['product_name'];
											$price = $row['price'];
											$quantity = $product['quantity'];
											$total = $price * $quantity;
									?>
											<tr>
												<td class="product-thumbnail">
													<img src="../images/product-1.png" alt="Image" class="img-fluid">
												</td>
												<td class="product-name">
													<h2 class="h5 text-black"><?php echo $product_name; ?></h2>
												</td>
												<td><?php echo $price; ?> DZD</td>
												<td><?php echo $quantity; ?></td>
												<td><?php echo $total; ?> DZD</td>
												<td>
													<form method="post">
														<input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
														<button type="submit" class="btn btn-black btn-sm" name="remove_product">X</button>
													</form>
												</td>
											</tr>
								</tbody>
						<?php
											$total_price += $total;
										}
									}
						?>
							</table>
						</div>
					</form>
			</div>
			<!-- End Cart Table -->

			<div class="row">
				<div class="col-md-6">
					<div class="row mb-5">
						<div class="col-md-6 mb-3 mb-md-0">
							<a href="shop.php"><button class="btn btn-black btn-sm btn-block">Continue Shopping</button></a>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label class="text-black h4" for="coupon">Coupon</label>
							<p>Enter your coupon code if you have one.</p>
						</div>
						<div class="col-md-7 mb-3 mb-md-0">
							<input type="text" class="form-control py-3" id="coupon" placeholder="Coupon Code">
						</div>
						<div class="col-md-5">
							<button class="btn btn-black">Apply Coupon</button>
						</div>
					</div>
				</div>
				<div class="col-md-6 pl-5">
					<div class="row justify-content-end">
						<div class="col-md-7">
							<div class="row">
								<div class="col-md-12 text-right border-bottom mb-5">
									<h3 class="text-black h4 text-uppercase">Cart Totals</h3>
								</div>
							</div>
							<div class="row mb-5">
								<div class="col-md-6">
									<span class="text-black">Total</span>
								</div>
								<div class="col-md-6 text-right">
									<strong class="text-black"><?php echo $total_price ?> DZD</strong>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<button class="btn btn-black btn-lg py-3 btn-block" onclick="window.location='checkout.php'">Proceed To Checkout</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Cart -->

	<!-- Start Footer Section -->
	<?php include("../inc/footer.php") ?>
	<!-- End Footer Section -->

	<script src="../js/bootstrap.bundle.min.js"></script>
	<script src="../js/tiny-slider.js"></script>
	<script src="../js/custom.js"></script>
</body>

</html>
<?php
				}
?>