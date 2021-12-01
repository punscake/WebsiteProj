<?php

function writeQueryResultToArray($queryResult) { //returns array
    $result = array();
    if ($queryResult) {
        while($row = mysqli_fetch_array($queryResult)) {
            $result[] = $row;
        }
    }
    return $result;
}

function getAllSimilarEvents($EventID, $database) { //returns array
    $query = "SELECT * FROM EVENTS WHERE Name = (SELECT Name FROM EVENTS WHERE EventID = " . $EventID . " LIMIT 1)
    && Description = (SELECT Description FROM EVENTS WHERE EventID = " . $EventID . " LIMIT 1);";
    $query_result = mysqli_query($database, $query);
    return $query_result;
}

function getAllSimilarEventsOnlySeatsAvailable($EventID, $database) { //returns array
    $query = "SELECT * FROM EVENTS WHERE Name = (SELECT Name FROM EVENTS WHERE EventID = " . $EventID . " LIMIT 1)
    && Description = (SELECT Description FROM EVENTS WHERE EventID = " . $EventID . " LIMIT 1);";
    $query_result = mysqli_query($database, $query);
    $filtered_array = array();
    if ($query_result) {
        while($row = mysqli_fetch_array($query_result)) {
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

function saveBillingData($UserID, $value_array, $replaceID, $database) {
    if (empty($replaceID)) {
        $query = "INSERT INTO BILLINGINFO VALUES (DEFAULT, " . $UserID . ", '" . $value_array['firstName'] . "', '" . $value_array['lastName'] . "', '" . $value_array['email'] . "', '" . $value_array['address'] . "', '" . $value_array['postal'] . "', '" . $value_array['city'] . "', '" . $value_array['StateProvince'] . "', '" . $value_array['country'] . "');";
        mysqli_query($database, $query);
    } else {
        $query = "REPLACE INTO BILLINGINFO VALUES (" . $replaceID . ", " . $UserID . ", '" . $value_array['firstName'] . "', '" . $value_array['lastName'] . "', '" . $value_array['email'] . "', '" . $value_array['address'] . "', '" . $value_array['postal'] . "', '" . $value_array['city'] . "', '" . $value_array['StateProvince'] . "', '" . $value_array['country'] . "');";
        mysqli_query($database, $query);
    }
}

function verifyBillingData($value_array) { //returns true if billing data is valid
    return true;
}

function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
 }

 