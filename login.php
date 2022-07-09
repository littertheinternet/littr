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
			// TODO: Refuse login if user is suspended.
            if(isset($_POST["submit"])) {
                $stmt = $conn->prepare("SELECT username, password from users WHERE username = ?");
                $stmt->bind_param("s", $_POST['username']);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
					if(password_verify($_POST['password'], $user['password'])) {
						$_SESSION['id'] = $user['id'];
						header("Location: index.php");
					} else {
						echo "<red>Invalid username/password combination.</red>";
					}
                } else {
					echo "<red>Username does not exist.</red>";
				}
            }
        ?>
    </div>
</body>
</html>