<?php
session_start();
if(!isset($_SESSION['username']))
{
    header('location: login.php?loginfirst');
    exit();
}
  include('connection.php');
  $today=date("Y/m/d");
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
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
        <h3 class="i-name">Dashboard</h3>
        <div class="values">
            <div class="val-box">
                <i class="fa-solid fa-users"></i>
                <div>
                    <h3><?php   
                        $sql="select sum(case when test_date='$today' then 1 else 0 end)as total_test,sum(case when test_date='$today' and test_status='positive' then 1 else 0 end)as total_positive from test;";
                        $result=mysqli_query($con,$sql);
                        $row=mysqli_fetch_assoc($result);
                        $totaltest=$row['total_test'];
                        $totalpositive=$row['total_positive'];
                        $sql=("select count(*) as total_cured from patient where test_status='negative' and Datecure='$today';");
                        $result=mysqli_query($con,$sql);
                        $row=mysqli_fetch_assoc($result);
                        $totalcured=$row['total_cured'];
                        if(($totaltest-$totalcured)==0)
                        {
                            $tpr="Not set";
                        }
                        else
                        {
                        $tpr=($totalpositive/($totaltest-$totalcured))*100;
                        }
                        echo $tpr;
                      ?></h3>
                    <span>TPR</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa-solid fa-users"></i>
                <div>
                    <h3><?php
                    $sql2="select count(*) from test where test_date='$today' and test_status='positive';";
                    $result2=mysqli_query($con,$sql2);
                    $row2=mysqli_fetch_assoc($result2);
                    $totalpositive=$row2['count(*)'];
                    echo $totalpositive;
                    ?></h3>
                    <span>New Cases today</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa-solid fa-users"></i>
                <div>
                    <h3><?php
                     $sql3=("select count(*) from patient where test_status='negative' and Datecure='$today';");
                     $result3=mysqli_query($con,$sql3);
                     $row3=mysqli_fetch_assoc($result3);
                     $totalnegative=$row3['count(*)'];
                     echo $totalnegative;
                     ?></h3>
                    <span>Cured today</span>
                </div>
            </div>
        </div>
        <div>
            <dir class="board">
                <table width="100%">
                    <thead>
                <tr>
    <th>Local Body</th>
    <th>Total Cases</th>
    <th>New Cases Today</th>
  </tr>
</thead>
<tbody>
  <?php
  $sql4="select * from localbody_totalcaseandnewcase;";
  $result4=mysqli_query($con,$sql4);
  if($result4)
  {
    while($row4=mysqli_fetch_assoc($result4))
    {
    $localbody=$row4['localbody'];
    $totalcase=$row4['totalcase'];
    $newcase=$row4['newcase'];
    echo" <tr><th><h5>".$localbody."</h5></th>
    <td><p>".$totalcase."</p></td>
    <td><p>".$newcase."</td></tr><p>";
    }
  }
?>
</tbody>
</table>
                  
            </dir>
        </div>
       <div  align="center">
       <canvas id="myChart1" style="width:50%;max-width:600px"></canvas><br><br>
        <canvas id="myChart2" style="width:50%;max-width:600px"></canvas></div>
         </section>
         <script>
var xValues = [<?php
 $sql4="select * from localbody_totalcaseandnewcase;";
 $result4=mysqli_query($con,$sql4);
 if($result4)
 {
   while($row4=mysqli_fetch_assoc($result4))
   {
   $localbody=$row4['localbody'];
echo "'".$localbody."',"; 
   }
}
?>];
var yValues = [
    <?php
 $sql4="select * from localbody_totalcaseandnewcase;";
 $result4=mysqli_query($con,$sql4);
 if($result4)
 {
   while($row4=mysqli_fetch_assoc($result4))
   {
    $totalcase=$row4['totalcase'];
echo $totalcase.","; 
   }
}
?>
];
var barColors = [
  "#b91d47",
  "#00aba9",
  "#2b5797",
  "#FFA500",
  "#1e714f",
  "#0e714y",
  "#3ff14e"
];

new Chart("myChart1", {
  type: "doughnut",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "Total Cases"
    }
  }
});
</script>
<script>
var xValues = [
    <?php
 $sql4="select * from localbody_totalcaseandnewcase;";
 $result4=mysqli_query($con,$sql4);
 if($result4)
 {
   while($row4=mysqli_fetch_assoc($result4))
   {
   $localbody=$row4['localbody'];
echo "'".$localbody."',"; 
   }
}
?>

];
var yValues = [
    <?php
 $sql4="select * from localbody_totalcaseandnewcase;";
 $result4=mysqli_query($con,$sql4);
 if($result4)
 {
   while($row4=mysqli_fetch_assoc($result4))
   {
    $newcase=$row4['newcase'];
echo $newcase.","; 
   }
}
?>
];
var barColors = [
  "#b91d47",
  "#00aba9",
  "#2b5797",
  "#FFA500",
  "#1e714f",
  "#0e714y",
  "#3ff14e"
];

new Chart("myChart2", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "New Cases Today"
    }
  }
});
</script>
</body>
</html>
