<?php
require 'config.php'; // Inclure le fichier de configuration pour la connexion à la base de données

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$id_test = $data['id_test'];
$theme = $data['theme'];
$date_test = $data['date_test'];
$nombre_questions = $data['nombre_questions'];
$score = $data['score'];

try {
    // Mettre à jour la table `test`
    $stmt = $pdo->prepare('UPDATE test SET theme = ?, date_test = ?, nombre_questions = ?, score = ? WHERE id_test = ?');
    $stmt->execute([$theme, $date_test, $nombre_questions, $score, $id_test]);

    echo json_encode(['message' => 'Test modifié avec succès']);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur lors de la modification du test : ' . $e->getMessage()]);
}
?>