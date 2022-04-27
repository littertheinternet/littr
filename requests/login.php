<?php
    include("../include/conn.php");

    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if(preg_match('/^[a-zA-Z0-9]+$/', $username)){
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $getres1 = $stmt->get_result();
        // now we see if user exists
        if ($getres1->num_rows > 0) {
        while ($row = $getres1->fetch_assoc()) {
          // password check
          $db_password = $row['password'];
    
          if (password_verify($password, $db_password)) {
            $login_status = 2;
            $login_status_text = "You are logged in!";
            // we now do some additional trolling
            // storing session stuff
            $_SESSION['id'] = $row['id'];
            header("Location: ../index.php");
          }
        }
    }
    }else{
        header("Location: ../login.php");
    }
?>