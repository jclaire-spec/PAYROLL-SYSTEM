<?php
include('../admin/connection.php');
session_start();
if (!isset($_SESSION['staff_id'])) 
{
die(header('Location: ../index.php'));
}

$staff_id = $_SESSION['staff_id'];
$qry = mysqli_query($conn, "SELECT * FROM register_staff WHERE staff_id = '$staff_id'");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profile</title>
<link rel="stylesheet" href="../css/staff.css?v=20251009" type="text/css" />
<style>
/* Profile specific styles */
.profile-container {
	max-width: 600px;
	margin: 0 auto;
}

.profile-card {
	background: #ffffff;
	border: 1.5px solid #d4c4a8;
	border-radius: 12px;
	box-shadow: 0 4px 12px rgba(0,0,0,.08);
	overflow: hidden;
	margin-bottom: 24px;
}

.profile-header {
	background: linear-gradient(135deg, #2c5f7d 0%, #1a3a4d 100%);
	color: #ffffff;
	padding: 24px;
	text-align: center;
}

.profile-header h2 {
	margin: 0;
	font-size: 24px;
	font-weight: 600;
	display: flex;
	align-items: center;
	justify-content: center;
	gap: 10px;
}

.profile-avatar {
	width: 80px;
	height: 80px;
	border-radius: 50%;
	background: #e8dcc8;
	margin: 0 auto 16px;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 36px;
	font-weight: 700;
	color: #2c5f7d;
	border: 4px solid rgba(255,255,255,0.3);
}

.profile-info {
	padding: 24px;
}

.profile-row {
	display: grid;
	grid-template-columns: 160px 1fr;
	gap: 16px;
	padding: 14px 0;
	border-bottom: 1px solid #e8dcc8;
	align-items: center;
}

.profile-row:last-child {
	border-bottom: none;
}

.profile-label {
	font-weight: 600;
	color: #5a6b75;
	font-size: 13px;
	text-transform: uppercase;
	letter-spacing: 0.5px;
}

.profile-value {
	color: #1a3a4d;
	font-size: 15px;
	font-weight: 500;
}

.profile-value.highlight {
	color: #2c5f7d;
	font-weight: 600;
	font-size: 16px;
}

.profile-actions {
	padding: 20px 24px;
	background: #f9f7f4;
	border-top: 1px solid #e8dcc8;
	display: flex;
	gap: 12px;
	justify-content: center;
}

.btn-back {
	padding: 10px 24px;
	background: #e8dcc8;
	color: #1a3a4d;
	text-decoration: none;
	border-radius: 8px;
	font-weight: 500;
	font-size: 14px;
	transition: all 0.2s ease;
	border: 1.5px solid #d4c4a8;
	display: inline-block;
}

.btn-back:hover {
	background: #d4c4a8;
	border-color: #c4b198;
}

.btn-edit {
	padding: 10px 24px;
	background: #2c5f7d;
	color: #ffffff;
	text-decoration: none;
	border-radius: 8px;
	font-weight: 500;
	font-size: 14px;
	transition: all 0.2s ease;
	border: 1.5px solid #2c5f7d;
	display: inline-block;
}

.btn-edit:hover {
	background: #1a3a4d;
	transform: translateY(-1px);
	box-shadow: 0 4px 12px rgba(44, 95, 125, 0.4);
}

.page-title {
	color: #1a3a4d;
	font-size: 24px;
	font-weight: 600;
	margin: 0 0 20px 0;
	padding-bottom: 16px;
	border-bottom: 2px solid #d4c4a8;
	text-align: center;
}

@media (max-width: 768px) {
	.profile-row {
		grid-template-columns: 1fr;
		gap: 6px;
	}
	
	.profile-actions {
		flex-direction: column;
	}
	
	.btn-back,
	.btn-edit {
		width: 100%;
		text-align: center;
	}
}
</style>
<script src="../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="outerwrapper">
<div id="header"><img src="../images/staffhead.jpg" alt="Staff Header" /></div>
<div id="links">
  <?php include('link.php'); ?>
</div>
<div id="body">
	<h2 class="page-title">👤 My Profile</h2>
	
	<div class="profile-container">
		<?php 
		if (mysqli_num_rows($qry) > 0) {
			$tbl = mysqli_fetch_array($qry);
			// Get first letter of name for avatar
			$initial = strtoupper(substr($tbl['fname'], 0, 1));
		?>
		<div class="profile-card">
			<div class="profile-header">
				<div class="profile-avatar"><?php echo $initial; ?></div>
				<h2><?php echo htmlspecialchars($tbl['fname']); ?></h2>
			</div>

			<div class="profile-info">
				<div class="profile-row">
					<div class="profile-label">Staff ID</div>
					<div class="profile-value highlight"><?php echo htmlspecialchars($tbl['staff_id']); ?></div>
				</div>

				<div class="profile-row">
					<div class="profile-label">Full Name</div>
					<div class="profile-value"><?php echo htmlspecialchars($tbl['fname']); ?></div>
				</div>

				<div class="profile-row">
					<div class="profile-label">Gender</div>
					<div class="profile-value"><?php echo htmlspecialchars($tbl['sex']); ?></div>
				</div>

				<div class="profile-row">
					<div class="profile-label">Date of Birth</div>
					<div class="profile-value"><?php echo date('F d, Y', strtotime($tbl['birthday'])); ?></div>
				</div>

				<div class="profile-row">
					<div class="profile-label">Position</div>
					<div class="profile-value"><?php echo htmlspecialchars($tbl['position']); ?></div>
				</div>

				<div class="profile-row">
					<div class="profile-label">Department</div>
					<div class="profile-value"><?php echo htmlspecialchars($tbl['department']); ?></div>
				</div>

				<div class="profile-row">
					<div class="profile-label">Grade Level</div>
					<div class="profile-value"><?php echo htmlspecialchars($tbl['grade']); ?></div>
				</div>

				<div class="profile-row">
					<div class="profile-label">Years of Service</div>
					<div class="profile-value"><?php echo htmlspecialchars($tbl['years']); ?> years</div>
				</div>

				<div class="profile-row">
					<div class="profile-label">Date Joined</div>
					<div class="profile-value"><?php echo date('F d, Y', strtotime($tbl['date_registered'])); ?></div>
				</div>
			</div>

			<div class="profile-actions">
				<a href="index.php" class="btn-back">← Back to Home</a>
				<a href="resetpassword.php" class="btn-edit">🔒 Change Password</a>
			</div>
		</div>
		<?php } else { ?>
		<div class="profile-card">
			<div class="profile-info" style="text-align:center; padding:40px 20px; color:#5a6b75;">
				<p><strong>Profile not found</strong></p>
				<p>Unable to load your profile information.</p>
			</div>
			<div class="profile-actions">
				<a href="index.php" class="btn-back" style="width:100%; text-align:center;">← Back to Home</a>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
</div>

</body>
</html>