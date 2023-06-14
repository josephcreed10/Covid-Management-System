<?php
function checkusername($name)
{
    if (!preg_match("/^[a-zA-Z-'0-9 ]*$/",$name))
     {
       $error=true;
     }
     else
     {
        $error=false;
     }
 return $error;
}

function checkemail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        $emailErr=true;
    }
    else
    {
        $emailErr=false;
    }
    return $emailErr;
}
function dup_username($username)
{
    include('connection.php');
    $sql="select * from users where username='$username';";
    $result=mysqli_query($con,$sql);
    $count = mysqli_num_rows($result);
    if($count==1)
    {
        $userexist=true;
    }
    else
    {
        $userexist=false;
    }
    return  $userexist;
}
function dup_userid($userid)
{
    include('connection.php');
    $sql="select * from users where userid=$userid;";
    $result=mysqli_query($con,$sql);
    $count = mysqli_num_rows($result);
    if($count==1)
    {
        $useridexist=true;
    }
    else
    {
        $useridexist=false;
    }
    return  $useridexist;
}

function checkid($id)
{
    if (!is_numeric($id))
     {
       $error=true;
     }
     else
     {
        $error=false;
     }
 return $error;
}



function check($teststatus)
{
    if(strcmp($teststatus,"positive")==0)
    {
        $color='red';
    }
    else
    {
        $color='blue';
    }
    return $color;
}

function dup_patientid($patientid)
{
    include('connection.php');
    $sql="select * from patient where patient_id=$patientid;";
    $result=mysqli_query($con,$sql);
    $count = mysqli_num_rows($result);
    if($count==1)
    {
        $useridexist=true;
    }
    else
    {
        $useridexist=false;
    }
    return  $useridexist;
}

function validate_phone_number($phone)
{
    if(preg_match('/^[0-9]{10}+$/', $phone)) {
       $error=false;
        } else {
        $error=true;
        }
        return $error;
}

function checkname($name)
{
    if (!preg_match ("/^[a-zA-z ]*$/", $name) ) {  
        $ErrMsg=true; 
    } 
    else {  
        $ErrMsg=false; 
    }  
    return $ErrMsg;
}
function dup_testid($testid)
{
    include('connection.php');
    $sql="select * from test where test_id=$testid;";
    $result=mysqli_query($con,$sql);
    $count = mysqli_num_rows($result);
    if($count==1)
    {
        $useridexist=true;
    }
    else
    {
        $useridexist=false;
    }
    return  $useridexist;
}
function checktestdate($testdate,$pid)
{
    include('connection.php');
    $sql="select test_date from test where p_id=$pid;";
    $result=mysqli_query($con,$sql);
    while($row=mysqli_fetch_assoc($result))
    {
        $ctestdate=$row['test_date'];
        if($ctestdate==$testdate)
        {
            return true;
            break;
        }
       
    }
    return false;
}
function dup_email($email)
{
    include('connection.php');
    $sql="select * from users where email='$email';";
    $result=mysqli_query($con,$sql);
    $count = mysqli_num_rows($result);
    if($count==1)
    {
        $useridexist=true;
    }
    else
    {
        $useridexist=false;
    }
    return  $useridexist;
}
?>