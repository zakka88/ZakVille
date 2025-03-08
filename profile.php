<?php
//require "./assets/function/authentificatione.php";
session_start();
$nav = "profile";
$title= "profile";
require "header.php";
?>
 <style>
    .cont{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 50vh;
    }
    img{
        width: 570px;
        margin-bottom: 20px;
        
    
    }
 </style>
 <div class="cont">
 <img src="./assets/img/ca_3.jpg" alt="">
 </div>

<?php
if (!isset($_SESSION["pseudo"] )) {
    header("Location: login.php");
    exit();
}

echo "<h1>Benvenuto, " . $_SESSION["pseudo"] . "!</h1>";
echo "<p><strong>nom:</strong> " . $_SESSION["nom"] . "</p>";
echo "<p><strong>prénom:</strong> " . $_SESSION["prénom"] . "</p>";

?>



 
<a href="logout.php">Logout</a>




