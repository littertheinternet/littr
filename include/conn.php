<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "root";
$db = "littr";

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

function redirect($url)
{
    if (!headers_sent())
    {    
        header('Location: '.$url);
        exit;
        }
    else
        {  
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>'; exit;
    }
}
?>

<meta name="title" content="littr - Litter the internet">
<meta name="description" content="Litter the internet. Join a community full of bored individuals! littr is a community to share virtually anything. Share recent events, ideas, or literally anything else! littr is your place to communicate.">