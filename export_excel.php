<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: Connexion.php');
    exit();
}

require 'vendor/autoload.php'; // Nécessite PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Connexion DB
$pdo = new PDO("mysql:host=localhost;dbname=ta_base", "utilisateur", "mot_de_passe");
$query = $pdo->query("SELECT nom, prenom, poste, statut, heure_arrivee FROM presences");
$donnees = $query->fetchAll(PDO::FETCH_ASSOC);

// Création du fichier Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->fromArray(['Nom', 'Prénom', 'Poste', 'Statut', 'Heure d\'arrivée'], NULL, 'A1');

$ligne = 2;
foreach ($donnees as $row) {
    $sheet->fromArray(array_values($row), NULL, 'A' . $ligne++);
}

// Téléchargement
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="rapport_presence.xlsx"');
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
