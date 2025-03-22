<?php
// Inclure le fichier de configuration pour la connexion à la base de données
require 'config.php';

// Définir le header pour indiquer que la réponse est au format JSON
header('Content-Type: application/json');

// Récupérer les données de la requête
$data = json_decode(file_get_contents('php://input'), true);

$action = $data['action'] ?? null; // 'avertissement' ou 'suppression'
$id_avis = $data['id_avis'] ?? null;

if (!$action || !$id_avis) {
    echo json_encode(['error' => 'Action ou ID de l\'avis manquant.']);
    exit;
}

try {
    if ($action === 'avertissement') {
        // Mettre à jour le statut de l'avis pour indiquer un avertissement
        $stmt = $pdo->prepare('UPDATE avis SET statut_moderation = ? WHERE id_avis = ?');
        $stmt->execute(['avertissement', $id_avis]);

        echo json_encode(['message' => 'Avis modéré avec succès (avertissement).']);
    } elseif ($action === 'suppression') {
        // Supprimer l'avis de la base de données
        $stmt = $pdo->prepare('DELETE FROM avis WHERE id_avis = ?');
        $stmt->execute([$id_avis]);

        echo json_encode(['message' => 'Avis supprimé avec succès.']);
    } else {
        echo json_encode(['error' => 'Action non reconnue.']);
    }
} catch (PDOException $e) {
    // En cas d'erreur, renvoyer un message d'erreur
    echo json_encode(['error' => 'Erreur lors de la gestion de l\'avis : ' . $e->getMessage()]);
}
?>