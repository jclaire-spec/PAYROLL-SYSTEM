<?php
include('../admin/connection.php');
include('../sanitise.php');
session_start();
if (!isset($_SESSION['staff_id'])) 
{
die(header('Location: ../index.php'));
}

$staff_id = $_SESSION['staff_id'];
$qry1 = mysqli_query($conn, "SELECT * FROM register_staff ORDER BY fname ASC");
$qry2 = mysqli_query($conn, "SELECT * FROM register_staff WHERE staff_id = '$staff_id'");
$sender = '';
if ($row = mysqli_fetch_array($qry2)) {
	$sender = $row['fname'];
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Compose Message</title>
<link rel="stylesheet" href="../css/staff.css?v=20251009" type="text/css" />
<style>
#compose-outerwrapper {
	width: 1300px;
	max-width: 95%;
	margin: 20px auto;
	background: #f5f1e8;
	border-radius: 16px;
	box-shadow: 0 8px 24px rgba(0,0,0,.15);
	overflow: hidden;
}

.compose-header {
	background: #ffffff;
	border: 1.5px solid #d4c4a8;
	border-radius: 12px;
	padding: 16px;
	margin-bottom: 20px;
  width: 96%;
}

.compose-header a {
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

.compose-header a:hover {
	background: #d4c4a8;
	border-color: #c4b198;
}

.compose-form-container {
	background: #ffffff;
	border: 1.5px solid #d4c4a8;
	border-radius: 12px;
	box-shadow: 0 4px 12px rgba(0,0,0,.08);
	padding: 32px;
  width: 94%;
}

.page-title {
	color: #1a3a4d;
	font-size: 24px;
	font-weight: 600;
	margin: 0 0 20px 0;
	padding-bottom: 16px;
	border-bottom: 2px solid #d4c4a8;
}

.compose-form-group {
	margin-bottom: 24px;
	display: grid;
	grid-template-columns: 150px 1fr;
	gap: 16px;
	align-items: start;
}

.compose-form-label {
	font-weight: 600;
	color: #1a3a4d;
	font-size: 14px;
	padding-top: 12px;
}

.compose-form-label.required::after {
	content: ' *';
	color: #8b5a2b;
}

.compose-form-input,
.compose-form-select,
.compose-form-textarea {
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

.compose-form-input:focus,
.compose-form-select:focus,
.compose-form-textarea:focus {
	outline: none;
	border-color: #2c5f7d;
	box-shadow: 0 0 0 3px rgba(44, 95, 125, 0.1);
}

.compose-form-textarea {
	resize: vertical;
	min-height: 150px;
	font-family: inherit;
	line-height: 1.6;
}

.compose-form-actions {
	display: flex;
	gap: 12px;
	justify-content: flex-end;
	margin-top: 32px;
	padding-top: 24px;
	border-top: 1px solid #e8dcc8;
}

.btn-submit {
	padding: 12px 32px;
	background: #2c5f7d;
	color: white;
	border: none;
	border-radius: 10px;
	font-size: 15px;
	font-weight: 600;
	cursor: pointer;
	transition: all 0.2s ease;
}

.btn-submit:hover {
	background: #1a3a4d;
	transform: translateY(-1px);
	box-shadow: 0 4px 12px rgba(44, 95, 125, 0.4);
}

.btn-reset {
	padding: 12px 32px;
	background: #e8dcc8;
	color: #1a3a4d;
	border: 1.5px solid #d4c4a8;
	border-radius: 10px;
	font-size: 15px;
	font-weight: 600;
	cursor: pointer;
	transition: all 0.2s ease;
}

.btn-reset:hover {
	background: #d4c4a8;
	border-color: #c4b198;
}

.form-help-text {
	font-size: 12px;
	color: #5a6b75;
	margin-top: 6px;
	font-style: italic;
}

@media (max-width: 768px) {
	.compose-form-container {
		padding: 20px;
	}
	
	.compose-form-group {
		grid-template-columns: 1fr;
		gap: 8px;
	}
	
	.compose-form-label {
		padding-top: 0;
	}
	
	.compose-form-actions {
		flex-direction: column;
	}
	
	.btn-submit,
	.btn-reset {
		width: 100%;
	}
}
</style>
<script src="../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="compose-outerwrapper">
<div id="header"><img src="../images/staffhead.jpg" alt="Staff Header" /></div>
<div id="links">
  <?php include('link.php'); ?>
</div>
<div id="body">
	<h2 class="page-title">✉️ Compose Message</h2>
	
	<div class="compose-header">
		<a href="inbox.php">← Back to Inbox</a>
	</div>

	<div class="compose-form-container">
		<form action="msgcomp.php" method="post" onsubmit="return validateForm()">
			<input type="hidden" name="sender" value="<?php echo htmlspecialchars($staff_id); ?>" />
			
			<div class="compose-form-group">
				<label class="compose-form-label required">Recipient ID</label>
				<div>
					<input type="text" name="rid" id="rid" class="compose-form-input" required />
					<p class="form-help-text">Enter the recipient's staff ID</p>
				</div>
			</div>

			<div class="compose-form-group">
				<label class="compose-form-label required">To</label>
				<div>
					<select name="receipient" id="receipient" class="compose-form-select" required>
						<option value="">Select Recipient</option>
						<?php
						if (mysqli_num_rows($qry1) > 0) {
							while($rs = mysqli_fetch_array($qry1)) {
								echo '<option value="' . htmlspecialchars($rs['fname']) . '">' . htmlspecialchars($rs['fname']) . ' (ID: ' . htmlspecialchars($rs['staff_id']) . ')</option>';
							}
						}
						?>
					</select>
					<p class="form-help-text">Select the recipient from the list</p>
				</div>
			</div>

			<div class="compose-form-group">
				<label class="compose-form-label required">Subject</label>
				<div>
					<input type="text" name="subject" id="subject" class="compose-form-input" required maxlength="200" />
					<p class="form-help-text">Brief description of your message</p>
				</div>
			</div>

			<div class="compose-form-group">
				<label class="compose-form-label required">Message</label>
				<div>
					<textarea name="message" id="message" class="compose-form-textarea" required></textarea>
					<p class="form-help-text">Write your message here</p>
				</div>
			</div>

			<div class="compose-form-actions">
				<button type="reset" class="btn-reset">Clear Form</button>
				<button type="submit" name="submit" class="btn-submit">Send Message</button>
			</div>
		</form>
	</div>
</div>
</div>

<script>
function validateForm() {
	const rid = document.getElementById('rid').value.trim();
	const receipient = document.getElementById('receipient').value;
	const subject = document.getElementById('subject').value.trim();
	const message = document.getElementById('message').value.trim();
	
	if (!rid || !receipient || !subject || !message) {
		alert('Please fill in all required fields.');
		return false;
	}
	
	return confirm('Are you sure you want to send this message?');
}
</script>
</body>
</html>