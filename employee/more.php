<?php
include('../admin/connection.php');
include('../sanitise.php');
session_start();
if (!isset($_SESSION['staff_id'])) 
{
die(header('Location: ../index.php'));
}

$staff_id = $_SESSION['staff_id'];
$mess = sanitise($_GET['id']);
$qry = mysqli_query($conn, "SELECT * FROM staff_inbox WHERE id = '$mess'");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Read Message</title>
<link rel="stylesheet" href="../css/staff.css?v=20251009" type="text/css" />
<style>
/* Read message specific styles */
.message-view-card {
	background: #ffffff;
	border: 1.5px solid #d4c4a8;
	border-radius: 12px;
	box-shadow: 0 4px 12px rgba(0,0,0,.08);
	overflow: hidden;
	margin-bottom: 24px;
}

.message-header-bar {
	background: linear-gradient(135deg, #2c5f7d 0%, #1a3a4d 100%);
	color: #ffffff;
	padding: 20px 24px;
	border-bottom: 2px solid #d4c4a8;
}

.message-header-bar h3 {
	margin: 0;
	font-size: 20px;
	font-weight: 600;
	display: flex;
	align-items: center;
	gap: 10px;
}

.message-details {
	background: #f9f7f4;
	padding: 20px 24px;
	border-bottom: 1px solid #e8dcc8;
}

.message-detail-row {
	display: grid;
	grid-template-columns: 140px 1fr;
	gap: 16px;
	margin-bottom: 12px;
	align-items: start;
}

.message-detail-row:last-child {
	margin-bottom: 0;
}

.message-detail-label {
	font-weight: 600;
	color: #5a6b75;
	font-size: 13px;
	text-transform: uppercase;
	letter-spacing: 0.5px;
}

.message-detail-value {
	color: #1a3a4d;
	font-size: 14px;
	font-weight: 500;
}

.message-subject {
	font-size: 16px;
	font-weight: 600;
	color: #1a3a4d;
}

.message-body-section {
	padding: 24px;
}

.message-body-label {
	font-weight: 600;
	color: #5a6b75;
	font-size: 13px;
	text-transform: uppercase;
	letter-spacing: 0.5px;
	margin-bottom: 12px;
	display: block;
}

.message-content {
	color: #1a3a4d;
	font-size: 14px;
	line-height: 1.8;
	padding: 16px;
	background: #f9f7f4;
	border-radius: 8px;
	border-left: 4px solid #2c5f7d;
}

.message-actions-bar {
	padding: 20px 24px;
	background: #f9f7f4;
	border-top: 1px solid #e8dcc8;
	display: flex;
	gap: 12px;
	justify-content: flex-end;
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

.btn-delete {
	padding: 10px 24px;
	background: #fef3e8;
	color: #8b5a2b;
	text-decoration: none;
	border-radius: 8px;
	font-weight: 500;
	font-size: 14px;
	transition: all 0.2s ease;
	border: 1.5px solid #e8c89f;
	display: inline-block;
}

.btn-delete:hover {
	background: #e8c89f;
	color: #6b4521;
}

.message-not-found {
	text-align: center;
	padding: 40px 20px;
	color: #8b5a2b;
	background: #fef3e8;
	border-radius: 10px;
	margin-bottom: 20px;
}

.page-title {
	color: #f9f7f4;
	font-size: 24px;
	font-weight: 600;
	margin: 0 0 20px 0;
	padding-bottom: 16px;
	border-bottom: 2px solid #d4c4a8;
}

@media (max-width: 768px) {
	.message-detail-row {
		grid-template-columns: 1fr;
		gap: 6px;
	}
	
	.message-actions-bar {
		flex-direction: column;
	}
	
	.btn-back,
	.btn-delete {
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
	<h2 class="page-title">📧 Read Message</h2>

	<?php 
	if (mysqli_num_rows($qry) > 0) {
		$tbl = mysqli_fetch_array($qry);
	?>
	<div class="message-view-card">
		<div class="message-header-bar">
			<h3>
				<span>📨</span>
				<span>Received Message</span>
			</h3>
		</div>

		<div class="message-details">
			<div class="message-detail-row">
				<div class="message-detail-label">Received Date</div>
				<div class="message-detail-value">
					<?php echo date('F d, Y \a\t g:i A', strtotime($tbl['received_date'])); ?>
				</div>
			</div>

			<div class="message-detail-row">
				<div class="message-detail-label">From</div>
				<div class="message-detail-value">
					<?php echo htmlspecialchars($tbl['sender']); ?>
				</div>
			</div>

			<div class="message-detail-row">
				<div class="message-detail-label">Subject</div>
				<div class="message-detail-value message-subject">
					<?php echo htmlspecialchars($tbl['msg_subject']); ?>
				</div>
			</div>
		</div>

		<div class="message-body-section">
			<span class="message-body-label">Message Content</span>
			<div class="message-content">
				<?php echo nl2br(htmlspecialchars($tbl['msg_msg'])); ?>
			</div>
		</div>

		<div class="message-actions-bar">
			<a href="inbox.php" class="btn-back">← Back to Inbox</a>
			<a href="inboxdelete.php?id=<?php echo $mess; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this message?')">🗑️ Delete Message</a>
		</div>
	</div>
	<?php } else { ?>
	<div class="message-not-found">
		<h3>⚠️ Message Not Found</h3>
		<p>The requested message could not be found.</p>
	</div>
	<div class="message-actions-bar">
		<a href="inbox.php" class="btn-back" style="width: 100%; text-align: center;">← Back to Inbox</a>
	</div>
	<?php } ?>
</div>
</div>

</body>
</html>