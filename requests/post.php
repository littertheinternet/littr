<?php
    include("../include/conn.php");
    include("../vendor/autoload.php");

    if(!isset($_SESSION['id'])){
        header("Location: ../index.php");
    }

    $content = $_POST["postcontent"];

    if(isset($_POST['submit'])){
        try {
            if(strlen($content) < 1) {
                header("Location: ../index.php");
            }else{
                $stmt = $conn->prepare("INSERT INTO posts (authorid, postcontent) VALUES (?, ?)");
                $stmt->bind_param("ss", $_SESSION['id'], $content);
                $stmt->execute();
    
                header("Location: ../index.php");
            }
        }
        catch (exception $e) {
            header("Location: ../index.php?error");
        }
    }
?>