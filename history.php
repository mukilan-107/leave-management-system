<?php
  include("db/config.php");
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeaveHistory</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="t1">
        <h1 class="l1">LeaveHistory</h1>
        <ul>
            <li><a href="leave.php">LeaveRequest</a></li>
            <li><a href="history.php">LeaveHistory</a></li>
            <li><a href="profile.php">Profile</a></li> 
            <li><a href="balance.php">Balance</a></li>
            <li><a href="login.php">Logout</a></li>
        </ul>
    </div>
    <div class="approve">
        <br>
        <table align="center">
            <thead>
                <tr>
                   <th>#</th>  
                   <th>Type</th>
                   <th>Time</th>
                   <th>From</th>
                   <th>To</th>
                   <th>Reason</th>
                   <th>Status</th>
                </tr>
           </thead>
           <?php
             $userid=$_SESSION['userid']; 
             $query="SELECT * FROM approve WHERE userid='$userid'";
             $RESULT=mysqli_query($mysqli,$query);
             $id=1;
             while($row = mysqli_fetch_array($RESULT)){
           ?>
           <tbody>
            <tr>
                <td><?php echo $id;?></td>
                <td><?php echo $row['type'];?></td>
                <td><?php echo $row['time'];?></td>
                <td><?php echo $row['fdate'];?></td>
                <td><?php echo $row['tdate'];?></td>
                <td><?php echo $row['reason'];?></td>
                <td><?php echo $row['status'];?></td> 
            </tr>
             <?php
               $id++; }
             ?>
           </tbody>
        </table>
    </div>
</body>
</html>