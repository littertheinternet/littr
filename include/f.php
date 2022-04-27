<?php
        $stmt = $conn->prepare("SELECT * FROM posts ORDER BY statusid DESC");
        $stmt->execute();
        $posts = $stmt->get_result();
        if ($posts->num_rows > 0) {
          while ($row = $posts->fetch_assoc()) {
            $stmt = $conn->prepare("SELECT * FROM users WHERE id = " . $row["authorid"]);
            $stmt->execute();
            $user = $stmt->get_result();
            if ($user->num_rows > 0) {
                while ($userrow = $user->fetch_assoc()) {
                    if($userrow["verified"] == 1){ 
                        echo "<div id=\"post\"><strong>" . htmlspecialchars($userrow['displayname']) . " </strong><img src='static/verified.png' height='15'/><span style=\"color: rgb(72, 72, 72);\"> @" . htmlspecialchars($userrow['username']) .  "</span><br><span>" . htmlspecialchars($row['postcontent']) . "</span><br><span style=\"color: rgb(95, 95, 95);\">" . $row['timeposted'] . "</span></div><br>";
                    }else{
                        echo "<div id=\"post\"><strong>" . htmlspecialchars($userrow['displayname']) . "</strong><span style=\"color: rgb(72, 72, 72);\"> @" . htmlspecialchars($userrow['username']) .  "</span><br><span>" . htmlspecialchars($row['postcontent']) . "</span><br><span style=\"color: rgb(95, 95, 95);\">" . $row['timeposted'] . "</span></div><br>";
                    }
                }
            }
          }
        }
?>