<?php
include('../admin/connection.php');
session_start();
if (!isset($_SESSION['staff_id'])) 
{
die(header('Location: ../index.php'));
}

$staff_id = $_SESSION['staff_id'];
$qry = mysqli_query($conn, "SELECT * FROM staff_outbox WHERE sender = '$staff_id' ORDER BY date_sent DESC");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Outbox</title>
<link rel="stylesheet" href="../css/staff.css?v=20251009" type="text/css" />
<style>
.outbox-actions {
	background: #ffffff;
	border: 1.5px solid #d4c4a8;
	border-radius: 12px;
	padding: 16px;
	margin-bottom: 20px;
  width: 96%;
}

.outbox-actions a {
	display: inline-block;
	padding: 10px 20px;
	background: #e8dcc8;
	color: #1a3a4d;
	text-decoration: none;
	border-radius: 8px;
	font-weight: 500;
	font-size: 14px;
	transition: all 0.2s ease;
	border: 1.5px solid #d4c4a8;
}

.outbox-actions a:hover {
	background: #d4c4a8;
	border-color: #c4b198;
}

#outbox-outerwrapper {
	width: 1800px;
	max-width: 95%;
	margin: 20px auto;
	background: #f5f1e8;
	border-radius: 16px;
	box-shadow: 0 8px 24px rgba(0,0,0,.15);
	overflow: hidden;
}

.outbox-table-wrapper {
	background: #ffffff;
	border: 1.5px solid #d4c4a8;
	border-radius: 12px;
	overflow: hidden;
	box-shadow: 0 4px 12px rgba(0,0,0,.08);
  width: 98%;
}

.outbox-table {
	width: 98%;
	border-collapse: collapse;
	margin: 0;
}

.outbox-table thead tr {
	background: #e8dcc8;
}

.outbox-table th {
	padding: 14px 16px;
	text-align: left;
	font-weight: 600;
	color: #1a3a4d;
	font-size: 13px;
	text-transform: uppercase;
	letter-spacing: 0.5px;
	border-bottom: 1px solid #d4c4a8;
}

.outbox-table td {
	padding: 14px 16px;
	border-bottom: 1px solid #e8dcc8;
	font-size: 14px;
	color: #1a3a4d;
	vertical-align: middle;
}

.outbox-table tbody tr:hover {
	background-color: #f9f7f4;
}

.outbox-table tbody tr:last-child td {
	border-bottom: none;
}

.outbox-table td.recipient-col {
	font-weight: 500;
	color: #2c5f7d;
}

.outbox-table td.subject-col {
	font-weight: 500;
}

.outbox-table td.message-preview {
	color: #5a6b75;
	font-size: 13px;
	font-style: italic;
	max-width: 250px;
	overflow: hidden;
	text-overflow: ellipsis;
	white-space: nowrap;
}

.outbox-table td.date-col {
	color: #5a6b75;
	font-size: 13px;
	white-space: nowrap;
}

.outbox-table td.actions-col {
	white-space: nowrap;
}

.outbox-table .action-link {
	display: inline-block;
	padding: 6px 14px;
	margin: 0 4px;
	border-radius: 6px;
	text-decoration: none;
	font-size: 13px;
	font-weight: 500;
	transition: all 0.2s ease;
}

.action-read {
	background: #2c5f7d;
	color: #ffffff;
	border: 1px solid #2c5f7d;
}

.action-read:hover {
	background: #1a3a4d;
	transform: translateY(-1px);
	box-shadow: 0 2px 8px rgba(44, 95, 125, 0.3);
}

.action-delete {
	background: #fef3e8;
	color: #8b5a2b;
	border: 1px solid #e8c89f;
}

.action-delete:hover {
	background: #e8c89f;
	color: #6b4521;
}

.empty-outbox {
	text-align: center;
	padding: 40px 20px;
	color: #5a6b75;
	font-size: 14px;
}

.empty-outbox-icon {
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

@media (max-width: 768px) {
	.outbox-table-wrapper {
		overflow-x: auto;
	}
	
	.outbox-table {
		min-width: 900px;
	}
}
</style>
<script src="../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="outbox-outerwrapper">
<div id="header"><img src="../images/staffhead.jpg" alt="Staff Header" /></div>
<div id="links">
  <?php include('link.php'); ?>
</div>
<div id="body">
	<h2 class="page-title">📤 Outbox</h2>
	
	<div class="outbox-actions">
		<a href="inbox.php">← Back to Inbox</a>
	</div>

	<div class="outbox-table-wrapper">
		<table class="outbox-table">
			<thead>
				<tr>
					<th width="12%">Recipient ID</th>
					<th width="18%">Sent To</th>
					<th width="22%">Subject</th>
					<th width="25%">Message Preview</th>
					<th width="13%">Date Sent</th>
					<th width="10%">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				if (mysqli_num_rows($qry) > 0) {
					while ($tbl = mysqli_fetch_array($qry)) { 
				?>
				<tr>
					<td><strong><?php echo htmlspecialchars($tbl['staff_id']); ?></strong></td>
					<td class="recipient-col"><?php echo htmlspecialchars($tbl['receiver']); ?></td>
					<td class="subject-col"><?php echo htmlspecialchars($tbl['msg_subject']); ?></td>
					<td class="message-preview"><?php echo htmlspecialchars(substr($tbl['msg_msg'], 0, 50)); ?>...</td>
					<td class="date-col"><?php echo date('M d, Y g:i A', strtotime($tbl['date_sent'])); ?></td>
					<td class="actions-col">
						<a href="outboxmore.php?so_id=<?php echo $tbl['so_id']; ?>" class="action-link action-read">Read</a>
						<a href="delete.php?so_id=<?php echo $tbl['so_id']; ?>" class="action-link action-delete" onclick="return confirm('Are you sure you want to delete this message?')">Delete</a>
					</td>
				</tr>
				<?php 
					}
				} else { 
				?>
				<tr>
					<td colspan="6" class="empty-outbox">
						<div class="empty-outbox-icon">📭</div>
						<p><strong>Your outbox is empty</strong></p>
						<p>You haven't sent any messages yet.</p>
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