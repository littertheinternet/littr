<?php
    include("../include/conn.php");

    if(isset($_POST['request'])){
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = " . $_SESSION['id']);
        $stmt->execute();
        $user = $stmt->get_result();
        if ($user->num_rows > 0) {
            while ($userrow = $user->fetch_assoc()) {
                $data = array("content" => "**Active Devs:**\n\nUsername: @" . $userrow["username"] . " is requesting verification.\n\n*To verify, go into the SQL database and modify the `VERIFIED` paramater.*", "username" => "Verifinator");
                $curl = curl_init("https://discord.com/api/webhooks/967565700032004096/BQeSN46Q2MDJR_a871cmM87YUDEtWebrLDcA0eQPR8sYz03dsteZoobo7Uaodqe9-IGX");
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                return curl_exec($curl);
            }
        }
    }
?>