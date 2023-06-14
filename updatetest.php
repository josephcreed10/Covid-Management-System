<?php
session_start();
if(!isset($_SESSION['username']))
{
    header('location: login.php?loginfirst');
    exit();
}
$e1=$e2=$e3="";
include('connection.php');
if(isset($_GET['updatetestid']))
{
 $testid=$_GET['updatetestid'];
 $sql="select* from test where test_id=$testid;";
 $result=mysqli_query($con,$sql);
 if($result)
 {
    $row=mysqli_fetch_assoc($result);
    $testid=$row['test_id'];
    $teststatus=$row['test_status'];
    $testdate=$row['test_date'];
    $pid=$row['p_id'];
 }
if(isset($_POST['submit']))
{
    $newtestid=$_POST['testid'];
    $newteststatus=$_POST['teststatus'];
    $newtestdate=$_POST['testdate'];
    require('functions.php');
    if($testid!=$newtestid)
    {
    if(checkid($testid)!=false)
    {
        $e1="**Use only digits**";
    }
    elseif(dup_testid($testid)!=false)
    {
         $e2="**Test ID exists**";
    }
    }
    if($testdate!=$newtestdate)
    {
    if(checktestdate($newtestdate,$pid)!=false)
    {
        $e3="**Test on same date exists**";
    }
    }
    if(empty($e1)&&empty($e2)&&empty($e3))
    {
    if($teststatus!=$newteststatus&&$newteststatus=="negative")
    {
        $sql="update patient set Datecure='$newtestdate' where patient_id='$pid';";
        $result=mysqli_query($con,$sql);
    }
    $sql="update test set test_id='$newtestid',test_status='$newteststatus',test_date='$newtestdate' where test_id=$testid;";
    $result=mysqli_query($con,$sql);
    if($result)
    {
        header("location:patientdetailed.php?detailid=$pid");
    }
}
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <section id="menu">
        <div class="logo">
        <img src="kk.jpg" alt="kkkk">
        <h2>Covid Management</h2>
        </div>
        <div class="items">
        <?php 
         if($_SESSION['role']=='admin')
         echo "<a href='users.php'><li><i class='fa-solid fa-user'></i>Admin Dashboard</li></a>";
         if($_SESSION['role']=='admin'||$_SESSION['role']=='hospital'||$_SESSION['role']=='health officer')
         echo "<a href='patients.php'>  <li><i class='fa-solid fa-head-side-mask'></i>Patients</li></a>";
         if(isset($_SESSION['role']))
         echo "<a href='home.php'><li><i class='fa-solid fa-house-user'></i>Home</li></a>";?>
         <a href="symptomps.php"><li><i class="fa-solid fa-mask-face"></i>Symptoms</li></a>
        </div>
        </div>
    </section>
    <section id="interface">
    <div class="navigation">
            <div class="n1">
                <div class="search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search">
                </div>
            </div>
            <div class="profile">
            <b style="color:grey"> <?php echo "Logged In as ".$_SESSION['role'];?></b>
                <div class="right-menu">
<i class="fa-solid fa-user"></i>
<div class="dropdown-menu">
<li><a style="color:black" href="home.php">Home</a></li>
<li><a style="color:black" href="#">About</a></li>
<li><a style="color:black" href="logout.php">Logout</a></li>
</div>
</div>    
            </div>
        </div>
          </section>
          <section id="details">
          <form method="POST">
          <br><br>
          <div>
         <label for="test_id">Test ID:</label><input type="text" id="testid" name="testid" value="<?php echo $testid;?>" required> <span class="error">
   <?php
    echo"$e1"."<br>";
    echo"$e2"."<br>";
    ?> 
    </span><br<br>
       <label for="teststatus">Test Status:</label>
     <select id="teststatus" name="teststatus" > 
     <option value="positive" <?php if($teststatus == "positive") echo "SELECTED";?>>Positive</option> 
     <option value="negative" <?php if($teststatus == "negative") echo "SELECTED";?>>Negative</option> 
</select><br>
<label for="testdate">Test Date:</label>
<input type="date" name="testdate" value="<?php echo $testdate;?>" required> <span class="error">
   <?php
    echo"$e3";
    ?> 
    </span><br<br>
<button type="submit" name="submit">Update</button>
</div>
</form>
</section>
        </body>
</html>