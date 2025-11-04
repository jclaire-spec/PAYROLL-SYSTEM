<?php
include('../sanitise.php');
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit();
}

include('connection.php');

$admin = $_SESSION['username'];
$staff_id = sanitise($_GET['staff_id']);

$qry = "SELECT * FROM register_staff WHERE staff_id = '$staff_id'";
$update = mysqli_query($conn, $qry) or die(mysqli_error($conn));
$row_update = mysqli_fetch_assoc($update);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Send Message</title>
<link href="../../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
        background: linear-gradient(135deg, #2c5f7d 0%, #1a3a4d 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .message-card {
        background: #f5f1e8;
        border: 1.5px solid #d4c4a8;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        padding: 40px 50px;
        width: 520px;
        animation: fadeIn 0.5s ease;
    }

    .message-card h2 {
        text-align: center;
        color: #1a3a4d;
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 24px;
        border-bottom: 2px solid #d4c4a8;
        padding-bottom: 10px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 18px;
    }

    .form-group label {
        font-size: 14px;
        color: #1a3a4d;
        font-weight: 500;
        margin-bottom: 6px;
    }

    .form-group input[type="text"],
    .form-group textarea {
        width: 100%;
        padding: 12px 14px;
        border: 1.5px solid #d4c4a8;
        border-radius: 10px;
        font-size: 14px;
        background: #ffffff;
        transition: all 0.2s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #2c5f7d;
        box-shadow: 0 0 0 3px rgba(44, 95, 125, 0.1);
    }

    .btn-submit {
        background: #2c5f7d;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        width: 100%;
    }

    .btn-submit:hover {
        background: #1a3a4d;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(44, 95, 125, 0.4);
    }

    .back-link {
        text-align: center;
        margin-top: 20px;
        font-size: 14px;
    }

    .back-link a {
        color: #2c5f7d;
        text-decoration: none;
        font-weight: 500;
    }

    .back-link a:hover {
        text-decoration: underline;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
function proceed() {
    return confirm('Do you want to send a message to Staff ID <?php echo htmlspecialchars($staff_id); ?>?');
}
</script>
</head>

<body>
    <div class="message-card">
        <h2>Send Message</h2>
        <form method="post" action="impro.php" onsubmit="return proceed()">
            <div class="form-group">
                <label>From:</label>
                <input type="text" name="from" value="<?php echo htmlspecialchars($admin); ?>" readonly>
            </div>

            <div class="form-group">
                <label>Staff ID:</label>
                <input type="text" name="staff_id" value="<?php echo htmlspecialchars($row_update['staff_id']); ?>" readonly>
            </div>

            <div class="form-group">
                <label>To:</label>
                <input type="text" name="fname" value="<?php echo htmlspecialchars($row_update['fname']); ?>" readonly>
            </div>

            <div class="form-group">
                <label>Subject:</label>
                <input type="text" name="subject" required>
            </div>

            <div class="form-group">
                <label>Message:</label>
                <textarea name="message" rows="5" required></textarea>
            </div>

            <button type="submit" name="submit" class="btn-submit">Send Message</button>

            <div class="back-link">
                <p>Go <a href="view_staff.php">Back</a></p>
            </div>
        </form>
    </div>
</body>
</html>