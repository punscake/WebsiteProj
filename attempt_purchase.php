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

if (!$loggedIn) {
    header("Location: login_page.php?error=Must be logged in");
} else if (empty($_POST['time_selector'])) {
	$feedback_str = "Error: No event were chosen";
} else {
	$billing_data_array = array();
	$billing_data_array["firstName"] = validate($_POST['firstName']);
	$billing_data_array['lastName'] = validate($_POST['lastName']);
	$billing_data_array['email'] = validate($_POST['email']);
	$billing_data_array['address'] = validate($_POST['address']);
	$billing_data_array['postal'] = validate($_POST['postal']);
	$billing_data_array['city'] = validate($_POST['city']);
	$billing_data_array['StateProvince'] = validate($_POST['StateProvince']);
	$billing_data_array['country'] = validate($_POST['country']);

	if (verifyBillingData($billing_data_array)) {
		//process transaction
		if (verifyBillingData($billing_data_array)) {
			if (!empty($_POST['TicketFirstName']) && !empty($_POST['TicketLastName'])) {
				
				$name_array = array();
				$name_array['firstName'] = validate($_POST['TicketFirstName']);
				$name_array['lastName'] = validate($_POST['TicketLastName']);

				buyTicket($userId, $billing_data_array, $name_array, $_POST['time_selector'], $con);

				//pat the user on the back
				header("Location: feedback_page.php?feedback=Success");
			} else {
				header("Location: feedback_page.php?feedback=Ticket must be on someone's name");
			}
		} else {
			header("Location: feedback_page.php?feedback=Transaction couldn't get through, try again");
		}
		
		//save billing data
		if (!empty($_POST['SaveBillingProfile'])) {
			saveBillingData($userId, $billing_data_array, $_POST['billing_profile_selector'], $con);
		}
	} else {
		header("Location: feedback_page.php?feedback=Incorrect billing data");
	}	
}