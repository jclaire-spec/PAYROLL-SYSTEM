<?php 
include('connection.php');
include('../sanitise.php');
$salary_id =sanitise( $_GET['salary_id']);
$staff_id =sanitise( $_GET['staff_id']);
$qry = ("DELETE FROM salary WHERE salary_id = '$salary_id' AND staff_id = '$staff_id'");
$con = mysql_query($qry) or die(mysql_error());
if(!$con)
{
	echo "not deleted successfully";
	echo "<a href = view_staff.php>Go Back</a>";
}

else
{
	echo "staff has been successfully deleted";
	echo "<a href = view_staff.php>Go Back Home</a>";
}
?>
