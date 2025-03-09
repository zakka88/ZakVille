<?php

$nav = "login";
$title= "login";
require "header.php";
require "baseDeDonneés.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $name = $_POST["name"];
    

    
    
    
    

    
    
    
    // Controllo utente nel database
    $stmt = $pdo->prepare("SELECT u.id, u.username, u.password, u.firstname, u.city_id, c.name AS city_name, c.name, c.country, c.capital
    FROM users u
    JOIN cities c ON u.city_id = c.id
    WHERE u.username = ? AND u.password = ?
    ");
    $stmt->execute([$username, $password, ]);
    $user = $stmt->fetch();
    
    
    if ($user) {
          session_start();
        $_SESSION["username"] = $user["username"];
        $_SESSION["password"] = $user["password"];
        $_SESSION["firstname"] = $user["firstname"];
        $_SESSION["name"] = $user["name"];
        $_SESSION["country"] = $user["country"];


    


        header("Location: profile.php");
        
     
        exit();
    } else {
        echo "Nome utente o password errati!";
    }
}
?>


<style>
    body{
        background-image:url(./assets/img/cn_3.jpg);
        block-size: cover;
        background-position: center;
        width: 100%;
        
    }

    form{
        background-color:coral;
        
        height: 30vh;
        border: solid;
        border-color: white;
        border-radius: 10px;
        opacity: 0.8;
        text-align: center;
        margin: 35px;
    }

    input{
        margin: 20px;
        border-radius: 10px;
        font-size: 25px;
    }
    button{
        border-radius: 10px;
    }


</style>


<form method="POST">
    <input type="text" name="username" placeholder="Nome utente" required>
    <br>
    <input type="password" name="password" placeholder="Password" required>
    <br>
    <button type="submit">Accedi</button>
</form>






