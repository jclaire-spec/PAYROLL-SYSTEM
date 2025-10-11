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
<title>Inbox</title>
<link rel="stylesheet" href="../css/style.css?v=20251009" type="text/css" />
<style>
.inbox-table-wrapper {
	background: #ffffff;
	border: 1.5px solid #d4c4a8;
	border-radius: 12px;
	overflow: hidden;
	box-shadow: 0 4px 12px rgba(0,0,0,.08);
	margin-bottom: 24px;
}

.inbox-data-table {
	width: 100%; 
	border-collapse: collapse; 
	margin: 0;
	box-shadow: none;
	border-radius: 0;
	border: none;
}

.inbox-data-table th {
	background: #e8dcc8; 
	font-weight: 600;
	color: #1a3a4d;
	font-size: 13px;
	padding: 14px 12px;
	text-align: left;
	white-space: nowrap;
	border-bottom: 1px solid #d4c4a8;
}

.inbox-data-table td {
	padding: 12px;
	font-size: 13px;
	color: #1a3a4d;
	border-bottom: 1px solid #e8dcc8;
	vertical-align: top;
}

.inbox-data-table tbody tr:hover {
	background-color: #f9f7f4;
}

.inbox-data-table tbody tr:last-child td {
	border-bottom: none;
}

.inbox-data-table tbody tr.unread {
	background-color: #e8f2f7;
	font-weight: 500;
}

.inbox-data-table tbody tr.unread:hover {
	background-color: #d9edf7;
}

.inbox-data-table td.msg-id {
	font-weight: 600;
	color: #2c5f7d;
}

.inbox-data-table td.msg-subject {
	font-weight: 500;
	color: #1a3a4d;
	max-width: 200px;
}

.inbox-data-table td.msg-preview {
	color: #5a6b75;
	font-size: 12px;
	font-style: italic;
	max-width: 250px;
	overflow: hidden;
	text-overflow: ellipsis;
}

.inbox-data-table td.msg-date {
	white-space: nowrap;
	color: #5a6b75;
	font-size: 12px;
}

.unread-badge {
	display: inline-block;
	background: #2c5f7d;
	color: #ffffff;
	padding: 2px 8px;
	border-radius: 10px;
	font-size: 11px;
	font-weight: 600;
	margin-left: 8px;
}

/* Message stats cards */
.inbox-stats-cards {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 20px;
	margin-bottom: 24px;
}

.inbox-stats-card {
	background: #ffffff;
	border: 1.5px solid #d4c4a8;
	border-radius: 12px;
	padding: 20px;
	text-align: center;
	box-shadow: 0 4px 12px rgba(0,0,0,.08);
	transition: all 0.2s ease;
}

.inbox-stats-card:hover {
	transform: translateY(-2px);
	box-shadow: 0 6px 16px rgba(0,0,0,.12);
}

.inbox-stats-card h3 {
	color: #5a6b75;
	font-size: 13px;
	font-weight: 500;
	margin: 0 0 12px 0;
	text-transform: uppercase;
	letter-spacing: 0.5px;
}

.inbox-stats-value {
	color: #2c5f7d;
	font-size: 28px;
	font-weight: 700;
	margin: 0;
	letter-spacing: -0.5px;
}

.inbox-stats-icon {
	font-size: 24px;
	margin-bottom: 8px;
}

/* Responsive */
@media (max-width: 900px) {
	.inbox-stats-cards {
		grid-template-columns: 1fr;
	}
}

@media (max-width: 768px) {
	.inbox-table-wrapper {
		overflow-x: auto;
	}
	
	.inbox-data-table {
		min-width: 1000px;
	}
	
	.inbox-stats-cards {
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
				<h2>📬 Inbox</h2>
				<p>Messages received from staff members</p>
			</div>

			<?php
			// Calculate inbox statistics
			// Note: You may need to create the 'admin_inbox' table or adjust based on your database structure
			// This assumes messages from staff are stored in a table called 'staff_outbox' or 'admin_inbox'
			
			// Check if admin_inbox table exists, otherwise use staff_outbox
			$table_check = mysqli_query($conn, "SHOW TABLES LIKE 'admin_inbox'");
			$table_exists = mysqli_num_rows($table_check) > 0;
			
			if ($table_exists) {
				$qry_stats = mysqli_query($conn, "SELECT 
					COUNT(*) as total_messages,
					COUNT(DISTINCT sender_id) as unique_senders,
					SUM(CASE WHEN is_read = 0 THEN 1 ELSE 0 END) as unread_messages
					FROM admin_inbox");
			} else {
				// Fallback: use staff_outbox table (messages sent by staff to admin)
				$qry_stats = mysqli_query($conn, "SELECT 
					COUNT(*) as total_messages,
					COUNT(DISTINCT sender) as unique_senders,
					0 as unread_messages
					FROM staff_outbox");
			}
			
			$stats = mysqli_fetch_assoc($qry_stats);
			?>

			<div class="inbox-stats-cards">
				<div class="inbox-stats-card">
					<div class="inbox-stats-icon">📨</div>
					<h3>Total Messages</h3>
					<p class="inbox-stats-value"><?php echo number_format($stats['total_messages']); ?></p>
				</div>
				<div class="inbox-stats-card">
					<div class="inbox-stats-icon">✉️</div>
					<h3>Unread Messages</h3>
					<p class="inbox-stats-value"><?php echo number_format($stats['unread_messages']); ?></p>
				</div>
				<div class="inbox-stats-card">
					<div class="inbox-stats-icon">👤</div>
					<h3>Unique Senders</h3>
					<p class="inbox-stats-value"><?php echo number_format($stats['unique_senders']); ?></p>
				</div>
			</div>

			<div class="inbox-table-wrapper">
				<?php
				// Fetch inbox messages
				if ($table_exists) {
					$qry = mysqli_query($conn, "SELECT * FROM admin_inbox ORDER BY received_date DESC");
				} else {
					// Fallback: show messages from staff_outbox
					$qry = mysqli_query($conn, "SELECT 
						so_id as inbox_id,
						sender as sender_name,
						staff_id as sender_id,
						receiver,
						msg_subject,
						msg_msg,
						date_sent as received_date,
						0 as is_read
						FROM staff_outbox 
						ORDER BY date_sent DESC");
				}

				if (!$qry) {
					die("Query failed: " . mysqli_error($conn));
				}
				?>
				
				<table class="inbox-data-table">
					<thead>
						<tr>
							<th>ID</th>
							<th>From</th>
							<th>Staff ID</th>
							<th>Subject</th>
							<th>Preview</th>
							<th>Received</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (mysqli_num_rows($qry) > 0) {
							while ($row = mysqli_fetch_assoc($qry)) {
								$unread_class = (isset($row['is_read']) && $row['is_read'] == 0) ? 'unread' : '';
								$inbox_id = isset($row['inbox_id']) ? $row['inbox_id'] : $row['so_id'];
								$sender_name = isset($row['sender_name']) ? $row['sender_name'] : $row['sender'];
								$sender_id = isset($row['sender_id']) ? $row['sender_id'] : $row['staff_id'];
								
								echo "<tr class='$unread_class'>";
								echo "<td class='msg-id'>" . htmlspecialchars($inbox_id) . "</td>";
								echo "<td>" . htmlspecialchars($sender_name);
								if ($unread_class) {
									echo "<span class='unread-badge'>NEW</span>";
								}
								echo "</td>";
								echo "<td><strong>" . htmlspecialchars($sender_id) . "</strong></td>";
								echo "<td class='msg-subject'>" . htmlspecialchars($row['msg_subject']) . "</td>";
								echo "<td class='msg-preview'>" . htmlspecialchars(substr($row['msg_msg'], 0, 50)) . "...</td>";
								echo "<td class='msg-date'>" . date('M d, Y g:i A', strtotime($row['received_date'])) . "</td>";
								echo "<td class='action-buttons'>";
								echo "<a href='readinbox.php?inbox_id=" . $inbox_id . "&sender_id=" . $sender_id . "' class='action-btn btn-edit'>Read</a>";
								echo "<a href='inboxdelete.php?inbox_id=" . $inbox_id . "' class='action-btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this message?\")'>Delete</a>";
								echo "</td>";
								echo "</tr>";
							}
						} else {
							echo "<tr><td colspan='7' style='text-align:center; padding:40px 20px;'>";
							echo "<div style='font-size:48px; margin-bottom:16px; opacity:0.5;'>📭</div>";
							echo "<p style='color:#5a6b75; font-size:14px; margin:0;'><strong>Your inbox is empty</strong></p>";
							echo "<p style='color:#5a6b75; font-size:14px; margin:8px 0 0 0;'>No messages from staff members yet.</p>";
							echo "</td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>

			<div class="quick-actions">
				<a href="index.php" class="btn btn-secondary">
					<span>← Go Home</span>
				</a>
				<a href="sentmessages.php" class="btn btn-primary">
					<span>View Sent Messages</span>
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