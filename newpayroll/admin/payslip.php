<?php
session_start();
if (!isset($_SESSION['username'])) 
{
die(header('Location: ../index.php'));
}

?>
<?php
//database connection
include('connection.php');
include('../sanitise.php');
$staff_id = sanitise($_GET['staff_id']);
$salary_id = sanitise($_GET['salary_id']);
$qry =("SELECT * FROM salary WHERE staff_id = '$staff_id' AND salary_id = '$salary_id'");
$update = mysql_query($qry) or die(mysql_error());
$row_update = mysql_fetch_assoc($update);
$totalRows_update = mysql_num_rows($update);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pay Slip</title>
<script language="javascript" type="text/javascript" >
        // Disen
        document.onselectstart=new Function('return false');
        function dMDown(e) {return false;}
        function dOClick() {return true;}
        document.onmousedown=dMDown;
        document.onclick=dOClick
        
        -->
    </script>
<style>
body, html
{
	margin:0;
	padding:0;
	font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
	font-size:11px;
	background-color:#fff;
}
#outerwrapper
{
	width:800px;
	height:auto;
	margin:auto;

}

#slip
{
	width:747px;
	height:auto;
	margin:auto;
	font-size: x-small;
}

#slip2
{
	width:418px;
	height:auto;
	margin-left:150px;
	margin-top:40px;
	text-align: right;
}

.text
{
	font-size:14px;
	font-family:Tahoma, Geneva, sans-serif;
	font-weight:bold;
}
</style>
</head>

<body>
<div id="outerwrapper">
<div id="slip">
<table width="747" border="1">
  <tr>
    <td colspan="4" align="center"><span class="text">INTERNATIONAL COMPANIES LIMITED</span><br />
      <span class="text">NO 11, YOUR AREA, YOUR TOWN, YOUR CITY</span><br />
      info@internationalcompanies.com<br />
      www.internationalcompanies.com<br />
      <br />
<br />
      <table width="200" border="0">
        <tr>
          <td align="center">PAYSLIP</td>
        </tr>
      </table></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Generated At</strong></td>
    <td><i><?php echo $row_update['date_s']; ?></i></td>
  </tr>
  <tr>
    <td><strong>Staff ID</strong></td>
    <td><?php echo $row_update['staff_id']; ?></td>
    <td><strong>Name</strong></td>
    <td width="181"><?php echo $row_update['fname']; ?></td>
  </tr>
  <tr>
    <td width="87"><strong>Department</strong></td>
    <td width="368"><?php echo $row_update['department']; ?></td>
    <td width="83"><strong>Position</strong></td>
    <td><?php echo $row_update['position']; ?></td>
  </tr>
  <tr>
    <td><strong>Years Spent</strong></td>
    <td><?php echo $row_update['years']; ?></td>
    <td><strong>Grade</strong></td>
    <td>GL<?php echo $row_update['grade']; ?></td>
  </tr>
  <tr>
    <td colspan="4">
    <div id="slip2">
    <table width="418" border="1">
      <tr>
        <td width="180"><strong>Basic Salary</strong></td>
        <td width="222"><?php echo $row_update['basic']; ?></td>
      </tr>
      <tr>
        <td><strong>Housing Allowance</strong></td>
        <td><?php echo $row_update['housing']; ?></td>
      </tr>
      <tr>
        <td><strong>Meal Allowance</strong></td>
        <td><?php echo $row_update['meal']; ?></td>
      </tr>
      <tr>
        <td><strong>Transport Allowance</strong></td>
        <td><?php echo $row_update['transport']; ?></td>
      </tr>
      <tr>
        <td><strong>Entertainment Allowance</strong></td>
        <td><?php echo $row_update['entertainment']; ?></td>
      </tr>
      <tr>
        <td><strong>Long Service Allowance</strong></td>
        <td><?php echo $row_update['long_service']; ?></td>
      </tr>
      <tr>
        <td><strong>Tax Deductions</strong></td>
        <td><?php echo $row_update['tax']; ?></td>
      </tr>
      <tr>
        <td><strong>Net Total</strong></td>
        <td><strong>N<?php echo $row_update['totall']; ?></strong></td>
      </tr>
    </table>
   </div></td>
  </tr>
</table>
<table width="747" border="1">
  <tr>
    <td align="center"><br />
      ............................................................<br />
      Acountant </td>
    <td align="center"><br />
      ............................................................<br />
      Finance Manager</td>
  </tr>
  </table>

Click <a href="print.php">here</a> to go back<br />
<a href="javascript:self.print()">Print This Page</a> <br />
</div>
</div>
</body>
</html>