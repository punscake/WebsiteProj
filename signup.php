<?php 

session_start(); 

include "connect.php";
include "functions.php";

if (isset($_POST['SignupUsername']) && isset($_POST['SignupPassword'])) {

    $uname = validate($_POST['SignupUsername']);

    $pass = validate($_POST['SignupPassword']);

    if (empty($uname)) {
        exit();

    } else if(empty($pass)){
        exit();

    } else {

        $sql = "INSERT INTO USERNAMEPASSWORD VALUES (DEFAULT, '$uname','$pass')";

        $result = mysqli_query($con, $sql);

        if ($result === false) {

            header("Location: signup_page.php?error=User already exists!");

        } else {
            
            $_SESSION['AutofillUsername'] = $uname;
            header("Location: login_page.php");

        }

    }

}else{

    header("Location: signup_page?error=Fields not filled in.php");

}
unset($_POST['SingupUsername']);
unset($_POST['SignupPassword']);
exit();