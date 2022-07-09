<?php 

include "include/conn.php";
//This is the directory where images will be saved 
include("vendor/autoload.php");
use \DiscordWebhooks\Client;
use \DiscordWebhooks\Embed;



//Writes the information to the database 
if(isset($_POST['submit'])){
    $uploadok = 1;

    $targetf = "pfp/"; 
    $target = $targetf . time() . "-". rand(111111,999999) . basename( $_FILES['pfp']['name']);
    $imageFileType = strtolower(pathinfo($target,PATHINFO_EXTENSION));
    
    //This gets all the other information from the form 

    $displayname = $_POST['displayname'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    if(preg_match('/^[a-zA-Z0-9]+$/', $username)){
        $stmt = $conn->prepare("UPDATE users SET pfp = ?, displayname = ?, username = ?, password = ? WHERE id = ?");
        $stmt->bind_param("sssss", $target, $displayname, $username, $password, $_SESSION["id"]); 
        $stmt->execute();
    }
    if ($_FILES["pfp"]["size"] > 50000) {
        header("Location: settings.php?pe2");
        $uploadok = 0;
      }

      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        header("Location: settings.php?pe1");
    $uploadok = 0;
    }

    if($uploadok != 0){

        if(move_uploaded_file($_FILES['pfp']['tmp_name'], $target)) 
        { 
    
        //Tells you if its all ok
        header("Location: settings.php?us");
        }
        else { 
     
        //Gives an error if its not 
        header("Location: settings.php?pe3");
        } 
    }
    
    if($uploadok = 0) {
        $displayname = $_POST['displayname'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        if(preg_match('/^[a-zA-Z0-9]+$/', $username)){
            $stmt = $conn->prepare("UPDATE users SET displayname = ?, username = ?, password = ? WHERE id = ?");
            $stmt->bind_param("ssss", $displayname, $username, $password, $_SESSION["id"]); 
            $stmt->execute();
        }


    if(empty($_POST['pfp'])){
        $displayname = $_POST['displayname'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        if(preg_match('/^[a-zA-Z0-9]+$/', $username)){
            $stmt = $conn->prepare("UPDATE users SET displayname = ?, username = ?, password = ? WHERE id = ?");
            $stmt->bind_param("ssss", $displayname, $username, $password, $_SESSION["id"]); 
            $stmt->execute();
        }
    }
    
    }
}

if(isset($_POST['request'])){
    $webhook = new Client('XXX');
    $embed = new Embed();
    
    $embed->description('**User ID: ** ' . strval($_SESSION['id']) . ' requested verification.');
    
    $webhook->username('tyler j verification homie')->embed($embed)->send();

    header("Location: settings.php?vus");
}
?>
