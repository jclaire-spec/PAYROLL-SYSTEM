<?php
session_start();
if (!isset($_SESSION['username'])) 
{
die(header('Location: ../index.php'));
}

//database connection
include('connection.php');
include('../sanitise.php');
$staff_id = sanitise($_GET['id']);
$qry = "SELECT * FROM register_staff WHERE staff_id = '$staff_id'";
$update = mysqli_query($conn, $qry) or die(mysqli_error($conn));
$row_update = mysqli_fetch_assoc($update);
$totalRows_update = mysqli_num_rows($update);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Calculate Salary</title>
<style>
body, html {
	margin: 0;
	padding: 0;
	font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
	font-size: 14px;
	background: linear-gradient(135deg, #2c5f7d 0%, #1a3a4d 100%);
	min-height: 100vh;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 20px;
}

.salary-container {
	background: #f5f1e8;
	border-radius: 20px;
	box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
	padding: 40px;
	width: 700px;
	max-width: 100%;
	border: none;
}

.salary-header {
	text-align: center;
	margin-bottom: 32px;
	padding-bottom: 20px;
	border-bottom: 2px solid #d4c4a8;
}

.salary-header h1 {
	color: #1a3a4d;
	margin: 0 0 8px 0;
	font-size: 28px;
	font-weight: 600;
	letter-spacing: -0.5px;
}

.salary-header p {
	color: #5a6b75;
	margin: 0;
	font-size: 15px;
}

.form-section {
	background: #ffffff;
	border: 1.5px solid #d4c4a8;
	border-radius: 12px;
	padding: 24px;
	margin-bottom: 20px;
}

.form-section h3 {
	color: #1a3a4d;
	font-size: 16px;
	font-weight: 600;
	margin: 0 0 20px 0;
	padding-bottom: 12px;
	border-bottom: 1px solid #e8dcc8;
}

.form-grid {
	display: grid;
	grid-template-columns: 1fr;
	gap: 16px;
}

.form-group {
	display: grid;
	grid-template-columns: 200px 1fr;
	gap: 16px;
	align-items: center;
}

.form-group label {
	color: #1a3a4d;
	font-weight: 500;
	font-size: 14px;
	text-align: right;
}

.form-group input[type="text"],
.form-group input[type="number"] {
	width: 100%;
	padding: 12px 14px;
	border: 1.5px solid #d4c4a8;
	border-radius: 10px;
	font-size: 14px;
	transition: all 0.2s ease;
	box-sizing: border-box;
	background: #ffffff;
	font-family: inherit;
}

.form-group input[readonly] {
	background: #e8dcc8;
	cursor: not-allowed;
	color: #5a6b75;
	font-weight: 500;
}

.form-group input:focus:not([readonly]) {
	outline: none;
	border-color: #2c5f7d;
	box-shadow: 0 0 0 3px rgba(44, 95, 125, 0.1);
}

.form-actions {
	display: flex;
	gap: 12px;
	justify-content: flex-end;
	margin-top: 24px;
}

.btn {
	padding: 14px 32px;
	border-radius: 10px;
	font-size: 15px;
	font-weight: 600;
	cursor: pointer;
	transition: all 0.2s ease;
	text-decoration: none;
	display: inline-block;
	text-align: center;
	border: none;
}

.btn-primary {
	background: #2c5f7d;
	color: white;
}

.btn-primary:hover {
	background: #1a3a4d;
	transform: translateY(-1px);
	box-shadow: 0 4px 12px rgba(44, 95, 125, 0.4);
}

.btn-secondary {
	background: #e8dcc8;
	color: #1a3a4d;
	border: 1.5px solid #d4c4a8;
}

.btn-secondary:hover {
	background: #d4c4a8;
	border-color: #c4b198;
}

.info-box {
	background: #e8f2f7;
	border: 1.5px solid #b3d9f0;
	border-radius: 10px;
	padding: 16px;
	margin-bottom: 20px;
	color: #1a3a4d;
	font-size: 13px;
	line-height: 1.6;
}

.info-box strong {
	color: #2c5f7d;
	display: block;
	margin-bottom: 8px;
	font-size: 14px;
}

@media (max-width: 768px) {
	.salary-container {
		padding: 24px;
		width: 100%;
	}
	
	.salary-header h1 {
		font-size: 24px;
	}
	
	.form-group {
		grid-template-columns: 1fr;
		gap: 8px;
	}
	
	.form-group label {
		text-align: left;
	}
	
	.form-section {
		padding: 16px;
	}
	
	.form-actions {
		flex-direction: column;
	}
	
	.btn {
		width: 100%;
	}
}
</style>
<script type="text/javascript">
 	function proceed() 
	{
	  return confirm('Compute Payroll for this staff member?');
 	}
</script>
</head>

<body>
<div class="salary-container">
	<div class="salary-header">
		<h1>Calculate Salary</h1>
		<p>Process payroll calculation for staff member</p>
	</div>

	<?php if ($totalRows_update > 0) { ?>
	
	<div class="info-box">
		<strong>💡 Instructions:</strong>
		Review staff information below and enter the Basic Salary and Meal Allowance. Other allowances and deductions will be calculated automatically based on system variables.
	</div>

	<form method="post" action="salprocessor2.php">
		<!-- Staff Information Section -->
		<div class="form-section">
			<h3>Staff Information</h3>
			<div class="form-grid">
				<div class="form-group">
					<label for="staff_id">Staff ID:</label>
					<input type="text" name="staff_id" id="staff_id" value="<?php echo htmlspecialchars($row_update['staff_id']); ?>" readonly>
				</div>

				<div class="form-group">
					<label for="fname">Full Name:</label>
					<input type="text" name="fname" id="fname" value="<?php echo htmlspecialchars($row_update['fname']); ?>" readonly>
				</div>

				<div class="form-group">
					<label for="department">Department:</label>
					<input type="text" name="department" id="department" value="<?php echo htmlspecialchars($row_update['department']); ?>" readonly>
				</div>

				<div class="form-group">
					<label for="position">Position:</label>
					<input type="text" name="position" id="position" value="<?php echo htmlspecialchars($row_update['position']); ?>" readonly>
				</div>

				<div class="form-group">
					<label for="years">Years Spent:</label>
					<input type="text" name="years" id="years" value="<?php echo htmlspecialchars($row_update['years']); ?>" readonly>
				</div>

				<div class="form-group">
					<label for="grade">Grade Level:</label>
					<input type="text" name="grade" id="grade" value="<?php echo htmlspecialchars($row_update['grade']); ?>" readonly>
				</div>
			</div>
		</div>

		<!-- Salary Input Section -->
		<div class="form-section">
			<h3>Salary Details</h3>
			<div class="form-grid">
				<div class="form-group">
					<label for="basic">Basic Salary: *</label>
					<input type="number" name="basic" id="basic" step="0.01" min="0" placeholder="Enter basic salary" required>
				</div>

				<div class="form-group">
					<label for="meal">Meal Allowance: *</label>
					<input type="number" name="meal" id="meal" step="0.01" min="0" placeholder="Enter meal allowance" required>
				</div>
			</div>
		</div>

		<div class="form-actions">
			<a href="payroll.php" class="btn btn-secondary">Cancel</a>
			<button type="submit" name="submit" class="btn btn-primary" onclick="return proceed()">Calculate Payroll</button>
		</div>
	</form>

	<?php } else { ?>
	<div style="text-align:center; padding:20px; color:#8b5a2b; background:#fef3e8; border-radius:10px; margin-bottom:20px;">
		Staff member not found.
	</div>
	<div class="form-actions">
		<a href="payroll.php" class="btn btn-secondary" style="width:100%;">Back to Payroll</a>
	</div>
	<?php } ?>
</div>
</body>
</html>