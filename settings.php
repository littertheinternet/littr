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
                if ($user->num_rows > 0) {
                    while ($userrow = $user->fetch_assoc()) {
                        echo "<form method='post' action='savesettings.php' enctype=\"multipart/form-data\"><span>Display Name </span> <input type=\"text\" name=\"displayname\" id=\"displayname\" value=\"" . $userrow['displayname'] . "\"><br>";
                        echo "<span>Profile Picture </span> <input type=\"file\" name=\"pfp\" id=\"pfp\" value=\"" . $userrow['pfp'] . "\"><red style='font-size:15px;'> Under 50KB, only JPG/JPEG & PNG</red><br>";
                        echo "<span>Username </span> <input type=\"text\" name=\"username\" id=\"username\" value=\"" . $userrow['username'] . "\"><br>";
                        echo "<span>Change Password </span> <input type=\"password\" name=\"password\" id=\"password\"><br><br><input type=\"submit\" value=\"Save changes\" name=\"submit\"><br><hr>";
                        
                        if($userrow['verified'] !== 1){
                            echo "<strong><img src='static/verified.png' height='15'/> Request Verification</strong><br><span>Verification ensures that the person(s)/orginization is authentic and reconginzable. Below are our minimum requirements for your littr account to be verified.<br><ul><li>Active on littr (spamming does not count as activity)</li><li>Recongizable/notable in the littr community; the community knows you well</li><li>Has not posted any vulgar or violent content that violates our Community Guidelines</li></ul><i>If you believe that you meet these requirements, click \"Request\" below to send a verification request. Most applicants are reviewed within 24 hours.</i></span><br><br><form action='requests/requestverification.php' method='post'>'<input type=\"submit\" value=\"Request\" name=\"request\"></form>";
                        }else{
                            echo "<strong><img src='static/verified.png' height='15'/> Request Verification</strong><br><span>Your account is already verified.</span><br><br><img src='static/icon_red_lock.gif'/><strong> Don't lose your verification status!</strong><span> To ensure that you remain verified, follow the below steps.</span><ul><li><strong>Regularly change your password.</strong> littr could remove your verification status if your account gets comprimised for security purposes. We don't want people mislead.</li><li><strong>Adhere to the Community Guidelines.</strong> littr reserves the right to take away verification status without warning, but littr usually takes away verification status in reply to a Community Guidelines violation.</li><li><strong>Have common sense.</strong> Read the audience when you post. A simple mistake could turn into a serious catastrophy.</li></ul>";
                        }

                    }
                }

                
            ?>
        </form>
    </div>
</body>
</html>