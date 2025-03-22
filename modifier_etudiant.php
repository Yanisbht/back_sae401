<?php
require 'config.php'; // Utilisez votre fichier config.php

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$id_etudiant = $data['id_etudiant'];
$prenom = $data['prenom'];
$nom = $data['nom'];
$date_naissance = $data['date_naissance'];
$login = $data['login'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);
$neph = $data['neph'];
$date_inscription = $data['date_inscription'];
$etg = $data['etg'];
$echec_etg = $data['echec_etg'];

try {
    // Récupérer l'id_personne correspondant à l'étudiant
    $stmt = $pdo->prepare('SELECT id_personne FROM etudiant WHERE id_etudiant = ?');
    $stmt->execute([$id_etudiant]);
    $id_personne = $stmt->fetchColumn();

    // Mettre à jour la table `personne`
    $stmt = $pdo->prepare('UPDATE personne SET prenom = ?, nom = ?, date_naissance = ?, login = ?, password = ? WHERE id_personne = ?');
    $stmt->execute([$prenom, $nom, $date_naissance, $login, $password, $id_personne]);

    // Mettre à jour la table `etudiant`
    $stmt = $pdo->prepare('UPDATE etudiant SET neph = ?, date_inscription = ?, etg = ?, echec_etg = ? WHERE id_etudiant = ?');
    $stmt->execute([$neph, $date_inscription, $etg, $echec_etg, $id_etudiant]);

    echo json_encode(['message' => 'Élève modifié avec succès']);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur lors de la modification de l\'élève : ' . $e->getMessage()]);
}
?>