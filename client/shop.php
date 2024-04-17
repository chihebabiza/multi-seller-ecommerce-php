<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
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
<style>
	.image {
		height: 300px;
		object-fit: contain;
	}
</style>

<!-- Start Header/Navigation -->
<?php include("../inc/header.php") ?>
<!-- End Header/Navigation -->

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