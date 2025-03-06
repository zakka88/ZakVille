
<?php
 require "./assets/function/authentificatione.php";
$nav = "login";
$title = "login";



$erreur = null;
if(!empty($_POST['pseudo']) || !empty($_POST['password'])){
    if ($_POST['pseudo'] === "zak" && $_POST['password'] === "0000"){
        session_start();
        $_SESSION['connected'] = 1;
        $_SESSION['pseudo'] = $_POST['pseudo'];
        header("Location: profile.php");
}else {
    $erreur = "identifiants incorrects ! ";
}
}
require "header.php";
if(is_connected()):
    header("Location: profile.php");
endif;
if($erreur) : ?>

<div class="alert alert-danger">
<?php echo $erreur ?>
</div>
<?php endif;
 ?>
<div align="center">
        </br>
        <h1>Login</h1>
        <form action="login.php" method="POST">
            <input type="text" name="pseudo" placeholder="Votre Login">
            <br><br>
            <input type="password" name="password" placeholder="Votre mot de passe">
            <br><br>
            <button class="btn btn-primary" type="submit">Se connecter</button>
       
    </div>














<?php

require "footer.php"

?>