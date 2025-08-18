<?php
// PresenceManager.php
require_once 'Database.php';

class PresenceManager
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    /**
     * Récupère les présences du jour avec les infos utilisateurs
     * Association : 1ère présence = 1er utilisateur (ordre d'insertion)
     */
    public function getPresencesDuJour($date)
    {
        // Récupérer tous les utilisateurs (dans l'ordre d'insertion)
        $stmt_users = $this->pdo->query('SELECT "idUtilisateur", "nom", "prenom", "poste" FROM "Utilisateur" ORDER BY "idUtilisateur"');
        $utilisateurs = $stmt_users->fetchAll(PDO::FETCH_ASSOC);

        // Récupérer toutes les présences de la date donnée
        $stmt_presence = $this->pdo->prepare('SELECT "idPresence", "heure", "date", "idUtilisateur" FROM "Presence" WHERE "date" = :date ORDER BY "idUtilisateur", "heure"');
        $stmt_presence->execute(['date' => $date]);
        $presences = $stmt_presence->fetchAll(PDO::FETCH_ASSOC);

        // Créer un tableau associatif pour un accès rapide
        $presencesParUtilisateur = [];
        foreach ($presences as $presence) {
            $presencesParUtilisateur[$presence['idUtilisateur']] = $presence;
        }

        // Associer les présences aux utilisateurs
        $resultats = [];

        foreach ($utilisateurs as $user) {
            $presence = $presencesParUtilisateur[$user['idUtilisateur']] ?? null;

            $resultats[] = [
                'nom' => $user['nom'],
                'prenom' => $user['prenom'],
                'poste' => $user['poste'],
                'statut' => $presence ? 'Présent' : 'Absent',
                'heure_arrivee' => $presence ? $presence['heure'] : null
            ];
        }

        return $resultats;
    }

    /**
     * Enregistre la présence d'un utilisateur par son ID biométrique
     */
    public function enregistrerPresence($id_biometrique)
    {
        // Vérifier si l'utilisateur existe
        $stmt = $this->pdo->prepare('SELECT "idUtilisateur" FROM "Utilisateur" WHERE "id_biometrique" = :id_biometrique');
        $stmt->execute(['id_biometrique' => $id_biometrique]);
        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$utilisateur) {
            throw new Exception("Utilisateur non trouvé");
        }

        // Vérifier s'il y a déjà une présence aujourd'hui
        $date = date('Y-m-d');
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM "Presence" WHERE "idUtilisateur" = :idUtilisateur AND "date" = :date');
        $stmt->execute([
            'idUtilisateur' => $utilisateur['idUtilisateur'],
            'date' => $date
        ]);
        $presenceExistante = $stmt->fetchColumn();

        // Enregistrer la présence
        $heure = date('H:i:s');
        $stmt = $this->pdo->prepare('INSERT INTO "Presence" ("idUtilisateur", "date", "heure", "type") VALUES (:idUtilisateur, :date, :heure, :type)');
        
        $type = $presenceExistante > 0 ? 'sortie' : 'entree';
        
        $stmt->execute([
            'idUtilisateur' => $utilisateur['idUtilisateur'],
            'date' => $date,
            'heure' => $heure,
            'type' => $type
        ]);

        return $type === 'entree' ? "Arrivée enregistrée à $heure" : "Départ enregistré à $heure";
    }
}