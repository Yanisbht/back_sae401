<?php
require 'config.php'; // Inclure le fichier de configuration pour la connexion à la base de données

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$theme = $data['theme'];
$date_test = $data['date_test'];
$nombre_questions = $data['nombre_questions'];
$score = $data['score'];

try {
    // Insérer dans la table `test`
    $stmt = $pdo->prepare('INSERT INTO test (theme, date_test, nombre_questions, score) VALUES (?, ?, ?, ?)');
    $stmt->execute([$theme, $date_test, $nombre_questions, $score]);

    echo json_encode(['message' => 'Test ajouté avec succès']);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur lors de l\'ajout du test : ' . $e->getMessage()]);
}
?>