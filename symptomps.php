<?php
session_start();
if(!isset($_SESSION['username']))
{
    header('location: login.php?loginfirst');
    exit();
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
        <div class="kk"><img src="symptoms.jpg" alt="Symptoms"></div>
          </section>
        </body>
</html>