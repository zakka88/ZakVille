<?php 
$host = "localhost"; // Cambia se necessario
$dbname = "zakville";
$username = "root"; // Cambia se necessario
$password = ""; // Cambia se necessario

    try{
        $pdo = new PDO('mysql:dbname=Zakville;host=localhost', "root",); 
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo 'Connexion réussie'."<br>";
        
    }catch (PDOException $e){
        die('Erreur : '. $e->getMessage());
    }

    ?>


  