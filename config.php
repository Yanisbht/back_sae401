<?php
// Informations de connexion à la base de données AlwaysData
$host = "mysql-aceclamence.alwaysdata.net"; // Remplacez [votre_compte] par votre nom de compte AlwaysData
$dbname = "easytodrive_sae401"; // Nom de votre base de données
$username = "aceclamence@gmail.com"; // Utilisateur MySQL généré par AlwaysData
$password = "7Npts,7Npts,"; // Mot de passe MySQL généré par AlwaysData

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En cas d'erreur, afficher un message d'erreur
    die(json_encode(["error" => "Connexion à la base de données échouée : " . $e->getMessage()]));
}
?>