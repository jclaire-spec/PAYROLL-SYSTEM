<?php
session_start();
if (!isset($_SESSION['username'])) {
    die(header('Location: ../index.php'));
}

// database connection
include('connection.php');
include('../sanitise.php');

$message = "";

// If form is submitted (update process)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $staff_id = sanitise($_POST['staff_id']);
    $fname = sanitise($_POST['fname']);
    $department = sanitise($_POST['department']);
    $position = sanitise($_POST['position']);
    $years = sanitise($_POST['years']);
    $grade = sanitise($_POST['grade']);

    $qry = "UPDATE register_staff 
            SET fname = '$fname', department = '$department', position = '$position', 
                years = '$years', grade = '$grade' 
            WHERE staff_id = '$staff_id'";
    $run = mysqli_query($conn, $qry);

    if ($run) {
        $message = "<div style='text-align:center; padding:10px; color:#155724; background:#d4edda; border-radius:8px; margin-bottom:20px;'>
                        ✅ Staff <strong>$fname</strong> has been successfully updated.
                        <br><a href='view_staff.php' style='color:#155724; text-decoration:underline;'>Back to Staff List</a>
                    </div>";
    } else {
        $message = "<div style='text-align:center; padding:10px; color:#721c24; background:#f8d7da; border-radius:8px; margin-bottom:20px;'>
                        ❌ Update failed: " . htmlspecialchars(mysqli_error($conn)) . "
                    </div>";
    }
}

// If accessed via GET, fetch existing data for editing
if (isset($_GET['staff_id'])) {
    $staff_id = sanitise($_GET['staff_id']);
    $qry = "SELECT * FROM register_staff WHERE staff_id = '$staff_id'";
    $update = mysqli_query($conn, $qry);
    $row_update = mysqli_fetch_assoc($update);
    $totalRows_update = mysqli_num_rows($update);
} else {
    $totalRows_update = 0;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Staff Info</title>
<style>
body, html {
	margin: 0;
	padding: 0;
	font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
	font-size: 14px;
	background: linear-gradient(135deg, #2c5f7d 0%, #1a3a4d 100%);
	min-height: 80vh;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 20px;
}

.update-container {
	background: #f5f1e8;
	border-radius: 20px;
	box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
	padding: 30px;
	width: 600px;
	max-width: 100%;
	border: none;
  margin-top: 20px;
}

.update-header {
	text-align: center;
	margin-bottom: 32px;
	padding-bottom: 20px;
	border-bottom: 2px solid #d4c4a8;
}

.update-header h1 {
	color: #1a3a4d;
	margin: 0 0 8px 0;
	font-size: 28px;
	font-weight: 600;
	letter-spacing: -0.5px;
}

.update-header p {
	color: #5a6b75;
	margin: 0;
	font-size: 15px;
}

.form-group {
	margin-bottom: 20px;
}

.form-group label {
	display: block;
	margin-bottom: 8px;
	color: #1a3a4d;
	font-weight: 500;
	font-size: 14px;
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
	margin-top: 32px;
	padding-top: 20px;
	border-top: 1px solid #d4c4a8;
}

.btn {
	padding: 12px 32px;
	border-radius: 10px;
	font-size: 15px;
	font-weight: 600;
	cursor: pointer;
	transition: all 0.2s ease;
	text-decoration: none;
	display: inline-block;
	text-align: center;
}

.btn-primary {
	background: #2c5f7d;
	color: white;
	border: none;
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

@media (max-width: 768px) {
	.update-container {
		padding: 24px;
		width: 100%;
	}
	
	.update-header h1 {
		font-size: 24px;
	}
	
	.form-actions {
		flex-direction: column;
	}
	
	.btn {
		width: 100%;
	}
}
</style>
</head>

<body>
<div class="update-container">
	<div class="update-header">
		<h1>Update Staff Information</h1>
		<p>Modify staff member details</p>
	</div>

	<!-- ✅ Display message after update -->
	<?php if (!empty($message)) echo $message; ?>

	<?php if ($totalRows_update > 0) { ?>
	<form method="post" action="">
		<div class="form-group">
			<label for="staff_id">Staff ID</label>
			<input type="text" name="staff_id" id="staff_id" value="<?php echo htmlspecialchars($row_update['staff_id']); ?>" readonly>
		</div>

		<div class="form-group">
			<label for="fname">Full Name *</label>
			<input type="text" name="fname" id="fname" value="<?php echo htmlspecialchars($row_update['fname']); ?>" required>
		</div>

		<div class="form-group">
			<label for="department">Department *</label>
			<input type="text" name="department" id="department" value="<?php echo htmlspecialchars($row_update['department']); ?>" required>
		</div>

		<div class="form-group">
			<label for="position">Position *</label>
			<input type="text" name="position" id="position" value="<?php echo htmlspecialchars($row_update['position']); ?>" required>
		</div>

		<div class="form-group">
			<label for="years">Years Spent *</label>
			<input type="number" name="years" id="years" value="<?php echo htmlspecialchars($row_update['years']); ?>" min="0" max="50" required>
		</div>

		<div class="form-group">
			<label for="grade">Grade Level *</label>
			<input type="number" name="grade" id="grade" value="<?php echo htmlspecialchars($row_update['grade']); ?>" min="1" max="20" required>
		</div>

		<div class="form-actions">
			<a href="view_staff.php" class="btn btn-secondary">Cancel</a>
			<button type="submit" class="btn btn-primary">Update Staff</button>
		</div>
	</form>
	<?php } else { ?>
	<div style="text-align:center; padding:20px; color:#8b5a2b; background:#fef3e8; border-radius:10px; margin-bottom:20px;">
		Staff member not found.
	</div>
	<div class="form-actions">
		<a href="view_staff.php" class="btn btn-secondary" style="width:100%;">Back to Staff List</a>
	</div>
	<?php } ?>
</div>
</body>
</html>