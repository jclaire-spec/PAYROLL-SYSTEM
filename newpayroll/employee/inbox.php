<?php
include('../admin/connection.php');
session_start();
if (!isset($_SESSION['staff_id'])) 
{
die(header('Location: ../index.php'));
}

$staff_id = $_SESSION['staff_id'];
$qry = mysqli_query($conn, "SELECT * FROM staff_inbox WHERE staff_id = '$staff_id' ORDER BY received_date DESC");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Staff Inbox</title>
<link rel="stylesheet" href="../css/staff.css?v=20251009" type="text/css" />
<style>
#inbox-outerwrapper {
	width: 1800px;
	max-width: 95%;
	margin: 20px auto;
	background: #f5f1e8;
	border-radius: 16px;
	box-shadow: 0 8px 24px rgba(0,0,0,.15);
	overflow: hidden;
}

.inbox-actions {
	background: #ffffff;
	border: 1.5px solid #d4c4a8;
	border-radius: 12px;
	padding: 16px;
	margin-bottom: 20px;
	display: flex;
	gap: 12px;
	justify-content: flex-start;
	width: 95%;
}

.inbox-actions a {
	display: inline-block;
	padding: 10px 20px;
	background: #2c5f7d;
	color: #ffffff;
	text-decoration: none;
	border-radius: 8px;
	font-weight: 500;
	font-size: 14px;
	transition: all 0.2s ease;
	border: 1.5px solid #2c5f7d;
}

.inbox-actions a:hover {
	background: #1a3a4d;
	transform: translateY(-1px);
	box-shadow: 0 4px 12px rgba(44, 95, 125, 0.4);
}

.inbox-table-wrapper {
	background: #ffffff;
	border: 1.5px solid #d4c4a8;
	border-radius: 12px;
	overflow: hidden;
	box-shadow: 0 4px 12px rgba(0,0,0,.08);
	width: 97%;
}

.inbox-table {
	width: 100%;
	border-collapse: collapse;
	margin: 0;
}

.inbox-table thead tr {
	background: #e8dcc8;
}

.inbox-table th {
	padding: 14px 16px;
	text-align: left;
	font-weight: 600;
	color: #1a3a4d;
	font-size: 13px;
	text-transform: uppercase;
	letter-spacing: 0.5px;
	border-bottom: 1px solid #d4c4a8;
}

.inbox-table td {
	padding: 14px 16px;
	border-bottom: 1px solid #e8dcc8;
	font-size: 14px;
	color: #1a3a4d;
	vertical-align: middle;
}

.inbox-table tbody tr:hover {
	background-color: #f9f7f4;
}

.inbox-table tbody tr:last-child td {
	border-bottom: none;
}

.inbox-table td.date-col {
	color: #5a6b75;
	font-size: 13px;
	white-space: nowrap;
}

.inbox-table td.sender-col {
	font-weight: 500;
	color: #2c5f7d;
}

.inbox-table td.subject-col {
	font-weight: 500;
	max-width: 300px;
	overflow: hidden;
	text-overflow: ellipsis;
}

.inbox-table td.actions-col {
	white-space: nowrap;
}

.inbox-table .action-link {
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

.empty-inbox {
	text-align: center;
	padding: 40px 20px;
	color: #5a6b75;
	font-size: 14px;
}

.empty-inbox-icon {
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
	.inbox-actions {
		flex-direction: column;
	}
	
	.inbox-actions a {
		width: 100%;
		text-align: center;
	}
	
	.inbox-table-wrapper {
		overflow-x: auto;
	}
	
	.inbox-table {
		min-width: 700px;
	}
}
</style>
<script src="../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="inbox-outerwrapper">
<div id="header"><img src="../images/staffhead.jpg" alt="Staff Header" /></div>
<div id="links">
  <?php include('link.php'); ?>
</div>
<div id="body">
	<h2 class="page-title">📬 Inbox</h2>
	
	<div class="inbox-actions">
		<a href="compose2.php">✉️ Compose Message</a>
		<a href="outbox.php">📤 Outbox</a>
	</div>

	<div class="inbox-table-wrapper">
		<table class="inbox-table">
			<thead>
				<tr>
					<th width="20%">Received Date</th>
					<th width="25%">Sender</th>
					<th width="35%">Subject</th>
					<th width="20%">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				if (mysqli_num_rows($qry) > 0) {
					while ($tbl = mysqli_fetch_array($qry)) { 
				?>
				<tr>
					<td class="date-col"><?php echo date('M d, Y g:i A', strtotime($tbl['received_date'])); ?></td>
					<td class="sender-col"><?php echo htmlspecialchars($tbl['sender']); ?></td>
					<td class="subject-col"><?php echo htmlspecialchars($tbl['msg_subject']); ?></td>
					<td class="actions-col">
						<a href="more.php?id=<?php echo $tbl['id']; ?>" class="action-link action-read">Read</a>
						<a href="inboxdelete.php?id=<?php echo $tbl['id']; ?>" class="action-link action-delete" onclick="return confirm('Are you sure you want to delete this message?')">Delete</a>
					</td>
				</tr>
				<?php 
					}
				} else { 
				?>
				<tr>
					<td colspan="4" class="empty-inbox">
						<div class="empty-inbox-icon">📭</div>
						<p><strong>Your inbox is empty</strong></p>
						<p>You have no messages at this time.</p>
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