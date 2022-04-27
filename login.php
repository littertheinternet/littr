<?php include("include/conn.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>littr</title>
</head>
<body>
    <?php include("include/header/logged-out.php"); ?>
        <strong style="font-size: 25px;">Log In</strong><br><span>Don't have an account? <a href="register.php">Register!</a></span>
        <hr>
        <form action="requests/login.php" method="post">
            <span>Username</span> <input type="text" name="username"><br>
            <span>Password</span> <input type="password" name="password"><br><br>
            <input type="submit" value="Log In">
        </form>
    </div>
</body>
</html>