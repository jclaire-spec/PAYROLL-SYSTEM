<?php
session_start();
if (!isset($_SESSION['username'])) 
{
die(header('Location: ../index.php'));
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Calculate Payroll</title>
<link rel="stylesheet" href="../css/style.css?v=20251009" type="text/css" />
<style>
.layout {
	position: relative;
}

.sidebar {
	position: fixed;
	left: -280px;
	top: 70px;
	width: 240px;
	height: calc(48vh - 70px);
	overflow-y: auto;
	z-index: 999;
	opacity: 0;
	pointer-events: none;
	transition: all 0.3s ease;
	background: #f5f1e8;
	border: 1.5px solid #d4c4a8;
	border-radius: 16px;
	box-shadow: 0 8px 24px rgba(0,0,0,.15);
	padding: 16px;
	margin: 16px 0 0 16px;
}

.btn-payroll {
	background: #e8dcc8;
	color: #1a3a4d;
	border: 1px solid #d4c4a8;
  	justify-content: center;
}

.btn-payroll:hover {
	background: #d4c4a8;
	border-color: #c4b198;
}

/* Payroll info section */
.payroll-info {
	margin: 24px 0;
}

.info-card {
	background: #ffffff;
	border: 1.5px solid #d4c4a8;
	border-radius: 12px;
	padding: 24px;
	box-shadow: 0 4px 12px rgba(0,0,0,.08);
}

.info-card h3 {
	color: #1a3a4d;
	font-size: 18px;
	font-weight: 600;
	margin: 0 0 16px 0;
	display: flex;
	align-items: center;
	gap: 8px;
  text-align: center;
}

.info-card ul {
	margin: 0;
	padding-left: 20px;
	color: #1a3a4d;
}

.info-card li {
	margin-bottom: 10px;
	line-height: 1.6;
	font-size: 14px;
}

.info-card li:last-child {
	margin-bottom: 0;
}
</style>
</head>

<body>
<div class="app-shell">

	<div class="headerbar">
		<div class="brand-wrap">
			<button class="hamburger" id="sidebarToggle" aria-label="Toggle sidebar">
				<span></span><span></span><span></span>
			</button>
			<div class="brand">Payroll Admin</div>
		</div>
		<div class="user-profile">
			<div class="avatar">D</div>
		</div>
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
		</aside>

		<main class="main">
			<div class="page-header">
				<h2>Calculate Payroll</h2>
				<p>Process payroll for staff members</p>
			</div>

			<div class="table-wrapper">
				<?php
				//database connection
				include('connection.php');

				//view record
				$qry = mysqli_query($conn, "SELECT * FROM register_staff ORDER BY fname ASC");
				?>
				
				<table class="data-table staff-table">
					<thead>
						<tr>
							<th>Staff ID</th>
							<th>Full Name</th>
							<th>Sex</th>
							<th>Birthday</th>
							<th>Department</th>
							<th>Position</th>
							<th>Grade</th>
							<th>Years</th>
							<th>Date Employed</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (mysqli_num_rows($qry) > 0) {
							while ($row = mysqli_fetch_array($qry)) {
								echo "<tr>";
								echo "<td><strong>" . htmlspecialchars($row['staff_id']) . "</strong></td>";
								echo "<td>" . htmlspecialchars($row['fname']) . "</td>";
								echo "<td>" . htmlspecialchars($row['sex']) . "</td>";
								echo "<td>" . htmlspecialchars($row['birthday']) . "</td>";
								echo "<td>" . htmlspecialchars($row['department']) . "</td>";
								echo "<td>" . htmlspecialchars($row['position']) . "</td>";
								echo "<td>" . htmlspecialchars($row['grade']) . "</td>";
								echo "<td>" . htmlspecialchars($row['years']) . " years</td>";
								echo "<td>" . htmlspecialchars($row['date_registered']) . "</td>";
								echo "<td class='action-buttons'>";
								echo "<a href='pay.php?id=" . $row['staff_id'] . "' class='action-btn btn-payroll'>Calculate Payroll</a>";
								echo "</td>";
								echo "</tr>";
							}
						} else {
							echo "<tr><td colspan='10' style='text-align:center; padding:20px; color:#5a6b75;'>No staff members found</td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>

			<div class="payroll-info">
				<div class="info-card">
					<h3>Payroll Instructions</h3>
					<ul>
						<li>Click "Calculate Payroll" to process salary for a staff member</li>
						<li>Review staff information before processing</li>
						<li>Ensure all payment variables are up to date</li>
						<li>Generate salary slip after calculation</li>
					</ul>
				</div>
			</div>

			<div class="quick-actions">
				<a href="index.php" class="btn btn-secondary">
					<span>← Go Home</span>
				</a>
			</div>
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