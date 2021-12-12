<?php 

session_start(); 

include "connect.php";
include "functions.php";

$loggedIn = false;
$userId = "";
$username = "";
if (!empty($_SESSION['UserID'])) {
	$loggedIn = true;
	$userId = $_SESSION['UserID'];
	$username = $_SESSION['Username'];
}?>

<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Events</title>
		<meta name="description" content="Book tickets online for events">
		<meta name="author" content="Max & Xavier">

		<link rel="icon" href="content/logo.ico">
		<link rel="stylesheet" href="styles.css?v=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Heebo&display=swap" rel="stylesheet">

	</head>

	<body>

	<!-- Navigation -->
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark pt-1 pb-1 pe-1">

			<a class="navbar-brand" href="index.php"><img class="Logo" src="content/logo.ico" alt="logo"></a>

			<?php
				if ($loggedIn) {
			?>
			<div class="navbar-brand heebo-font">
				<?php echo "Hello, " . $username ."!"; ?>
			</div>
			<?php } ?>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarCollapse">
				<ul class="navbar-nav heebo-font ms-2">
					<li class="nav-item">
						<a class="nav-link" href="index.php"> Events </a>
					</li>
					<?php
						if ($loggedIn) {
					?>
					<li class="nav-item">
						<a class="nav-link" href="bookings_page.php"> Bookings </a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="receipts_page.php"> Receipts </a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="edit_billing_page.php"> Billing </a>
					</li>
					<?php
						}
					?>
					<li class="nav-item">
						<a class="nav-link" href="about.php"> About Us </a>
					</li>
					<?php
						if (!$loggedIn) {
					?>
					<li class="nav-item">
						<a class="nav-link" href="login_page.php"> Log In/Sign Up </a>
					</li>
					<?php
						}
					?>
					<?php
						if ($loggedIn) {
					?>
					<li class="nav-item">
						<a class="nav-link" href="logout.php"> Logout </a>
					</li>
					<?php
						}
					?>
				</ul>
			</div>
		</nav>
        <main class="h-100">
			<!--Hero Image-->
			<div class="HeroImg d-flex align-items-center justify-content-center min-vh-100">
				<div class="IntroductionMiddleOfPage" id="feedback-box">
					<?php echo $_GET['feedback']; ?>
				</div>
			</div>
			

			<footer class="bg-dark text-center p-4 text-secondary">
				Copyright &copy 2021 Max & Xavier | All Rights Reserved
			</footer>
		</main>
    </body>
</html>