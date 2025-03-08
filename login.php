<?php

$nav = "login";
$title= "login";
require "header.php";
require "baseDeDonneés.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pseudo = $_POST["pseudo"];
    $mot_de_passe = $_POST["mot_de_passe"];
    $nom = $_POST["nom"];
    $nom = $_POST["prénom"];
    

    
    
    
    // Controllo utente nel database
    $stmt = $pdo->prepare("SELECT * FROM zakville WHERE pseudo = ? AND mot_de_passe = ?  ");
    $stmt->execute([$pseudo, $mot_de_passe, ]);
    $user = $stmt->fetch();
    
    
    if ($user) {

        $_SESSION["pseudo"] = $user["pseudo"];
        $_SESSION["mot_de_passe"] = $user["mot_de_passe"];
        $_SESSION["nom"] = $user["nom"];
        $_SESSION["prénom"] = $user["prénom"];


        header("Location: profile.php");
        
     
        exit();
    } else {
        echo "Nome utente o password errati!";
    }
}
?>

<form method="POST">
    <input type="text" name="pseudo" placeholder="Nome utente" required>
    <input type="password" name="mot_de_passe" placeholder="Password" required>
    <button type="submit">Accedi</button>
</form>






