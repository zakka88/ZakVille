<?php
$host = "localhost"; // Cambia se necessario
$dbname = "tp_zakville";
$username = "root"; // Cambia se necessario
$password = ""; // Cambia se necessario

try {
	$pdo = new PDO("mysql:dbname=$dbname;host=$host", $username, $password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// echo '<span style="color: white; margin-left: 20px; font-size: 30px;">Connexion réussie</span>' . "<br>";
} catch (PDOException $e) {
	die('Erreur : ' . $e->getMessage());
}
