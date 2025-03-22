<?php
header('Content-Type: application/json');

// Connexion à la base de données
$host = 'localhost';
$dbname = 'sae401';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur de connexion à la base de données']);
    exit;
}

// Récupérer l'ID de l'utilisateur depuis l'URL
$userId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($userId > 0) {
    // Requête SQL pour récupérer les données de l'utilisateur et de l'étudiant
    $sql = "
        SELECT 
            p.id_personne, 
            p.prenom, 
            p.nom, 
            p.date_naissance, 
            p.login, 
            e.neph, 
            e.date_inscription, 
            e.etg, 
            e.echec_etg
        FROM 
            personne p
        JOIN 
            etudiant e 
        JOIN 
            admin a
        ON 
            p.id_personne = e.id_personne
            AND p.id_personne = a.id_personne
        WHERE 
            p.id_personne = :userId;
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();

    // Récupérer les données
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userData) {
        echo json_encode($userData); // Renvoyer les données au format JSON
    } else {
        echo json_encode(['error' => 'Utilisateur non trouvé']);
    }
} else {
    echo json_encode(['error' => 'ID utilisateur non valide']);
}
?>