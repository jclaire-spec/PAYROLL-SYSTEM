<?php
session_start();
if (!isset($_SESSION['username'])) 
{
die(header('Location: ../index.php'));
}

?>
<?php
//database connection
include('connection.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print PaySlip</title>
<link rel="stylesheet" href="../css/style.css" type="text/css" />
<script src="../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
</head>

<body><div id="outerwrapper">
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
// number of records to be displayed per page
$records_per_page = 10;
// look for starting marker
// if not available, assume 0
(!$_GET['start']) ? $start = 0 : $start = $_GET['start'];

//view record
$qry = mysql_query("SELECT * FROM salary");
// get total number of records
$row = mysql_fetch_row($qry);
$total_records = $row[0];


// if records exist
if (($total_records > 0) && ($start < $total_records))
{
// create and execute query to get batch of records
$query = "SELECT * FROM salary LIMIT $start, $records_per_page";
$result = mysql_query($query) or die ('Error in query: $query. ' . mysql_error());

echo "<table border='1' align='center'>
<tr>
<th>SID</th>
<th>ID</th>
<th>Full Name</th>
<th>Dept</th>
<th>Position</th>
<th>Grade</th>
<th>Years</th>
<th>Basic</th>
<th>Meal All.</th>
<th>Housing All.</th>
<th>Transport All.</th>
<th>Ent. All</th>
<th>LS All</th>
<th>Tax</th>
<th>Total</th>
<th>Date</th>

</tr>";

while ($row = mysql_fetch_array($qry))
{
	echo "<tr>";
	echo "<td>" .$row['salary_id'] . "</td>";
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
	echo "<td> <a href= salary_delete.php?salary_id=".$row['salary_id']."&staff_id=".$row['staff_id']."&salary_id=".$row['salary_id'].">Delete</a>";
	echo "<td> <a href= payslip.php?staff_id=".$row['staff_id']."&salary_id=".$row['salary_id'].">Print</a>";
	echo "</tr>";
}
echo "</table>";

// set up the previous page link
// this should appear on all pages except the first page
// the start point for the previous page will be
// the start point for this page
// less the number of records per page

if ($start >= $records_per_page)
{
echo "<a href=" . $_SERVER['PHP_SELF'] . 
"?start=" . ($start-$records_per_page) . ">Previous Page</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
}
// set up the "next page" link
// this should appear on all pages except the last page
// the start point for the next page
// will be the end point for this page
if ($start+$records_per_page < $total_records && $start >= 0)
{
echo "<a href=" . $_SERVER['PHP_SELF'] . 
"?start=" . ($start+$records_per_page) . ">Next Page</a>";
}
}
?></div>
</div>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"../../SpryAssets/SpryMenuBarDownHover.gif", imgRight:"../../SpryAssets/SpryMenuBarRightHover.gif"});
</script>

</body>

</html>