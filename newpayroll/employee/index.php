<?php
include('../admin/connection.php');
session_start();
if (!isset($_SESSION['staff_id'])) 
{
die(header('Location: ../index.php'));
}

$staff_id = $_SESSION['staff_id'];
$qry = mysqli_query($conn, "SELECT * FROM register_staff WHERE staff_id = '$staff_id'");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Staff Dashboard</title>
<link rel="stylesheet" href="../css/staff.css?v=20251009" type="text/css" />
<script src="../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="index-outerwrapper">
<div id="header"><img src="../images/staffhead.jpg" alt="Staff Header" /></div>
<div id="links">
  <?php include('link.php'); ?>
</div>
<div id="body">
  <table width="1000" border="0">
    <tr>
      <td width="124" valign="top">
        <img src="../images/UlIqmHJn-SK.gif" width="124" height="110" alt="Avatar" />
        <a href="profile.php">View Complete Profile</a>
        <a href="resetpassword.php" class="bx2" rel="470-200">Change Password</a>
      </td>
      <td width="860" align="left" valign="top">
        <table width="100%" border="0">
          <tr>
            <td align="left" valign="top">
              <table width="395" border="1" align="center">
                <?php 
                if (mysqli_num_rows($qry) > 0) {
                  $row = mysqli_fetch_array($qry);
                ?>
                <tr>
                  <td width="126"><strong>Staff ID</strong></td>
                  <td width="237">&nbsp;<?php echo htmlspecialchars($row['staff_id']); ?></td>
                </tr>
                <tr>
                  <td><strong>Full Name</strong></td>
                  <td>&nbsp;<?php echo htmlspecialchars($row['fname']); ?></td>
                </tr>
                <tr>
                  <td><strong>Department</strong></td>
                  <td>&nbsp;<?php echo htmlspecialchars($row['department']); ?></td>
                </tr>
                <tr>
                  <td><strong>Position</strong></td>
                  <td>&nbsp;<?php echo htmlspecialchars($row['position']); ?></td>
                </tr>
                <tr>
                  <td><strong>Date Joined</strong></td>
                  <td>&nbsp;<?php echo htmlspecialchars($row['date_registered']); ?></td>
                </tr>
                <?php } else { ?>
                <tr>
                  <td colspan="2" style="text-align:center; padding:20px; color:#5a6b75;">
                    Staff information not found.
                  </td>
                </tr>
                <?php } ?>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</div>
</div>

<script type="text/javascript" src="../css/mootools.js"></script> 
<script type="text/javascript" src="../css/bumpbox-2.0.1.js" ></script> 
<script type="text/javascript">
//names,inSpeed,outSpeed,boxColor,backColor,bgOpacity,bRadius,borderWeight,borderColor,boxShadowSize,boxShadowColor,iconSet,effectsIn,effectsOut
doBump('.bx2',850, 500, 'FFF', '6b7477', 0.7, 7, 2 ,'333', 15,'000', 2, Fx.Transitions.Back.easeOut, Fx.Transitions.linear);
</script>
</body>
</html>