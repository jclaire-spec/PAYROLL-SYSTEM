<?php
include('admin/connection.php');
include('sanitise.php');

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = sanitise($_POST['fname']);
    $sex = sanitise($_POST['sex']);
    $birthday = sanitise($_POST['birthday']);
    $department = sanitise($_POST['department']);
    $position = sanitise($_POST['position']);
    $grade = sanitise($_POST['grade']);
    $years = sanitise($_POST['years']);
    $username = sanitise($_POST['username']);
    $password = sanitise($_POST['password']);
    $confirm_password = sanitise($_POST['confirm_password']);
    
    // Validation
    if (empty($fname) || empty($sex) || empty($birthday) || empty($department) || 
        empty($position) || empty($grade) || empty($years) || empty($username) || 
        empty($password) || empty($confirm_password)) {
        $error_message = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters long.";
    } else {
        // Check if username already exists
        $check_query = mysqli_query($conn, "SELECT * FROM register_staff WHERE username = '$username'");
        if (mysqli_num_rows($check_query) > 0) {
            $error_message = "Username already exists. Please choose a different username.";
        } else {
            // Insert new staff member
            $insert_query = "INSERT INTO register_staff (fname, sex, birthday, department, position, grade, years, username, password, date_registered) 
                            VALUES ('$fname', '$sex', '$birthday', '$department', '$position', '$grade', '$years', '$username', '$password', NOW())";
            
            if (mysqli_query($conn, $insert_query)) {
                $success_message = "Account created successfully! You can now login.";
            } else {
                $error_message = "Error creating account. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Account - Payroll System</title>
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
	padding: 20px 0;
}

.signup-container {
	background: #f5f1e8;
	border-radius: 20px;
	box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
	padding: 24px 32px 20px 32px;
	width: 520px;
	max-width: 90%;
	border: none;
	position: relative;
}

.signup-container::after {
    content: none; 
}

.signup-header {
	text-align: center;
	margin-bottom: 20px;
}

.signup-header h1 {
	color: #1a3a4d;
	margin: 0;
	font-size: 26px;
	font-weight: 600;
	letter-spacing: -0.5px;
}

.signup-header p {
	color: #5a6b75;
	margin: 4px 0 0 0;
	font-size: 13px;
	font-weight: 400;
}

.form-row {
	display: flex;
	gap: 12px;
	margin-bottom: 14px;
}

.form-group {
	flex: 1;
	margin-bottom: 14px;
}

.form-group.full-width {
	flex: 100%;
}

.form-group label {
	display: block;
	margin-bottom: 6px;
	color: #1a3a4d;
	font-weight: 500;
	font-size: 13px;
}

.form-group input,
.form-group select {
	width: 100%;
	padding: 10px 12px;
	border: 1.5px solid #d4c4a8;
	border-radius: 8px;
	font-size: 14px;
	transition: all 0.2s ease;
	box-sizing: border-box;
	background: #ffffff;
}

.form-group input:focus,
.form-group select:focus {
    outline: none;
    border-color: #2c5f7d;
    box-shadow: 0 0 0 3px rgba(44, 95, 125, 0.1);
}

.signup-btn {
    width: 100%;
    padding: 11px;
    background: #2c5f7d;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-bottom: 12px;
}

.signup-btn:hover {
    background: #1a3a4d;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(44, 95, 125, 0.4);
}

.signup-btn:active {
	transform: translateY(0);
}

.back-to-login {
	text-align: center;
	padding-top: 16px;
	border-top: 1px solid #d4c4a8;
}

.back-to-login a {
    color: #2c5f7d;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
}

.back-to-login a:hover {
	text-decoration: underline;
}

.error-message {
	background: #fef3e8;
	color: #8b5a2b;
	padding: 10px 12px;
	border-radius: 8px;
	margin-bottom: 16px;
	border: 1.5px solid #e8c89f;
	text-align: center;
	font-size: 13px;
}

.success-message {
	background: #e8f5e9;
	color: #2e7d32;
	padding: 10px 12px;
	border-radius: 8px;
	margin-bottom: 16px;
	border: 1.5px solid #a5d6a7;
	text-align: center;
	font-size: 13px;
}

/* Scrollbar styling */
.signup-container::-webkit-scrollbar {
	width: 8px;
}

.signup-container::-webkit-scrollbar-track {
	background: #e8dcc8;
	border-radius: 10px;
}

.signup-container::-webkit-scrollbar-thumb {
	background: #2c5f7d;
	border-radius: 10px;
}

.signup-container::-webkit-scrollbar-thumb:hover {
	background: #1a3a4d;
}

@media (max-width: 600px) {
	.signup-container {
		margin: 20px;
		padding: 32px 24px 24px 24px;
	}
	
	.form-row {
		flex-direction: column;
		gap: 0;
	}
	
	.signup-header h1 {
		font-size: 28px;
	}
}
</style>
</head>

<body>
<div class="signup-container">
	<div class="signup-header">
		<h1>Create Account</h1>
		<p>Join our payroll system</p>
	</div>

	<?php if ($error_message): ?>
		<div class="error-message"><?php echo $error_message; ?></div>
	<?php endif; ?>

	<?php if ($success_message): ?>
		<div class="success-message"><?php echo $success_message; ?></div>
	<?php endif; ?>

	<form method="post" action="signup.php">
		<div class="form-group full-width">
			<label for="fname">Full Name</label>
			<input type="text" name="fname" id="fname" required value="<?php echo isset($_POST['fname']) ? htmlspecialchars($_POST['fname']) : ''; ?>">
		</div>

		<div class="form-row">
			<div class="form-group">
				<label for="sex">Gender</label>
				<select name="sex" id="sex" required>
					<option value="">Select Gender</option>
					<option value="Male" <?php echo (isset($_POST['sex']) && $_POST['sex'] == 'Male') ? 'selected' : ''; ?>>Male</option>
					<option value="Female" <?php echo (isset($_POST['sex']) && $_POST['sex'] == 'Female') ? 'selected' : ''; ?>>Female</option>
				</select>
			</div>
			<div class="form-group">
				<label for="birthday">Birthday</label>
				<input type="date" name="birthday" id="birthday" required value="<?php echo isset($_POST['birthday']) ? htmlspecialchars($_POST['birthday']) : ''; ?>">
			</div>
		</div>

		<div class="form-row">
			<div class="form-group">
				<label for="department">Department</label>
				<select name="department" id="department" required>
					<option value="">Select Department</option>
					<option value="I.T." <?php echo (isset($_POST['department']) && $_POST['department'] == 'I.T.') ? 'selected' : ''; ?>>I.T.</option>
					<option value="Human Resources" <?php echo (isset($_POST['department']) && $_POST['department'] == 'Human Resources') ? 'selected' : ''; ?>>Human Resources</option>
					<option value="Accounting" <?php echo (isset($_POST['department']) && $_POST['department'] == 'Accounting') ? 'selected' : ''; ?>>Accounting</option>
					<option value="Administration" <?php echo (isset($_POST['department']) && $_POST['department'] == 'Administration') ? 'selected' : ''; ?>>Administration</option>
					<option value="Marketing" <?php echo (isset($_POST['department']) && $_POST['department'] == 'Marketing') ? 'selected' : ''; ?>>Marketing</option>
					<option value="Production" <?php echo (isset($_POST['department']) && $_POST['department'] == 'Production') ? 'selected' : ''; ?>>Production</option>
				</select>
			</div>
			<div class="form-group">
				<label for="position">Position</label>
				<input type="text" name="position" id="position" required value="<?php echo isset($_POST['position']) ? htmlspecialchars($_POST['position']) : ''; ?>" placeholder="e.g., Manager, Director">
			</div>
		</div>

		<div class="form-row">
			<div class="form-group">
				<label for="grade">Grade</label>
				<input type="number" name="grade" id="grade" required min="1" max="20" value="<?php echo isset($_POST['grade']) ? htmlspecialchars($_POST['grade']) : ''; ?>">
			</div>
			<div class="form-group">
				<label for="years">Years of Experience</label>
				<input type="number" name="years" id="years" required min="0" max="50" value="<?php echo isset($_POST['years']) ? htmlspecialchars($_POST['years']) : ''; ?>">
			</div>
		</div>

		<div class="form-group full-width">
			<label for="username">Username</label>
			<input type="text" name="username" id="username" required value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
		</div>

		<div class="form-row">
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" name="password" id="password" required minlength="6">
			</div>
			<div class="form-group">
				<label for="confirm_password">Confirm Password</label>
				<input type="password" name="confirm_password" id="confirm_password" required minlength="6">
			</div>
		</div>

		<button type="submit" class="signup-btn">Create Account</button>
	</form>

	<div class="back-to-login">
		<a href="index.php">Already have an account? Sign in</a>
	</div>
</div>

<script>
// Password confirmation validation
document.addEventListener('DOMContentLoaded', function() {
	const password = document.getElementById('password');
	const confirmPassword = document.getElementById('confirm_password');
	
	function validatePassword() {
		if (password.value !== confirmPassword.value) {
			confirmPassword.setCustomValidity("Passwords don't match");
		} else {
			confirmPassword.setCustomValidity('');
		}
	}
	
	password.addEventListener('change', validatePassword);
	confirmPassword.addEventListener('keyup', validatePassword);
	
	// Form validation
	const form = document.querySelector('form');
	form.addEventListener('submit', function(e) {
		const inputs = form.querySelectorAll('input[required], select[required]');
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
</script>
</body>
</html>