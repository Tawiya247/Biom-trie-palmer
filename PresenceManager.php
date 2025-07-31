<?php
require_once 'Database.php';

class PresenceManager {
    private $pdo;

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function enregistrerPresence($id_biometrique) {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE id_biometrique = ?");
        $stmt->execute([$id_biometrique]);
        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($utilisateur) {
            $heure_now = date("H:i:s");
            $date_now = date("Y-m-d");
            $statut = ($heure_now <= '17:30:00') ? 'Présent' : 'Absent';

            $insert = $this->pdo->prepare("INSERT INTO jour_presence (date_jour, heure_arrivee, statut, utilisateur_id)
                                          VALUES (?, ?, ?, ?)
                                          ON CONFLICT (utilisateur_id, date_jour)
                                          DO UPDATE SET statut = EXCLUDED.statut, heure_arrivee = EXCLUDED.heure_arrivee");

            $insert->execute([$date_now, $heure_now, $statut, $utilisateur['id_utilisateur']]);

            return "Présence enregistrée pour " . $utilisateur['prenom'] . " " . $utilisateur['nom'];
        } else {
            return "Utilisateur non reconnu.";
        }
    }

    public function getPresencesDuJour($date) {
        $stmt = $this->pdo->prepare("SELECT u.nom, u.prenom, u.poste, j.statut, j.heure_arrivee
                                     FROM utilisateurs u
                                     LEFT JOIN jour_presence j ON u.id_utilisateur = j.utilisateur_id AND j.date_jour = ?
                                     ORDER BY u.nom");
        $stmt->execute([$date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

