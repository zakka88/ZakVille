<?php 
    try{
        $pdo = new PDO('mysql:dbname=Zakville;host=localhost', "root",""); 
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo 'Connexion réussie'."<br>";
        
    }catch (PDOException $e){
        die('Erreur : '. $e->getMessage());
    }