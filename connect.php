<?php

$dbhost = "ticketsdatabase.ci00wu7lvl7q.us-east-2.rds.amazonaws.com:3306";
$dbuser = "admin";
$dbpass = "qwerfdsa";
$dbname = "Main";

$con = new mysqli($dbhost,$dbuser,$dbpass,$dbname);

if($con->connect_errno)
{
	echo ("failed to connect");
	die("failed to connect!");
}