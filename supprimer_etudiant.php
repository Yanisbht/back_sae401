<?php
require 'config.php'; // Utilisez votre fichier config.php

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$id_etudiant = $data['id_etudiant'];

try {
    // Récupérer l'id_personne correspondant à l'étudiant
    $stmt = $pdo->prepare('SELECT id_personne FROM etudiant WHERE id_etudiant = ?');
    $stmt->execute([$id_etudiant]);
    $id_personne = $stmt->fetchColumn();

    // Supprimer de la table `etudiant`
    $stmt = $pdo->prepare('DELETE FROM etudiant WHERE id_etudiant = ?');
    $stmt->execute([$id_etudiant]);

    // Supprimer de la table `personne`
    $stmt = $pdo->prepare('DELETE FROM personne WHERE id_personne = ?');
    $stmt->execute([$id_personne]);

    echo json_encode(['message' => 'Élève supprimé avec succès']);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur lors de la suppression de l\'élève : ' . $e->getMessage()]);
}
?>