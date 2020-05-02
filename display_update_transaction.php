<?php

	if(!isset($_COOKIE['user'])){

		die("Cookies is not set. Please login <a href='index.html'>here</a>");

	}

	$id = $_COOKIE['user'];
	$sum = 0;
	
	echo "<style type='text/css'>";
	echo "table, tr, th{ border: 1px solid black;}";
	echo "</style>";
	echo "<table>";
	echo "<tr>";
	echo "<th> ID </th>";
	echo "<th> Code </th>";
	echo "<th> Amount </th>";
	echo "<th> Type of Transaction </th>";
	echo "<th> Source </th>";
	echo "<th> Transaction Date </th>";
	echo "<th> Note </th>";
	echo "<th> Delete </th>";
	echo "</tr>";

	echo "<form action='update_transaction.php' method='POST'>";

	include 'dbconfig.php';
	$sql = "SELECT * FROM CPS3740_2019S.Money_nadeems WHERE cid=$id";
	$res = mysqli_query($con, $sql);

	while($row = mysqli_fetch_array($res)){

		$mid = $row['mid'];
		$code = $row['code'];
		$amount = $row['amount'];
		$type = $row['type'];
		$source = $row['sid'];
		$date = $row['mydatetime'];
		$note = $row['note'];

		echo "<input type='hidden' name='id[]' value='" . $mid . "'>";
		echo "<tr>";
		echo "<th>" . $mid . "</th>";
		echo "<th>" . $code . "</th>";
		echo "<th>" . $amount . "</th>";
		$sum = $sum + $amount;
		echo "<th>" . $type . "</th>";
		echo "<th>" . $source . "</th>";
		echo "<th>" . $date . "</th>";
		echo "<th><input style='background: yellow'; type='text' name='note[]' value='$note'></th>";
		echo "<th><input type='checkbox' name='delete[]' value='$mid'></th>";
		echo "</tr>";

	}

	echo "</table>";

	echo "Current Balance: $" . $sum;
	echo "<br><input type='submit'>";
	echo "</form>";
	mysqli_close($con);

?>