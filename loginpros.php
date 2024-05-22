<?php
   include("db/config.php");
   session_start();

   if(isset($_POST['userid']) && isset($_POST['password']))
   {
    $userid= ($_POST['userid']);
    $password=($_POST['password']);
    if(empty($userid) || empty($password)){
        header("Location:login.php?error:enter the userid");
        exit();
    }
    else{
        $sql="SELECT * FROM employees WHERE userid='$userid' AND password='$password' ";
        $result=mysqli_query($mysqli,$sql);
        if(mysqli_num_rows($result))
        {
            $row=mysqli_fetch_assoc($result);
            if($row['usertype']==="manager"){
                header("Location:register.php");
                exit();
            }
            else if($row['userid']===$userid && $row['password']===$password)
            {
                $_SESSION['userid']=$row['userid'];
                $_SESSION['name']=$row['name'];
                $_SESSION['number']=$row['number'];
                $_SESSION['emailid']=$row['emailid'];
                $_SESSION['usertype']=$row['usertype'];
                $_SESSION['annualleave']=$row['annualleave'];
                $_SESSION['casualsickleave']=$row['casualsickleave'];
                $_SESSION['joiningdate']=$row['joiningdate'];
                $_SESSION['onduty']=$row['onduty'];
                $_SESSION['maternity']=$row['maternity'];
                $_SESSION['paternity']=$row['paternity'];
                $_SESSION['lop']=$row['lop'];
                $_SESSION['gender']=$row['gender'];
                header("Location:profile.php");
                exit();
            }
        }else{
            header("Location:login.php?error:Enter valid id and password");
            exit();
        }
    }
   }
   