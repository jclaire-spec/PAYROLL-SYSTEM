<?php
session_start();
$log = session_destroy();
if($log)
{
	header('Location:index.php');
}
?>