<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit();
}

// database connection
include('connection.php');
include('../sanitise.php');

// sanitize inputs
$staff_id = sanitise($_GET['staff_id']);
$salary_id = sanitise($_GET['salary_id']);

// prepare and execute query
$qry = "SELECT * FROM salary WHERE staff_id = ? AND salary_id = ?";
$stmt = $conn->prepare($qry);
$stmt->bind_param("ss", $staff_id, $salary_id);
$stmt->execute();
$result = $stmt->get_result();

// fetch result
$row_update = $result->fetch_assoc();
$totalRows_update = $result->num_rows;

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pay Slip</title>

<style>
/* ===== General Reset ===== */
body, html {
    margin: 0;
    padding: 0;
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f5f3ef;
    color: #1a3a4d;
}

/* ===== Outer Wrapper ===== */
#outerwrapper {
    width: 900px;
    margin: 40px auto;
    background: #ffffff;
    border: 1.5px solid #d4c4a8;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    overflow: hidden;
    padding: 40px;
}

/* ===== Header Section ===== */
#company-header {
    text-align: center;
    margin-bottom: 30px;
    border-bottom: 2px solid #d4c4a8;
    padding-bottom: 15px;
}

#company-header .text {
    font-size: 20px;
    font-weight: 700;
    color: #1a4d2e;
    letter-spacing: 0.5px;
}

#company-header small {
    color: #5a6b75;
    display: block;
    margin-top: 4px;
    font-size: 13px;
}

/* ===== PAYSLIP TITLE ===== */
.payslip-title {
    background: linear-gradient(135deg, #1a4d2e 0%, #2c5f7d 100%);
    color: #ffffff;
    text-align: center;
    padding: 12px;
    font-size: 16px;
    font-weight: 600;
    border-radius: 8px;
    margin: 0 auto 24px;
    width: 200px;
}

/* ===== Pay Slip Table ===== */
#slip table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 24px;
}

#slip table th, #slip table td {
    border: 1px solid #e8dcc8;
    padding: 10px 14px;
    text-align: left;
    font-size: 14px;
}

#slip table th {
    background-color: #f9f7f4;
    color: #5a6b75;
    font-weight: 600;
}

#slip table td strong {
    color: #1a4d2e;
}

/* ===== Section Divider ===== */
.section-divider {
    border-bottom: 2px solid #d4c4a8;
    margin: 30px 0;
}

/* ===== Accountant Signatures ===== */
.signatures {
    width: 100%;
    border-collapse: collapse;
    margin-top: 40px;
}

.signatures td {
    width: 50%;
    text-align: center;
    border: 1px solid #e8dcc8;
    padding: 30px 0;
    font-size: 13px;
}

.signatures td::before {
    content: "............................................................";
    display: block;
    margin-bottom: 5px;
    color: #5a6b75;
}

/* ===== Buttons / Links ===== */
.actions {
    text-align: center;
    margin-top: 30px;
}

.actions a {
    display: inline-block;
    background: #2c5f7d;
    color: #fff;
    text-decoration: none;
    padding: 10px 16px;
    border-radius: 6px;
    margin: 5px;
    font-size: 14px;
    transition: all 0.2s ease;
}

.actions a:hover {
    background: #1a4d2e;
}

/* Print Styling */
@media print {
    body {
        background: #fff;
    }
    #outerwrapper {
        box-shadow: none;
        border: none;
        margin: 0;
        padding: 0;
    }
    .actions {
        display: none;
    }
}
</style>
</head>

<body>
<div id="outerwrapper">
    <div id="company-header">
        <span class="text">INTERNATIONAL COMPANIES LIMITED</span>
        <small>NO 11, YOUR AREA, YOUR TOWN, YOUR CITY</small>
        <small>info@internationalcompanies.com | www.internationalcompanies.com</small>
    </div>

    <div class="payslip-title">PAYSLIP</div>

    <div id="slip">
        <table>
            <tr>
                <th>Generated At</th>
                <td><i><?php echo $row_update['date_s']; ?></i></td>
                <th>Staff ID</th>
                <td><?php echo $row_update['staff_id']; ?></td>
            </tr>
            <tr>
                <th>Name</th>
                <td><?php echo $row_update['fname']; ?></td>
                <th>Department</th>
                <td><?php echo $row_update['department']; ?></td>
            </tr>
            <tr>
                <th>Position</th>
                <td><?php echo $row_update['position']; ?></td>
                <th>Years Spent</th>
                <td><?php echo $row_update['years']; ?></td>
            </tr>
            <tr>
                <th>Grade</th>
                <td colspan="3">GL<?php echo $row_update['grade']; ?></td>
            </tr>
        </table>

        <h3 style="color:#1a4d2e; font-size:15px; margin-bottom:8px;">Salary Breakdown</h3>
        <table>
            <tr><th>Basic Salary</th><td><?php echo $row_update['basic']; ?></td></tr>
            <tr><th>Housing Allowance</th><td><?php echo $row_update['housing']; ?></td></tr>
            <tr><th>Meal Allowance</th><td><?php echo $row_update['meal']; ?></td></tr>
            <tr><th>Transport Allowance</th><td><?php echo $row_update['transport']; ?></td></tr>
            <tr><th>Entertainment Allowance</th><td><?php echo $row_update['entertainment']; ?></td></tr>
            <tr><th>Long Service Allowance</th><td><?php echo $row_update['long_service']; ?></td></tr>
            <tr><th>Tax Deductions</th><td><?php echo $row_update['tax']; ?></td></tr>
            <tr>
                <th>Net Total</th>
                <td><strong>N<?php echo $row_update['totall']; ?></strong></td>
            </tr>
        </table>

        <div class="section-divider"></div>

        <table class="signatures">
            <tr>
                <td>Accountant</td>
                <td>Finance Manager</td>
            </tr>
        </table>

        <div class="actions">
            Click <a href="print.php">here</a> to go back  
            <a href="javascript:self.print()">Print This Page</a>
        </div>
    </div>
</div>
</body>
</html>