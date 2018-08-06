<?php
//echo "start<br>";
//$dbhost = 'dedi230.flk1.host-h.net';
//$dbuser = 'dliroot01';
//$dbpass = 'Mother_1234';
//$dbname = 'dli_sans01';

$dbhost = 'localhost';
$dbuser = 'sanskvrcpu_9';
$dbpass = 'r4QVZV1AFJ8';
$dbname = 'sanskvrcpu_db9';


$conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
//echo "after conn<br>";
// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}else{
	//echo "connected<br>";
}
$dbselect=mysqli_select_db($conn,$dbname) or die("could not select");
/*if ($conn)
	echo "opened<br>";
else
	echo "not ok<br>";

if ($dbselect)
	echo "open<br>";
else
	echo "db issue<br>";*/
?>

