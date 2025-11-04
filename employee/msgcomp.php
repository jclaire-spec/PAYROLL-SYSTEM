<?php
include('../admin/connection.php');
include('../sanitise.php');

if (isset($_POST['submit'])) {
    // sanitize inputs
    $sender         = sanitise($_POST['sender']);
    $receipientid   = sanitise($_POST['rid']);
    $receipientname = sanitise($_POST['receipient']);
    $subject        = sanitise($_POST['subject']);
    $message        = sanitise($_POST['message']);

    // Insert into inbox
    $inbox_sql = "INSERT INTO staff_inbox (staff_id, sender, receiver, msg_subject, msg_msg) 
                  VALUES ('$receipientid', '$sender', '$receipientname', '$subject', '$message')";
    $inbox_insert = mysqli_query($conn, $inbox_sql);

    // Insert into outbox
    $outbox_sql = "INSERT INTO staff_outbox (staff_id, sender, receiver, msg_subject, msg_msg) 
                   VALUES ('$receipientid', '$sender', '$receipientname', '$subject', '$message')";
    $outbox_insert = mysqli_query($conn, $outbox_sql);

    if ($inbox_insert && $outbox_insert) {
        $status = 'success';
        $message_status = "Message has been successfully sent!";
    } else {
        $status = 'error';
        $message_status = "Message failed to send. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Message Status - Admin Messaging</title>
<style>
body {
	background: linear-gradient(135deg, #2c5f7d 0%, #1a3a4d 100%);
	margin: 0;
	padding: 0;
	font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
	min-height: 100vh;
	display: flex;
	align-items: center;
	justify-content: center;
}

.status-container {
	background: #f5f1e8;
	border-radius: 20px;
	box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
	padding: 48px 40px;
	width: 440px;
	max-width: 90%;
	text-align: center;
	position: relative;
}

.status-container h2 {
	color: #1a3a4d;
	margin: 0 0 24px 0;
	font-size: 26px;
	font-weight: 600;
}

.message {
	padding: 16px 20px;
	border-radius: 10px;
	margin-bottom: 28px;
	font-size: 15px;
	line-height: 1.5;
}

.success {
	background: #e7f8ec;
	color: #0b7a2b;
	border: 1.5px solid #9ed7b5;
}

.error {
	background: #fef3e8;
	color: #8b5a2b;
	border: 1.5px solid #e8c89f;
}

.back-btn {
	display: inline-block;
	padding: 14px 32px;
	background: #2c5f7d;
	color: white;
	text-decoration: none;
	border-radius: 10px;
	font-weight: 600;
	font-size: 15px;
	transition: all 0.2s ease;
}

.back-btn:hover {
	background: #1a3a4d;
	transform: translateY(-1px);
	box-shadow: 0 4px 12px rgba(44, 95, 125, 0.4);
}
</style>
</head>
<body>

<div class="status-container">
	<h2>Message Sending Status</h2>

	<div class="message <?php echo $status; ?>">
		<?php echo htmlspecialchars($message_status); ?>
	</div>

	<a href="../employee/outbox.php" class="back-btn">Back to Outbox</a>
</div>

</body>
</html>