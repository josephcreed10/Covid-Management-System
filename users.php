<?php
session_start();
if(!isset($_SESSION['username']))
{
    header('location: login.php?loginfirst');
    exit();
}
include("connection.php");
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
                       $sql=("select count(*) from users;");
                       $result=mysqli_query($con,$sql);
                       $row=mysqli_fetch_assoc($result);
                       echo $row['count(*)'];
                      ?> </h3>
                    <span>Total Users</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa-solid fa-users"></i>
                <div>
                    <h3><?php   
                       $date=date("Y/m/d");
                       $sql=("select count(*) from users where date='$date';");
                       $result=mysqli_query($con,$sql);
                       $row=mysqli_fetch_assoc($result);
                       echo $row['count(*)'];
                      ?> </h3>
                    <span>New Users</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa-solid fa-users"></i>
                <div>
                    <h3><?php   
                       $sql=("select count(*) from users where role='hospital';");
                       $result=mysqli_query($con,$sql);
                       $row=mysqli_fetch_assoc($result);
                       echo $row['count(*)'];
                      ?></h3>
                    <span>Hospital</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa-solid fa-users"></i>
                <div>
                    <h3><?php   
                       $sql=("select count(*) from users where role='health officer';");
                       $result=mysqli_query($con,$sql);
                       $row=mysqli_fetch_assoc($result);
                       echo $row['count(*)'];
                      ?></h3>
                    <span>Health Officer</span>
                </div>
            </div>
        </div>
        <div class="adduserbutton">
        <button><a href="addusers.php">Add User</a></button>
</div>
        <div>
            <dir class="board">
                <table width="100%">
                    <thead>
                    <tr>
                      <th>User ID</th>
                      <th>User Name</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th>Password</th>
                      <th>Operations</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql="select* from users;";
                    $result=mysqli_query($con,$sql);
                    if($result)
                    {
                      while($row=mysqli_fetch_assoc($result))
                      {
                      $userid=$row['userid'];
                      $username=$row['username'];
                      $email=$row['email'];
                      $role=$row['role'];
                      $pass=$row['password'];
                      echo" <tr><th><h5>".$userid."</h5></th>
                      <td class='username'><p>".$username."</p></td>
                      <td class='email'>".$email."</td>
                      <td class='role'>".$role."</td>
                      <td class='pass'>".$pass."</td><td><a href='update.php?updateid=$userid'><button>Update</button></a>&nbsp<a href='delete.php?deleteid=$userid'><button>Delete</button></a></td></tr>";
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