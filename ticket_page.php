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
}
?>

<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Log In</title>
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
		

		<main>
			<!--Hero Image-->
			<div class="HeroImg d-flex align-items-center justify-content-center min-vh-100">
				<div class="EventMiddleOfPage p-3">
					<?php
					if (!empty($_GET['event'])) {?>

						<div class="p-1" style="font-weight: bold;" id="event_name_container">
							<!-- JS added text -->
						</div>
						<div class="p-1" style="border-style: inset none outset none;" id="event_desc_container">
							<!-- JS added text -->
						</div>
						<div class="p-1" style="border-style: none none outset none;" id="event_venue_container">
							<!-- JS added text -->
						</div>
						<div class="d-flex flex-row justify-content-between" style="border-style: none none outset none;">
							<div class="p-1 Bebas-font">
								Event Date:
							</div>
							<div class="pt-2" id="event_date_container">
								<!-- JS added text -->
							</div>
						</div>
						<div class="d-flex flex-row justify-content-between" style="border-style: none none outset none;">
							<div class="p-1 Bebas-font">
								Starting Time:
							</div>
							<div class="pt-2" id="event_start_container">
								<!-- JS added text -->
							</div>
						</div>
						<div class="d-flex flex-row justify-content-between" style="border-style: none none outset none;">
							<div class="p-1 Bebas-font">
								Ending Time:
							</div>
							<div class="pt-2" id="event_end_container">
								<!-- JS added text -->
							</div>
						</div>
						<div class="mt-1 Bebas-font d-flex justify-content-center">
							Your tickets:
						</div>
						<div class="ps-3 pe-3 row justify-content-between">
							<div class="col-5 Bebas-font">
								Name:
							</div>
							<div class="col-7 Bebas-font text-end">
								Seat #:
							</div>
						</div>
						<div class="p-1" id="event_ticket_container">
								<!-- JS added text -->
						</div>
					<?php } else { ?>
						<p>Event not found!</p>
					<?php } ?>
				</div>
			</div>


			<footer class="bg-dark text-center p-4 text-secondary">
				Copyright &copy 2021 Max & Xavier | All Rights Reserved
			</footer>
		</main>

		<!-- JavaScript -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		
		<script>
			<?php
			if (!empty($_GET['event'])) { ?>	
				//get tables
				const event_php =
				<?php
					$query = "SELECT * FROM EVENTS WHERE EventID = " . $_GET['event'] . ";";
					$result = mysqli_fetch_assoc( mysqli_query($con, $query) );
					echo "'";
					echo json_encode($result);
					echo "'";
				?>
				;
				const tickets_php =
				<?php
					$query = "SELECT PI.FirstName, PI.LastName, T.SeatNumber FROM (SELECT * FROM PERSONALINFO) AS PI RIGHT JOIN
					(SELECT * FROM TICKETS WHERE Event = " . $_GET['event'] . " && TicketID IN
					(SELECT TicketItem FROM LINEITEM WHERE BelongsToReceipt IN
					(SELECT ReceiptID FROM RECEIPT WHERE BelongsToUser = " . $userId . "))) AS T
					ON PI.PersonalInfoID = T.BelongsToPerson;"
					;
					$result = writeQueryResultToArray( mysqli_query($con, $query) );
					echo "'";
					echo json_encode($result);
					echo "'";
				?>
				;
				//as a javascript objects
				const event = JSON.parse(event_php);
				const tickets = JSON.parse(tickets_php);

				//write event name and description
				const name_container = document.getElementById("event_name_container");
				name_container.appendChild(document.createTextNode(event.Name));

				const description_container = document.getElementById("event_desc_container");
				description_container.appendChild(document.createTextNode(event.Description));

				const venue_container = document.getElementById("event_venue_container");
				venue_container.appendChild(document.createTextNode(event.Venue));

				const date_container = document.getElementById("event_date_container");
				date_container.appendChild(document.createTextNode(event.Date));

				const start_container = document.getElementById("event_start_container");
				start_container.appendChild(document.createTextNode(event.StartingTime));
				
				const end_container = document.getElementById("event_end_container");
				end_container.appendChild(document.createTextNode(event.EndingTime));

				const ticket_container = document.getElementById("event_ticket_container");
				for (const elem of tickets) {
					const row = document.createElement("div");
					row.setAttribute("class", "row justify-content-between m-1");
					row.setAttribute("style", "background-color: white; border-radius: 3px;");

					const name = document.createElement("div");
					name.setAttribute("class", "col-10");
					const str = elem.FirstName + " " + elem.LastName;
					name.appendChild(document.createTextNode(str));
					row.appendChild(name);

					const seat = document.createElement("div");
					seat.setAttribute("class", "col-2 text-end pe-3");
					seat.appendChild(document.createTextNode(elem.SeatNumber));
					row.appendChild(seat);

					ticket_container.appendChild(row);
				}
			<?php
			}
			?>
		</script>
	</body>
</html>