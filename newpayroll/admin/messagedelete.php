<?php 
include('connection.php');
include('../sanitise.php');

$staff_id = sanitise($_GET['staff_id']);
$id = sanitise($_GET['ao_id']);

$qry = "DELETE FROM admin_outbox WHERE staff_id = '$staff_id' AND ao_id = '$id'";
$result = mysqli_query($conn, $qry);

if (!$result) {
    $status = 'error';
    $message = "❌ Deletion failed. Please try again.<br>" . mysqli_error($conn);
} else {
    if (mysqli_affected_rows($conn) > 0) {
        $status = 'success';
        $message = "Staff message has been successfully deleted.";
    } else {
        $status = 'warning';
        $message = "No matching record found to delete.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Deletion Status - Admin Outbox</title>
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
	<h2>Message Deletion Status</h2>

	<div class="message <?php echo $status; ?>">
		<?php echo htmlspecialchars($message); ?>
	</div>

	<a href="view_staff.php" class="back-btn">Go Back Home</a>
</div>

</body>
</html>