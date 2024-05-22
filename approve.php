<?php
    session_start();
    if(isset($_SESSION['userid']) && isset($_SESSION['name'])){
    }
    include("db/config.php");
    if (isset($_POST['approve'])) {
        $id=$_POST['id'];
        $select="UPDATE approve SET status='approved' WHERE id='$id'";
        $result=mysqli_query($mysqli,$select);
        echo '<script> location.replace("manapprove.php")</script>';
        $time=$_POST['time'];
        $userid = $_POST['userid'];
        $type = $_POST['type'];
        $num_days = $_POST['ndays']; 
        $res = ($time === "first half" || $time === "second half") ? 0.5 : 1;
        if ($num_days > 1) {
        $res *= $num_days;
        }  
        $select="SELECT * FROM approve WHERE userid='$userid' AND status='approved'";
        $tocheck=mysqli_query($mysqli,$select);
     if($tocheck){
        $user_leave_query = "SELECT * FROM employees WHERE userid = '$userid'";
        $user_leave_result = mysqli_query($mysqli, $user_leave_query);
        $user_leave_data = mysqli_fetch_assoc($user_leave_result);
    if($type==="onduty"){
        $check=$user_leave_data['onduty']+$num_days;
        $select=mysqli_query($mysqli,"UPDATE employees SET onduty='$check' WHERE userid='$userid'");
    }
    else if($type==="maternity"){
        $check=$user_leave_data['maternity']+$num_days;
        $select=mysqli_query($mysqli,"UPDATE employees SET maternity='$check' WHERE userid='$userid'");
    }
    else if($type==="paterinty"){
        $check=$user_leave_data['paterinty']+$num_days;
        $select=mysqli_query($mysqli,"UPDATE employees SET paternity='$check' WHERE userid='$userid'");
    }
    else if($type==="Lop")
    {
        $check=$user_leave_data['lop']+$res;
        $select=mysqli_query($mysqli,"UPDATE employees SET lop='$check' WHERE userid='$userid'");
    }
    else if($type==="sick" || $type==="casual"){
             $check=$user_leave_data['casualsickleave']-$res;
             $result=mysqli_query($mysqli, "UPDATE employees SET casualsickleave='$check' WHERE userid='$userid'");
}else if ($type ==="annual") {
    if ($user_leave_data['annualleave'] < $num_days) {
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
    } else {
        $new_balance = $user_leave_data['annualleave'] - $num_days;
        $leavetaken=$user_leave_date['leavetaken']+$num_days;
        $update_query = "UPDATE employees SET annualleave = '$new_balance' WHERE userid = '$userid'";
    }
}
if (isset($update_query)) {
    mysqli_query($mysqli, $update_query);
}
} 
    }
    else if(isset($_POST['deny'])){
        $id=$_POST['id'];
        $select="UPDATE approve SET status='denied' WHERE id='$id'";
        $result=mysqli_query($mysqli,$select);
        echo '<script> location.replace("manapprove.php")</script>';
       }
?>