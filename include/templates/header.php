<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title><?php echo getTitle() ?></title>
		<link rel="stylesheet" href="<?php echo $css ?>bootstrap.css" />
		<link rel="stylesheet" href="<?php echo $css ?>font-awesome.min.css" />
		<link rel="stylesheet" href="<?php echo $css ?>jquery-ui.css" />
		<link rel="stylesheet" href="<?php echo $css ?>front.css" />
		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

	</head>
	<body>
		<div class="upper-bar">
			<div class="container">
				<div class="col-md-9">
				<ul class="header-links pull-left">
					<li><a href="#"><i class="fa fa-phone"></i> +021-95-51-84</a></li>
					<li><a href="#"><i class="fa fa-envelope-o"></i> email@email.com</a></li>
					<li><a href="#"><i class="fa fa-map-marker"></i>Elmansoura</a></li>
				</ul>
			</div>
				<?php
				 		if (isset($_SESSION['user'])) {
							?>
								<?php
									// SELECT All Users Except Admin
									$stmt = $con->prepare("SELECT profile_image FROM users WHERE UserID = Username");


									// Execute The Statement
									$stmt->execute();

									// Assign To Variable
									$rows = $stmt->fetchAll();
							?>
							<div class="btn btn-group my-info">
									<span class="btn dropdown-toggle" data-toggle="dropdown">
												<?php echo $sessionUser ?>
												<span class="caret"></span>
									</span>
									<ul class="dropdown-menu">
											<li><a href="profile.php">My Profile</a></li>
											<li class="newitem"><a href="newad.php">New Item</a></li>
											<li><a href="logout.php">Logout</a></li>
									</ul>

							</div>

						<?php

				 		}else {

				 ?>
				 <div class="col-md-3">
					<a href="login.php">
							<span class="pull-right">Login | SignUp</span>
					</a>
				</div>
				<?php } ?>
		 </div>
	 </div>

			<!-- MAIN HEADER -->
			<div id="header">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<!-- LOGO -->
						<div class="col-md-3">
							<div class="header-logo">
								<a href="#" class="logo">
									<img src="image/logo.png" alt="">
								</a>
							</div>
						</div>
						<!-- /LOGO -->

						<!-- SEARCH BAR -->
						<div class="col-md-6">
							<div class="header-search">
								<form>
									<input class="input" placeholder="Search here">
									<button class="search-btn">Search</button>
								</form>
							</div>
						</div>
						<!-- /SEARCH BAR -->

						<!-- ACCOUNT -->
						<div class="col-md-3 clearfix">
							<div class="header-ctn">

								<!-- Cart -->
								<div class="cart">
										<i class="fa fa-shopping-cart"></i>
										<span>Your Cart</span>
								</div>
								<!-- /Cart -->
							</div>
						</div>
						<!-- /ACCOUNT -->
					</div>
					<!-- row -->
				</div>
				<!-- container -->
			</div>
			<!-- /MAIN HEADER -->
			<nav class="navbar">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>

					</div>


					<div class="collapse navbar-collapse pull-left" id="app-nav">

						<ul class="nav navbar-nav main-nav">
							<li class="active"><a href="index.php">Home <span class="sr-only">(current)</span></a></li>
							<?php
								$allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID", 'ASC');
									foreach ($allCats as $c) {

										echo
										 '<li>
												<a href="categories.php?pageid=' . $c['ID'] . '">
													' . $c['C_Name'] . '
												</a>
										 </li>';

										 '<li>
												<a href="categories.php?pageid=' . $c['ID'] . '">
													' . $c['C_Name'] . '
												</a>
										 </li>';

									}
							?>
							<!--
							<li><a href="accsorise.php">Accessories</a></li>
							<li><a href="accsorise.php">Mobile</a></li>
							<li class="dropdown">
				          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Electronic<span class="caret"></span></a>
				          <ul class="dropdown-menu">
				            <li><a href="#">Labtop</a></li>
				            <li><a href="#">TV</a></li>
				            <li><a href="#">Camera</a></li>
          			</ul>
        		</li>
					-->

						</ul>
					</div>

				</div>

			</nav>
