<?php
$username=$pass="";
if (isset($_POST['submit']))
{
    include('connection.php');  
    $username=$_POST['username'];  
    $pass=$_POST['pass'];  
      
        $sql="select *from users where username='$username'";  
        $result=mysqli_query($con, $sql);   
        $count=mysqli_num_rows($result);  
          
        if($count==1)
        {  
            $row=mysqli_fetch_assoc($result);
            if($pass==$row['password']) 
            {
                session_start();
                $_SESSION['username']=$username;
                $_SESSION['userid']=$row['userid'];
                $_SESSION['role']=$row['role'];
                header('location: home.php');
            }
            else
            {
             header('location: login.php?incorrectpass');
            }
        }  
        else
        {  
            header('location: login.php?incorrectusername');
        }   
    }  
?>  <!DOCTYPE html>
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
    </section>
    <section id="interface">
        <div class="navigation">
            <div class="n1">
                <div class="search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search">
                </div>
            </div>
            <div class="links">
            <a href='login.php'> <button>Login</button></a>
            <a href='register.php'><button>Register</button></a>
            </div>
        </div>
          </section>
          <section id="logindetails">
            <div class="login">
            <div><span class="error"><?php if(isset($_GET['loginfirst']))echo"Login First";?></span>
            <form method="POST">
                <br>
                <label for="username">User Name</label>
<input type="text" name="username" id="username" value="<?php echo $username;?>" placeholder="User Name" required>
<span class="error">
<?php if(isset($_GET['incorrectusername'])) echo"Incorrect Username";?>
</span>
<br><br>
<label for="pass">Password</label>
<input type="password" name="pass" id="pass" value="<?php echo $pass;?>" placeholder="Password" required><br><br><br>
<input type="checkbox" onclick="myFunction()"><label>Show Password</label><br>
<span class='error'>
<?php if(isset($_GET['incorrectpass'])) echo"Incorrect Password";?>
</span>
<button type="submit" name="submit">Login</button>&nbsp
<button type="reset">Reset</button>
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