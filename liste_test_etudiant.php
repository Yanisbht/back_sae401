<?php
// Inclure le fichier de configuration pour la connexion à la base de données
require 'config.php';

// Définir le header pour indiquer que la réponse est au format JSON
header('Content-Type: application/json');

// Récupérer l'ID de l'étudiant depuis les paramètres de la requête
$id_etudiant = $_GET['id_etudiant'] ?? null;

if (!$id_etudiant) {
    echo json_encode(['error' => 'ID de l\'étudiant manquant.']);
    exit;
}

try {
    // Requête SQL pour récupérer les tests de l'étudiant
    $sql = "
        SELECT 
            t.id_test,
            t.theme,
            t.date_test,
            t.nombre_questions,
            t.score
        FROM 
            test t
        JOIN 
            passetest pt ON t.id_test = pt.id_test
        WHERE 
            pt.id_etudiant = ?
    ";

    // Préparer et exécuter la requête
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_etudiant]);

    // Récupérer tous les résultats sous forme de tableau associatif
    $tests = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Renvoyer les données au format JSON
    echo json_encode(['tests' => $tests]);
} catch (PDOException $e) {
    // En cas d'erreur, renvoyer un message d'erreur
    echo json_encode(['error' => 'Erreur lors de la récupération des tests : ' . $e->getMessage()]);
}
?>