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
			<!--Ticket Selection-->
			<div class="after-nav justify-content-center blue-background">
				<div class="IntroductionMiddleOfPage w-100 pt-3" id="booking_disclaimer">
					<p>View upcoming bookings</p>
				</div>
				<div class="d-flex flex-row justify-content-evenly" id="booking_container">
					<!-- JavaScript added content -->
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
			//get table
			const events_table =
				<?php
					$query_result = mysqli_query($con,
					"SELECT * FROM EVENTS WHERE Date > CURRENT_TIMESTAMP && EventID IN
					(SELECT Event FROM TICKETS WHERE TicketID IN
					(SELECT TicketItem FROM LINEITEM WHERE BelongsToReceipt IN
					(SELECT ReceiptID FROM RECEIPT WHERE BelongsToUser = " . $userId . ")));"
					);
					$result = writeQueryResultToArray($query_result);
					echo "'";
					echo json_encode($result);
					echo "'";
				?>
			;
			//as a javascript object
			const event_array = JSON.parse(events_table);

			listTable();
			window.addEventListener('resize', listTable);
			//call on load and window resize
			function listTable(){
				//calc num of colums
				window_width = window.innerWidth;
				num_displayed_colums = Math.max(parseInt(window_width / 333), 1);
				
				//remove then add colums
					const main_container = document.getElementById("booking_container");

					//remove
					main_container.innerHTML = "";
					
					//add disclaimer if no bookings
					if (event_array.length === 0) {
						document.getElementById("booking_disclaimer").innerHTML = "No bookings yet!";
					}

					//add bookings (if any)
					for (let i = 0; i < num_displayed_colums && i < event_array.length; i++) {
						//create column
						const col = document.createElement("div");
						col.setAttribute("class", "flex-col mw-320");

						//create column elements and append each
						for (let j = i; j < event_array.length; j += num_displayed_colums) {
							//create div for event information
							const column_entry = document.createElement("div");
							const onclick_string = "viewEvent(" + event_array[j].EventID + ")";
							column_entry.setAttribute("onclick", onclick_string);
							column_entry.setAttribute("class", "mt-5 event_link heebo-font p-3");
							//append to column
							col.appendChild(column_entry);

							//add information
							const name_container = document.createElement("div");
							name_container.setAttribute("class", "p-1");
							name_container.setAttribute("style", "font-weight: bold;");
							const name_text = document.createTextNode(event_array[j].Name);
							name_container.appendChild(name_text);
							column_entry.appendChild(name_container);


							const description_container = document.createElement("div");
							description_container.setAttribute("class", "p-1");
							description_container.setAttribute("style", "border-style: inset none outset none;");
							const description_text = document.createTextNode(event_array[j].Description);
							description_container.appendChild(description_text);
							column_entry.appendChild(description_container);

							
							const venue_container = document.createElement("div");
							venue_container.setAttribute("class", "p-1");
							const venue_text = document.createTextNode(event_array[j].Venue);
							venue_container.appendChild(venue_text);
							column_entry.appendChild(venue_container);


						}

						//append to rows
						main_container.appendChild(col);
					}
			}

			function viewEvent(EventID) {
				const link_str = "ticket_page.php?event=" + EventID;
				window.open(link_str, "_self");
			}
		</script>
	</body>
</html>
<!--
Logged in: Events, My bookings, My receipts, About Us, Logout
Not logged in: Events, About Us, Login/Signup
Combined: Events, My bookings, My receipts, About Us, Login/Signup, Logout
+ 2 pages for ticket booking and review
9 total
-->