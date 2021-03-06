<html>
<head>
    <link rel="stylesheet" href="stylesheet.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
</head>
<body>
<h1><a href="home.php" class="nav-link">MoviePlus Rental</a></h1>

<?php
require_once '.secret.php';

$db = new mysqli('cis.gvsu.edu', // hostname of db server
    $mysqluser, // your userid
    $mysqlpassword, // your password
    $mydbname);

session_start();
$custId = urldecode($_GET['id']);
$custName = urldecode($_GET['name']);
if (!empty($custId) && !empty($custName)){
    session_start();
    $_SESSION['cName'] = "$custName";
    $_SESSION['cId'] = "$custId";
} else {
    $custId = $_SESSION['cId'];
    $custName = $_SESSION['cName'];
}

$success = urldecode($_GET['success']);
if ($success){
    printf('<p>Successfully checked movie in!</p>');
}

printf('<h3>History for customer %s</h3>', $custName);

printf('<table> <tr class="head"><th></th><th>Film Title</th><th>Rental Date</th><th>Return Date</th></tr>');

$i = 1;
$result = $db->query("SELECT * FROM rental where customer_id = $custId order by return_date");
while ($row = $result->fetch_assoc()) {
    $inv = urlencode($row['inventory_id']);

    $film = $db->query("SELECT * FROM inventory where inventory_id = $inv");
    $filmRow = $film->fetch_assoc();

    $fId = urlencode($filmRow['film_id']);

    $filmName = $db->query("SELECT * FROM film where film_id = $fId");
    $filmNameRow = $filmName->fetch_assoc();

    printf('<tr><td>%d</td><td>%s</td><td>%s</td>', $i++, $filmNameRow['title'], $row['rental_date']);
    if (empty($row['return_date'])){
        printf('<td align="center"><a href="return.php?rid=%s">Checkin</td></tr>', $row['rental_id']);
    } else {
        printf('<td>%s</td></tr>', $row['return_date']);
    }
}
printf('</table>');

?>
</body>
<footer>
	<p> Created by Jacob Walton</p>
</footer>
</html>