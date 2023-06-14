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
    $userid=$_GET['deleteid'];
    $sql="delete from users where userid=$userid;";
    $result=mysqli_query($con,$sql);
    if($result)
    {
        header("location:users.php");
    }
    else
    {
        die("Failed to connect with MySQL: ". mysqli_connect_error());

    }
}
else{
    header("location:users.php");
}
?>