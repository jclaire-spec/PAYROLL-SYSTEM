<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payroll System - Login</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />

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

.login-container {
	background: #f5f1e8;
	border-radius: 20px;
	box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
	padding: 48px 40px;
	width: 420px;
	max-width: 90%;
	border: none;
	position: relative;
}

.login-container::after {
    content: none;
}

.login-header {
	text-align: center;
	margin-bottom: 36px;
}

.login-header h1 {
	color: #1a3a4d;
	margin: 0;
	font-size: 32px;
	font-weight: 600;
	letter-spacing: -0.5px;
}

.login-header p {
	color: #5a6b75;
	margin: 8px 0 0 0;
	font-size: 15px;
	font-weight: 400;
}

.tab-container {
	margin-bottom: 28px;
}

.tab-buttons {
	display: flex;
	background: #e8dcc8;
	border-radius: 12px;
	padding: 4px;
	margin-bottom: 28px;
}

.tab-button {
	flex: 1;
	padding: 10px 20px;
	background: none;
	border: none;
	cursor: pointer;
	font-size: 14px;
	font-weight: 500;
	color: #5a6b75;
	transition: all 0.2s ease;
	border-radius: 10px;
}

.tab-button.active {
    color: #ffffff;
    background: #2c5f7d;
}

.tab-button:hover {
    color: #1a3a4d;
}

.tab-button.active:hover {
    color: #ffffff;
}

.tab-content {
	display: none;
}

.tab-content.active {
	display: block;
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
	transition: all 0.2s ease;
	box-sizing: border-box;
	background: #ffffff;
}

.form-group input:focus {
	outline: none;
	border-color: #2c5f7d;
	box-shadow: 0 0 0 3px rgba(44, 95, 125, 0.1);
}

.login-btn {
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

.login-btn:hover {
    background: #1a3a4d;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(44, 95, 125, 0.4);
}

.login-btn:active {
	transform: translateY(0);
}

.forgot-password {
	text-align: center;
	margin-bottom: 20px;
}

.forgot-password a {
    color: #2c5f7d;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
}

.forgot-password a:hover {
	text-decoration: underline;
}

.create-account {
	text-align: center;
	padding-top: 24px;
	border-top: 1px solid #d4c4a8;
}

.create-account p {
	color: #5a6b75;
	margin: 0 0 16px 0;
	font-size: 14px;
}

.create-account-btn {
    display: inline-block;
    padding: 12px 32px;
    background: #e8dcc8;
    color: #1a3a4d;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.2s ease;
    border: 1.5px solid #d4c4a8;
}

.create-account-btn:hover {
    background: #d4c4a8;
    border-color: #c4b198;
    text-decoration: none;
    color: #1a3a4d;
}

.error-message {
	background: #fef3e8;
	color: #8b5a2b;
	padding: 12px 16px;
	border-radius: 10px;
	margin-bottom: 20px;
	border: 1.5px solid #e8c89f;
	text-align: center;
	font-size: 14px;
}

@media (max-width: 480px) {
	.login-container {
		margin: 20px;
		padding: 32px 24px;
	}
	
	.login-header h1 {
		font-size: 28px;
	}
}
</style>
</head>

<body>
<div class="login-container">
	<div class="login-header">
		<h1>Payroll System</h1>
		<p>Sign in to your account</p>
	</div>

	<div class="tab-container">
		<div class="tab-buttons">
			<button class="tab-button active" onclick="switchTab('admin')">Administrator</button>
			<button class="tab-button" onclick="switchTab('staff')">Staff</button>
		</div>

		<!-- Administrator Login Tab -->
		<div id="admin-tab" class="tab-content active">
			<form method="post" action="login.php">
				<div class="form-group">
					<label for="admin-username">Username</label>
					<input type="text" name="username" id="admin-username" required>
				</div>
				<div class="form-group">
					<label for="admin-password">Password</label>
					<input type="password" name="password" id="admin-password" required>
				</div>
				<button type="submit" class="login-btn">Login as Administrator</button>
			</form>
		</div>

		<!-- Staff Login Tab -->
		<div id="staff-tab" class="tab-content">
			<form method="post" action="stafflog.php">
				<div class="form-group">
					<label for="staff-id">Staff ID</label>
					<input type="text" name="staff_id" id="staff-id" required>
				</div>
				<div class="form-group">
					<label for="staff-username">Username</label>
					<input type="text" name="username" id="staff-username" required>
				</div>
				<div class="form-group">
					<label for="staff-password">Password</label>
					<input type="password" name="password" id="staff-password" required>
				</div>
				<button type="submit" class="login-btn">Login as Staff</button>
			</form>
			<div class="forgot-password">
				<a href="resetpassword.php">Forgot Password?</a>
			</div>
    </div>
  </div>
 
	<!-- Create Account Section -->
	<div class="create-account">
		<p>Don't have an account?</p>
		<a href="signup.php" class="create-account-btn">Create Account</a>
	</div>
</div>

<script>
function switchTab(tabName) {
	// Remove active class from all tabs and buttons
	document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
	document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
	
	// Add active class to selected tab and button
	document.querySelector(`[onclick="switchTab('${tabName}')"]`).classList.add('active');
	document.getElementById(`${tabName}-tab`).classList.add('active');
}

// Add some basic form validation
document.addEventListener('DOMContentLoaded', function() {
	const forms = document.querySelectorAll('form');
	forms.forEach(form => {
		form.addEventListener('submit', function(e) {
			const inputs = form.querySelectorAll('input[required]');
			let isValid = true;
			
			inputs.forEach(input => {
				if (!input.value.trim()) {
					isValid = false;
					input.style.borderColor = '#dc3545';
				} else {
					input.style.borderColor = '#e0e0e0';
				}
			});
			
			if (!isValid) {
				e.preventDefault();
				alert('Please fill in all required fields.');
			}
		});
	});
});
</script>
</body>
</html>