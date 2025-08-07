<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: Connexion.php');
    exit();
}

require 'vendor/autoload.php'; // Nécessite FPDF ou Dompdf
use Dompdf\Dompdf;

// Connexion DB
$pdo = new PDO("mysql:host=localhost;dbname=ta_base", "utilisateur", "mot_de_passe");
$query = $pdo->query("SELECT nom, prenom, poste, statut, heure_arrivee FROM presences");
$donnees = $query->fetchAll(PDO::FETCH_ASSOC);

// Création HTML pour le PDF
$html = '<h2 style="text-align:center;">Rapport de Présence</h2>';
$html .= '<table border="1" cellpadding="5" cellspacing="0" width="100%">';
$html .= '<tr><th>Nom</th><th>Prénom</th><th>Poste</th><th>Statut</th><th>Heure d\'arrivée</th></tr>';

foreach ($donnees as $row) {
    $html .= '<tr>';
    foreach ($row as $value) {
        $html .= '<td>' . htmlspecialchars($value) . '</td>';
    }
    $html .= '</tr>';
}
$html .= '</table>';

// Génération PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("rapport_presence.pdf", ["Attachment" => true]);
exit();
