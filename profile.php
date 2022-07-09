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
    <?php
        if(isset($_SESSION['id'])){
            include("include/header/logged-in.php");
       }else{
           include("include/header/logged-out.php");
       }
    ?>
        <?php
                $profileid = $_GET['id'];

                if(!isset($profileid)){
                    header("Location: index.php");
                }

                $stmt = $conn->prepare("SELECT * FROM users WHERE id = " . $profileid);
                $stmt->execute();
                $user = $stmt->get_result();
                if ($user->num_rows > 0) {
                    while ($userrow = $user->fetch_assoc()) {
                        $date = new DateTime($userrow['registered']);

                        if($userrow['admin'] == 1){
                            echo "<div id='c'><span>@" . $userrow['username'] . " is a littr employee. littr employees will never ask for your password. Ensure your accounts are safe and don't fall for scams.</span></div><br>";
                        }
                        echo "<img style='border:1px solid black;' src='" . $userrow["pfp"] . "' height='20' width='20'/> <strong style=\"font-size: 25px;\">" . htmlspecialchars($userrow["displayname"]) . " </strong>"; if($userrow["verified"] == 1){ echo "<img src='static/verified.png' height='20'/>"; } echo "<br><span>@" . htmlspecialchars($userrow["username"]) . "</span><br><br><span style='color:gray'>Joined " . date_format($date, 'F t, Y') . "</span><hr>";
                        $pf = $conn->prepare("SELECT * FROM posts WHERE authorid = ? ORDER BY statusid DESC");
                        $pf->bind_param("s", $profileid);
                        $pf->execute();
                        $rows = $pf->get_result();
                        if ($rows->num_rows > 0) {
                            while ($row = $rows->fetch_assoc()) {
                                if($userrow["verified"] == 1){ 
                                    echo "<div id=\"post\"><img src='" . htmlspecialchars($userrow['pfp']) . "' height='36' width='36' style='border:1px solid black;'/><div style='display:inline-block;margin-left:10px;width:90%;'><a style='text-decoration:none;'><strong> " . htmlspecialchars($userrow['displayname']) . " </strong><img src='static/verified.png' height='15'/><span style=\"color: rgb(72, 72, 72);\"> @" . htmlspecialchars($userrow['username']) .  "</span></a><br><span>" . htmlspecialchars($row['postcontent']) . "</span><br><span style=\"color: rgb(95, 95, 95);\">" . $row['timeposted'] . " </span></div></div><br>";
                                }else{
                                    echo "<div id=\"post\"><img src='" . htmlspecialchars($userrow['pfp']) . "' height='36' width='36' style='border:1px solid black;'/><div style='display:inline-block;margin-left:10px;width:90%;><a style='text-decoration:none;'><strong> " . htmlspecialchars($userrow['displayname']) . "</strong><span style=\"color: rgb(72, 72, 72);\"> @" . htmlspecialchars($userrow['username']) .  "</span></a><br><span>" . htmlspecialchars($row['postcontent']) . "</span><br><span style=\"color: rgb(95, 95, 95);\">" . $row['timeposted'] . "</span></div></div><br>";
                                }
                            }
                        }
                    }
                }else{
                    echo "<center>No profile here! The user you are trying to reach either does not exist or has been suspended.</center>";
                }
        ?>
    </div>
</body>
</html>