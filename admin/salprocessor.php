<?php
include_once('connection.php');

$staff_id   = $_POST['staff_id'];
$lname      = $_POST['lname'];
$fname      = $_POST['fname'];
$department = $_POST['department'];
$position   = $_POST['position'];
$grade      = $_POST['grade'];
$years      = $_POST['years'];
$basic      = $_POST['basic'];
$meal       = $_POST['meal'];

// housing allowance is 15% of basic salary
$housing = (0.15 * $basic);

// transport allowance is 8% of basic salary
$transport = (0.08 * $basic);

// tax is 9% of basic salary
$tax = (0.09 * $basic);

// entertainment allowance
$entertainment = ($grade > 7) ? 0.02 * $basic : 0;

// long service allowance
$long_service = ($years >= 15) ? 0.0175 * $basic : 0;

// total salary
$totall = ($basic + $housing + $meal + $transport + $entertainment + $long_service - $tax);

// Check if salary already computed this month
$query = "SELECT * FROM salary WHERE staff_id = '$staff_id' AND MONTH(date_s) = MONTH(NOW())";
$result = mysqli_query($conn, $query);

if (!$result) {
    $status = 'error';
    $message = "Query failed: " . mysqli_error($conn);
} else {
    $num = mysqli_num_rows($result);

    if ($num > 0) {
        $status = 'warning';
        $message = "Salary has already been computed for this month.";
    } else {
        $qry = "INSERT INTO salary 
                (staff_id, lname, fname, department, position, years, grade, basic, meal, housing, transport, entertainment, long_service, tax, totall)
                VALUES 
                ('$staff_id', '$lname', '$fname', '$department', '$position', '$years', '$grade', '$basic', '$meal', '$housing', '$transport', '$entertainment', '$long_service', '$tax', '$totall')";
        
        $insert = mysqli_query($conn, $qry);

        if ($insert) {
            $status = 'success';
            $message = "Salary successfully computed and saved!";
            header('Refresh: 3; URL=print.php');
        } else {
            $status = 'error';
            $message = "Insert failed: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Salary Status - Payroll System</title>
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
	font-size: 28px;
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

.warning {
	background: #fff6e5;
	color: #8a6300;
	border: 1.5px solid #f0cd66;
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

.salary-summary {
	text-align: left;
	background: #ffffff;
	padding: 20px;
	border-radius: 12px;
	margin-top: 20px;
	font-size: 14px;
	line-height: 1.6;
	border: 1px solid #ddd;
}

.salary-summary strong {
	color: #1a3a4d;
}
</style>
</head>
<body>
<div class="status-container">
	<h2>Salary Computation Status</h2>

	<div class="message <?php echo $status; ?>">
		<?php echo htmlspecialchars($message); ?>
	</div>

	<?php if ($status == 'success'): ?>
	<div class="salary-summary">
		<strong>Employee:</strong> <?php echo $fname . " " . $lname; ?><br>
		<strong>Department:</strong> <?php echo $department; ?><br>
		<strong>Position:</strong> <?php echo $position; ?><br>
		<strong>Total Salary:</strong> ₱<?php echo number_format($totall, 2); ?><br>
	</div>
	<?php endif; ?>

	<a href="payroll.php" class="back-btn">Back to Payroll</a>
</div>
</body>
</html>