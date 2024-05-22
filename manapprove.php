<?php
   include("db/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="t1">
        <h1 class="l1">Approval Page</h1>
        <ul>
            <li><a href="manapprove.php">Approval Page</a></li>
            <li><a href="register.php">RegisterEmployee</a></li>
            <li><a href="employee.php">Employee List</a></li> 
            <li><a href="login.php">Logout</a></li>
        </ul>
    </div>
    <div class="approve">
        <br>
        <table align="center" id="users">
            <thead>
                <tr>
                <th>User Id</th>
                <th>Name</th>
                <th>Type</th>
                <th>Time</th>
                <th>From date</th>
                <th>To date</th>
                <th>reason</th>
                <th>Action</th>
                </tr>
            </thead>
            <?php
                $query= "SELECT * FROM approve WHERE status='pending' ORDER BY id ASC";
                $RESULT=mysqli_query($mysqli,$query);
                while($row = mysqli_fetch_array($RESULT)){
            ?>
            <tbody>
                <tr>
                <td><?php echo $row['userid'];?></td>
                <td><?php echo $row['name'];?></td>
                <td><?php echo $row['type'];?></td>
                <td><?php echo $row['time'];?></td>
                <td><?php echo $row['fdate'];?></td>
                <td><?php echo $row['tdate'];?></td>    
                <td><?php echo $row['reason'];?></td>
                <td>
                <form action="approve.php" method="post">
                    <input type="hidden" name="userid" value="<?php echo $row['userid']; ?>">
                    <input type="hidden" name="time" value="<?php echo $row['time']; ?>">
                    <input type="hidden" name="type" value="<?php echo $row['type']; ?>">
                    <input type="hidden" name="ndays" value="<?php echo $row['ndays']; ?>">
                    <input type="hidden" name="id" value="<?php echo $row['id']?>">
                    <input type="submit" class="b1" name="approve" value="Approve">
                    <input type="submit" class="b2" name="deny" value="Deny">
                </form>
                </td>
                </tr>
                <?php
                     }
                ?>
            </tbody>
</table>
</div>
</body>
</html>