<?php
require 'config.php'; // Utilisez votre fichier config.php

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

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
    // Insérer dans la table `personne`
    $stmt = $pdo->prepare('INSERT INTO personne (prenom, nom, date_naissance, login, password) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$prenom, $nom, $date_naissance, $login, $password]);

    $id_personne = $pdo->lastInsertId();

    // Insérer dans la table `etudiant`
    $stmt = $pdo->prepare('INSERT INTO etudiant (id_personne, neph, date_inscription, etg, echec_etg) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$id_personne, $neph, $date_inscription, $etg, $echec_etg]);

    echo json_encode(['message' => 'Élève ajouté avec succès']);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur lors de l\'ajout de l\'élève : ' . $e->getMessage()]);
}
?>