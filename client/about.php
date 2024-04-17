<!-- Start Header/Navigation -->
<?php include("../inc/header.php") ?>
<!-- End Header/Navigation -->

<!-- Start Hero Section -->
<div class="hero">
	<div class="container">
		<div class="row justify-content-between">
			<div class="col-lg-5">
				<div class="intro-excerpt">
					<h1>About Us</h1>
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