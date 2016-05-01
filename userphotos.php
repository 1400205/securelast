<?php

//include ("secureSessionID.php");//verify user session
//include ("inactiveTimeOut.php");//check user idle time
$resultText = "";
if(isset($_SESSION['username']))
{
    $name = $_SESSION["username"];

    //declare instance of connection
    $sqlcon=new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

    //prepare statement
    if($stmt=$sqlcon->prepare("SELECT userID FROM usersSecure WHERE username=?")){
        //bind parameter
        $stmt->bind_param('s',$name);
        $stmt->execute();

        //get result
      //  $result = $stmt->get_result();
    }

    if (!$data -> execute()){
        echo "Execute failed: (" . $data->errno . ") " . $data->error;
    }

    $row=$data->fetch();

    $sql="SELECT userID FROM usersSecure WHERE username='$name'";
    //$result=mysqli_query($db,$sql);
    //$row=mysqli_fetch_assoc($result);
    if$row=$data->fetch())
    {
        $searchID = $row['userID'];
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