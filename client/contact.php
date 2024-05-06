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
					<h1>Contact</h1><br>
					<p class="mb-4">If you have any questions, inquiries, or feedback, please don't hesitate to reach out to us. Our team is dedicated to providing excellent customer service and will do our best to assist you. You can contact us via phone, email, or by filling out the contact form below. We value your input and look forward to hearing from you.</p>
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

<!-- Start Contact Form -->
<div class="untree_co-section">
	<div class="container">

		<div class="block">
			<div class="row justify-content-center">


				<div class="col-md-8 col-lg-8 pb-4">


					<div class="row mb-5">
						<div class="col-lg-4">
							<div class="service no-shadow align-items-center link horizontal d-flex active" data-aos="fade-left" data-aos-delay="0">
								<div class="service-icon color-1 mb-4">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
										<path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
									</svg>
								</div> <!-- /.icon -->
								<div class="service-contents">
									<p>Campus El Bez. Sétif 19137, Algérie</p>
								</div> <!-- /.service-contents-->
							</div> <!-- /.service -->
						</div>

						<div class="col-lg-4">
							<div class="service no-shadow align-items-center link horizontal d-flex active" data-aos="fade-left" data-aos-delay="0">
								<div class="service-icon color-1 mb-4">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
										<path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555zM0 4.697v7.104l5.803-3.558L0 4.697zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757zm3.436-.586L16 11.801V4.697l-5.803 3.546z" />
									</svg>
								</div> <!-- /.icon -->
								<div class="service-contents">
									<p>contact@bricodz.com</p>
								</div> <!-- /.service-contents-->
							</div> <!-- /.service -->
						</div>

						<div class="col-lg-4">
							<div class="service no-shadow align-items-center link horizontal d-flex active" data-aos="fade-left" data-aos-delay="0">
								<div class="service-icon color-1 mb-4">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
										<path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
									</svg>
								</div> <!-- /.icon -->
								<div class="service-contents">
									<p>+213 657 842 205</p>
								</div> <!-- /.service-contents-->
							</div> <!-- /.service -->
						</div>
					</div>

					<form>
						<div class="row">
							<div class="col-6">
								<div class="form-group">
									<label class="text-black" for="fname">First name</label>
									<input type="text" class="form-control" id="fname">
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									<label class="text-black" for="lname">Last name</label>
									<input type="text" class="form-control" id="lname">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="text-black" for="email">Email address</label>
							<input type="email" class="form-control" id="email">
						</div>

						<div class="form-group mb-5">
							<label class="text-black" for="message">Message</label>
							<textarea name="" class="form-control" id="message" cols="30" rows="5"></textarea>
						</div>

						<button type="submit" class="btn btn-primary">Send Message</button>
					</form>

				</div>

			</div>

		</div>

	</div>


</div>
<!-- End Contact Form -->

<!-- Start Footer Section -->
<?php include("../inc/footer.php") ?>
<!-- End Footer Section -->

<script>
	// Get the <li> element with the ID "contact"
	var contactLi = document.getElementById('contact');

	// Add classes "nav-item" and "active" to the <li> element
	contactLi.classList.add('nav-item', 'active');
</script>