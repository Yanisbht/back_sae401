<?php
// Inclure le fichier de configuration pour la connexion à la base de données
require 'config.php';

// Définir le header pour indiquer que la réponse est au format JSON
header('Content-Type: application/json');

try {
    // Requête SQL pour récupérer la liste des étudiants avec leurs informations personnelles
    $sql = "
        SELECT 
            e.id_etudiant,
            p.prenom,
            p.nom,
            p.date_naissance,
            p.login,
            e.neph,
            e.date_inscription,
            e.etg,
            e.echec_etg
        FROM 
            etudiant e
        JOIN 
            personne p ON e.id_personne = p.id_personne
    ";

    // Exécuter la requête
    $stmt = $pdo->query($sql);

    // Récupérer tous les résultats sous forme de tableau associatif
    $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Renvoyer les données au format JSON
    echo json_encode(['etudiants' => $etudiants]);
} catch (PDOException $e) {
    // En cas d'erreur, renvoyer un message d'erreur
    echo json_encode(['error' => 'Erreur lors de la récupération des étudiants : ' . $e->getMessage()]);
}
?>