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
	</style>
	<nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark sticky-top" arial-label="Furni navigation bar">
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
						<a class="nav-link" href="cart.php">
							<i class="fas fa-shopping-cart fs-4 text-white">
							</i>
						</a>
					</li>
					<li class="me-3"><a class="nav-link" href="login.php"><i class="fas fa-circle-plus fs-4 text-white"></i></a></li>
					<li class="me-3"><a class="nav-link" href="register.php"><i class="fas fa-user fs-4 text-white"></i></a></li>
				</ul>
			</div>
		</div>
	</nav>