<?php
header('Content-Type: application/json');
require 'config.php'; // Fichier de connexion à la base de données

// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=localhost;dbname=sae401", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["error" => "Connexion échouée : " . $e->getMessage()]));
}

// Inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'register') {
    $data = json_decode(file_get_contents('php://input'), true);
    $prenom = $data['prenom'];
    $nom = $data['nom'];
    $date_naissance = $data['date_naissance'];
    $login = $data['login'];
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO personne (prenom, nom, date_naissance, login, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$prenom, $nom, $date_naissance, $login, $password])) {
        echo json_encode(["message" => "Utilisateur inscrit !"]);
    } else {
        echo json_encode(["error" => "Erreur lors de l'inscription"]);
    }
}

// Connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'login') {
    $data = json_decode(file_get_contents('php://input'), true);
    $login = $data['login'];
    $password = $data['password'];
    
    $sql = "SELECT * FROM personne WHERE login = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {
        echo json_encode(["message" => "Connexion réussie", "user" => ["id" => $user['id_personne'], "login" => $user['login']]]);
    } else {
        echo json_encode(["error" => "Identifiants incorrects"]);
    }
}
?>
