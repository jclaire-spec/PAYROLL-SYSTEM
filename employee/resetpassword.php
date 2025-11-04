<?php
include('../admin/connection.php');
session_start();
if (!isset($_SESSION['staff_id'])) 
{
die(header('Location: ../index.php'));
}

$staff_id = $_SESSION['staff_id'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password</title>
<style>
body, html {
	margin: 0;
	padding: 0;
	font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
	font-size: 14px;
	background: linear-gradient(135deg, #2c5f7d 0%, #1a3a4d 100%);
	min-height: 100vh;
	display: flex;
	align-items: center;
	justify-content: center;
}

.reset-container {
	background: #f5f1e8;
	border-radius: 20px;
	box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
	padding: 40px;
	width: 500px;
	max-width: 100%;
	border: none;
}

.reset-header {
	text-align: center;
	margin-bottom: 32px;
}

.reset-icon {
	width: 70px;
	height: 70px;
	border-radius: 50%;
	background: #2c5f7d;
	margin: 0 auto 20px;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 32px;
	color: #ffffff;
}

.reset-header h1 {
	color: #1a3a4d;
	margin: 0 0 8px 0;
	font-size: 28px;
	font-weight: 600;
	letter-spacing: -0.5px;
}

.reset-header p {
	color: #5a6b75;
	margin: 0;
	font-size: 15px;
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

.form-group input[type="text"],
.form-group input[type="password"] {
	width: 100%;
	padding: 14px 16px;
	border: 1.5px solid #d4c4a8;
	border-radius: 10px;
	font-size: 15px;
	transition: all 0.2s ease;
	box-sizing: border-box;
	background: #ffffff;
	font-family: inherit;
}

.form-group input[readonly] {
	background: #e8dcc8;
	cursor: not-allowed;
	color: #5a6b75;
}

.form-group input:focus:not([readonly]) {
	outline: none;
	border-color: #2c5f7d;
	box-shadow: 0 0 0 3px rgba(44, 95, 125, 0.1);
}

.form-help {
	font-size: 12px;
	color: #5a6b75;
	margin-top: 6px;
	font-style: italic;
}

.password-strength {
	margin-top: 8px;
	height: 4px;
	background: #e8dcc8;
	border-radius: 2px;
	overflow: hidden;
}

.password-strength-bar {
	height: 100%;
	width: 0%;
	transition: all 0.3s ease;
	border-radius: 2px;
}

.strength-weak { background: #e74c3c; width: 33%; }
.strength-medium { background: #f39c12; width: 66%; }
.strength-strong { background: #27ae60; width: 100%; }

.form-actions {
	display: flex;
	gap: 12px;
	justify-content: flex-end;
	margin-top: 32px;
	padding-top: 20px;
	border-top: 1px solid #d4c4a8;
}

.btn {
	padding: 14px 32px;
	border-radius: 10px;
	font-size: 15px;
	font-weight: 600;
	cursor: pointer;
	transition: all 0.2s ease;
	border: none;
	text-decoration: none;
	display: inline-block;
	text-align: center;
}

.btn-primary {
	background: #2c5f7d;
	color: white;
}

.btn-primary:hover {
	background: #1a3a4d;
	transform: translateY(-1px);
	box-shadow: 0 4px 12px rgba(44, 95, 125, 0.4);
}

.btn-secondary {
	background: #e8dcc8;
	color: #1a3a4d;
	border: 1.5px solid #d4c4a8;
}

.btn-secondary:hover {
	background: #d4c4a8;
	border-color: #c4b198;
}

.alert {
	padding: 12px 16px;
	border-radius: 10px;
	margin-bottom: 20px;
	font-size: 14px;
}

.alert-info {
	background: #e8f2f7;
	color: #2c5f7d;
	border: 1.5px solid #b3d9f0;
}

@media (max-width: 768px) {
	.reset-container {
		padding: 24px;
		width: 100%;
	}
	
	.reset-header h1 {
		font-size: 24px;
	}
	
	.form-actions {
		flex-direction: column;
	}
	
	.btn {
		width: 100%;
	}
}
</style>
</head>

<body>
<div class="reset-container">
	<div class="reset-header">
		<div class="reset-icon">🔒</div>
		<h1>Reset Password</h1>
		<p>Update your account password</p>
	</div>

	<div class="alert alert-info">
		<strong>💡 Password Requirements:</strong> Your new password must be at least 6 characters long. Use a mix of letters, numbers, and symbols for better security.
	</div>

	<form action="reset.php" method="post" onsubmit="return validateForm()">
		<div class="form-group">
			<label for="staff_id">Staff ID</label>
			<input type="text" name="staff_id" id="staff_id" value="<?php echo htmlspecialchars($staff_id); ?>" readonly />
			<p class="form-help">Your staff ID (cannot be changed)</p>
		</div>

		<div class="form-group">
			<label for="password">New Password *</label>
			<input type="password" name="password" id="password" required minlength="6" onkeyup="checkPasswordStrength()" />
			<div class="password-strength">
				<div class="password-strength-bar" id="strengthBar"></div>
			</div>
			<p class="form-help" id="strengthText">Enter your new password (minimum 6 characters)</p>
		</div>

		<div class="form-group">
			<label for="confirm_password">Confirm New Password *</label>
			<input type="password" name="confirm_password" id="confirm_password" required minlength="6" />
			<p class="form-help">Re-enter your new password to confirm</p>
		</div>

		<div class="form-actions">
			<a href="index.php" class="btn btn-secondary">Cancel</a>
			<button type="submit" name="submit" class="btn btn-primary">Reset Password</button>
		</div>
	</form>
</div>

<script>
function checkPasswordStrength() {
	const password = document.getElementById('password').value;
	const strengthBar = document.getElementById('strengthBar');
	const strengthText = document.getElementById('strengthText');
	
	let strength = 0;
	if (password.length >= 6) strength++;
	if (password.length >= 10) strength++;
	if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
	if (/[0-9]/.test(password)) strength++;
	if (/[^a-zA-Z0-9]/.test(password)) strength++;
	
	strengthBar.className = 'password-strength-bar';
	
	if (password.length === 0) {
		strengthBar.style.width = '0%';
		strengthText.textContent = 'Enter your new password (minimum 6 characters)';
	} else if (strength <= 2) {
		strengthBar.classList.add('strength-weak');
		strengthText.textContent = '⚠️ Weak password - add more characters or complexity';
		strengthText.style.color = '#e74c3c';
	} else if (strength <= 3) {
		strengthBar.classList.add('strength-medium');
		strengthText.textContent = '⚡ Medium strength - consider adding special characters';
		strengthText.style.color = '#f39c12';
	} else {
		strengthBar.classList.add('strength-strong');
		strengthText.textContent = '✓ Strong password!';
		strengthText.style.color = '#27ae60';
	}
}

function validateForm() {
	const password = document.getElementById('password').value;
	const confirm = document.getElementById('confirm_password').value;
	
	if (password.length < 6) {
		alert('Password must be at least 6 characters long.');
		return false;
	}
	
	if (password !== confirm) {
		alert('Passwords do not match. Please try again.');
		return false;
	}
	
	return confirm('Are you sure you want to reset your password?');
}
</script>
</body>
</html>