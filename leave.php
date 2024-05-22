<?php
    session_start();
    if(isset($_SESSION['userid']) && isset($_SESSION['name'])){
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
    <div class="t1">
        <h1 class="l1">RequestLeave</h1>
        <ul>
            <li><a href="leave.php">LeaveRequest</a></li>
            <li><a href="history.php">LeaveHistory</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="balance.php">Balance</a></li> 
            <li><a href="login.php">Logout</a></li>
        </ul>
    </div><br><br><br>
    <div  class="a1">
        <br><br>
        <form action="leave.php" method="post">
        <label class="s1">Leave Type:</label>&nbsp;&nbsp;
        <select name="type" id="s1" onchange="toggleReasonField()">
            <option value="0"> --Choose Leave type--</option>
            <option value="onduty">On-Duty</option>
            <option value="maternity">Maternity Leave</option>
            <option value="paterinty">Paternity Leave</option>
            <option value="sick">Sick Leave</option>
            <option value="casual">Casual Leave</option>
            <option value="annual">Annual/Earned Leave</option>
            <option value="Lop">Loss Of Pay</option>
        </select><br><br>
        <div id="reasonField" style="display:none;">
        <p><label  class="s1">Leave Reason:</label>&nbsp;<textarea name="reason" rows="3" placeholder="Reason for leave"></textarea></p><br>
        </div>
        <div id="reasonField1">
        <p><label class="s1">leave time:</label>&nbsp;&nbsp;
        <select name="time" >
            <option value="0"> --Choose Leave time--</option>
            <option value="first half">first half</option>
            <option value="second half">second half</option>
            <option value="full day">full day</option>
        </select><br><br>
        </div>
        <p><label  class="s1">From date:</label>&nbsp;&nbsp;<input type="date" id="fromDate" name="fdate" placeholder="date" required min="<?php echo date('Y-m-d'); ?>">&nbsp;<br><br>
        <p><label  class="s1">To date:     </label>&nbsp;&nbsp;<input type="date" id="toDate" name="tdate" placeholder="date" required >&nbsp;<br> 
        <input type="hidden" name="userid" value="<?php echo $_SESSION['userid']?>" ></p>
        <input type="hidden" name="name" value="<?php echo $_SESSION['name']?>" ></p>
        &nbsp;<button name="submit" class="b1">Apply</button>&nbsp;&nbsp;<button  class="b2"><a href="leave.php" style="text-decoration: none;color: white;">Cancel</a></button><br><br>
    </form>
    </div>
    <script>
        function toggleReasonField() {
            var leaveType = document.getElementById("s1").value;
            var reasonField = document.getElementById("reasonField");
             if (leaveType === "onduty" || leaveType === "Lop") {
                reasonField.style.display = "block";
            } else {
                reasonField.style.display = "none";
            }
            var reasonField = document.getElementById("reasonField1");
           

            if(leaveType === "maternity" ||leaveType ==="paterinty" ||leaveType ==="onduty"||leaveType==="annual")
            {
                reasonField1.style.display = "none";
            }
            else{
                reasonField1.style.display = "block";
            }
        }
        const fromDateInput = document.getElementById('fromDate');
        const toDateInput = document.getElementById('toDate');
        function validateDateRange() {
            const fromDate = new Date(fromDateInput.value);
            const toDate = new Date(toDateInput.value);

            if (toDate < fromDate) {
                alert('To date must be greater than or equal to From date.');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
<?php 
   include("db/config.php");

   if(isset($_POST['submit']))
   {
    $type=$_POST['type'];
    $time=$_POST['time'];
    $fdate=$_POST['fdate'];
    $tdate=$_POST['tdate'];
    $reason=$_POST['reason'];
    $userid=$_POST['userid'];
    $name=$_POST['name']; 
    $start_date = new DateTime($fdate);
    $end_date = new DateTime($tdate);
    $interval = $start_date->diff($end_date);
    $num_days = $interval->days + 1;
    $res = ($time === "first half" || $time === "second half") ? 0.5 : 1;
    $user_leave_query = "SELECT * FROM employees WHERE userid = '$userid'";
    $user_leave_result = mysqli_query($mysqli, $user_leave_query);
    $user_leave_data = mysqli_fetch_assoc($user_leave_result);
    if ($num_days > 1) {
    $res *= $num_days;
    }  
    if($type==="sick" || $type==="casual"){
        $current_month = date('m');
        $current_year = date('Y');
        $check_query = "SELECT SUM(CASE WHEN time = 'first half' OR time = 'second half' THEN 0.5 ELSE 1 END) AS total_days FROM approve WHERE MONTH(fdate) = '$current_month' AND YEAR(fdate) = '$current_year' AND type IN ('sick', 'casual') AND userid = '$userid'";
        $check_result = mysqli_query($mysqli, $check_query);
        $row = mysqli_fetch_assoc($check_result);
        $total_days_taken = $row['total_days'];
        $max_leaves_allowed = 1; 
        if($num_days>$max_leaves_allowed)
        {
            ?>
            <script>
                swal({
                    title: "Limit Reached For This Month!",
                    text: "Apply for Loss Of Pay If Leave Required ",
                });
            </script>
            <?php
            exit();
        }
        else if (($total_days_taken + $res) > $max_leaves_allowed) {
            ?>
            <script>
                swal({
                    title: "You can't Apply This Type of Leave",
                    text: "Please check your balance and apply for Loss Of Pay",
                });
            </script>
            <?php
            exit();
        }
    }
    else if($type==="annual"){
     if($user_leave_data['annualleave'] < $num_days) {
        ?>
        <script>
            swal({
                title: "Insufficient Annual/Earned Leave",
                text: "You have <?php echo $user_leave_data['annualleave']; ?> days of annual/earned leave remaining.",
                icon: "error",
            });
        </script>
        <?php
        exit();
    } 
}

   
    $result=mysqli_query($mysqli, "insert into approve value('','$type','$time','$fdate','$tdate','$reason','pending','$userid','$name','$num_days')");
     if($result){
     ?>
    <script>
        swal({
        title: "Leave Applied",
        text:"Waiting For Approval",
        icon: "info",
        });
    </script>
    <?php
     } 
}


?>