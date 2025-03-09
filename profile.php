<?php
//require "./assets/function/authentificatione.php";
session_start();
$nav = "profile";
$title= "profile";
require "header.php";
?>
 <style>
    body{

        background-image: url(./assets/img/br_1.jpg);
    }
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

    h1{
        color: white;
        font-size: 55px;
        text-align: center;
        text-shadow:  2px 2px 1px black;
    }
    p{
        color: white;
        font-size: 55px;
        text-align: center; 
        text-shadow:  2px 2px 1px black;
        
    }

    .profilo{
        margin-top: -200px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 1px;
        height: 30vh;
        margin-left: 50px;
        
        
    }

    a{
        text-shadow:  2px 2px 1px black;
    }
    .logout{
        text-shadow:  2px 2px 1px black;
        margin-left: 20px;
        
    }

    img{
        width: 200px;
        margin-left: 150px;
        margin-top: -200px;
        border-radius: 50px;

        
        
    }


 </style>
 <div class="cont">
 <!-- <img src="./assets/img/ca_3.jpg" alt=""> -->
 </div>

<?php
if (!isset($_SESSION["password"] )) {
    header("Location: login.php");
    exit();
}
?>



<div class="profilo">
    <img src="./assets/img/profilo.jpg" alt="">
    <?php

echo "<h1>Benvenuto : " . $_SESSION["username"]." " .$_SESSION["firstname"] . " !</h1>";
echo "<h1>City : " . $_SESSION["name"]." <br> Nationalité : ". $_SESSION["country"].  " </h1>";

// echo "<p><strong>prénom:</strong> " . $_SESSION["prénom"] . "</p>";
?>
    </div>



 
<a class="logout" href="logout.php">Logout</a>




