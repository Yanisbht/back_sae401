<?php
require 'config.php'; // Inclure le fichier de configuration pour la connexion à la base de données

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$id_test = $data['id_test'];

try {
    // Supprimer de la table `test`
    $stmt = $pdo->prepare('DELETE FROM test WHERE id_test = ?');
    $stmt->execute([$id_test]);

    echo json_encode(['message' => 'Test supprimé avec succès']);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur lors de la suppression du test : ' . $e->getMessage()]);
}
?>