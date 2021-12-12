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

$all_similar_events = getAllSimilarEvents($_GET['event'], $con);
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
					if (mysqli_num_rows($all_similar_events) > 0) {?>

						<div class="p-1" style="font-weight: bold;" id="event_name_container">
							<!-- JS added text -->
						</div>
						<div class="p-1" style="border-style: inset none outset none;" id="event_desc_container">
							<!-- JS added text -->
						</div>
						<div class="p-1" style="border-style: none none outset none;" id="event_venue_container">
							<!-- JS added text -->
						</div>

						<form method="POST" action="attempt_purchase.php" class="mt-2" id="ticket_form">
							<div class="d-flex flex-row">
								<div class="me-auto Bebas-font pt-1">
									Available Dates:
								</div>
								<div class="">
									<select class="form-select" aria-label="Select Date" id="date_selector" onchange="writeTimeOptions()" required>
										<option value="" selected>Select Date</option>
										<!-- JS added options -->
									</select>
								</div>
							</div>
							<div class="d-flex flex-row mb-1">
								<div class="me-auto Bebas-font pt-1">
									Time:
								</div>
								<div class="">
									<select class="form-select" aria-label="Select Date" name="time_selector" id="time_selector" required>
										<option value="" selected>Date Not Selected</option>
										<!-- JS added options -->
									</select>
								</div>
							</div>
							<?php if ($loggedIn) { ?>
							<div class="p-1 mt2 heebo-font" style="border-top: inset;">
								<div class="d-flex flex-row">
									<div class="ms-auto me-4 pt-2 form-check form-switch">
										<input class="form-check-input" type="checkbox" id="SaveBillingProfile" name="SaveBillingProfile">
										<label class="form-check-label" for="flexCheckDefault">Save Profile</label>
									</div>
									<div class="">
										<select class="form-select" aria-label="Select Billing Profile" id="billing_profile_selector" name="billing_profile_selector" onchange="LoadBillingData()">
											<option value="" selected>No Billing Profile</option>
											<!-- JS added options -->
										</select>
									</div>
								</div>
								<div class="mt-1 heebo-font" id="billing_container">
									<!-- JS added form -->
								</div>
								<div class="mt-1 Bebas-font">Who the ticket is for:</div>
								<div class="w-100 flex-row-on-small">
									<div class="flex-fill">
										<input type="text" placeholder="First Name" class="form-control" name="TicketFirstName" id="TicketFirstName" pattern="^[A-Za-z]{0,20}$" required>
									</div>
									<div class="flex-fill">
										<input type="text" placeholder="Last Name" class="form-control" name="TicketLastName" id="TicketLastName" pattern="^[A-Za-z]{0,20}$" required>
									</div>
								</div>
								<div class="d-flex justify-content-center mt-3">
									<button class="btn btn-primary" type="submit" id="buyBtn"></button>
								</div>
							</div>							
						</form>
						<?php } else { ?>
							<p class="p-2 font-weight-bold text-center Bebas-font">Log In to Purchase</p>
						<?php } ?>
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
			if (mysqli_num_rows($all_similar_events) > 0) { ?>	
				//get tables
				const all_events_php =
				<?php					
					echo "'";
					echo json_encode(writeQueryResultToArray($all_similar_events));
					echo "'";
				?>
				;
				const available_events_php =
				<?php
					$result = getAllSimilarEventsOnlySeatsAvailable($_GET['event'], $con);
					echo "'";
					echo json_encode($result);
					echo "'";
				?>
				;
				const billing_data_php =
				<?php
					$result = getBillingData($userId, $con);
					echo "'";
					echo json_encode($result);
					echo "'";
				?>
				;
				//as a javascript objects
				const all_events_array = JSON.parse(all_events_php);
				const available_events_array = JSON.parse(available_events_php);
				const billing_profile_array = JSON.parse(billing_data_php);

				//write event name and description
				const name_container = document.getElementById("event_name_container");
				name_container.appendChild(document.createTextNode(all_events_array[0].Name));

				const description_container = document.getElementById("event_desc_container");
				description_container.appendChild(document.createTextNode(all_events_array[0].Description));

								
				const venue_container = document.getElementById("event_venue_container");
				venue_container.appendChild(document.createTextNode(all_events_array[0].Venue));

				//get unique date events
				const key = 'Date';
				const unique_dates_array = [...new Map(all_events_array.map(item =>
				[item[key], item])).values()];

				//write date options
				const date_selector = document.getElementById("date_selector");
				for (const elem of unique_dates_array) {
					const date_option = document.createElement("option");
					date_option.setAttribute("value",elem.Date);
					date_option.appendChild(document.createTextNode(elem.Date));
					date_selector.appendChild(date_option);
				}

				//write time options function
				var chosen_date = "";
				const time_selector = document.getElementById("time_selector");
				function writeTimeOptions() {
					//filter by date
					chosen_date = date_selector.value;
					const timeArray = all_events_array.filter(({Date}) => Date === chosen_date);
					const available_timeArray = available_events_array.filter(({Date}) => Date === chosen_date);
					//clear options
					time_selector.innerHTML = "";
					//promp date selection if none
					if (chosen_date.length === 0) {
						const time_option = document.createElement("option");
						time_option.setAttribute("value", "");
						time_option.setAttribute("selected", "true");
						time_option.appendChild(document.createTextNode("Date Not Selected"));
						time_selector.appendChild(time_option);
					}
					//lists no options 
					else if(available_timeArray.length === 0) {
						const time_option = document.createElement("option");
						time_option.setAttribute("value", "");
						time_option.setAttribute("selected", "true");
						time_option.setAttribute("disabled", "true");
						time_option.appendChild(document.createTextNode("Tickets sold out!"));
						time_selector.appendChild(time_option);
					} else { //lists options
						const time_default_option = document.createElement("option");
						time_default_option.setAttribute("value", "");
						time_default_option.setAttribute("selected", "true");
						time_default_option.appendChild(document.createTextNode("Select time"));
						time_selector.appendChild(time_default_option);
						//write time options
						for (const elem of timeArray) {
							const time_option = document.createElement("option");
							
							time_option.setAttribute("value", "");
							var dsbl = true;
							time_option.setAttribute("title", "Tickets sold out!");
							time_option.appendChild(document.createTextNode("Tickets sold out!"));

							for (const elem2 of available_timeArray) {
								if (elem.EventID === elem2.EventID) {
									time_option.innerHTML = "";
									time_option.setAttribute("value", elem.EventID);
									dsbl = false;
									time_option.setAttribute("title", "");
									time_option.appendChild(document.createTextNode(
										"Start: " + elem.StartingTime + " | End: " + elem.EndingTime
									));
									break;
								}
							}	
							if (dsbl) {
								time_option.setAttribute("disabled", "true");
							}						
							time_selector.appendChild(time_option);
						}
					}
				}

				<?php if ($loggedIn) { ?>
				//list billing profiles
				for (let i = 0; i < billing_profile_array.length; i++) {
					const billing_profile = document.createElement("option");
					billing_profile.setAttribute("value", billing_profile_array[i].BillingInfoID);

					billing_profile.setAttribute("value", billing_profile_array[i].BillingInfoID);
					const str = "Profile #" + billing_profile_array[i].BillingInfoID;
					billing_profile.appendChild(document.createTextNode(str));
					billing_profile_selector.appendChild(billing_profile);
				}

				//render billing form
				listBillingForm();
				window.addEventListener('resize', listBillingForm);
				//call on load and window resize
				function listBillingForm(){
					//calc num of colums
					window_width = window.innerWidth;

					const main_container = document.getElementById("billing_container");
					main_container.innerHTML = "";

					const first_name = document.createElement("input");
					first_name.setAttribute("type", "text");
					first_name.setAttribute("id", "firstName");
					first_name.setAttribute("name", "firstName");
					first_name.setAttribute("class", "form-control");
					first_name.setAttribute("placeholder", "First Name*");
					first_name.setAttribute("required", "true");
					first_name.setAttribute("pattern", "^[A-Za-z]{0,20}$");
					const first_name_container = document.createElement("div");
					first_name_container.setAttribute("class", "flex-fill");
					first_name_container.appendChild(first_name);

					const last_name = document.createElement("input");
					last_name.setAttribute("type", "text");
					last_name.setAttribute("id", "lastName");
					last_name.setAttribute("name", "lastName");
					last_name.setAttribute("class", "form-control");
					last_name.setAttribute("placeholder", "Last Name*");
					last_name.setAttribute("required", "true");
					last_name.setAttribute("pattern", "^[A-Za-z]{0,20}$");
					const last_name_container = document.createElement("div");
					last_name_container.setAttribute("class", "flex-fill");
					last_name_container.appendChild(last_name);

					const email = document.createElement("input");
					email.setAttribute("type", "text");
					email.setAttribute("id", "email");
					email.setAttribute("name", "email");
					email.setAttribute("class", "form-control");
					email.setAttribute("placeholder", "Email*");
					email.setAttribute("required", "true");
					email.setAttribute("type", "email");
					const email_container = document.createElement("div");
					email_container.setAttribute("class", "flex-fill");
					email_container.appendChild(email);

					const address = document.createElement("input");
					address.setAttribute("type", "text");
					address.setAttribute("id", "address");
					address.setAttribute("name", "address");
					address.setAttribute("class", "form-control");
					address.setAttribute("placeholder", "Address*");
					address.setAttribute("required", "true");
					address.setAttribute("pattern", "^[A-Za-z0-9 ]{0,44}$");
					const address_container = document.createElement("div");
					address_container.setAttribute("class", "flex-fill");
					address_container.appendChild(address);

					const postal = document.createElement("input");
					postal.setAttribute("type", "text");
					postal.setAttribute("id", "postal");
					postal.setAttribute("name", "postal");
					postal.setAttribute("class", "form-control");
					postal.setAttribute("placeholder", "Postal Code*");
					postal.setAttribute("required", "true");
					postal.setAttribute("pattern", "^.{2,10}$");
					const postal_container = document.createElement("div");
					postal_container.setAttribute("class", "flex-fill");
					postal_container.appendChild(postal);

					const city = document.createElement("input");
					city.setAttribute("type", "text");
					city.setAttribute("id", "city");
					city.setAttribute("name", "city");
					city.setAttribute("class", "form-control");
					city.setAttribute("placeholder", "City*");
					city.setAttribute("required", "true");
					city.setAttribute("pattern", "^[A-Za-z ]{1,20}$");
					const city_container = document.createElement("div");
					city_container.setAttribute("class", "flex-fill");
					city_container.appendChild(city);

					const StateProvince = document.createElement("input");
					StateProvince.setAttribute("type", "text");
					StateProvince.setAttribute("id", "StateProvince");
					StateProvince.setAttribute("name", "StateProvince");
					StateProvince.setAttribute("class", "form-control");
					StateProvince.setAttribute("placeholder", "Province/State");
					StateProvince.setAttribute("pattern", "^[A-Za-z ]{1,20}$");
					const StateProvince_container = document.createElement("div");
					StateProvince_container.setAttribute("class", "flex-fill");
					StateProvince_container.appendChild(StateProvince);


					const country = document.createElement("input");
					country.setAttribute("type", "text");
					country.setAttribute("id", "country");
					country.setAttribute("name", "country");
					country.setAttribute("class", "form-control");
					country.setAttribute("placeholder", "Country*");
					country.setAttribute("required", "true");
					country.setAttribute("pattern", "^[A-Za-z ]{1,20}$");
					const country_container = document.createElement("div");
					country_container.setAttribute("class", "flex-fill");
					country_container.appendChild(country);

					if (window_width >= 768) {

						const names_container = document.createElement("div");
						names_container.setAttribute("class", "d-flex flex-row mb-1");
						names_container.appendChild(first_name_container);
						names_container.appendChild(last_name_container);

						email_container.setAttribute("class", "mb-1");

						const AddressPostal_container = document.createElement("div");
						AddressPostal_container.setAttribute("class", "d-flex flex-row mb-1");
						AddressPostal_container.appendChild(address_container);
						AddressPostal_container.appendChild(postal_container);

						const CPSC_container = document.createElement("div");
						CPSC_container.setAttribute("class", "d-flex flex-row");
						CPSC_container.appendChild(city_container);
						CPSC_container.appendChild(StateProvince_container);
						CPSC_container.appendChild(country_container);

						main_container.appendChild(names_container);
						main_container.appendChild(email_container);
						main_container.appendChild(AddressPostal_container);
						main_container.appendChild(CPSC_container);
					} else {
						first_name_container.setAttribute("class", "mb-1");
						last_name_container.setAttribute("class", "mb-1");
						email_container.setAttribute("class", "mb-1");
						address_container.setAttribute("class", "mb-1");
						postal_container.setAttribute("class", "mb-1");
						city_container.setAttribute("class", "mb-1");
						StateProvince_container.setAttribute("class", "mb-1");
						country_container.setAttribute("class", "");

						main_container.appendChild(first_name_container);
						main_container.appendChild(last_name_container);
						main_container.appendChild(email_container);
						main_container.appendChild(address_container);
						main_container.appendChild(postal_container);
						main_container.appendChild(city_container);
						main_container.appendChild(StateProvince_container);
						main_container.appendChild(country_container);
					}
				}
				<?php } ?>

				
				window.addEventListener('resize', LoadBillingData);
				function LoadBillingData() {
					const billID = document.getElementById("billing_profile_selector").value;
					if(billID !== "") {
						for (const elem3 of billing_profile_array) {
							if (elem3.BillingInfoID === billID) {
								document.getElementById("firstName").value = elem3.Billing_FirstName;

								document.getElementById("lastName").value = elem3.Billing_LastName;

								document.getElementById("email").value = elem3.Email;

								document.getElementById("address").value = elem3.Address;

								document.getElementById("postal").value = elem3.Billing_PostalCode;

								document.getElementById("city").value = elem3.City;

								document.getElementById("StateProvince").value = elem3.StateProvince;

								document.getElementById("country").value = elem3.Country;
								break;
							}
						}
					}
				}

				SetButtonPrice("");
				function SetButtonPrice(price) {
					const buyBtn = document.getElementById('buyBtn');
					if (price.length === 0) {
						buyBtn.innerHTML = "Buy a Ticket";
					} else {
						buyBtn.innerHTML = "Buy a Ticket (" + price + "$)";
					}
				}			
			<?php
			}
			?>
		</script>
	</body>
</html>