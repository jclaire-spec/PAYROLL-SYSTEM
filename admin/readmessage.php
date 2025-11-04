<?php
session_start();
if (!isset($_SESSION['username'])) 
{
die(header('Location: ../index.php'));
}

include('connection.php');
include('../sanitise.php');
$id = sanitise($_GET['ao_id']);
$staff_id = sanitise($_GET['staff_id']);
$qry = "SELECT * FROM admin_outbox WHERE ao_id = '$id' AND staff_id = '$staff_id'";
$update = mysqli_query($conn, $qry) or die(mysqli_error($conn));
$row_update = mysqli_fetch_assoc($update);
$totalRows_update = mysqli_num_rows($update);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Read Message</title>
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

.message-view-container {
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

.message-meta {
	background: #f9f7f4;
	padding: 20px 24px;
	border-bottom: 1px solid #e8dcc8;
}

.message-meta-row {
	display: grid;
	grid-template-columns: 140px 1fr;
	gap: 16px;
	margin-bottom: 12px;
	align-items: start;
}

.message-meta-row:last-child {
	margin-bottom: 0;
}

.message-meta-label {
	font-weight: 600;
	color: #5a6b75;
	font-size: 13px;
	text-transform: uppercase;
	letter-spacing: 0.5px;
}

.message-meta-value {
	color: #1a3a4d;
	font-size: 14px;
	font-weight: 500;
}

.message-id-badge {
	display: inline-block;
	background: #2c5f7d;
	color: #ffffff;
	padding: 4px 12px;
	border-radius: 20px;
	font-size: 12px;
	font-weight: 600;
}

.message-subject {
	font-size: 16px;
	font-weight: 600;
	color: #1a3a4d;
}

.message-body {
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

.message-actions {
	padding: 20px 24px;
	background: #f9f7f4;
	border-top: 1px solid #e8dcc8;
	display: flex;
	gap: 12px;
	justify-content: flex-end;
}

.message-not-found {
	text-align: center;
	padding: 40px 20px;
	color: #8b5a2b;
	background: #fef3e8;
	border-radius: 10px;
	margin-bottom: 20px;
}

.message-not-found h3 {
	margin: 0 0 8px 0;
	font-size: 18px;
}

.message-not-found p {
	margin: 0;
	font-size: 14px;
}

@media (max-width: 768px) {
	.message-meta-row {
		grid-template-columns: 1fr;
		gap: 6px;
	}
	
	.message-actions {
		flex-direction: column;
	}
	
	.btn {
		width: 100%;
		justify-content: center;
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
				<h2>Read Message</h2>
				<p>View sent message details</p>
			</div>

			<?php if ($totalRows_update > 0) { ?>
			<div class="message-view-container">
				<div class="message-header-bar">
					<h3>
						<span>Sent Message</span>
					</h3>
				</div>

				<div class="message-meta">
					<div class="message-meta-row">
						<div class="message-meta-label">Message ID</div>
						<div class="message-meta-value">
							<span class="message-id-badge">#<?php echo htmlspecialchars($row_update['ao_id']); ?></span>
						</div>
					</div>

					<div class="message-meta-row">
						<div class="message-meta-label">Date Sent</div>
						<div class="message-meta-value">
							<?php echo date('F d, Y \a\t g:i A', strtotime($row_update['sent_date'])); ?>
						</div>
					</div>

					<div class="message-meta-row">
						<div class="message-meta-label">From</div>
						<div class="message-meta-value">
							<?php echo htmlspecialchars($row_update['sender']); ?>
						</div>
					</div>

					<div class="message-meta-row">
						<div class="message-meta-label">To</div>
						<div class="message-meta-value">
							<?php echo htmlspecialchars($row_update['receiver']); ?> 
							<span style="color: #5a6b75; font-size: 12px;">(Staff ID: <?php echo htmlspecialchars($staff_id); ?>)</span>
						</div>
					</div>

					<div class="message-meta-row">
						<div class="message-meta-label">Subject</div>
						<div class="message-meta-value message-subject">
							<?php echo htmlspecialchars($row_update['msg_subject']); ?>
						</div>
					</div>
				</div>

				<div class="message-body">
					<span class="message-body-label">Message Content</span>
					<div class="message-content">
						<?php echo nl2br(htmlspecialchars($row_update['msg_msg'])); ?>
					</div>
				</div>

				<div class="message-actions">
					<a href="sentmessages.php" class="btn btn-secondary">
						<span>← Back to Sent Messages</span>
					</a>
					<a href="messagedelete.php?staff_id=<?php echo $staff_id; ?>&ao_id=<?php echo $id; ?>" 
					   class="btn btn-primary" 
					   onclick="return confirm('Are you sure you want to delete this message?')"
					   style="background: #8b5a2b; border-color: #8b5a2b;">
						<span>Delete Message</span>
					</a>
				</div>
			</div>
			<?php } else { ?>
			<div class="message-not-found">
				<h3>Message Not Found</h3>
				<p>The requested message could not be found or you don't have permission to view it.</p>
			</div>
			<div class="quick-actions">
				<a href="sentmessages.php" class="btn btn-secondary" style="width: 100%;">
					<span>← Back to Sent Messages</span>
				</a>
			</div>
			<?php } ?>
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