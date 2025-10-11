<?php
session_start();
if (!isset($_SESSION['username'])) 
{
die(header('Location: ../index.php'));
}

include('connection.php');
$qry = "SELECT count(*), sum(basic), sum(meal), sum(housing), sum(transport), sum(entertainment), sum(long_service), sum(tax), sum(totall), monthname(date_s) FROM salary GROUP BY month(date_s)";
$run = mysqli_query($conn, $qry) or die(mysqli_error($conn));

$qry2 = "SELECT count(*) FROM register_staff";
$run2 = mysqli_query($conn, $qry2) or die(mysqli_error($conn));

$qry3 = "SELECT *, count(*) FROM register_staff GROUP BY sex";
$run3 = mysqli_query($conn, $qry3) or die(mysqli_error($conn));

$qry4 = "SELECT *, count(*) FROM register_staff GROUP BY position";
$run4 = mysqli_query($conn, $qry4) or die(mysqli_error($conn));

$qry5 = "SELECT *, count(*) FROM register_staff GROUP BY department";
$run5 = mysqli_query($conn, $qry5) or die(mysqli_error($conn));

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home</title>
<link rel="stylesheet" href="../css/style.css?v=20251008" type="text/css" />
<script type="text/javascript">
 	function proceed() 
	{
	  return confirm('Compute Payroll');
 	}
 </script>
</head>

<body>

<div class="app-shell">

	<div class="headerbar">
		<div class="brand-wrap"><button class="hamburger" id="sidebarToggle" aria-label="Toggle sidebar"><span></span><span></span><span></span></button><div class="brand">Payroll Admin</div></div>
		<div class="user-profile"><div class="avatar">D</div></div>
</div>

<div class="layout" id="layout">
	<aside class="sidebar">
		<ul class="nav-list">
			<li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
			<li class="nav-item"><a class="nav-link" href="reg_staff.php">Register Staff</a></li>
			<li class="nav-item"><a class="nav-link" href="view_staff.php">View Staff</a></li>
			<li class="nav-item"><a class="nav-link" href="payroll.php">Payroll</a></li>
			<li class="nav-item"><a class="nav-link" href="print.php">Print Slip</a></li>
			<li class="nav-item"><a class="nav-link" href="inbox.php">Inbox</a></li>
			<li class="nav-item"><a class="nav-link" href="sentmessages.php">Sent</a></li>
			<li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
		</ul>
		<form name="variables" action="varia.php" method="post" style="margin-top:12px;">
			<div class="card">
				<h3>Update Payment Variables</h3>
				<table>
					<tr>
						<td>Housing</td>
						<td><span id="sprytextfield1"><input type="text" name="housing" id="housing" /><span class="textfieldRequiredMsg"> </span></span></td>
					</tr>
					<tr>
						<td>Transport</td>
						<td><span id="sprytextfield2"><input type="text" name="transport" id="transport" /><span class="textfieldRequiredMsg"> </span></span></td>
					</tr>
					<tr>
						<td>Entertainment</td>
						<td><span id="sprytextfield3"><input type="text" name="entertainment" id="entertainment" /><span class="textfieldRequiredMsg"> </span></span></td>
					</tr>
					<tr>
						<td>Long Service</td>
						<td><span id="sprytextfield4"><input type="text" name="long_service" id="long_service" /><span class="textfieldRequiredMsg"> </span></span></td>
					</tr>
					<tr>
						<td>Tax</td>
						<td><span id="sprytextfield5"><input type="text" name="tax" id="tax" /></span></td>
					</tr>
				</table>
				<div style="margin-top:8px;text-align:right;"><input class="btn" type="submit" name="submit" id="submit" value="Submit" onclick="proceed()"/></div>
			</div>
		</form>
	</aside>
	<main class="main">
		<div class="cards">
			<div class="card">
				<h3>Staff Overview</h3>
				<table>
					<?php while ($rows = mysqli_fetch_array($run2)) {?>
					<tr>
						<td>No of Registered Staffs</td>
						<td><?php echo $rows['count(*)']; ?></td>
					</tr>
					<?php }?>
					<?php  while($rowsb = mysqli_fetch_array($run3)) {?>
					<tr>
						<td><?php echo $rowsb['sex']; ?></td>
						<td><?php echo $rowsb['count(*)']; ?></td>
					</tr>
					<?php }?>
				</table>
			</div>
			<div class="card">
				<h3>Staff by Position</h3>
				<table>
					<tr>
						<th>Position</th>
						<th>Number of Staffs</th>
					</tr>
					<?php  while($rb = mysqli_fetch_array($run4)) {?>
					<tr>
						<td><a href="position.php?position=<?php echo $rb['position'];?>"> <?php echo $rb['position'];?></a></td>
						<td><?php echo $rb['count(*)']; ?>&nbsp;</td>
					</tr>
					<?php }?>
				</table>
			</div>
			<div class="card">
				<h3>Staff by Department</h3>
				<table>
					<tr>
						<th>Department</th>
						<th>Number of Staffs</th>
					</tr>
					<?php  while($r = mysqli_fetch_array($run5)) {?>
					<tr>
						<td><a href="department.php?department=<?php echo $r['department']; ?>"> <?php echo $r['department'];?></a></td>
						<td><?php echo $r['count(*)']; ?></td>
					</tr>
					<?php }?>
				</table>
			</div>
		</div>

		<table class="data-table">
			<tr>
				<th>No of Salaries Paid</th>
				<th>Sum of Basic Salary</th>
				<th>Meal</th>
				<th>Housing</th>
				<th>Transport</th>
				<th>Entertainment</th>
				<th>Long Service</th>
				<th>Tax</th>
				<th>Total</th>
				<th>Month</th>
			</tr>
			<?php while ($row = mysqli_fetch_array($run)) {?>
			<tr>
				<td><?php echo $row['count(*)']; ?></td>
				<td>N<?php echo round($row['sum(basic)']); ?></td>
				<td>N<?php echo round($row['sum(meal)']); ?></td>
				<td>N<?php echo round($row['sum(housing)']); ?></td>
				<td>N<?php echo round($row['sum(transport)']); ?></td>
				<td>N<?php echo round($row['sum(entertainment)']); ?></td>
				<td>N<?php echo round($row['sum(long_service)']); ?></td>
				<td>N<?php echo round($row['sum(tax)']); ?></td>
				<td>N<?php echo round($row['sum(totall)']); ?></td>
				<td><a href="view_month.php?month=<?php echo $row['monthname(date_s)'];?>"><?php echo $row['monthname(date_s)'];?></a></td>
			</tr>
			<?php }?>
		</table>
	</main>
</div>

<div class="footerbar">&copy; <?php echo date('Y'); ?> Payroll System</div>

</div>
<script>
	document.addEventListener("DOMContentLoaded", function() {
	const toggleBtn = document.getElementById('sidebarToggle');
	const layoutEl = document.getElementById('layout');
	const sidebar = document.querySelector('.sidebar');

	if (toggleBtn && layoutEl) {
		toggleBtn.addEventListener('click', function(e) {
		e.stopPropagation();
		layoutEl.classList.toggle('sidebar-visible');
		});
		layoutEl.addEventListener('click', function(e) {
		if (layoutEl.classList.contains('sidebar-visible') && !sidebar.contains(e.target)) {
			layoutEl.classList.remove('sidebar-visible');
		}
		});
		sidebar.addEventListener('click', e => e.stopPropagation());
	}
	});
</script>

</body>
</html>