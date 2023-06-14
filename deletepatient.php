<?php
session_start();
if(!isset($_SESSION['username']))
{
    header('location: login.php?loginfirst');
    exit();
}
include("connection.php");
if(isset($_GET['deleteid']))
{
    $patientid=$_GET['deleteid'];
    $sql="delete from patient where patient_id=$patientid;";
    $result=mysqli_query($con,$sql);
    if($result)
    {
        header("location:patients.php");
    }
    else
    {
        die("Failed to connect with MySQL: ". mysqli_connect_error());

    }
}
else
{
    header("location: patients.php");
}

?>