<?php
session_start();
include("connection.php"); //Establishing connection with our database
$mysqli = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);//instance of connection

if(isset($_GET['id']))
{
    $photoID = $_GET['id'];

    //filter input from get
    $photoID=mysqli_real_escape_string($db,$photoID);

    //filter $_Get from xss attack
    $photoID=xss_cleaner($photoID);
    $photoID=xssafe($photoID);

    //$remsql = "DELETE FROM photosSecure WHERE photoID='$photoID'";
    $stmt=$mysqli->prepare("DELETE FROM photosSecure WHERE photoID=?");
   // $query = mysqli_query($db, $remsql) or die(mysqli_error($db));
    //bind parameter
    $stmt->bind_param('i', $photoID);
    $stmt->execute();
    if ($stmt) {
        header("Location: photos.php");
    }
    else {
        echo "Sorry, there was an error deleting the file.";
    }
    //echo $name." ".$email." ".$password

}

?>