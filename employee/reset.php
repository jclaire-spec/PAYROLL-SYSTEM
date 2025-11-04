<?php
include('../admin/connection.php');
include('../sanitise.php');

$staff_id = sanitise($_POST['staff_id']);
$password = sanitise($_POST['password']);

// Use MySQLi (not mysql_query)
$qry = "UPDATE register_staff SET password = '$password' WHERE staff_id = '$staff_id'";
$result = mysqli_query($conn, $qry);

if ($result) {
    $status = 'success';
    $message = "Password has been successfully reset for Staff ID: <strong>$staff_id</strong>.";
    $redirect = "index.php"; // change this to your preferred redirect page
} else {
    $status = 'error';
    $message = "Password reset failed. Please try again.<br>Error: " . mysqli_error($conn);
    $redirect = "resetpassword.php"; // change this to your form page
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Password Reset Status</title>
<style>
    body {
        background: linear-gradient(135deg, #2c5f7d 0%, #1a3a4d 100%);
        margin: 0;
        padding: 0;
        font-family: "Poppins", sans-serif;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .status-container {
        background: #f5f1e8;
        border-radius: 18px;
        padding: 45px 50px;
        width: 420px;
        text-align: center;
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.3);
        animation: fadeIn 0.4s ease;
    }
    .status-container h2 {
        color: #1a3a4d;
        font-size: 24px;
        margin-bottom: 20px;
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
        padding: 12px 30px;
        background: #2c5f7d;
        color: #fff;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: 0.2s ease;
    }
    .back-btn:hover {
        background: #1a3a4d;
        box-shadow: 0 4px 12px rgba(44, 95, 125, 0.4);
        transform: translateY(-2px);
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
</head>
<body>
<div class="status-container">
    <h2>Password Reset Status</h2>
    <div class="message <?= $status; ?>">
        <?= $message; ?>
    </div>
    <a href="<?= $redirect; ?>" class="back-btn">← Go Back</a>
</div>
</body>
</html>