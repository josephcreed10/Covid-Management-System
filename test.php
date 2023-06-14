<?php
session_start();
if(!isset($_SESSION['username']))
{
    header('location: login.php?loginfirst');
    exit();
}
$e1=$e2=$e3="";
include('connection.php');
if(isset($_POST['submit']))
{
    $testid=$_POST['testid'];
    $newteststatus=$_POST['teststatus'];
    $testdate=$_POST['testdate'];
    $pid=$_GET['pid'];
    $sql="select test_status from test_data where p_id=$pid;";
    $result=mysqli_query($con,$sql);
    $row=mysqli_fetch_assoc($result);
    $teststatus=$row['test_status'];
    require('functions.php');
    if(!empty($testid))
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
    if(checktestdate($testdate,$pid)!=false)
    {
        $e3="**Test on same date exists**";
    }
    if(empty($e1)&&empty($e2)&&empty($e3))
  {
    if($teststatus!=$newteststatus&&$newteststatus=="negative")
    {
        $sql="update patient set Datecure='$testdate' where patient_id='$pid';";
        $result=mysqli_query($con,$sql);
    }
    $sql="insert into test(test_id,test_status,test_date,p_id)values('$testid','$newteststatus','$testdate','$pid');";
    $result=mysqli_query($con,$sql);
    if($result)
    {
        header("location:patientdetailed.php?detailid=$pid");
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
            <label for="test_id">Test ID:</label><input type="text" id="testid" name="testid" required>
            <span class="error">
   <?php
    echo"$e1";
    echo"$e2";
    ?> 
    </span><br>
       <label for="teststatus">Test Status:</label>
     <select id="teststatus" name="teststatus"> 
     <option value="positive">Positive</option> 
     <option value="negative">Negative</option> 
</select><br>
<label for="testdate">Test Date:</label>
<input type="date" name="testdate" required> <span class="error">
   <?php
    echo"$e3";
    ?> 
    </span><br>
<button type="submit" name="submit">Submit</button>
</div>
</form>
</section>
        </body>
</html>