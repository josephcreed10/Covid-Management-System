<?php
session_start();
if(!isset($_SESSION['username']))
{
    header('location: login.php?loginfirst');
    exit();
}
include("connection.php");
require("functions.php");
$sql="update patient set test_status=(select test_status from test_data where patient.patient_id=test_data.p_id);";
$result=mysqli_query($con,$sql);
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
        </div>v>
        </div>
        <h3 class="i-name"></h3>
        <div class="values">
            <div class="val-box">
                <i class="fa-solid fa-users"></i>
                <div>
                    <h3><?php   
                       $sql=("select count(*) from total_positive;");
                       $result=mysqli_query($con,$sql);
                       $row=mysqli_fetch_assoc($result);
                       echo $row['count(*)'];
                      ?></h3>
                    <span>Total affected</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa-solid fa-users"></i>
                <div>
                    <h3><?php   
                       $today=date("Y/m/d");
                       $sql=("select count(*) from test where test_status='positive' and test_date='$today';");
                       $result=mysqli_query($con,$sql);
                       $row=mysqli_fetch_assoc($result);
                       echo $row['count(*)'];
                      ?></h3>
                    <span> Positive today</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa-solid fa-users"></i>
                <div>
                    <h3><?php   
                       $today=date("Y/m/d");
                       $sql=("select count(*) from patient where test_status='negative' and Datecure='$today';");
                       $result=mysqli_query($con,$sql);
                       $row=mysqli_fetch_assoc($result);
                       echo $row['count(*)'];
                      ?></h3>
                    <span>Cured Today</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa-solid fa-users"></i>
                <div>
                    <h3><?php   
                       $today=date("Y/m/d");
                       $sql=("select count(*) from test where test_date='$today';");
                       $result=mysqli_query($con,$sql);
                       $row=mysqli_fetch_assoc($result);
                       echo $row['count(*)'];
                      ?></h3>
                    <span>Total Tests today</span>
                </div>
            </div>
        </div>
            <div class="adduserbutton">
            <a href="addpatients.php"> <button>Add New Patient</button></a>
            </div>   
        <div>
            <dir class="board">
                <table width="100%">
                    <thead>
                <tr>
    <th>Patient ID&nbsp &nbsp </th>
    <th>Patient Name</th>
    <th>Age</th>
    <th>Gender</th>
    <th>Contact No</th>
    <th>Test Status</th>
    <th>Operations&nbsp&nbsp</th>
  </tr>
</thead>
<tbody>
  <?php
  $sql="select* from patient;";
  $result=mysqli_query($con,$sql);
  if($result)
  {
    while($row=mysqli_fetch_assoc($result))
    {
    $patientid=$row['patient_id'];
    $patientname=$row['patient_name'];
    $age=$row['age'];
   $mobile=$row['mobile'];
   $gender=$row['gender'];
   $teststatus=$row['test_status'];
   $color=check($teststatus);
    echo" <tr><th><h5>".$patientid."</h5></th>
    <td><p>".$patientname."</p></td>
    <td>".$age."</td>
    <td>".$gender."</td>
    <td>".$mobile."</td>
    <td><h1 style='color:$color;'>".$teststatus."</h1></td>
    <td><a href='patientdetailed.php?detailid=$patientid'><button>Details</button></a>&nbsp<a href='updatepatient.php?updateid=$patientid'><button>Update</button></a>&nbsp<a href='deletepatient.php?deleteid=$patientid'><button>Delete</button></a></td></tr>";
    }
  }
?>
</tbody>
</table>
                  
            </dir>
        </div>
    </section>
</body>
</html>