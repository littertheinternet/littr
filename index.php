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
            echo "<strong>Litter the internet. </strong><span>Join a community full of bored individuals! littr is a community to share virtually anything. Share recent events, ideas, or literally anything else! littr is your place to communicate. So, what are you waiting for? Join littr.</span>";
        }
    ?>

        <?php
            if(isset($_GET['error'])){
                echo "<strong style='color:darkred;'>Unable to perform specified action(s). This is most likely a server-side issue. If the problem persists, contact us.</strong><br><br>";
            }

            if(isset($_SESSION['id'])){
                echo "<form action='requests/post.php' method='post'><textarea placeholder=\"What's up?\" name='postcontent' id='postarea'></textarea><br><input type='submit' value='Post' name='submit' style='float: right;'></form>";
            }
        ?>
        <br><br>
        <?php
                $per_page_record = 5;
  
                //find the total number of results stored in the database  
                $query = "select *from posts";  
                $result = mysqli_query($conn, $query);  
                $number_of_result = mysqli_num_rows($result);  
              
                //determine the total number of pages available  
                $number_of_page = ceil ($number_of_result / $per_page_record);  
              
                //determine which page number visitor is currently on  
                if (!isset ($_GET['page']) ) {  
                    $page = 1;  
                } else {  
                    $page = $_GET['page'];  
                }  
              
                //determine the sql LIMIT starting number for the results on the displaying page  
                $page_first_result = ($page-1) * $per_page_record;  
              
                //retrieve the selected results from database   
                $query = "SELECT *FROM posts ORDER BY statusid DESC LIMIT " . $page_first_result . ',' . $per_page_record;  
                $result = mysqli_query($conn, $query);  
                  
                //display the retrieved result on the webpage  
                while ($row = mysqli_fetch_array($result)) {  
                    $stmt = $conn->prepare("SELECT * FROM users WHERE id = " . $row["authorid"]);
                    $stmt->execute();
                    $user = $stmt->get_result();
                    if ($user->num_rows > 0) {
                        while ($userrow = $user->fetch_assoc()) {
                            if($userrow["verified"] == 1){ 
                                echo "<div id=\"post\"><img src='" . htmlspecialchars($userrow['pfp']) . "' height='36' width='36' style='border:1px solid black;'/><br><a style='text-decoration:none;'><strong> " . htmlspecialchars($userrow['displayname']) . " </strong><img src='static/verified.png' height='15'/><span style=\"color: rgb(72, 72, 72);\"> @" . htmlspecialchars($userrow['username']) .  "</span></a><br><span>" . htmlspecialchars($row['postcontent']) . "</span><br><span style=\"color: rgb(95, 95, 95);\">" . $row['timeposted'] . " </span></div><br>";
                            }else{
                                echo "<div id=\"post\"><img src='" . htmlspecialchars($userrow['pfp']) . "' height='36' width='36' style='border:1px solid black;'/><br><a style='text-decoration:none;'><strong> " . htmlspecialchars($userrow['displayname']) . "</strong><span style=\"color: rgb(72, 72, 72);\"> @" . htmlspecialchars($userrow['username']) .  "</span></a><br><span>" . htmlspecialchars($row['postcontent']) . "</span><br><span style=\"color: rgb(95, 95, 95);\">" . $row['timeposted'] . "</span></div><br>";
                            }
                        }
                    }
                }  
              
              
                //display the link of the pages in URL  
                for($page = 1; $page<= $number_of_page; $page++) {  
                    echo '<a href = "index.php?page=' . $page . '">' . $page . ' </a>';  
                }  
        ?>
    </div>
</body>
</html>