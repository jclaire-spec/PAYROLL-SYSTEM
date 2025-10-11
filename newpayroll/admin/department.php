<?php
include('../sanitise.php');
session_start();
if (!isset($_SESSION['username'])) 
{
die(header('Location: ../index.php'));
}

$dept = sanitise($_GET['department']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View staffs by position</title>
<link rel="stylesheet" href="../css/style.css" type="text/css" />
<script src="../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
 	function proceed() 
	{
	  return confirm('WANNA SEND IM?');
 	}
 </script>
</head>

<body>
<div id="outerwrapper">
<div id="header"></div>
<div id="links">
  <ul id="MenuBar1" class="MenuBarHorizontal">
    <li><a href="index.php">HOME</a>      </li>
    <li><a href="reg_staff.php">REGISTER STAFF</a></li>
    <li><a href="view_staff.php">VIEW STAFF</a>      </li>
    <li><a href="payroll.php" class="MenuBarItemSubmenu">PAYROLL</a>
      <ul>
        <li><a href="print.php">Print Slip</a></li>
      </ul>
    </li>
    <li><a href="#" class="MenuBarItemSubmenu">MESSAGE</a>
      <ul>
<li><a href="inbox.php">Inbox</a></li>
<li><a href="sentmessages.php">Sent</a></li>
      </ul>
    </li>
    <li><a href="../logout.php">Logout</a></li>
  </ul>
</div>

<div id="body">
<?php
//database connection
include('connection.php');

//view record
$qry = mysql_query("SELECT * FROM register_staff WHERE department = '$dept'");
echo "<table border='1' align='center'>
<tr>
<th>Staff ID</th>
<th>Name</th>
<th>Sex</th>
<th>Birthday</th>
<th>Department</th>
<th>Position</th>
<th>Grade</th>
<th>Years</th>
<th>Date Employed</th>

</tr>";


while ($row = mysql_fetch_array($qry))
{
	echo "<tr>";
	echo "<td>" .$row['staff_id'] . "</td>";
	echo "<td>" .$row['fname'] . "</td>";
	echo "<td>" .$row['sex'] . "</td>";
	echo "<td>" .$row['birthday'] . "</td>";
	echo "<td>" .$row['department'] . "</td>";
	echo "<td>" .$row['position'] . "</td>";
	echo "<td>" .$row['grade'] . "</td>";
	echo "<td>" .$row['years'] . "</td>";
	echo "<td>" .$row['date_registered'] . "</td>";
	echo "<td> <a href= delete.php?staff_id=".$row['staff_id'].">Delete</a>";
	echo "<td> <a href= up_staff.php?staff_id=".$row['staff_id'].">Update</a>";
	echo "<td> <a href= im.php?staff_id=".$row['staff_id'].">Message</a>";
	echo "</tr>";
}
echo "</table>";
echo "<a href=index.php>Go Home</a>  <br />";
echo "<a href=payroll.php>Calculate Payroll</a>";
?>
</div>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"../../SpryAssets/SpryMenuBarDownHover.gif", imgRight:"../../SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</div>
</body>
</html>