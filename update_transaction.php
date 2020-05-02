<?php

if(!isset($_COOKIE['user'])){

    die("Cookies is not set. Please login <a href='index.html'>here</a>");

}

include 'dbconfig.php';

$deleteCounter = 0;
$updateCounter = 0;

@$deleteArray = $_REQUEST['delete'];
@$changeArray = $_REQUEST['note'];
@$idArray = $_REQUEST['id'];
$custID = $_COOKIE['user'];

    //Changing Note
    for($i = 0; $i<sizeof($changeArray); $i++){

        $note = $changeArray[$i];
        $curID = $idArray[$i];

        $sql = "SELECT note FROM CPS3740_2019S.Money_nadeems WHERE mid=$curID";
        $res = mysqli_query($con, $sql);
        
        while($row = mysqli_fetch_array($res)){

            if($row['note'] != $note){

                $sql = "UPDATE CPS3740_2019S.Money_nadeems SET note='$note' WHERE mid='$curID'";
                mysqli_query($con, $sql);
                $updateCounter += 1;

            }

        }

    }

    //Delete statements
   if(!empty($deleteArray)){
        foreach($deleteArray as $delete){

            $sql = "DELETE FROM CPS3740_2019S.Money_nadeems WHERE mid='$delete'";
            mysqli_query($con, $sql);
            $deleteCounter += 1;
        }
    }

    echo "Deleted " . $deleteCounter . " records from the table and " . $updateCounter . " records updated";
?>