<?php

function writeQueryResultToArray($queryResult) { //returns array
    $result = array();
    if ($queryResult) {
        while($row = mysqli_fetch_assoc($queryResult)) {
            $result[] = $row;
        }
    }
    return $result;
}

function getAllSimilarEvents($EventID, $database) { //returns array
    $query = "SELECT * FROM EVENTS WHERE Name = (SELECT Name FROM EVENTS WHERE EventID = " . $EventID . " LIMIT 1)
    && Description = (SELECT Description FROM EVENTS WHERE EventID = " . $EventID . " LIMIT 1)
    && Venue = (SELECT Venue FROM EVENTS WHERE EventID = " . $EventID . " LIMIT 1);";
    $query_result = mysqli_query($database, $query);
    return $query_result;
}

function getAllSimilarEventsOnlySeatsAvailable($EventID, $database) { //returns array
    $query = "SELECT * FROM EVENTS WHERE Name = (SELECT Name FROM EVENTS WHERE EventID = " . $EventID . " LIMIT 1)
    && Description = (SELECT Description FROM EVENTS WHERE EventID = " . $EventID . " LIMIT 1)
    && Venue = (SELECT Venue FROM EVENTS WHERE EventID = " . $EventID . " LIMIT 1);";
    $query_result = mysqli_query($database, $query);
    $filtered_array = array();
    if ($query_result) {
        while($row = mysqli_fetch_assoc($query_result)) {
            if (checkEventHasTicketsAvailable($row['EventID'], $database)) { //filter
                $filtered_array[] = $row;
            }
        }
    }
    return $filtered_array;
}

function getBillingData($UserID, $database) { //returns array
    $query = "SELECT * FROM BILLINGINFO WHERE BelongsToUser = " . $UserID . ";";
    $query_result = mysqli_query($database, $query);
    return writeQueryResultToArray($query_result);
}

function checkTicketAvailable($TicketID, $database) { //returns bool
    $query = "SELECT * FROM TICKETS WHERE TicketID = " . $TicketID . ";";
    $row = mysqli_fetch_assoc( mysqli_query($database, $query) );
    if ($row && $row['BelongsToPerson'] === NULL) {
        return true;
    }
    return false;
}

function getAvailableTickets($EventID, $database) { //returns tickets table, or false
    $query = "SELECT * FROM TICKETS WHERE Event = " . $EventID . " && BelongsToPerson IS NULL;";
    $result = mysqli_query($database, $query);
    return $result;
}

function checkEventHasTicketsAvailable($EventID, $database) { //returns bool
    $available = getAvailableTickets($EventID, $database);
    if ( !$available || !mysqli_fetch_assoc( $available ) ) {
        return false;
    }
    return true;
}

function getLineItems2d($userId, $database) {
    $query1 = "SELECT * FROM LINEITEM WHERE BelongsToReceipt IN
    (SELECT ReceiptID FROM RECEIPT WHERE BelongsToUser = " . $userId . ");";
    $query1_result = mysqli_query($database, $query1);

    $query2 = "SELECT * FROM RECEIPT WHERE BelongsToUser = " . $userId . " ORDER BY DateTimeOfTransaction DESC;";
    $query2_result = mysqli_query($database, $query2);
    
    $result = array();
    if ($query1_result && $query2_result) {
        $items = array();
        while($row = mysqli_fetch_assoc($query1_result)) {
            $items[] = $row;
        }

        while($receipt = mysqli_fetch_assoc($query2_result)) {
            $subarray = array();
           
            foreach($items as $item) {
                if ($item['BelongsToReceipt'] === $receipt['ReceiptID']) {
                    $subarray[] = $item;
                }
            }
            //return $subarray;
            $result[$receipt['ReceiptID']] = $subarray;
        }						
    }
    return $result;
}

function saveBillingData($UserID, $billing_data_array, $replaceID, $database) {
    if (empty($replaceID)) {
        $query = "INSERT INTO BILLINGINFO VALUES (DEFAULT, " . $UserID . ", '" . $billing_data_array['firstName'] . "', '" . $billing_data_array['lastName'] . "', '" . $billing_data_array['email'] . "', '" . $billing_data_array['address'] . "', '" . $billing_data_array['postal'] . "', '" . $billing_data_array['city'] . "', '" . $billing_data_array['StateProvince'] . "', '" . $billing_data_array['country'] . "');";
        mysqli_query($database, $query);
    } else {
        $check_belongs_to_user_query = "SELECT * FROM BILLINGINFO WHERE BillingInfoID = " . $replaceID . " LIMIT 1;";
        $table1 = mysqli_query($database, $check_belongs_to_user_query);
        $row1 = mysqli_fetch_assoc($table1);
        if ($row1 && $row1['BelongsToUser'] === $UserID) {
            $query = "REPLACE INTO BILLINGINFO VALUES (" . $replaceID . ", " . $UserID . ", '" . $billing_data_array['firstName'] . "', '" . $billing_data_array['lastName'] . "', '" . $billing_data_array['email'] . "', '" . $billing_data_array['address'] . "', '" . $billing_data_array['postal'] . "', '" . $billing_data_array['city'] . "', '" . $billing_data_array['StateProvince'] . "', '" . $billing_data_array['country'] . "');";
            mysqli_query($database, $query);
        }
    }
}

function deleteBillingData($UserID, $deleteID, $database) {
    $check_belongs_to_user_query = "SELECT * FROM BILLINGINFO WHERE BillingInfoID = " . $deleteID . " LIMIT 1;";
    $table1 = mysqli_query($database, $check_belongs_to_user_query);
    $row1 = mysqli_fetch_assoc($table1);
    if ($row1 && $row1['BelongsToUser'] === $UserID) {
        $query = "DELETE FROM BILLINGINFO WHERE BillingInfoID = " . $deleteID . " LIMIT 1;";
        mysqli_query($database, $query);
    }
}

function verifyBillingData($billing_data_array) { //returns true if billing data is valid
    return true;
}

function buyTicket($UserID, $billing_data_array, $name_array, $EventID, $database) {
    $availableTicket = mysqli_fetch_assoc(getAvailableTickets($EventID, $database));
    if ($availableTickets !== false) {
        //create personal info
        $query1 = "INSERT INTO PERSONALINFO VALUES (DEFAULT, '" . $name_array['firstName'] . "', '" . $name_array['lastName'] . "');";
        mysqli_query($database, $query1);
        $personal_info_id = mysqli_insert_id($database);
        
        //link ticket to personal info
        $query2 = "UPDATE TICKETS SET BelongsToPerson = " . $personal_info_id . " WHERE TicketID = " . $availableTicket['TicketID'] . ";";
        mysqli_query($database, $query2);

        //create billing info for receipt
        $query3 = "INSERT INTO BILLINGINFO VALUES (DEFAULT, NULL, '" . $billing_data_array['firstName'] . "', '" . $billing_data_array['lastName'] . "', '" . $billing_data_array['email'] . "', '" . $billing_data_array['address'] . "', '" . $billing_data_array['postal'] . "', '" . $billing_data_array['city'] . "', '" . $billing_data_array['StateProvince'] . "', '" . $billing_data_array['country'] . "');";
        mysqli_query($database, $query3);
        $billing_data_id = mysqli_insert_id($database);
        
        //create receipt
        $query4 = "INSERT INTO RECEIPT VALUES (DEFAULT, " . $billing_data_id . ", " . $UserID . ", CURRENT_TIMESTAMP);";
        mysqli_query($database, $query4);
        $receipt_id = mysqli_insert_id($database);

        //create line item for receipt
        $line_num = 1;
        $query5 = "INSERT INTO LINEITEM VALUES (DEFAULT, " . $receipt_id . ", " . $line_num . ", " . $availableTicket['TicketID'] . ", " . $availableTicket['Price'] . ", FALSE);";
        mysqli_query($database, $query5);
    }
}

function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
 }

 