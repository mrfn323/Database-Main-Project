<?php

	if(!isset($_COOKIE['user'])){

		die("Cookies is not set. Please login <a href='index.html'>here</a>");

	}

	$custName = $_COOKIE['name'];
	$balance = $_COOKIE['balance'];

	echo "<a href='logout.php'>Logout</a>";
	echo "<h1>Add Transaction </h1>";
	echo $custName . " current balance is <strong>$" . $balance . "</strong>";

	//HTML
	echo "<form method='POST' action='insert_transaction.php'><br>";
	echo "Transaction code: <input type='text' name='transCode'><br>";
	echo "<input type='radio' value='D' name='type'> Deposit";
	echo "<input type='radio' value='W' name='type'> Withdraw <br>";
	echo "Amount: <input type='number' name='amount' min='0.01' step='0.01'><br>";

	//Source
	include 'dbconfig.php';
	$sql = 'SELECT * FROM CPS3740.Sources';
	$res = mysqli_query($con, $sql);
	
	echo "Select a Source: <select name='sources'>";
	echo "<option value=''></option>";
	while($row = mysqli_fetch_array($res)){

		echo "<option value='" . $row['id'] ."'>" . $row['name'] . "</option>";

	}

	echo "</select>"; 
	mysqli_close($con);

	echo "<br>Note: <input type='text' name='note'>";
	echo "<br><input type='submit'>";
	echo "</form>";
	
?>