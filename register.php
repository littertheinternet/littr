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
        <strong style="font-size: 25px;">Register</strong><br><span>Free, easy, and fast. Already have an account? <a href="login.php">Log In!</a></span>
        <hr>
        <form action="requests/register.php" method="post">
            <span>Username</span> <input type="text" name="username"><br>
            <span>E-Mail</span> <input type="email" name="email"><br>
            <span>Password</span> <input type="password" name="password"><br><br>
            <input type="submit" value="Sign Up" name="submit">
        </form>
    </div>
</body>
</html>