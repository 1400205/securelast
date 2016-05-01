<?php
session_start();
?>

<?php
include("connection.php"); //Establishing connection with our database
//get session info
$login_user= $_SESSION["username"];
$ip=$_SESSION["ip"];
$timeout=$_SESSION ["timeout"];

$resultText = "";
if(isset($_SESSION['username']))
{
    $name = $_SESSION["username"];

    //clean input photo user name
    $name = stripslashes( $name );
   $name=mysqli_real_escape_string($db,$name);
    $name = htmlspecialchars($name);

    //declare instance of connection
        $sqlcon=new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
        if (!($sqlcon->connect_errno)){
            //echo"connection Failed";
        }

    //$sql="SELECT userID FROM usersSecure WHERE username='$name'";

    //prepare statement
    if($stmt=$sqlcon->prepare("SELECT userID FROM usersSecure WHERE username=?")) {
        //bind parameter
        $stmt->bind_param('s', $name);
        $stmt->execute();
        //get result
        $result = $stmt->get_result();
    }

        //$result=mysqli_query($db,$sql);
    //$row=mysqli_fetch_assoc($result);
    if(($row = $result->fetch_row()))
    {
        $searchID = $row[0];
        $searchSql="SELECT title, photoID,url FROM photosSecure WHERE userID='$searchID'";
        $searchresult=mysqli_query($db,$searchSql);

        if(mysqli_num_rows($searchresult)>0){
            while($searchRow = mysqli_fetch_assoc($searchresult)){
                $line = "<p><img src='".$searchRow['url']."' style='width:100px;height:100px;'><a href='photo.php?id=".$searchRow['photoID']."'>".$searchRow['title']."</a></p>";
                $resultText = $resultText.$line;
            }
        }
        else{
            $resultText = "no photos by you!";
        }
    }
    else
    {
        $resultText = "no user with that username";

    }
}
?>