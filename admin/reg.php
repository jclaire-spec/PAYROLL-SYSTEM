<?php
if (isset($_POST['submit']))
{
    //database connection
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
    $submit = sanitise($_POST['submit']);

    //record insertion
    $qry = "INSERT INTO register_staff (fname, sex, birthday, department, position, grade, years, username, password) 
            VALUES ('$fname', '$sex', '$birthday', '$department', '$position', '$grade', '$years', '$username', '$password')";

    // ✅ changed this line
    $result = mysqli_query($conn, $qry);

    if($result)
    {
        echo "Staff has been successfully registered";
        echo "<a href='view_staff.php'> View </a>";
    }
    else
    {
        echo "Registration was not completed, please try again";
        echo "<a href='index.php'>Home</a>";
    }
}
?>