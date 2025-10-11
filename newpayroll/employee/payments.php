<?php
include('../admin/connection.php');
session_start();
if (!isset($_SESSION['staff_id'])) 
{
die(header('Location: ../index.php'));
}

$staff_id = $_SESSION['staff_id'];
$qry = mysqli_query($conn, "SELECT * FROM salary WHERE staff_id = '$staff_id' ORDER BY date_s DESC");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Staff Payments</title>
<link rel="stylesheet" href="../css/staff.css?v=20251009" type="text/css" />
<style>
.payments-table-wrapper {
	background: #ffffff;
	border: 1.5px solid #d4c4a8;
	border-radius: 12px;
	overflow: hidden;
	box-shadow: 0 4px 12px rgba(0,0,0,.08);
	margin-bottom: 24px;
  	width: 98%;
}

.payments-table {
	width: 100%;
	border-collapse: collapse;
	margin: 0;
}

#payments-outerwrapper {
	width: 1800px;
	max-width: 95%;
	margin: 20px auto;
	background: #f5f1e8;
	border-radius: 16px;
	box-shadow: 0 8px 24px rgba(0,0,0,.15);
	overflow: hidden;
}

.payments-table thead tr {
	background: #e8dcc8;
}

.payments-table th {
	padding: 14px 12px;
	text-align: left;
	font-weight: 600;
	color: #1a3a4d;
	font-size: 12px;
	text-transform: uppercase;
	letter-spacing: 0.5px;
	border-bottom: 1px solid #d4c4a8;
	white-space: nowrap;
}

.payments-table td {
	padding: 12px;
	border-bottom: 1px solid #e8dcc8;
	font-size: 13px;
	color: #1a3a4d;
	vertical-align: middle;
}

.payments-table tbody tr:hover {
	background-color: #f9f7f4;
}

.payments-table tbody tr:last-child td {
	border-bottom: none;
}

.payments-table td.date-col {
	font-weight: 500;
	color: #2c5f7d;
	white-space: nowrap;
}

.payments-table td.amount {
	text-align: right;
	font-family: 'Courier New', monospace;
	font-weight: 500;
	color: #2c5f7d;
}

.payments-table td.tax {
	color: #8b5a2b;
}

.payments-table td.total {
	background: #e8f2f7;
	font-weight: 600;
	font-size: 14px;
}

.payments-summary {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 20px;
	margin-bottom: 24px;
  width: 98%;
}

.summary-card {
	background: #ffffff;
	border: 1.5px solid #d4c4a8;
	border-radius: 12px;
	padding: 20px;
	text-align: center;
	box-shadow: 0 4px 12px rgba(0,0,0,.08);
	transition: all 0.2s ease;
}

.summary-card:hover {
	transform: translateY(-2px);
	box-shadow: 0 6px 16px rgba(0,0,0,.12);
}

.summary-card h3 {
	color: #5a6b75;
	font-size: 13px;
	font-weight: 500;
	margin: 0 0 12px 0;
	text-transform: uppercase;
	letter-spacing: 0.5px;
}

.summary-value {
	color: #2c5f7d;
	font-size: 28px;
	font-weight: 700;
	margin: 0;
	letter-spacing: -0.5px;
}

.summary-icon {
	font-size: 24px;
	margin-bottom: 8px;
}

.empty-payments {
	text-align: center;
	padding: 40px 20px;
	color: #5a6b75;
	font-size: 14px;
}

.empty-payments-icon {
	font-size: 48px;
	margin-bottom: 16px;
	opacity: 0.5;
}

.page-title {
	color: #1a3a4d;
	font-size: 24px;
	font-weight: 600;
	margin: 0 0 20px 0;
	padding-bottom: 16px;
	border-bottom: 2px solid #d4c4a8;
}

@media (max-width: 900px) {
	.payments-summary {
		grid-template-columns: 1fr;
	}
}

@media (max-width: 768px) {
	.payments-table-wrapper {
		overflow-x: auto;
	}
	
	.payments-table {
		min-width: 1000px;
	}
	
	.payments-summary {
		grid-template-columns: 1fr;
	}
}
</style>
<script src="../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="payments-outerwrapper">
<div id="header"><img src="../images/staffhead.jpg" alt="Staff Header" /></div>
<div id="links">
  <?php include('link.php'); ?>
</div>
<div id="body">
	<h2 class="page-title">💰 Payment History</h2>

	<?php
	// Calculate payment statistics
	$qry_stats = mysqli_query($conn, "SELECT 
		COUNT(*) as total_payments,
		SUM(totall) as total_earned,
		AVG(totall) as avg_payment
		FROM salary 
		WHERE staff_id = '$staff_id'");
	$stats = mysqli_fetch_assoc($qry_stats);
	?>

	<div class="payments-summary">
		<div class="summary-card">
			<div class="summary-icon">📊</div>
			<h3>Total Payments</h3>
			<p class="summary-value"><?php echo number_format($stats['total_payments']); ?></p>
		</div>
		<div class="summary-card">
			<div class="summary-icon">💵</div>
			<h3>Total Earned</h3>
			<p class="summary-value">₦<?php echo number_format(round($stats['total_earned']), 0); ?></p>
		</div>
		<div class="summary-card">
			<div class="summary-icon">📈</div>
			<h3>Average Payment</h3>
			<p class="summary-value">₦<?php echo number_format(round($stats['avg_payment']), 0); ?></p>
		</div>
	</div>

	<div class="payments-table-wrapper">
		<table class="payments-table">
			<thead>
				<tr>
					<th>Month</th>
					<th>Basic</th>
					<th>Meal</th>
					<th>Housing</th>
					<th>Transport</th>
					<th>Entertainment</th>
					<th>Long Service</th>
					<th>Tax</th>
					<th>Net Pay</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				// Reset query for table display
				$qry = mysqli_query($conn, "SELECT * FROM salary WHERE staff_id = '$staff_id' ORDER BY date_s DESC");
				
				if (mysqli_num_rows($qry) > 0) {
					while ($tbl = mysqli_fetch_array($qry)) { 
				?>
				<tr>
					<td class="date-col"><?php echo date('M Y', strtotime($tbl['date_s'])); ?></td>
					<td class="amount">₦<?php echo number_format(round($tbl['basic']), 0); ?></td>
					<td class="amount">₦<?php echo number_format(round($tbl['meal']), 0); ?></td>
					<td class="amount">₦<?php echo number_format(round($tbl['housing']), 0); ?></td>
					<td class="amount">₦<?php echo number_format(round($tbl['transport']), 0); ?></td>
					<td class="amount">₦<?php echo number_format(round($tbl['entertainment']), 0); ?></td>
					<td class="amount">₦<?php echo number_format(round($tbl['long_service']), 0); ?></td>
					<td class="amount tax">₦<?php echo number_format(round($tbl['tax']), 0); ?></td>
					<td class="amount total">₦<?php echo number_format(round($tbl['totall']), 0); ?></td>
				</tr>
				<?php 
					}
				} else { 
				?>
				<tr>
					<td colspan="9" class="empty-payments">
						<div class="empty-payments-icon">💸</div>
						<p><strong>No payment history found</strong></p>
						<p>You don't have any payment records yet.</p>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
</div>
</body>
</html>