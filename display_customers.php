<!DOCTYPE html>
<html>
<head>
	<title>Customer Information</title>
	
	<style type="text/css">
		table, tr, th {
			border: 1px solid black;
		}
	</style>

</head>
<body>

<p>The following customers are in the bank system.</p><br>

<table>
	<tr>
		<th>ID</th>
		<th>Name</th>
		<th>Login</th>
		<th>Password</th>
		<th>DOB</th>
		<th>Gender</th>
		<th>Street</th>
		<th>City</th>
		<th>State</th>
		<th>Zipcode</th>
	</tr>

</body>

</html>
<?php 
include 'dbconfig.php';

$sql = 'SELECT * FROM Customers';
$results= mysqli_query($con, $sql);

while($row = mysqli_fetch_array($results)){

	echo "<tr>";
	echo "<th>" . $row['id'] . "</th>";
	echo "<th>" . $row['name'] . "</th>";
	echo "<th>" . $row['login'] . "</th>";
	echo "<th>" . $row['password'] . "</th>";
	echo "<th>" . $row['DOB'] . "</th>";
	echo "<th>" . $row['gender'] . "</th>";
	echo "<th>" . $row['street'] . "</th>";
	echo "<th>" . $row['city'] . "</th>";
	echo "<th>" . $row['state'] . "</th>";
	echo "<th>" . $row['zipcode'] . "</th>";
	echo "<tr>";


}

echo "</table>";

mysqli_close($con);

 ?>