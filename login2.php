<!-- 
This Program was entirely written by Syed Fahad Nadeem
CPS 3740 Section 1
Project 2
Professor Austin Huang

  -->

<?php 
echo "<title>Welcome</title>";
// Needed Variables
@$username = $_POST['username'];
@$password = $_POST['password'];
$ip = $_SERVER['REMOTE_ADDR'];

if($username == "" || $password == ""){

	die("Username or password feilds are empty. Please go back to <a href='index.html'>login page.</a>");

}

// SQL
include 'dbconfig.php';
$sql = "SELECT * FROM Customers WHERE login='$username'";
$res = mysqli_query($con, $sql) or die("Database Error! Please go back to the home page and try again");
$fetch = mysqli_fetch_array($res);
$id = $fetch['id'];
$name = $fetch['name'];

// Authentication
if(!isset($fetch)){

	mysqli_close($con);
	die("$username not found in database. <a href='index.html'>Click here</a> to go back to login.");

}else if($password != $fetch['password']){

	mysqli_close($con);
	die("Login $username exist, but password does not match. <a href='index.html'>Click here</a> to go back to the main page");


}

//Setting cookie for when customer sucessfully logs in
setcookie('user', $id, time()+3600,"/");
setcookie('name', $name, time()+3600,"/");

//Logout function
echo "<a href='logout.php'>logout</a><br/>";

// IP Check
echo "Your IP: " . $ip . "<br>";
$split = explode(".", $ip);
if($split[0] == "10"){

echo "You are from Kean University.<br>";

}else if($split[0] == "131" && $split[1] == "125"){

echo "You are from Kean University.<br>"; 

}else{

echo "You are NOT from Kean University.<br>";

}

// Customer Information
echo "Welcome Customer: " . $name . "<br>";
echo "Address: " . $fetch['street'] . ", " . $fetch['city'] . ", " . $fetch['zipcode'] . "<br>";
echo "Age: ";
$customerDOB = $fetch['DOB'];
$now = date("Y-m-d");
$date1 = date_create($now);
$date2 = date_create($customerDOB);
$diff = date_diff($date1, $date2);
echo $diff->format('%y');
echo "<hr>";

echo "<p> The transaction for customer " . $name . " are: Savings Account";
mysqli_close($con);

// SQL for Retrieveing the table
include 'dbconfig.php';
$sql = 'SELECT * FROM CPS3740_2019S.Money_nadeems';
$res = mysqli_query($con, $sql);

echo <<< _HTML_BLOCK

<style type="text/css">
	table, tr, th{
		border: 1px solid black;
	}
</style>

<table>
	<tr>
		<th> Transaction ID </th>
		<th> Code </th>
		<th> Customer ID </th>
		<th> Source ID </th>
		<th> Type of Transaction </th>
		<th> Amount </th>
		<th> Transaction Date </th>
		<th> Note </th>
	</tr>

_HTML_BLOCK;

$sum = 0;

while($row = mysqli_fetch_array($res)){

	echo "<tr>";
	echo "<th>" . $row['mid'] . "</th>";
	echo "<th>" . $row['code'] . "</th>";
	echo "<th>" . $row['cid'] . "</th>";
	echo "<th>" . $row['sid'] . "</th>";
	$type = $row['type'];
	$amount = $row['amount'];
	$sum = $sum + ($amount);
	echo "<th>" . $type . "</th>";
	if($type == 'D'){
		echo "<th style='color: blue;'>" . $amount . "</th>";
	}
	else{
		echo "<th style='color: red;'>" . $amount . "</th>";
	}
	echo "<th>" . $row['mydatetime'] . "</th>";
	echo "<th>" . $row['note'] . "</th>";
	echo "</tr>";

}

setcookie('balance', $sum, time()+3600,"/");
echo "</table>";
echo "<strong> Your Total Balance is: $" . $sum . "</strong>";

mysqli_close($con);

//Addition of Add, Search, and Display

echo <<< _HTML_BLOCK

<br>

<form action='add_transaction.php' method='POST'>
<input type='submit' value='Add Transaction'>
</form>

<a href='display_update_transaction.php'>Display and Update Transaction</a>

<br>
<form action='search.php' method='GET'>
Keyword: <input name='search' type='text'>
<input type='submit' value='Search Transaction'>	
</form>
	

_HTML_BLOCK;

 ?>