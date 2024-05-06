	<?php
	if (isset($_SESSION['vendorName'])) {
		$vendorName = $_SESSION['vendorName'];
		$vendor_id = $_SESSION['vendor_id']; // Assuming vendor_id is stored in session
	?>
		<nav class="custom-navbar navbar navbar-expand-md navbar-dark sticky-top" arial-label="Furni navigation bar">
			<div class="container">
				<a class="navbar-brand" href="/project/client/index.php">BRICO <span>DZ</span></a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarsFurni">
					<ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
						<li id="home"><a class="nav-link" href="/project/client/index.php">Home</a></li>
						<li id="shop"><a class="nav-link" href="/project/client/shop.php">Shop</a></li>
						<li id="about"><a class="nav-link" href="/project/client/about.php">About us</a></li>
						<li id="contact"><a class="nav-link" href="/project/client/contact.php">Contact us</a></li>
					</ul>
					<ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5 d-flex align-items-center">
						<li class="me-3">
							<span class="cart-number" id="cartCount"><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></span>
							<a class="nav-link" href="/project/client/cart.php">
								<i class="fas fa-shopping-cart fs-4 text-white">
								</i>
							</a>
						</li>
						<li class="me-3">
							<span class="cart-number" id="cartCount"><?php echo getVendorPoints($vendorName, $conn); ?></span>
							<a class="nav-link" href="/project/vendor/convert.php">
								<i class="fas fa-heart fs-4 text-white">
								</i>
							</a>
						</li>
						<ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="fas fa-bars fs-4 text-white"></i> </a>
								<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
									<li><a class="dropdown-item" href="/project/vendor/dashboard.php">Dashboard</a></li>
									<li><a class="dropdown-item" href="/project/vendor/orders.php">Orders</a></li>
									<li><a class="dropdown-item" href="/project/vendor/annoucements.php">Announcements</a></li>
									<li><a class="dropdown-item" href="/project/vendor/add.php">Add Product</a></li>
									<li><a class="dropdown-item" href="/project/vendor/profile.php">Profile</a></li>
									<li><a class="dropdown-item" href="/project/vendor/logout.php">Log out</a></li>
								</ul>
							</li>
						</ul>
					</ul>
				</div>
			</div>
		</nav>
	<?php
	} elseif (isset($_SESSION['admin_logged_in'])) {
	?>
		<link href="../css/dash.css" rel="stylesheet">
		<nav class="custom-navbar navbar navbar-expand-md navbar-dark sticky-top" arial-label="Furni navigation bar">
			<div class="container">
				<a class="navbar-brand" href="#">BRICO <span>DZ</span></a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarsFurni">
					<ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
					</ul>
					<ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5 d-flex align-items-center">
						</li>
						<ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="fas fa-bars fs-4 text-white"></i> </a>
								<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
									<li><a class="dropdown-item" href="/project/admin/admin.php">Dashboard</a></li>
									<li><a class="dropdown-item" href="/project/admin/users.php">Users</a></li>
									<li><a class="dropdown-item" href="/project/admin/announcements.php">Announcements</a></li>
									<li><a class="dropdown-item" href="/project/admin/logout.php">Log out</a></li>
								</ul>
							</li>
						</ul>
					</ul>
				</div>
			</div>
		</nav>
	<?php
	} else {
	?>
		<nav class="custom-navbar navbar navbar-expand-md navbar-dark sticky-top" arial-label="Furni navigation bar">
			<div class="container">
				<a class="navbar-brand" href="index.php">BRICO <span>DZ</span></a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarsFurni">
					<ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
						<li id="home"><a class="nav-link" href="index.php">Home</a></li>
						<li id="shop"><a class="nav-link" href="shop.php">Shop</a></li>
						<li id="about"><a class="nav-link" href="about.php">About us</a></li>
						<li id="contact"><a class="nav-link" href="contact.php">Contact us</a></li>
					</ul>
					<ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5 d-flex align-items-center">
						<li class="me-3">
							<span class="cart-number" id="cartCount"><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></span>
							<a class="nav-link" href="/project/client/cart.php">
								<i class="fas fa-shopping-cart fs-4 text-white">
								</i>
							</a>
						</li>
						<li class="me-3"><a class="nav-link" href="login.php"><i class="fas fa-circle-plus fs-4 text-white"></i></a></li>
						<li class="me-3"><a class="nav-link" href="login.php"><i class="fas fa-user fs-4 text-white"></i></a></li>
					</ul>
				</div>
			</div>
		</nav>
	<?php
	}
	?>