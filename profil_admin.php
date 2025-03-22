<?php
// Inclure le fichier de configuration pour la connexion à la base de données
require 'config.php';

// Définir le header pour indiquer que la réponse est au format JSON
header('Content-Type: application/json');

// Récupérer l'ID ou le login de l'administrateur connecté
$id_admin = $_GET['id_admin'] ?? null;
$login = $_GET['login'] ?? null;

if (!$id_admin && !$login) {
    echo json_encode(['error' => 'ID ou login de l\'administrateur manquant.']);
    exit;
}

try {
    // Requête SQL pour récupérer les informations de l'administrateur
    if ($id_admin) {
        $sql = "
            SELECT 
                p.id_personne,
                p.prenom,
                p.nom,
                p.date_naissance,
                p.login,
                a.administrateur_reseau
            FROM 
                personne p
            JOIN 
                admin a ON p.id_personne = a.id_personne
            WHERE 
                a.id_admin = ?
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_admin]);
    } else {
        $sql = "
            SELECT 
                p.id_personne,
                p.prenom,
                p.nom,
                p.date_naissance,
                p.login,
                a.administrateur_reseau
            FROM 
                personne p
            JOIN 
                admin a ON p.id_personne = a.id_personne
            WHERE 
                p.login = ?
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$login]);
    }

    // Récupérer les résultats sous forme de tableau associatif
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin) {
        echo json_encode(['error' => 'Administrateur non trouvé.']);
        exit;
    }

    // Renvoyer les données au format JSON
    echo json_encode(['admin' => $admin]);
} catch (PDOException $e) {
    // En cas d'erreur, renvoyer un message d'erreur
    echo json_encode(['error' => 'Erreur lors de la récupération des données de l\'administrateur : ' . $e->getMessage()]);
}
?>