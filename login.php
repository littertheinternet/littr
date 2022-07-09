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
        <strong style="font-size: 25px;">Login</strong><br><span>Don't have an account? <a href="register.php">Register!</a></span>
        <hr>
        <form method="post">
            <span>Username</span> <input type="text" name="username"><br>
            <span>Password</span> <input type="password" name="password"><br><br>
            <input type="submit" value="Log In" name="submit">
        </form>
        <?php
         if(isset($_POST['submit'])){
             $username = $_POST['username'];
             $password = $_POST['password'];

             $stmt = $conn->prepare("SELECT * from users WHERE username = ?");
             $stmt->bind_param("s", $username);
             $stmt->execute();
             $result = $stmt->get_result();

             if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $db_password = $row['password'];
            
                  if (password_verify($password, $db_password)) {
                    $_SESSION['id'] = $row['id'];
                    header("Location: index.php");
                  } else {
                      echo "<br><red>Incorrect username/password combination.</red>";
                  }
                }
              } else {
                  echo "<br><red>User does not exist or has been deleted.</red>";
              }
         }
        ?>
    </div>
</body>
</html>