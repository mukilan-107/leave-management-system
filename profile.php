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
    <title>Document</title>
    <link rel="stylesheet" href="style1.css">
<body>
<div class="t1">
        <h1 class="l1">ProfilePage</h1>
        <ul>
            <li><a href="leave.php">LeaveRequest</a></li>
            <li><a href="history.php">LeaveHistory</a></li>
            <li><a href="profile.php">Profile</a></li> 
            <li><a href="balance.php">Balance</a></li>
            <li><a href="login.php">Logout</a></li>
        </ul>
    </div>
    <div class="main">
        <br><h2>PROFILE</h2>
        <div class="card">
            <div class="card-body">
                <table>
                    <tbody>
                        <tr>
                            <td>UserId</td>
                            <td>:</td>
                            <td><?php echo $_SESSION['userid']; ?></td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>:</td>
                            <td><?php echo $_SESSION['name']; ?></td>
                        </tr>
                        <tr>
                            <td>Number</td>
                            <td>:</td>
                            <td><?php echo $_SESSION['number']; ?></td>
                        </tr>
                        <tr>
                            <td>Emailid</td>
                            <td>:</td>
                            <td><?php echo $_SESSION['emailid']; ?></td>
                        </tr>
                        <tr>
                            <td>UserType</td>
                            <td>:</td>
                            <td><?php echo $_SESSION['usertype']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
</body>
</html>