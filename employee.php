<?php
  include("db/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="t1">
        <h1 class="l1">Employee Details</h1>
        <ul>
            <li><a href="manapprove.php">Approval Page</a></li>
            <li><a href="register.php">RegisterEmployee</a></li>
            <li><a href="employee.php">Employee List</a></li> 
            <li><a href="login.php">Logout</a></li>
        </ul>
    </div>
    <br><br>
    <div class="approve">
        <table align="center">
            <thead>
                <tr>
                   <th>#</th>
                   <th>UserId</th>
                   <th>Name</th>
                   <th>MobileNumber</th>
                   <th>Emailid</th>
                   <th>Gender</th>
                   <th>Remove</th>
                </tr>
           </thead>
           <?php
             $query="SELECT * FROM employees";
             $RESULT=mysqli_query($mysqli,$query);
             while($row = mysqli_fetch_array($RESULT)){
           ?>
           <tbody>
            <tr>
                <td><?php echo $row['id'];?></td>
                <td><?php echo $row['userid'];?></td>
                <td><?php echo $row['name'];?></td>
                <td><?php echo $row['number'];?></td>
                <td><?php echo $row['emailid'];?></td> 
                <td><?php echo $row['gender'];?></td>
                <td>
                  <form action="employee.php" method="post">
                  <input type="hidden" name="id" value="<?php echo $row['id']?>">
                    <input type="submit" class="b2" name="delete" value="Delete">
                  </form>
                </td>
            </tr>
             <?php
               }
             ?>
           </tbody>
        </table>
    </div>
    <?php
   if(isset($_POST['delete']))
   {
    $id=$_POST['id'];
    $select="DELETE FROM employees WHERE id='$id'";
    $result=mysqli_query($mysqli,$select);
    echo '<script> location.replace("employee.php")</script>';
   }

?>
</body>
</html>