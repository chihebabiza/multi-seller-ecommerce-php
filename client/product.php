<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include("../config/connect.php");
include("../config/function.php");

// Retrieve product details based on product_id
if (isset($_GET['product_id'])) {
	$product_id = $_GET['product_id'];
	$product = getProduct($conn, $product_id);

	// Redirect if product not found
	if (!$product) {
		echo "Product not found!";
		exit;
	}
} else {
	echo "Product ID not provided!";
	exit;
}

// Check if the add to cart form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
	addToCart($conn, $_POST['product_id'], $_POST['selected_quantity']);
}

// include the head
include("../inc/head.php");

// include the header
include("../inc/header.php");
?>
<!-- include the style in this page only -->
<style>
	.icon-hover:hover {
		border-color: #3b71ca !important;
		background-color: white !important;
		color: #3b71ca !important;
	}

	.icon-hover:hover i {
		color: #3b71ca !important;
	}

	.nav-tabs .nav-item .nav-link:not(.active) {
		color: #6c757d;
		/* Change the color as needed */
		background-color: transparent;
		/* Remove the background color */
		border-color: transparent;
		/* Remove the border color */
	}
</style>

<!-- content -->
<section class="py-5">
	<div class="container">
		<div class="row gx-5">
			<aside class="col-lg-6">
				<div class="border rounded-4 mb-3 d-flex justify-content-center">
					<a data-fslightbox="mygallery" class="rounded-4" target="_blank" data-type="image" href="<?php echo $product['image']; ?>">
						<img style="max-width: 100%; max-height: 70vh; margin: auto;" class="rounded-4 fit" src="../uploads/<?php echo $product['image']; ?>" alt="<?php echo $product['product_name']; ?>" />
					</a>
				</div>
			</aside>
			<main class="col-lg-6">
				<div class="ps-lg-3">
					<h4 class="title text-dark">
						<?php echo $product['product_name']; ?>
					</h4>
					<div class="d-flex flex-row my-3">
						<!-- Star ratings and orders count -->
						<div class="text-warning mb-1 me-2">
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fas fa-star-half-alt"></i>
							<span class="ms-1">4.5</span>
						</div>
						<span class="text-muted"><i class="fas fa-shopping-basket fa-sm mx-1"></i><?php echo $product['quantity']; ?> items in stock</span>
						<span class="text-success ms-2">In stock</span>
					</div>

					<div class="mb-3">
						<!-- Product price -->
						<span class="h5"><?php echo $product['price']; ?> DZD</span>
					</div>

					<p>
						<!-- Product description -->
						<?php echo $product['description']; ?>
					</p>

					<div class="row">
						<!-- Product details -->
						<dt class="col-3">Name:</dt>
						<dd class="col-9"><?php echo $product['product_name']; ?></dd>

						<dt class="col-3">Date Created:</dt>
						<dd class="col-9"><?php echo $product['create_date']; ?></dd>

						<dt class="col-3">Category:</dt>
						<dd class="col-9"><?php echo $product['category']; ?></dd>

						<dt class="col-3">Seller Name:</dt>
						<dd class="col-9"><?php echo $product['seller_name']; ?></dd>
					</div>

					<hr />
					<form method="post" class="quantity-form" id="form_<?php echo $product['product_id']; ?>">
						<input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
						<div class="product-home text-center mb-5">
							<div class="row">
								<div class="col-md-6 mt-1">
									<!-- Quantity selection -->
									<select class="mb-3 form-select p-2" aria-label="Default select example" name="selected_quantity">
										<?php
										for ($i = 1; $i <= $product['quantity']; $i++) {
											echo '<option value="' . $i . '">' . $i . '</option>';
										}
										?>
									</select>
								</div>
								<div class="col-md-6">
									<!-- Add to Cart button -->
									<button class="btn btn-secondary mb-4" type="submit" name="add_to_cart">Add to Cart</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</main>
		</div>
	</div>
</section>

<!-- content -->
<section class="py-5 bg-white">
	<div class="container">
		<div class="row gx-4">
			<div class="col-lg-12 mb-4">
				<div class="border rounded-2 px-4 py-3">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item" role="presentation">
							<a class="nav-link active" id="specification-tab" data-bs-toggle="tab" href="#specification" role="tab" aria-controls="specification" aria-selected="true">Specification</a>
						</li>
						<li class="nav-item" role="presentation">
							<a class="nav-link" id="seller-profile-tab" data-bs-toggle="tab" href="#seller-profile" role="tab" aria-controls="seller-profile" aria-selected="false">Seller Profile</a>
						</li>
					</ul>
					<!-- Tab panes -->
					<div class="tab-content mt-3" id="myTabContent">
						<div class="tab-pane fade show active" id="specification" role="tabpanel" aria-labelledby="specification-tab">
							<p>
								<?php echo $product['description']; ?>
							</p>
						</div>
						<div class="tab-pane fade mb-2" id="seller-profile" role="tabpanel" aria-labelledby="seller-profile-tab">
							<?php
							// Assuming you have a connection to the database established

							// Query to fetch seller information based on product's seller_name
							$sellerName = $product['seller_name'];
							$sql = "SELECT `vendor_id`, `vendor_name`, `vendor_email`, `register_date`, `vendor_status`, `vendor_password`, `points`, `balance`, `role` FROM `vendor` WHERE `vendor_name` = ?";
							$stmt = $conn->prepare($sql);
							$stmt->bind_param("s", $sellerName);
							$stmt->execute();
							$result = $stmt->get_result();

							// Check if seller information is found
							if ($result && $result->num_rows > 0) {
								$seller = $result->fetch_assoc();
							?>
								<!-- Display seller name and email -->
								<ul class="list-group">
									<li class="list-group-item">
										<span class="fw-bold">Seller Name : </span> <?php echo $seller['vendor_name']; ?>
									</li>
									<li class="list-group-item">
										<span class="fw-bold">Seller Email : </span> <?php echo $seller['vendor_email']; ?>
									</li>
									<li class="list-group-item">
										<span class="fw-bold">Register Date : </span> <?php echo $seller['register_date']; ?>
									</li>
									<li class="list-group-item">
										<span class="fw-bold">Total Orders : </span> <?php echo getVendorOrders($conn, $seller['vendor_name']); ?>
									</li>
								</ul>
							<?php } else {
								echo "Seller information not found.";
							}
							?>

						</div>
					</div>
					<!-- Pills content -->
				</div>
			</div>
		</div>
	</div>
	<!-- Start Related Products Section -->
	<!-- End Related Products Section -->
</section>

<?php
// Fetch related products based on the category of the current product
$relatedProducts = getRelatedProducts($conn, $product);
?>

<div class="product-section">
    <div class="container">
        <div class="row">
            <!-- Start Column  -->
            <div class="col-md-12 col-lg-12">
                <h2 class="section-title">Related Products</h2><br>
                <div class="row">
                    <?php foreach ($relatedProducts as $relatedProduct) : ?>
                        <div class="col-md-3 mb-4">
                            <div class="product-item">
                                <a href="product.php?product_id=<?php echo $relatedProduct['product_id']; ?>" class="product-item">
                                    <img src="../uploads/<?php echo $relatedProduct['image']; ?>" alt="<?php echo $relatedProduct['product_name']; ?>" class="image img-fluid product-thumbnail">
                                    <h3 class="product-title"><?php echo $relatedProduct['product_name']; ?></h3>
                                    <strong class="product-price">$<?php echo $relatedProduct['price']; ?></strong>
                                </a>
                                <form method="post" class="quantity-form" id="form_<?php echo $relatedProduct['product_id']; ?>">
                                    <input type="hidden" name="product_id" value="<?php echo $relatedProduct['product_id']; ?>">
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- End Column  -->
        </div>
    </div>
</div>

<!-- Footer -->
<?php include("../inc/footer.php") ?>
<!-- Footer -->