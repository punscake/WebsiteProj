<?php

include "connect.php";

$price = 16.00;
$eventID = 18;
$ticketNum = 2;

for ($i = 1; $i <= $ticketNum; $i++) {
    $query = "REPLACE INTO Main.TICKETS VALUES (DEFAULT, " . $price . ", NULL, " . $eventID . ", '" . $i . "');";
    mysqli_query($con, $query);
}