<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>admin</title>
	<link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
    <div class="t1">
        <h1 class="l1">Employee Register</h1>
		<ul>
            <li><a href="manapprove.php">Approval Page</a></li>
            <li><a href="register.php">RegisterEmployee</a></li>
            <li><a href="employee.php">Employee List</a></li> 
            <li><a href="login.php">Logout</a></li>
        </ul>
</div>
	<div class="a2">
		<br><h3>Enter Employee details</h3>
<form action="register.php" method="post">
<i class="fa-solid fa-user"></i><input type="text" name="userid" placeholder="enter the userid" required><br><br>
<i class="fa-solid fa-user"></i> <input type="text" name="name" placeholder="enter your name" required><br><br>
<i class="fa-solid fa-key"></i> <input type="password" name="password" placeholder="enter password" required><br><br>
<i class="fa-solid fa-mobile-screen-button"></i><input type="number" name="number" placeholder="enter mobile number" required><br><br>
<i class="fa-solid fa-envelope"></i> <input type="email" name="emailid" placeholder="enter your emailid" required><br><br>
<i class="fa-solid fa-venus-mars"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="gender" id="s1">
            <option value="0"> --Choose Gender--</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select><br><br>
<i class="fa-solid fa-calendar-days"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="date" name="joiningdate" required><br><br>
	User Type:<select name="usertype" id="s1">
            <option value="0"> --Choose user type--</option>
            <option value="manager">Manager</option>
            <option value="employee">employee</option>
        </select><br><br>
	<input type="submit" class="b1" name="submit" value="Create Account">
</form>
</div>
</body>
</html>
<?php
include("db/config.php");
if(isset($_POST['submit'])) 

{
	$userid=$_POST['userid'];
	$name=$_POST['name'];
	$password=$_POST['password'];
	$number=$_POST['number'];
	$emailid=$_POST['emailid'];
	$usertype=$_POST['usertype'];
    $joiningdate=$_POST['joiningdate'];
    $gender=$_POST['gender'];
$result=mysqli_query($mysqli, "insert into employees value('','$userid','$name','$password','$number','$emailid','$usertype','$gender','0','12','$joiningdate','0','0','0','0')");
if($result) {
	?>
    <script>
        swal({
        title: "Registered Successfully",
        icon: "success",
        });
    </script>
    <?php
}
else {
	echo "something wrong, data not stored";
}
}
?>