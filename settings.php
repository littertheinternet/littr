<?php
    include("include/conn.php");

    if(!isset($_SESSION['id'])){
        header("Location: ../index.php");
    }
?>
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
    <?php
            if(isset($_SESSION['id'])){
                include("include/header/logged-in.php");
           }else{
               include("include/header/logged-out.php");
               echo "<strong>Litter the internet. </strong><span>Join a community full of bored individuals! littr is a community to share virtually anything. Share recent events, ideas, or literally anything else! littr is your place to communicate. So, what are you waiting for? Join littr.</span>";
           }

           if(isset($_GET['pe1'])){
                echo "<red>Only JPG, JPEG, PNG, & GIF files are allowed.</red><br>";
           }
           if(isset($_GET['pe2'])){
            echo "<red>Your file is too large. Try compressing it.</red><br>";
            }
            if(isset($_GET['pe3'])){
             echo "<red>There was a problem on our end. Try again soon.</red><br>";
             }
             if(isset($_GET['us'])){
              echo "<green>Your profile picture was successfully uploaded.</green><br>";
              }
              if(isset($_GET['vus'])){
               echo "<green>You successfully applied for verification. Most applicants are reviewed within 24 hours. If you don't recieve the blue badge next to your name, you were reviewed and did not qualify.</green><br>";
               }
    ?>
        <strong style="font-size: 25px;">Settings</strong><br><span>Manage your littr account.</span>
        <hr>
            <?php
                $stmt = $conn->prepare("SELECT * FROM users WHERE id = " . $_SESSION['id']);
                $stmt->execute();
                $user = $stmt->get_result();
                $stmt->close();
                if ($user->num_rows > 0) {
                    while ($userrow = $user->fetch_assoc()) {
                        echo "<form method='post' enctype=\"multipart/form-data\"><span>Display Name </span> <input type=\"text\" name=\"displayname\" id=\"displayname\" value=\"" . $userrow['displayname'] . "\"><br>";
                        echo "<span>Username </span> <span style='color:gray'>@" . htmlspecialchars($userrow['username']) . "</span><br><br><input type='submit' name='submit' value='Save'></form><hr>";
                        echo "<form method='post' enctype=\"multipart/form-data\"<span>Profile Picture </span> <input type=\"file\" name=\"pfp\" id=\"pfp\" value=\"" . $userrow['pfp'] . "\"><red style='font-size:15px;'> Under 100KB, only JPG/JPEG & PNG</red><br><br><input type='submit' name='pfps' value='Upload Profile Picture'></form>";

                    }
                }

                if(isset($_POST['submit'])){
                    $dp = $_POST['displayname'];

                    $stmt = $conn->prepare("UPDATE users SET displayname = ? WHERE id = ?");
                    $stmt->bind_param("ss", $dp, $_SESSION["id"]); 
                    $stmt->execute();
                }

                if(isset($_POST['pfps'])){
                    

                    $uploadok = 1;
                
                    $targetf = "pfp/"; 
                    $target = $targetf . time() . "-". rand(111111,999999) . basename( $_FILES['pfp']['name']);
                    $imageFileType = strtolower(pathinfo($target,PATHINFO_EXTENSION));
                    
                    
                    
                    //This gets all the other information from the form 

                    if ($_FILES["pfp"]["size"] > 100000) {
                        header("Location: settings.php?pe2");
                        $uploadok = 0;
                      }
                
                      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif" ) {
                        header("Location: settings.php?pe1");
                    $uploadok = 0;
                    }
                
                    if($uploadok != 0){
                        $stmt = $conn->prepare("UPDATE users SET pfp = ? WHERE id = ?");
                        $stmt->bind_param("ss", $target, $_SESSION["id"]); 
                        $stmt->execute();
                
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
                    
                    

                    $stmt = $conn->prepare("UPDATE users SET pfp = ? WHERE id = ?");
                    $stmt->bind_param("ss", $target, $_SESSION["id"]); 
                    $stmt->execute();
                }
                
                    
            ?>
        </form>
    </div>
</body>
</html>