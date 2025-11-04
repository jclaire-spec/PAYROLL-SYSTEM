<?php
session_start();
if (!isset($_SESSION['username'])) 
{
die(header('Location: ../index.php'));
}
include('../sanitise.php');
$month = sanitise($_GET['month']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Assistant Managers</title>
<link rel="stylesheet" href="../css/style.css" type="text/css" />
<script src="../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />

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
$qry = mysql_query("SELECT * FROM salary WHERE monthname(date_s) = '$month'");
echo "<table border='1' align='center'>
<tr>
<th>Staff ID</th>
<th>Full Name</th>
<th>Department</th>
<th>Position</th>
<th>Grade</th>
<th>Years</th>
<th>Basic</th>
<th>Meal All</th>
<th>Housing All</th>
<th>Transport</th>
<th>Entertainment</th>
<th>Long Service</th>
<th>Tax</th>
<th>Net</th>
<th>Date</th>
</tr>";


while ($row = mysql_fetch_array($qry))
{
	echo "<tr>";
	echo "<td>" .$row['staff_id'] . "</td>";
	echo "<td>" .$row['fname'] . "</td>";
	echo "<td>" .$row['department'] . "</td>";
	echo "<td>" .$row['position'] . "</td>";
	echo "<td>" .$row['grade'] . "</td>";
	echo "<td>" .$row['years'] . "</td>";
	echo "<td>" .$row['basic'] . "</td>";
	echo "<td>" .$row['meal'] . "</td>";
	echo "<td>" .$row['housing'] . "</td>";
	echo "<td>" .$row['transport'] . "</td>";
	echo "<td>" .$row['entertainment'] . "</td>";
	echo "<td>" .$row['long_service'] . "</td>";
	echo "<td>" .$row['tax'] . "</td>";
	echo "<td>" .$row['totall'] . "</td>";
	echo "<td>" .$row['date_s'] . "</td>";
	echo "</tr>";
}
echo "</table>";
echo "<a href=index.php>Go Home</a>  <br />";
?>
</div>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"../../SpryAssets/SpryMenuBarDownHover.gif", imgRight:"../../SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</div>
</body>
</html>