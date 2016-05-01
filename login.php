<?php

//display error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("connection.php"); //Establishing connection with our database

$error = ""; //Variable for storing our errors.
if(isset($_POST["submit"]))
{
    if(empty($_POST["username"]) || empty($_POST["password"]))
    {
        $error = "Both fields are required.";
    }else
    {
        // Define $username and $password
        $username1=$_POST['username'];
        $password=$_POST['password'];


        // To protect from MySQL injection and XSS
        $username1 = stripslashes($username1);
        $password = stripslashes($password);
        $username1 = mysqli_real_escape_string($db, $username1);
        $password = mysqli_real_escape_string($db, $password);
        $username1 = htmlspecialchars($username1);
        $password = htmlspecialchars($password);

        $password = md5($password);




        //prepare statement
        if($stmt=$sqlcon->prepare("SELECT userID FROM usersSecure WHERE username=? and password=?")){
            //bind parameter
            $stmt->bind_param('ss',$username,$password);
            $stmt->execute();
            //get result
            $result = $stmt->get_result();
        }


        if( ($row=$result->fetch_row()))


        // Initializing Session
        {
            $_SESSION['username'] = $username; // Initializing Session
            $_SESSION["userid"] = $row[0];//user id assigned to session global variable
            $_SESSION["timeout"] = time();//get session time
            $_SESSION["ip"] = $_SERVER['REMOTE_ADDR'];//get session time
            header("location: photos.php"); // Redirecting To Other Page
        }


    }
}
?>