<?php
session_start();
if(!isset($_SESSION['username']))
{
    header('location: login.php?loginfirst');
    exit();
}
   include('connection.php');
   $e1=$e2=$e3=$e4=$e5=$patientname=$address=$age=$localbody=$mobile=$gender=$condition=$teststatus=$quarentine=$testid=$teststatus=$testdate="";
   if(isset($_POST['submit']))
   {
    $patientname=$_POST['patientname'];
    $address=$_POST['address'];
    $age=$_POST['age'];
    $localbody=$_POST['localbody'];
    $mobile=$_POST['mobile'];
    $gender=$_POST['gender'];
    $condition=$_POST['condition'];
    $teststatus=$_POST['teststatus'];
    $quarentine=$_POST['quarentine'];
    $id=$_SESSION['userid'];
    $testid=$_POST['testid'];
    $teststatus=$_POST['teststatus'];
    $testdate=$_POST['testdate'];
  
    require('functions.php');
    if(!empty($patientid))
    {
    if(checkid($patientid)!=false)
    {
        $e1="**Use only digits**";
    }
    elseif(dup_patientid($patientid)!=false)
    {
            $e2="**Patient ID exists**";
    }
    }

    if(checkname($patientname)!=false)
    {
        $e3="**Only letters and whitespaces allowed**";
    }

    if(validate_phone_number($mobile)!=false)
    {
        $e4="**Enter valid mobile no**";
    }
    if(dup_testid($testid))
    {
        $e5="**Test ID exists**";
    }
   
if(empty($e1)&&empty($e2)&&empty($e3)&&empty($e4)&&empty($e5))
{
    $sql="insert into patient (patient_name,address,age,panchayath_or_muncipality,gender,mobile,patient_condition,date,quarentine,hospital)values('$patientname','$address','$age','$localbody','$gender','$mobile','$condition','$testdate','$quarentine',$id);";
    $result=mysqli_query($con,$sql);
    if($result)
    {
        {
            $sql="select last_insert_id() as id;";
            $result=mysqli_query($con,$sql);
            $row=mysqli_fetch_assoc($result);
            $patientid=$row['id'];
        }
    $sql="insert into test(test_id,test_status,test_date,p_id)values('$testid','$teststatus','$testdate','$patientid');";
    $result=mysqli_query($con,$sql);
    if($result)
    {
        $sql="update patient set test_status=(select test_status from test_data where patient.patient_id=test_data.p_id);";
        $result=mysqli_query($con,$sql);
        header("location:patients.php");
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
            <div>
            <form method="POST">
                <br>
    <span class="error">
    <?php
    echo"$e1";
    echo"$e2";
    ?> 
    </span>
    <br>
    <label for="patientname">Patient Name:</label>
    <input type=text placeholder="Patient Name" name='patientname' id="patientname" value="<?php echo$patientname;?>"  required>
    <span class="error">
   <?php
    echo"$e3";
    ?> 
    </span>
    <br>
    <label for="address">Address:</label><br>
    <textarea rows="5" cols="50" placeholder="Address" name='address' id="address" required><?php echo$address;?></textarea>
    <br>
     <label for="age">Age:</label>
     <input type=text placeholder="Age" name='age' id="age" value="<?php echo$age;?>" required> 
    <br>
    <label for="mobile">Mobile:</label>
    <input type=text placeholder="Mobile No" name="mobile" id="mobile" value="<?php echo$mobile;?>" required>
   <span class="error"> 
    <?php echo $e4;?>
</span><br>

   <label for="localbody">Panchayath/Muncipality:</label>
    <input type=text placeholder="Local Body" name="localbody" id="localbody" value="<?php echo$localbody;?>" required><br>

<label for="gender">Gender:</label>
    <select name="gender" id="gender">
     <option value="male" <?php if($gender == "male") echo "SELECTED";?>>Male</option>
     <option value="female" <?php if($gender == "female") echo "SELECTED";?>>Female</option>
     <option value="other" <?php if($gender == "other") echo "SELECTED";?>>Other</option>
     </select><br>
     <label for="test_id">Test ID:</label><input type="text" id="testid" name="testid" value="<?php echo $testid;?>" required>
    <span class="error">
     <?php echo $e5;?></span>
     <br>
       <label for="teststatus">Test Status:</label>
     <select id="teststatus" name="teststatus" onchange="myFunction()"> 
     <option value="positive" <?php if($teststatus == "positive") echo "SELECTED";?>>Positive</option> 
     <option value="negative" <?php if($teststatus == "negative") echo "SELECTED";?>>Negative</option> 
</select><br>
<label for="testdate">Test Date:</label>
<input type="date" name="testdate" max="<?php echo date('Y/m/d')?>" value="<?php echo $testdate;?>" required><br>
<label for="quarentine">Quarentine:</label>
<select name="quarentine" id="quarentine">
    <option value="home" <?php if($quarentine == "home") echo "SELECTED";?>>Home Quarentine</option>
    <option value="hospital" <?php if($quarentine == "hospital") echo "SELECTED";?>>Hospital</option>
</select><br>
<label for="condition">Condition:</label>    
<select name="condition" id="condition">
     <option value="normal" <?php if($condition=="normal") echo "SELECTED";?>>Normal</option>
     <option value="critical"  <?php if($condition=="critical") echo "SELECTED";?>>Critical</option>
     <option value="dead"  <?php if($condition=="dead") echo "SELECTED";?>>Dead</option>
</select> 
<br>
     <button type="submit" name="submit">Add</button>
</form>

              </div>
           </section>
         <script> 
          function myFunction() {
  var x = document.getElementById("teststatus").value;
  var y="positive"
  if(x!=y)
  {
    document.getElementById("quarentine").disabled=true;
    document.getElementById("condition").disabled=true;
  }
  else{
    document.getElementById("quarentine").disabled=false;
    document.getElementById("condition").disabled=false;
  }
}
</script>
</body>
</html>