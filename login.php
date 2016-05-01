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




        //Check username and password from database
        if (!($data=$db->prepare("SELECT userID FROM users WHERE username=? and password=?;")))
        {echo "fail";}

        if(!$data->bind_param('ss',$username1,$password )) {
            echo "binding parameters failed: (" . $data->errno . ")" . $data->error;
        }


        if (!$data -> execute()){
            echo "Execute failed: (" . $data->errno . ") " . $data->error;
        }

        $row=$data->fetch();

        // Initializing Session
        {
            $_SESSION['username'] = $username1;

            // Redirecting To Other Page
            header("location: photos.php");
        }


    }
}
?>