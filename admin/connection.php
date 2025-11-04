<?php
$host = "localhost";
$username = "root";
$password = "";
$db_name = "newsalary";

// Create connection
$conn = mysqli_connect($host, $username, $password, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>