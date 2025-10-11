<?php
$host = "127.0.0.1:3307";
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