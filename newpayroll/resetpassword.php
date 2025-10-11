<?php
include('admin/connection.php');
include('sanitise.php');

$message = ""; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $staff_id = sanitise($_POST['staff_id']);
    $password = sanitise($_POST['newpassword']);

    // No hashing applied — directly update password
    $stmt = mysqli_prepare($conn, "UPDATE register_staff SET password = ? WHERE staff_id = ?");

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $password, $staff_id);

        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $message = "<div class='alert success'>Password reset successfully! 
                            <br><a href='index.php' class='back-btn'>Back to Home</a></div>";
            } else {
                $message = "<div class='alert error'>No matching staff ID found.</div>";
            }
        } else {
            $message = "<div class='alert error'>Query execution failed: " . mysqli_error($conn) . "</div>";
        }

        mysqli_stmt_close($stmt);
    } else {
        $message = "<div class='alert error'>Statement preparation failed: " . mysqli_error($conn) . "</div>";
    }

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password - Payroll System</title>
<style>
body {
	background: linear-gradient(135deg, #2c5f7d 0%, #1a3a4d 100%);
	margin: 0;
	padding: 0;
	font-family: "Segoe UI", Roboto, Arial, sans-serif;
	min-height: 100vh;
	display: flex;
	align-items: center;
	justify-content: center;
}

.reset-container {
	background: #f5f1e8;
	border-radius: 20px;
	box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
	padding: 48px 40px;
	width: 420px;
	max-width: 90%;
}

.reset-header {
	text-align: center;
	margin-bottom: 24px;
}

.reset-header h1 {
	color: #1a3a4d;
	margin: 0;
	font-size: 32px;
	font-weight: 600;
}

.reset-header p {
	color: #5a6b75;
	margin: 8px 0 0;
	font-size: 15px;
}

.alert {
	padding: 14px;
	border-radius: 8px;
	margin-bottom: 20px;
	text-align: center;
	font-weight: 500;
}
.alert.success {
	background-color: #d9f7e3;
	color: #1a3a4d;
	border: 1px solid #2c5f7d;
}
.alert.error {
	background-color: #ffe0e0;
	color: #a94442;
	border: 1px solid #d9534f;
}

.back-btn {
	display: inline-block;
	margin-top: 10px;
	padding: 10px 18px;
	background: #2c5f7d;
	color: white;
	text-decoration: none;
	border-radius: 8px;
	font-size: 14px;
	transition: all 0.2s ease;
}
.back-btn:hover {
	background: #1a3a4d;
}

.form-group {
	margin-bottom: 20px;
}

.form-group label {
	display: block;
	margin-bottom: 8px;
	color: #1a3a4d;
	font-weight: 500;
	font-size: 14px;
}

.form-group input {
	width: 100%;
	padding: 14px 16px;
	border: 1.5px solid #d4c4a8;
	border-radius: 10px;
	font-size: 15px;
	box-sizing: border-box;
	background: #ffffff;
	transition: all 0.2s ease;
}

.form-group input:focus {
	outline: none;
	border-color: #2c5f7d;
	box-shadow: 0 0 0 3px rgba(44, 95, 125, 0.1);
}

.reset-btn {
	width: 100%;
	padding: 14px;
	background: #2c5f7d;
	color: white;
	border: none;
	border-radius: 10px;
	font-size: 15px;
	font-weight: 600;
	cursor: pointer;
	transition: all 0.2s ease;
	margin-bottom: 16px;
}
.reset-btn:hover {
	background: #1a3a4d;
	transform: translateY(-1px);
	box-shadow: 0 4px 12px rgba(44, 95, 125, 0.4);
}
.reset-btn:active {
	transform: translateY(0);
}
</style>
</head>

<body>
<div class="reset-container">
	<div class="reset-header">
		<h1>Reset Password</h1>
		<p>Enter your staff ID and new password</p>
	</div>

	<?php if ($message) echo $message; ?>

	<form method="post" action="">
		<div class="form-group">
			<label for="staff_id">Staff ID</label>
			<input type="text" name="staff_id" id="staff_id" required>
		</div>
		
		<div class="form-group">
			<label for="password">New Password</label>
			<input type="password" name="password" id="password" required minlength="6">
		</div>
		
		<div class="form-group">
			<label for="newpassword">Confirm New Password</label>
			<input type="password" name="newpassword" id="newpassword" required minlength="6">
		</div>
		
		<button type="submit" class="reset-btn">Reset Password</button>
	</form>
</div>

<script>
// Password confirmation validation
document.addEventListener('DOMContentLoaded', function() {
	const password = document.getElementById('password');
	const confirmPassword = document.getElementById('newpassword');
	
	function validatePassword() {
		if (password.value !== confirmPassword.value) {
			confirmPassword.setCustomValidity("Passwords don't match");
		} else {
			confirmPassword.setCustomValidity('');
		}
	}
	
	password.addEventListener('change', validatePassword);
	confirmPassword.addEventListener('keyup', validatePassword);
});
</script>
</body>
</html>