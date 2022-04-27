<?php
    include("../include/conn.php");
    $username = $_POST['username']; 
    $password = $_POST['password'];
    $email = $_POST['email'];


        // hash thy password
        $hash = password_hash($password, PASSWORD_BCRYPT);

    if(isset($_POST['submit'])){
        if(preg_match('/^[a-zA-Z0-9]+$/', $username)){

            $stmt = $conn->prepare("INSERT INTO users (displayname, username, email, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $username, $email, $hash);
            $stmt->execute();

            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->bind_param('s', $username);   
            $stmt->execute();

            header("Location: ../login.php");
        }else{
            header("Location: ../register.php");
        }

    }
?>