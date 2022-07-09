<div class="content">
        <div id="header">
            <img src="static/littr.png" height="50"><br><br>
            <ul>
                <li><a href="index.php">Home</a></li>
                <div style="float: right;">
                <?php
                            $stmt = $conn->prepare("SELECT * FROM users WHERE id = " . $_SESSION["id"]);
                            $stmt->execute();
                            $user = $stmt->get_result();
                            if ($user->num_rows > 0) {
                                while ($userrow = $user->fetch_assoc()) {
                                    if($userrow["verified"] == 1){
                                        echo "@" . $userrow["username"] . " <img src='static/verified.png' height='15'/> | <a href='profile.php?id=" . $_SESSION['id'] . "'>Profile</a> | <a href='settings.php'>Settings</a> | <a href='requests/logout.php'>Log Out</a>";
                                    }else{
                                        echo "@" . $userrow["username"] . "  | <a href='profile.php?id=" . $_SESSION['id'] . "'>Profile</a> | <a href='settings.php'>Settings</a> | <a href='logout.php'>Log Out</a>";
                                    }
                                    if($userrow["admin"] == 1){
                                        echo " | <a href='admin.php'>Admin</a>";
                                    }
                                }
                            }
                ?>
                </div>
            </ul>
        </div>
        <br>