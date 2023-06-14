<?php
session_start();
if(!isset($_SESSION['username']))
{
    header('location: login.php?loginfirst');
    exit();
}
include("connection.php");
if(isset($_GET['deletetestid']))
{
    $testid=$_GET['deletetestid'];
    $sql="select p_id from test where test_id=$testid;";
    $result=mysqli_query($con,$sql);
    $row=mysqli_fetch_assoc($result);
    $pid=$row['p_id'];
    $sql="delete from test where test_id=$testid;";
    $result=mysqli_query($con,$sql);
    if($result)
    {
        header("location:patientdetailed.php?detailid=$pid");
    }
    else
    {
        die("Failed to connect with MySQL: ". mysqli_connect_error());

    }
}
else{
    header("location:patientdetailed.php?detailid=$pid");
}
?>