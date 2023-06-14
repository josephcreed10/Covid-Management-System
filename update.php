<?php
session_start();
if(!isset($_SESSION['username']))
{
    header('location: login.php?loginfirst');
    exit();
}
   include('connection.php');
   $e1=$e2=$e3=$e4=$e5=$newuserid=$newusername="";
   if(isset($_GET['updateid']))
   {
   $id=$_GET['updateid'];
   $sql="select* from users where userid=$id;";
   $result=mysqli_query($con,$sql);
  if($result)
  {
    $row=mysqli_fetch_assoc($result);
    $userid=$row['userid'];
    $username=$row['username'];
    $email=$row['email'];
    $role=$row['role'];
    $pass=$row['password'];
  }
   if(isset($_POST['submit']))
   {
   $newuserid=$_POST['userid'];
   $newusername=$_POST['username'];
   $email=$_POST['email'];
   $role=$_POST['role'];
   $pass=$_POST['pass'];
   require('functions.php');
   if($userid!=$newuserid)
   {
   if(checkid($newuserid)!=false)
    {
        $e1="**Use only digits**";
    }
    elseif(dup_userid($newuserid)!=false)
    {
            $e2="**User ID exists**";
    }
    }
    if(strcmp($username,$newusername)!=0)
    {
    if(checkusername($newusername)!=false)
    {
      $e4="**Use digits and letters**";
    }
    elseif(dup_username($newusername)!=false)
    {
      $e3="**Username exists**";
    }
    }
   
    if(checkemail($email)!=false)
    {
       $e5="**Enter valid email**";
    }
    if(empty($e1)&&empty($e2)&&empty($e3)&&empty($e4)&&empty($e5))
    {
   $sql="update users set userid=$newuserid,username='$newusername',email='$email',role='$role',password='$pass' where userid=$id;";
   $result=mysqli_query($con,$sql);
   if($result)
   {
       header("location:users.php");
   }
   else{
    die("Failed to connect with MySQL: ". mysqli_connect_error()); 
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
            <div class="addusers">
            <form method="POST">
                <br>
    <label for="userid"> User ID: </label>
    <input type="text" placeholder="User ID" name="userid" id="userid" value="<?php 
    if(empty($newuserid))
    {echo $userid;}
     else
    {echo $newuserid;}?>">
    <span class="error">
    <?php
    echo"$e1";
    echo"$e2";
    ?> 
    </span>
    <br>
    <label for="username">User Name:</label>
    <input type="text" placeholder="User Name" name='username' id="username" value="<?php if(empty($newusername))
    {echo $username;}
     else
    {echo $newusername;}?>"  required>
    <span class="error">
   <?php
    echo"$e4";
    echo"$e3";
    ?> 
    </span>
    <br>
    <label for="email">Email:</label>
    <input type="text" placeholder="Email" name='email' id="email" value="<?php echo$email;?>" required>
    <span class="error">
    <?php
    echo"$e5";
    ?> 
    </span>
    <br>
    <label for="role">Role:</label>
     <select name="role" id="role">
     <option value="admin" <?php if($role=='admin') echo "SELECTED"; ?> >Admin</option>
     <option value="health officer" <?php if($role=='health officer') echo "SELECTED"; ?>>Health Officer</option>
     <option value="hospital" <?php if($role=='hospital') echo "SELECTED"; ?>>Hospital</option>
     <option value="user"  <?php if($role=='user') echo "SELECTED"; ?>>User</option>
     </select><br>
     <label for="pass">Password:</label>
     <input type="password" placeholder="Password" name='pass' id="pass" value="<?php echo$pass;?>" required> 
     <input type="checkbox" onclick="myFunction()">Show Password<br>
     <button type="submit" name="submit">Submit</button>
</form>

              </div>
           </section>
</body>
<script>
  function myFunction() {
  var x = document.getElementById("pass");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
</html>