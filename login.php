<?php
include('admin/connection.php');
include('sanitise.php');

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitise($_POST['username']);
    $password = sanitise($_POST['password']);
    
    if (empty($username) || empty($password)) {
        $error_message = "Please enter both username and password.";
    } else {
        $qry = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username' AND password = '$password'");
        $count = mysqli_num_rows($qry);
        
        if ($count == 1) {
            session_start();
            $_SESSION['username'] = $username;
            header('Location: admin/index.php');
            exit();
        } else {
            $error_message = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Error - Payroll System</title>
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

.error-container {
	background: #f5f1e8;
	border-radius: 20px;
	box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
	padding: 48px 40px;
	width: 420px;
	max-width: 90%;
	border: none;
	text-align: center;
	position: relative;
}

.error-container::after {
	content: none;
}

.error-container h2 {
	color: #1a3a4d;
	margin: 0 0 24px 0;
	font-size: 28px;
	font-weight: 600;
	letter-spacing: -0.5px;
}

.error-message {
	background: #fef3e8;
	color: #8b5a2b;
	padding: 16px 20px;
	border-radius: 10px;
	margin-bottom: 28px;
	border: 1.5px solid #e8c89f;
	font-size: 15px;
	line-height: 1.5;
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
	text-decoration: none;
	color: white;
	transform: translateY(-1px);
	box-shadow: 0 4px 12px rgba(44, 95, 125, 0.4);
}

.back-btn:active {
	transform: translateY(0);
}

@media (max-width: 480px) {
	.error-container {
		margin: 20px;
		padding: 32px 24px;
	}
	
	.error-container h2 {
		font-size: 24px;
	}
}
</style>
</head>
<body>
<div class="error-container">
	<h2>Login Error</h2>
	<?php if ($error_message): ?>
		<div class="error-message"><?php echo $error_message; ?></div>
	<?php endif; ?>
	<a href="index.php" class="back-btn">Back to Login</a>
</div>
</body>
</html>