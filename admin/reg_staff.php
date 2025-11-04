<?php
session_start();
if (!isset($_SESSION['username'])) {
    die(header('Location: ../index.php'));
}

// define variable to hold message
$message = "";

if (isset($_POST['submit'])) {
    include('connection.php');
    include('../sanitise.php');

    $fname = sanitise($_POST['fname']);
    $sex = sanitise($_POST['sex']);
    $birthday = sanitise($_POST['birthday']);
    $department = sanitise($_POST['department']);
    $position = sanitise($_POST['position']);
    $grade = sanitise($_POST['grade']);
    $years = sanitise($_POST['years']);
    $username = sanitise($_POST['username']);
    $password = sanitise($_POST['password']);

    $qry = "INSERT INTO register_staff (fname, sex, birthday, department, position, grade, years, username, password) 
            VALUES ('$fname', '$sex', '$birthday', '$department', '$position', '$grade', '$years', '$username', '$password')";
    $result = mysqli_query($conn, $qry);

    if ($result) {
        $message = "<div style='color: green; font-weight: bold; text-align: center; margin-top: -20px; margin-bottom: 10px;'>Staff has been successfully registered. 
                    <a href='view_staff.php'>View Staff</a></div>";
    } else {
        $message = "<div style='color: red; font-weight: bold; text-align: center; margin-top: -20px; margin-bottom: 10px;''>Registration was not completed, please try again. 
                    <a href='index.php'>Home</a></div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register Staff</title>
<link rel="stylesheet" href="../css/tcal.css?v=20251009" type="text/css" />
<script type="text/javascript" src="../css/tcal.js"></script>
<script type="text/javascript">
function proceed() {
    return confirm('Click to confirm registration');
}
</script>
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
				<li class="nav-item"><a class="nav-link active" href="reg_staff.php">Register Staff</a></li>
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
				<h2>Register Staff</h2>
				<p>Add new staff member to the system</p>
			</div>

			<?php if (!empty($message)) { echo $message; } ?>

			<div class="form-container">
				<form name="register" action="" method="post" onsubmit="return proceed()">
					<div class="form-grid">
						<div class="form-group">
							<label for="fname">Full Name *</label>
							<input type="text" name="fname" id="fname" required />
						</div>

						<div class="form-group">
							<label for="sex">Sex *</label>
							<select name="sex" id="sex" required>
								<option value="">Select sex</option>
								<option value="Male">Male</option>
								<option value="Female">Female</option>
							</select>
						</div>

						<div class="form-group">
							<label for="birthday">Birthday *</label>
							<input type="text" name="birthday" id="birthday" class="tcal" required />
						</div>

						<div class="form-group">
							<label for="department">Department *</label>
							<select name="department" id="department" required>
								<option value="">Select Department</option>
								<option value="Human Resources">Human Resources</option>
								<option value="I.T.">I.T.</option>
								<option value="Accounting">Accounting</option>
								<option value="Research">Research &amp; Development</option>
								<option value="Administration">Administration</option>
								<option value="Marketing">Marketing</option>
								<option value="Production">Production</option>
							</select>
						</div>

						<div class="form-group">
							<label for="position">Position *</label>
							<select name="position" id="position" required>
								<option value="">Select Position</option>
								<option value="Director">Director</option>
								<option value="As. Director">As. Director</option>
								<option value="Manager">Manager</option>
								<option value="As.Manager">As. Manager</option>
								<option value="Supervisor">Supervisor</option>
								<option value="Head">Head</option>
								<option value="Ass. Head">Ass. Head</option>
								<option value="Clerk">Clerk</option>
							</select>
						</div>

						<div class="form-group">
							<label for="grade">Grade Level *</label>
							<input type="number" name="grade" id="grade" min="1" max="20" required />
						</div>

						<div class="form-group">
							<label for="years">Years Spent *</label>
							<input type="number" name="years" id="years" min="0" max="50" required />
						</div>

						<div class="form-group">
							<label for="username">Username *</label>
							<input type="text" name="username" id="username" required />
						</div>

						<div class="form-group">
							<label for="password">Password *</label>
							<input type="password" name="password" id="password" minlength="7" required />
							<small>Minimum 7 characters</small>
						</div>
					</div>

					<div class="form-actions">
						<button type="submit" name="submit" class="btn btn-primary">Register Staff</button>
						<button type="reset" class="btn btn-secondary">Clear Form</button>
					</div>
				</form>
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