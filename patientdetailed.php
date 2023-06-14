<?php
session_start();
if(!isset($_SESSION['username']))
{
    header('location: login.php?loginfirst');
    exit();
}
if(isset($_GET['detailid']))
{
  $id=$_GET['detailid']; 
  include("connection.php");
  include('functions.php');
  $sql="select* from patient where patient_id=$id;";
  $result=mysqli_query($con,$sql);
  if($result)
  {
    $row=mysqli_fetch_assoc($result);
    $patientid=$row['patient_id'];
    $patientname=$row['patient_name'];
    $address=$row['address'];
    $age=$row['age'];
    $localbody=$row['panchayath_or_muncipality'];
   $mobile=$row['mobile'];
   $gender=$row['gender'];
   $condition=$row['patient_condition'];
   $teststatus=$row['test_status'];
   $quarentine=$row['quarentine'];
   $hospital=$row['hospital'];
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
    <section>
    <div class="patientdetails">
        <h3>Patient&nbspDetails</h3><br>
        <text>Name:&nbsp<?php echo $patientname;?></text><br><br>
        <text>Patient ID:&nbsp<?php echo $patientid;?></text><br><br>
        <text>Address:&nbsp<?php echo $address;?></text><br><br>
        <text>Age:&nbsp<?php echo $age;?></text><br><br>
        <text>Locality:&nbsp<?php echo $localbody;?></text><br><br>
        <text>Mobile:&nbsp<?php echo $mobile;?></text><br><br>
        <text>Gender:&nbsp<?php echo $gender;?></text><br><br>
        <text>Test&nbspStatus:&nbsp<?php echo $teststatus;?></text><br><br>
        <text>Quarentine:&nbsp<?php echo $quarentine;?></text><br><br>
        <text>Condition:&nbsp<?php echo $condition;?></text><br><br>
        <text>Hospital:&nbsp<?php echo $hospital;?></text><br>
      
       

 <dir class="board">
                <table width="500px">
                    <thead>
                <tr>
    <th>&nbspTest&nbspID&nbsp&nbsp</th>
    <th>&nbspTest&nbspStatus</th>
    <th>&nbspTest&nbspDate</th>
    <th>Operations&nbsp&nbsp</th>
  </tr>
</thead>
<tbody>
  <?php
  $sql="select* from test where p_id='$id' order by test_date;";
  $result=mysqli_query($con,$sql);
  if($result)
  {
    while($row=mysqli_fetch_assoc($result))
    {
    $testid=$row['test_id'];
    $teststatus=$row['test_status'];
    $testdate=$row['test_date'];
    $color=check($teststatus);
    echo" <tr><th><h5>".$testid."</h5></th>
    <td><h3 style='color:$color;'>".$teststatus."</h3></td>
    <td>".$testdate."</td><td><button><a href='updatetest.php?updatetestid=$testid'>Update</a></button>&nbsp<button><a href='deletetest.php?deletetestid=$testid'>Delete</button></td></tr>";
   
    }
  }
?>
</tbody>
</table>
                  
            </dir>
            <br>
            <button><a href='patients.php'>Go Back</a></button>&nbsp<button><a href="test.php?pid=<?php echo $patientid;?>">Add Test</a></button>
            </div>
</section>
</body>
</html>