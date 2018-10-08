<html>
<head>
  <style>
    tr:nth-child(odd) {
        background-color: wheat;
    }
	tr:nth-child(1) {
		background-color: black;
		color: white;
	}
    tr:nth-child(even) {
        background-color: palegreen;
    }
  </style>
</head>
<body>
<h1>MoviePlus Rental</h1>

<?php
require_once '.secret.php';

$db = new mysqli('cis.gvsu.edu', // hostname of db server
    $mysqluser, // your userid
    $mysqlpassword, // your password
    $mydbname);


$store = urldecode($_GET['storeId']);
$address = urldecode($_GET['addr']);
$city = urldecode($_GET['cit']);


printf('<h3>List of Customers at Store %s, %s</h3>', $address, $city);
printf('<table> <tr><th>Name</th><th>Email</th><th>Rental History</th><th>New Rental</th></tr>');
$i = 1;
$result = $db->query("SELECT * FROM customer where store_id = $store order by last_name");
while ($row = $result->fetch_assoc()) {
    printf('<tr><td>%d %s %s</td><td>%s</td><td><a href="history.php?id=%s&name=%s">View</a></td><td><a href="new.php?id=%s&name=%s">Rent</a></td></tr>',
    $i++, $row['first_name'], $row['last_name'], $row['email'], $row['customer_id'], $row['first_name']." ".$row['last_name'], $row['customer_id'], $row['first_name']." ".$row['last_name']);
}

?>
</body>
</html>