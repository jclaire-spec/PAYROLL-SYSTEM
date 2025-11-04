<?php
session_start();
if (!isset($_SESSION['username'])) 
{
die(header('Location: ../index.php'));
}

//database connection
include('connection.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Print PaySlip</title>
<link rel="stylesheet" href="../css/style.css?v=20251009" type="text/css" />
<style>
.payslip-table-wrapper {
	background: #ffffff;
	border-radius: 12px;
	overflow: hidden;
	box-shadow: 0 4px 12px rgba(0,0,0,.08);
	margin-bottom: 24px;
}

.payslip-data-table {
	width: 100%; 
	border-collapse: collapse; 
	margin: 0;
	box-shadow: none;
	border-radius: 0;
	border: none;
	text-align: center;
}

.payslip-data-table th {
	background: #e8dcc8; 
	font-weight: 600;
	color: #1a3a4d;
	font-size: 12px;
	padding: 12px 8px;
	text-align: left;
	white-space: nowrap;
	text-align: center;
}

.payslip-data-table th, .payslip-data-table td {
  border: 1px solid #d4c4a8;
  padding: 8px 10px;
  text-align: center;
}

.payslip-data-table td {
	padding: 10px 8px;
	font-size: 12px;
	color: #1a3a4d;
}

.payslip-data-table tbody tr:hover {
	background-color: #f9f7f4;
}

.payslip-data-table tbody tr:last-child td {
	border-bottom: none;
}

.payslip-data-table td.amount {
	text-align: right;
	font-family: 'Courier New', monospace;
	font-weight: 500;
	color: #2c5f7d;
}

.payslip-data-table td.tax {
	color: #8b5a2b;
}

.payslip-data-table td.total {
	background: #e8f2f7;
	color: #1a3a4d;
	font-weight: 600;
}

/* Summary cards - specific to this page */
.payslip-summary-cards {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 20px;
	margin-bottom: 24px;
}

.payslip-summary-card {
	background: #ffffff;
	border: 1.5px solid #d4c4a8;
	border-radius: 12px;
	padding: 20px;
	text-align: center;
	box-shadow: 0 4px 12px rgba(0,0,0,.08);
	transition: all 0.2s ease;
}

.payslip-summary-card:hover {
	transform: translateY(-2px);
	box-shadow: 0 6px 16px rgba(0,0,0,.12);
}

.payslip-summary-card h3 {
	color: #5a6b75;
	font-size: 13px;
	font-weight: 500;
	margin: 0 0 12px 0;
	text-transform: uppercase;
	letter-spacing: 0.5px;
}

.payslip-summary-value {
	color: #2c5f7d;
	font-size: 28px;
	font-weight: 700;
	margin: 0;
	letter-spacing: -0.5px;
}

/* Responsive */
@media (max-width: 900px) {
	.payslip-summary-cards {
		grid-template-columns: 1fr;
	}
}

@media (max-width: 768px) {
	.payslip-table-wrapper {
		overflow-x: auto;
	}
	
	.payslip-data-table {
		min-width: 1200px;
	}
	
	.payslip-summary-cards {
		grid-template-columns: 1fr;
	}
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
				<h2>Print PaySlip</h2>
				<p>View and print salary slips for all staff members</p>
			</div>

			<div class="payslip-table-wrapper">
				<?php
				//view record
				$qry = mysqli_query($conn, "SELECT * FROM salary ORDER BY date_s DESC, fname ASC");
				?>
				
				<table class="payslip-data-table">
					<thead>
						<tr>
							<th>SID</th>
							<th>Staff ID</th>
							<th>Full Name</th>
							<th>Dept</th>
							<th>Position</th>
							<th>Grade</th>
							<th>Years</th>
							<th>Basic</th>
							<th>Meal</th>
							<th>Housing</th>
							<th>Transport</th>
							<th>Ent.</th>
							<th>L/S</th>
							<th>Tax</th>
							<th>Total</th>
							<th>Date</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (mysqli_num_rows($qry) > 0) {
							while ($row = mysqli_fetch_array($qry)) {
								echo "<tr>";
								echo "<td>" . htmlspecialchars($row['salary_id']) . "</td>";
								echo "<td><strong>" . htmlspecialchars($row['staff_id']) . "</strong></td>";
								echo "<td>" . htmlspecialchars($row['fname']) . "</td>";
								echo "<td>" . htmlspecialchars($row['department']) . "</td>";
								echo "<td>" . htmlspecialchars($row['position']) . "</td>";
								echo "<td>" . htmlspecialchars($row['grade']) . "</td>";
								echo "<td>" . htmlspecialchars($row['years']) . "</td>";
								echo "<td class='amount'>₦" . number_format(round($row['basic']), 0) . "</td>";
								echo "<td class='amount'>₦" . number_format(round($row['meal']), 0) . "</td>";
								echo "<td class='amount'>₦" . number_format(round($row['housing']), 0) . "</td>";
								echo "<td class='amount'>₦" . number_format(round($row['transport']), 0) . "</td>";
								echo "<td class='amount'>₦" . number_format(round($row['entertainment']), 0) . "</td>";
								echo "<td class='amount'>₦" . number_format(round($row['long_service']), 0) . "</td>";
								echo "<td class='amount tax'>₦" . number_format(round($row['tax']), 0) . "</td>";
								echo "<td class='amount total'><strong>₦" . number_format(round($row['totall']), 0) . "</strong></td>";
								echo "<td>" . date('M d, Y', strtotime($row['date_s'])) . "</td>";
								echo "<td class='action-buttons'>";
								echo "<a href='payslip.php?staff_id=" . $row['staff_id'] . "&salary_id=" . $row['salary_id'] . "' class='action-btn btn-print' target='_blank'>Print</a>";
								echo "<a href='salary_delete.php?salary_id=" . $row['salary_id'] . "&staff_id=" . $row['staff_id'] . "' class='action-btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this salary record?\")'>Delete</a>";
								echo "</td>";
								echo "</tr>";
							}
						} else {
							echo "<tr><td colspan='17' style='text-align:center; padding:20px; color:#5a6b75;'>No salary records found</td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>

			<div class="payslip-summary-cards">
				<?php
				// Calculate summary statistics
				$qry_summary = mysqli_query($conn, "SELECT 
					COUNT(*) as total_records,
					SUM(totall) as total_salary,
					AVG(totall) as avg_salary
					FROM salary");
				$summary = mysqli_fetch_assoc($qry_summary);
				?>
				<div class="payslip-summary-card">
					<h3>Total Records</h3>
					<p class="payslip-summary-value"><?php echo number_format($summary['total_records']); ?></p>
				</div>
				<div class="payslip-summary-card">
					<h3>Total Salary Paid</h3>
					<p class="payslip-summary-value">₦<?php echo number_format(round($summary['total_salary']), 0); ?></p>
				</div>
				<div class="payslip-summary-card">
					<h3>Average Salary</h3>
					<p class="payslip-summary-value">₦<?php echo number_format(round($summary['avg_salary']), 0); ?></p>
				</div>
			</div>

			<div class="quick-actions">
				<a href="index.php" class="btn btn-secondary">
					<span>← Go Home</span>
				</a>
				<a href="payroll.php" class="btn btn-primary">
					<span>Calculate New Payroll</span>
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