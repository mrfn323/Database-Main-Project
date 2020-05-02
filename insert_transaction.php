<?php

	if(!isset($_COOKIE['user'])){

		die("Cookies is not set. Please login <a href='index.html'>here</a>");

	}

	$sid = $_POST['sources'];
	$amount = $_POST['amount'];
	@$type = $_POST['type'];
	$code = $_POST['transCode'];
	$cid = $_COOKIE['user'];
	$note = $_POST['note'];
	$date = date("Y-m-d H:i:s");
	$balance = $_COOKIE['balance'];

	//Error checking
	if($amount == 0 || $amount < 0){

		die("ERROR. Amount entered either 0 or less than 0.");

	}else if($sid == ''){

		die("ERROR. No Source entered.");

	}else if($type == null){

		die("ERROR. No Type selected.");

	}

	include 'dbconfig.php';
	$sql = 'SELECT * FROM CPS3740_2019S.Money_nadeems WHERE code="$code"';
	$res = mysqli_query($con, $sql);

	if(mysqli_num_rows($res) == 0){
		$sql = "";

		if($type == "D"){

			$sql = "INSERT INTO CPS3740_2019S.Money_nadeems (code, cid, sid, type, amount, mydatetime, note) VALUES ('$code', $cid, $sid, '$type', $amount, '$date', '$note')";

		}
		else if($type == "W" || $amount <= $balance){

			$sql = "INSERT INTO CPS3740_2019S.Money_nadeems (code, cid, sid, type, amount, mydatetime, note) VALUES ('$code', $cid, $sid, '$type', ($amount * -1), '$date', '$note')";

		}else{

			die("Withdraw amount greater than or equal balance available");

		}
		
		if(mysqli_query($con, $sql) == TRUE){

			echo "New record added.";

		}else{

			echo "ERROR: " . mysqli_error($con);

		}		

	}else{

		die("This Transaction Code already exist. Go back to <a href='add_transaction.php'>add transaction</a> page");

	}

	echo "<br>Click <a href='login2.php'>here</a> to go back to the main page";
	mysqli_close($con);

?>