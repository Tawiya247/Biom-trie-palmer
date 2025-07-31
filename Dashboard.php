<?php
require_once '../includes/PresenceManager.php';
$manager = new PresenceManager();
$date = date("Y-m-d");
$resultats = $manager->getPresencesDuJour($date);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de présence du <?php echo $date; ?></title>
    <style>
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background-color: #eee; }
    .present { background-color: #d4edda; }
    .absent { background-color: #f8d7da; }
</style>
</head>
<body>
<h2>Présences du <?php echo $date; ?></h2>
<table>
    <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Poste</th>
        <th>Statut</th>
        <th>Heure d'arrivée</th>
    </tr>
    <?php foreach ($resultats as $row): ?>
        <tr class="<?php echo strtolower($row['statut'] ?? 'absent'); ?>">
            <td><?php echo htmlspecialchars($row['nom']); ?></td>
            <td><?php echo htmlspecialchars($row['prenom']); ?></td>
            <td><?php echo htmlspecialchars($row['poste']); ?></td>
            <td><?php echo htmlspecialchars($row['statut'] ?? 'Absent'); ?></td>
            <td><?php echo htmlspecialchars($row['heure_arrivee'] ?? '-'); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
