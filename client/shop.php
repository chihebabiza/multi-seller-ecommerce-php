<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

// Include database connection and custom functions
include("../config/connect.php");
include("../config/function.php");

// Fetch categories from the database
$categories = fetchCategories($conn);

// Process adding items to the cart if the form is submitted
if (isset($_POST['add_to_cart'])) {
	$product_id = $_POST['product_id']; // Get the product ID from the form
	$selected_quantity = $_POST['selected_quantity']; // Get the selected quantity from the form

	addToCart($conn, $product_id, $selected_quantity); // Call the addToCart function
}

// Process category filtering
if (isset($_GET['category'])) {
	$selectedCategory = $_GET['category']; // Get the selected category from the URL parameter

	// Call the filterProductsByCategory function to filter products by category
	$filteredProducts = filterProductsByCategory($conn, $selectedCategory);
} else {
	// If no category parameter is set, fetch all products
	$filteredProducts = getProducts($conn); // Call the getProducts function to fetch all products
}

// include head
include("../inc/head.php");

// include header
include("../inc/header.php");
?>
<!-- Start Filter Categories -->
<div class="container">
	<br>
	<div class="row justify-content-between align-items-end">
		<form action="" method="get" class="w-100 d-flex">
			<div class="form-floating flex-grow-1 me-2 mb-0">
				<select class="form-select w-100" id="category" name="category" aria-label="Select Category">
					<option value="">All Categories</option>
					<?php
					foreach ($categories as $category) {
						$selected = ($category == $selectedCategory) ? 'selected' : '';
						echo '<option value="' . $category . '" ' . $selected . '>' . $category . '</option>';
					}
					?>
				</select>
				<label for="categoryFilter">Select Category</label>
			</div>
			<button type="submit" class="btn btn-primary">Apply</button>
		</form>
	</div>
</div>
<!-- End Filter Categories -->

<!-- Add Display Products -->
<div class="untree_co-section product-section before-footer-section">
	<div class="container">
		<div class="row">
			<?php include("../inc/product_card.php") ?>
		</div>
	</div>
</div>
<!-- End Display Products -->

<!-- Start Footer Section -->
<?php include("../inc/footer.php") ?>
<!-- End Footer Section -->

<script>
	// Get the <li> element with the ID "contact"
	var contactLi = document.getElementById('shop');

	// Add classes "nav-item" and "active" to the <li> element
	contactLi.classList.add('nav-item', 'active');
</script>