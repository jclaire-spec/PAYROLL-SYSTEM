<?php
session_start();
if (!isset($_SESSION['username'])) 
{
die(header('Location: ../index.php'));
}

include_once('connection.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sent Messages</title>
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

.messages-table-wrapper {
	background: #ffffff;
	border: 1.5px solid #d4c4a8;
	border-radius: 12px;
	overflow: hidden;
	box-shadow: 0 4px 12px rgba(0,0,0,.08);
	margin-bottom: 24px;
}

.messages-data-table {
	width: 100%; 
	border-collapse: collapse; 
	margin: 0;
	box-shadow: none;
	border-radius: 0;
	border: none;
}

.messages-data-table th {
	background: #e8dcc8; 
	font-weight: 600;
	color: #1a3a4d;
	font-size: 13px;
	padding: 14px 12px;
	text-align: left;
	white-space: nowrap;
	border-bottom: 1px solid #d4c4a8;
}

.messages-data-table td {
	padding: 12px;
	font-size: 13px;
	color: #1a3a4d;
	border-bottom: 1px solid #e8dcc8;
	vertical-align: top;
}

.messages-data-table tbody tr:hover {
	background-color: #f9f7f4;
}

.messages-data-table tbody tr:last-child td {
	border-bottom: none;
}

.messages-data-table td.msg-id {
	font-weight: 600;
	color: #2c5f7d;
}

.messages-data-table td.msg-subject {
	font-weight: 500;
	color: #1a3a4d;
	max-width: 200px;
}

.messages-data-table td.msg-preview {
	color: #5a6b75;
	font-size: 12px;
	font-style: italic;
	max-width: 250px;
	overflow: hidden;
	text-overflow: ellipsis;
}

.messages-data-table td.msg-date {
	white-space: nowrap;
	color: #5a6b75;
	font-size: 12px;
}

/* Message stats cards */
.message-stats-cards {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 20px;
	margin-bottom: 24px;
}

.message-stats-card {
	background: #ffffff;
	border: 1.5px solid #d4c4a8;
	border-radius: 12px;
	padding: 20px;
	text-align: center;
	box-shadow: 0 4px 12px rgba(0,0,0,.08);
	transition: all 0.2s ease;
}

.message-stats-card:hover {
	transform: translateY(-2px);
	box-shadow: 0 6px 16px rgba(0,0,0,.12);
}

.message-stats-card h3 {
	color: #5a6b75;
	font-size: 13px;
	font-weight: 500;
	margin: 0 0 12px 0;
	text-transform: uppercase;
	letter-spacing: 0.5px;
}

.message-stats-value {
	color: #2c5f7d;
	font-size: 28px;
	font-weight: 700;
	margin: 0;
	letter-spacing: -0.5px;
}

.message-stats-icon {
	font-size: 24px;
	margin-bottom: 8px;
}

/* Responsive */
@media (max-width: 900px) {
	.message-stats-cards {
		grid-template-columns: 1fr;
	}
}

@media (max-width: 768px) {
	.messages-table-wrapper {
		overflow-x: auto;
	}
	
	.messages-data-table {
		min-width: 1000px;
	}
	
	.message-stats-cards {
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
				<h2>Sent Messages</h2>
				<p>View all messages sent to staff members</p>
			</div>

			<?php
			// Calculate message statistics
			$qry_stats = mysqli_query($conn, "SELECT 
				COUNT(*) as total_messages,
				COUNT(DISTINCT staff_id) as unique_recipients,
				COUNT(DISTINCT DATE(sent_date)) as days_active
				FROM admin_outbox");
			$stats = mysqli_fetch_assoc($qry_stats);
			?>

			<div class="message-stats-cards">
				<div class="message-stats-card">
					<div class="message-stats-icon">📧</div>
					<h3>Total Messages</h3>
					<p class="message-stats-value"><?php echo number_format($stats['total_messages']); ?></p>
				</div>
				<div class="message-stats-card">
					<div class="message-stats-icon">👥</div>
					<h3>Recipients</h3>
					<p class="message-stats-value"><?php echo number_format($stats['unique_recipients']); ?></p>
				</div>
				<div class="message-stats-card">
					<div class="message-stats-icon">📅</div>
					<h3>Active Days</h3>
					<p class="message-stats-value"><?php echo number_format($stats['days_active']); ?></p>
				</div>
			</div>

			<div class="messages-table-wrapper">
				<?php
				// view record
				$qry = mysqli_query($conn, "SELECT * FROM admin_outbox ORDER BY sent_date DESC");

				if (!$qry) {
					die("Query failed: " . mysqli_error($conn));
				}
				?>
				
				<table class="messages-data-table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Sender</th>
							<th>Staff ID</th>
							<th>Recipient</th>
							<th>Subject</th>
							<th>Preview</th>
							<th>Date Sent</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (mysqli_num_rows($qry) > 0) {
							while ($row = mysqli_fetch_assoc($qry)) {
								echo "<tr>";
								echo "<td class='msg-id'>" . htmlspecialchars($row['ao_id']) . "</td>";
								echo "<td>" . htmlspecialchars($row['sender']) . "</td>";
								echo "<td><strong>" . htmlspecialchars($row['staff_id']) . "</strong></td>";
								echo "<td>" . htmlspecialchars($row['receiver']) . "</td>";
								echo "<td class='msg-subject'>" . htmlspecialchars($row['msg_subject']) . "</td>";
								echo "<td class='msg-preview'>" . htmlspecialchars(substr($row['msg_msg'], 0, 50)) . "...</td>";
								echo "<td class='msg-date'>" . date('M d, Y g:i A', strtotime($row['sent_date'])) . "</td>";
								echo "<td class='action-buttons'>";
								echo "<a href='readmessage.php?staff_id=" . $row['staff_id'] . "&ao_id=" . $row['ao_id'] . "' class='action-btn btn-edit'>Read</a>";
								echo "<a href='messagedelete.php?staff_id=" . $row['staff_id'] . "&ao_id=" . $row['ao_id'] . "' class='action-btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this message?\")'>Delete</a>";
								echo "</td>";
								echo "</tr>";
							}
						} else {
							echo "<tr><td colspan='8' style='text-align:center; padding:20px; color:#5a6b75;'>No messages found</td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>

			<div class="quick-actions">
				<a href="index.php" class="btn btn-secondary">
					<span>← Go Home</span>
				</a>
				<a href="inbox.php" class="btn btn-primary">
					<span>View Inbox</span>
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