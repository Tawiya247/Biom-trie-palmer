<?php
session_start();
if (!isset($_SESSION['connecte']) || !$_SESSION['connecte']) {
    header('Location: Connexion.php');
    exit();
}

// Utilisation de la classe Database pour la connexion
require_once 'Database.php';
$database = new Database();
$pdo = $database->getConnection();

// Vérification de l'existence de Dompdf
if (!file_exists('vendor/autoload.php')) {
    die("Erreur : Dompdf n'est pas installé. Veuillez exécuter 'composer require dompdf/dompdf'");
}

require 'vendor/autoload.php';
use Dompdf\Dompdf;

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

// Création HTML pour le PDF
$html = '<h2 style="text-align:center;">Rapport de Présence - ' . $date . '</h2>';
$html .= '<table border="1" cellpadding="5" cellspacing="0" width="100%">';
$html .= '<tr><th>Nom</th><th>Prénom</th><th>Poste</th><th>Statut</th><th>Heure d\'arrivée</th></tr>';

foreach ($donnees as $row) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($row['nom']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['prenom']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['poste']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['statut']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['heure_arrivee'] ?? '-') . '</td>';
    $html .= '</tr>';
}
$html .= '</table>';

// Génération PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("rapport_presence_" . $date . ".pdf", ["Attachment" => true]);
exit();
