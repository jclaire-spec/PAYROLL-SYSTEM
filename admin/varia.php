<?php
if(isset($_POST['submit'])){
include('connection.php');
include('sanitise.php');
$housing = sanitise($_POST['housing']);
$transport = sanitise($_POST['transport']);
$entertainment = sanitise($_POST['entertainment']);
$long_service = sanitise($_POST['long_service']);
$tax = sanitise($_POST['tax']);

$insert = ("UPDATE variables SET housing = '$housing', transport = '$transport', tax = '$tax', entertainment = '$entertainment', long_service = '$long_service'");
$qry = mysql_query($insert) or die(mysql_error());
if($insert)
	{
		echo "success";
		echo "<br />";
		echo "<a href=index.php> Home </a>";
	}
else
	{
		echo "failed";
	}
}
?>