<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: Connexion.php');
    exit();
}

// Utilisation de la classe Database pour la connexion
require_once 'Database.php';
$database = new Database();
$pdo = $database->getConnection();

// Vérification de l'existence de PhpSpreadsheet
if (!file_exists('vendor/autoload.php')) {
    die("Erreur : PhpSpreadsheet n'est pas installé. Veuillez exécuter 'composer require phpoffice/phpspreadsheet'");
}

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Récupération des données de présence du jour
$date = date('Y-m-d');
$stmt = $pdo->prepare("SELECT u.nom, u.prenom, u.poste, 
                      CASE WHEN p.idPresence IS NOT NULL THEN 'Présent' ELSE 'Absent' END as statut, 
                      p.heure as heure_arrivee 
                      FROM \"Utilisateur\" u 
                      LEFT JOIN \"Presence\" p ON u.\"idUtilisateur\" = p.\"idUtilisateur\" AND p.\"date\" = :date
                      ORDER BY u.\"idUtilisateur\"");
$stmt->execute(['date' => $date]);
$donnees = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
header('Content-Disposition: attachment; filename="rapport_presence_' . $date . '.xlsx"');
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
