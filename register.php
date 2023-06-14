<?php
   include('connection.php');
   $e3=$e4=$e5=$username= $email= $pass=$message="";
   if(isset($_POST['submit']))
   {
   $username=$_POST['username'];
   $email=$_POST['email'];
   $pass=$_POST['pass'];
    require('functions.php');
    if(checkusername($username)!=false)
    {
      $e4="**Use digits and letters**";
    }
    elseif(dup_username($username)!=false)
    {
      $e3="**Username exists**";
    }
   
    if(checkemail($email)!=false)
    {
       $e5="**Enter valid email**";
    }
    else if(dup_email($email)!=false)
    {
      $e5="**Email is registered before**";
    }

   
if(empty($e3)&&empty($e4)&&empty($e5))
{
   $date=date("Y/m/d");
   $sql="insert into users (username,email,password,role,date)values('$username','$email','$pass','user','$date');";
   $result=mysqli_query($con,$sql);
   if($result)
   {
      $message="Registered Successfully.Go to Login page";
   }
   else{
    die("Failed to connect with MySQL: ". mysqli_connect_error()); 
   }
}
}

?> <!DOCTYPE html>
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
            <form method="POST">
                <br>
    <label for="username">User Name:</label>
    <input type="text" placeholder="User Name" name='username' id="username" value="<?php echo$username;?>"  required>
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
     <label for="pass">Password:</label>
     <input type="password" placeholder="Password" name='pass' id="pass" value="<?php echo$pass;?>" required>
     <input type="checkbox" onclick="myFunction()"><label>Show Password</label><br><br><br>
     <button type="submit" name="submit">Register</button>
</form>
<span style="color:green"><?php echo $message?></span>
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