<?php
require_once 'includes/PresenceManager.php';

header('Content-Type: application/json');

$id_biometrique = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$manager = new PresenceManager();

if ($id_biometrique) {
    try {
        $result = $manager->enregistrerPresence($id_biometrique);
        echo json_encode(['success' => true, 'message' => $result]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID biométrique manquant.']);
}
?>