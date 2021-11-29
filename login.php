<?php 

session_start(); 

include "connect.php";

if (isset($_POST['InputUsername']) && isset($_POST['InputPassword'])) {

    function validate($data){

       $data = trim($data);

       $data = stripslashes($data);

       $data = htmlspecialchars($data);

       return $data;

    }

    $uname = validate($_POST['InputUsername']);

    $pass = validate($_POST['InputPassword']);

    if (empty($uname)) {
        exit();

    } else if(empty($pass)){
        exit();

    } else {

        $sql = "SELECT * FROM USERNAMEPASSWORD WHERE Username='$uname'";

        $result = mysqli_query($con, $sql);

        $row = mysqli_fetch_assoc($result);

        if ($row && $row['Pass'] === $pass) {

            $_SESSION['LoggedIn'] = true;

            $_SESSION['UserID'] = $row['UserID'];

            header("Location: index.php");

        } else {

            header("Location: login_page.php?error=Incorect User name or password");
        }

    }

}else{
    
    header("Location: login_page.php");
    
}
unset($_POST['InputUsername']);
unset($_POST['InputPassword']);
exit();