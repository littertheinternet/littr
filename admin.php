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
        redirect("index.php");
       }

       
    ?>
    <div>
        <center><h1>Admin Panel</h1><br><span><strong>NOTICE:</strong> Distrubtion or any method of electronic/physical sharing of the contents of the littr admin panel may result in demotion or permanent suspension from the littr website and services. You are liable and responsible for any damages - including if your account gets comprimised. Create a secure password and never share login details with anyone - even if you trust them.</span></center><br><br><hr>
       <?php
        $sql = "SELECT * FROM users WHERE id=?";
        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("s", $_SESSION['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            echo "<strong>Welcome, " . $row['username'] . "</strong>";

            if($row['admin'] !== 1){
                redirect("index.php");
            }
        }
       ?>
       <br><br>
       <?php
        if(isset($_POST['lookups'])){
            redirect("admin.php?search=" . $_POST['searchforusername']);
        }

        if(isset($_GET['search'])){
            $sql = "SELECT * FROM users WHERE username=?";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("s", $_GET['search']);
            $stmt->execute();
            $result = $stmt->get_result();
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<strong style='color:darkgreen'>User found!</strong><br><br>";
                    echo "<span>Display Name: " . htmlspecialchars($row['displayname']) . "</span><br>";
                    echo "<span>User ID: " . htmlspecialchars($row['id']) . "</span><br>";
                    echo "<span>Username: " . htmlspecialchars($row['username']) . "</span><br>";
                    echo "<span>Registered: " . htmlspecialchars($row['registered']) . "</span><br>";
                    echo "<span>E-Mail: " . htmlspecialchars($row['email']) . "</span><br>";
                    echo "<span>Profile Picture Path: " . htmlspecialchars($row['pfp']) . "</span><br>";
                    echo "<span>Verified: " . htmlspecialchars($row['verified']) . "</span> (1=true,blank/0=false)<br>";
                    echo "<span>Admin: " . htmlspecialchars($row['admin']) . "</span> (1=true,blank/0=false)<br>";
                    echo "<span>Suspended: " . htmlspecialchars($row['suspended']) . "</span> (1=true,blank=false)<br><br>";
                    echo "<strong>Actions:</strong>";
                    echo "<ul style='list-style-type:none;padding: 0;'>";
                    echo "<a href='admin.php?edit=" . $row['username'] . "#edit'>Edit this user</a>";
                    if($row['admin'] !== 1){
                        echo "<li><a style='color:darkred;' href='admin.php?delete=" . $_GET['search'] . "'>PERMANENTLY Delete User</a></li>";
                    }
                    if($row['verified'] !== 1){
                        echo "<li><a href='admin.php?verify=" . $_GET['search'] . "'>Verify User</a></li>";
                    }else{
                        echo "<li><a style='color:darkred;' href='admin.php?unverify=" . $_GET['search'] . "'>Unverify User</a></li>";
                    }
                    if($row['admin'] !== 1){
                        echo "<li><a href='admin.php?ma=" . $_GET['search'] . "'>Make Administrator</a></li>";
                    }
                    if($row['admin']){
                        echo "<br><strong style='color:darkred'>Options limited as the user is an administrator.</strong>";
                    }
                    echo "</ul><hr><br>";
                }
              } else {
                echo "<strong style='color:darkred'>Query returned 0 results.</strong><br><br>";
              }
        }

        if(isset($_GET['delete'])){
            $sql = "SELECT * FROM users WHERE username=?";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("s", $_GET['delete']);
            $stmt->execute();
            $result = $stmt->get_result();
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                    $sql = "DELETE FROM users WHERE username=?";
                    $stmt = $conn->prepare($sql); 
                    $stmt->bind_param("s", $_GET['delete']);
                    $stmt->execute();

                    $sql = "DELETE FROM posts WHERE authorid=?";
                    $stmt = $conn->prepare($sql); 
                    $stmt->bind_param("s", $_GET['delete']);
                    $stmt->execute();

                    echo "<strong style='color:darkgreen'>User \"" . $_GET['delete'] . "\" deleted.</strong><br>";
                    echo "<strong style='color:darkgreen'>Posts created by \"" . $_GET['delete'] . "\" were successfully deleted.</strong><br><br>";
                }
            }
        }

        if(isset($_GET['verify'])){
            $sql = "SELECT * FROM users WHERE username=?";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("s", $_GET['verify']);
            $stmt->execute();
            $result = $stmt->get_result();
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                    $sql = "UPDATE users SET verified=1 WHERE username=?";
                    $stmt = $conn->prepare($sql); 
                    $stmt->bind_param("s", $_GET['verify']);
                    $stmt->execute();

                    echo "<strong style='color:darkgreen'>User \"" . $_GET['verify'] . "\" is now verified.</strong><br><br>";
                }
            }
        }

        if(isset($_GET['unverify'])){
            $sql = "SELECT * FROM users WHERE username=?";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("s", $_GET['unverify']);
            $stmt->execute();
            $result = $stmt->get_result();
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                    $sql = "UPDATE users SET verified=0 WHERE username=?";
                    $stmt = $conn->prepare($sql); 
                    $stmt->bind_param("s", $_GET['unverify']);
                    $stmt->execute();

                    echo "<strong style='color:darkgreen'>User \"" . $_GET['unverify'] . "\" is now unverified.</strong><br><br>";
                }
            }
        }

        if(isset($_GET['ma'])){
            $sql = "SELECT * FROM users WHERE username=?";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("s", $_GET['ma']);
            $stmt->execute();
            $result = $stmt->get_result();
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                    $sql = "UPDATE users SET admin=1 WHERE username=?";
                    $stmt = $conn->prepare($sql); 
                    $stmt->bind_param("s", $_GET['ma']);
                    $stmt->execute();

                    echo "<strong style='color:darkgreen'>User \"" . $_GET['ma'] . "\" is now an admin.</strong><br><br>";
                }
            }
        }
       ?>
       <form method="post">
           <strong>Username Lookup</strong>
           <input type="text" name="searchforusername" placeholder="(i.e.) littr">
           <input type="submit" name="lookups" value="Query">
       </form>
        <?php
            if(isset($_GET['edit'])){
                $sql = "SELECT * FROM users WHERE username=?";
                $stmt = $conn->prepare($sql); 
                $stmt->bind_param("s", $_GET['edit']);
                $stmt->execute();
                $result = $stmt->get_result();
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<hr>";
                        echo "<strong style='font-size:20px' id='edit'>Edit @" . htmlspecialchars($row['username']) . "</strong><br><br>";
                        echo "<form method='post'>";
                        echo "<strong>Display Name </strong><input type='text' name='dp' value='" . htmlspecialchars($row['displayname']) . "'/><br>";
                        echo "<strong>Username </strong><span style='color:gray'>@" . $row['username'] . "</span><br>";
                        echo "<strong>E-Mail Address </strong><input type='email' name='email' value='" . htmlspecialchars($row['email']) . "'/><br>";
                        echo "<br><strong style='color:darkgray'>To delete/verify this user, you must lookup their username via the Username Lookup function.</strong>";
                        
                    }
                }
            }
        ?>

    </div>
</body>
</html>