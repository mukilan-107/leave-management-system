<?php
    function calculateLeaveBalances($dateOfJoining) {
        $dateOfJoiningTimestamp = strtotime($dateOfJoining);
        $currentTime = time();
        $continuousServiceMonths = ($currentTime - $dateOfJoiningTimestamp) / (60 * 60 * 24 * 30);

        $annualLeaveBalance = ($continuousServiceMonths >= 12) ? 15 : 0; 

        return $annualLeaveBalance;
    }
      
    session_start();
    if(isset($_SESSION['userid']) && isset($_SESSION['name'])){
        include("db/config.php");
        $userid = $_SESSION['userid'];  
        $query = "SELECT * FROM employees WHERE userid = '$userid'";
        $result = mysqli_query($mysqli, $query);
        if(mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $dateOfJoining = $row['joiningdate'];
            $leaveBalances = calculateLeaveBalances($dateOfJoining);
            $annualLeaveBalance = $leaveBalances;
            $select="UPDATE employees SET annualleave='$annualLeaveBalance' WHERE userid='$userid'";
            $result=mysqli_query($mysqli,$select);
            echo '<script> location.replace("balance.php")</script>';   
        }
    }
    $user_leave_query = "SELECT * FROM employees WHERE userid = '$userid'";
    $user_leave_result = mysqli_query($mysqli, $user_leave_query);
    $data = mysqli_fetch_assoc($user_leave_result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
<div class="t1">
        <h1 class="l1">Leave Balance</h1>
        <ul>
            <li><a href="leave.php">LeaveRequest</a></li>
            <li><a href="history.php">LeaveHistory</a></li>
            <li><a href="profile.php">Profile</a></li> 
            <li><a href="balance.php">Balance</a></li>
            <li><a href="login.php">Logout</a></li>
        </ul>
    </div>
    <div class="main">
        <br><h2>Leave Balance Tracking</h2>
        <div class="card">
            <div class="card-body">
                <table>
                    <tbody>
                        <tr>
                            <td>Annual/Earn Leave Remaining </td>
                            <td>:</td>
                            <td><?php echo $annualLeaveBalance; ?></td>
                        </tr>
                        <tr>
                            <td>Casual/Sick balance Remaining</td>
                            <td>:</td>
                            <td><?php echo $data['casualsickleave'];?></td>
                        </tr>
                        <tr>
                            <td>On-Duty</td>
                            <td>:</td>
                            <td><?php echo  $data['onduty'];?></td>
                        </tr>
                        <tr>
                            <td>Loss Of Pay Leave</td>
                            <td>:</td>
                            <td><?php echo $data['lop'];?></td>
                        </tr>
                        <tr id="reasonField1" style="">
                            <td>Paternity Leave</td>
                            <td>:</td>
                            <td><?php echo $data['paternity']; ?></td>
                        </tr>
                        <tr id="reasonField" style=" ">
                            <td>Maternity Leave</td>
                            <td>:</td>
                            <td><?php echo  $data['maternity'];?></td>
                        </tr>
                     </tbody>
                </table>
            </div>
        </div>
        <script>
            var gender="<?php echo $_SESSION['gender']; ?>";
            var reasonField = document.getElementById("reasonField");
            if(gender==="male"){
                reasonField.style.display = "none";
            }
            if(gender==="female"){
                reasonField1.style.display = "none";
            }
        </script>
</body>
</html>
