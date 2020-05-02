<?php

	if(!isset($_COOKIE['user'])){

		die("Cookies is not set. Please login <a href='index.html'>here</a>");

	}

	$searchMe = $_GET['search'];

	if($searchMe == ""){

		die("Search query is empty.");

	}

$name = $_COOKIE['name'];
$id = $_COOKIE['user'];

	if($searchMe == "*"){

		echo "The transactions in customer " . $name . " records matched keywords " . $searchMe . " are:<br>";

		tableStart();

		include 'dbconfig.php';

		$sql = "SELECT * FROM CPS3740_2019S.Money_nadeems WHERE cid='$id'";
		$res = mysqli_query($con, $sql);

		$sum = 0;

		while($row = mysqli_fetch_array($res)){

			$id = $row['mid'];
			$code = $row['code'];
			$type = $row['type'];
			$amount = $row['amount'];
			$sum = $sum + $amount;
			$date = $row['mydatetime'];
			$note = $row['note'];
			$source = findSource($row['sid']);
			$custName = findCustName($row['cid']);
			
			displayTable($id, $code, $type, $amount, $date, $note, $source, $custName);
			
		}

		echo "</table>";
		echo "Total Balance: " . $sum;

	}else{
	
		include 'dbconfig.php';

		$sql = "SELECT * FROM CPS3740_2019S.Money_nadeems WHERE note LIKE '%$searchMe%'";
		$res = mysqli_query($con, $sql);

		if(mysqli_num_rows($res) == 0){

			echo "No records matches search keyword " . $searchMe;

		}else{

			echo "The transactions in customer " . $name . " records matched keywords " . $searchMe . " are:<br>";
			$sum = 0;
			tableStart();
			while($row = mysqli_fetch_array($res)){

				$id = $row['mid'];
				$code = $row['code'];
				$type = $row['type'];
				$amount = $row['amount'];
				$sum = $sum + $amount;
				$date = $row['mydatetime'];
				$note = $row['note'];
				$source = findSource($row['sid']);
				$custName = findCustName($row['cid']);

				displayTable($id, $code, $type, $amount, $date, $note, $source, $custName);
				
			}

			echo "</table>";
			echo "Total Balance: $" . $sum;
		}
	}
	
	mysqli_close($con);
	
//Helper Functions
	
	function tableStart(){

		echo "<style type='text/css'>";
		echo "table, tr, th{ border: 1px solid black;}";
		echo "</style>";
		echo "<table>";
		echo "<tr>";
		echo "<th> ID </th>";
		echo "<th> Code </th>";
		echo "<th> Type of Transaction </th>";
		echo "<th> Amount </th>";
		echo "<th> Transaction Date </th>";
		echo "<th> Note </th>";
		echo "<th> Source </th>";
		echo "<th> Customer Name</th>";
		echo "</tr>";

	}

	function displayTable($id, $code, $type, $amount, $date, $note, $source, $custName){

		echo "<tr>";
		echo "<th> $id </th>";
		echo "<th> $code </th>";

		if($type == "D"){

			echo "<th style='color:blue;'> $type </th>";
	
		}else{
	
			echo "<th style='color:red;'> $type </th>";

		}

		echo "<th> $amount </th>";
		echo "<th> $date </th>";
		echo "<th> $note </th>";
		echo "<th> $source </th>";
		echo "<th> $custName </th>";
		echo "</tr>";
	}

	function findCustName($custName){

		include 'dbconfig.php';
		$return = "Placeholder";
		$sql2 = "SELECT * FROM CPS3740.Customers WHERE id=$custName";

		$res2 = mysqli_query($con, $sql2);
		while($row = mysqli_fetch_array($res2)){

			$return = $row['name'];

		}
	
		

		mysqli_close($con);
		return $return;

	}

	function findSource($source){

		include 'dbconfig.php';
		$return = "Placeholder";
		$sql3 = "SELECT * FROM CPS3740.Sources WHERE id=$source";

		$res3 = mysqli_query($con, $sql3);
		while($row = mysqli_fetch_array($res3)){

			$return = $row['name'];

		}
		
		mysqli_close($con);
		return $return;

	}

?>