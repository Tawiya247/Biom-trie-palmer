<?php
// PresenceManager.php

class PresenceManager
{
    private $pdo;

    public function __construct()
    {
        $host = 'localhost';
        $dbname = 'gestion_presence';  // ← À vérifier
        $user = 'postgres';
        $password = 'root';     // ← Change ce mot de passe si tu utilises autre chose

        $dsn = "pgsql:host=$host;dbname=$dbname;user=$user;password=$password";

        try {
            $this->pdo = new PDO($dsn);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
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
        $stmt_presence = $this->pdo->prepare('SELECT "idPresence", "heure", "date" FROM "Presence" WHERE "date" = :date ORDER BY "idPresence"');
        $stmt_presence->execute(['date' => $date]);
        $presences = $stmt_presence->fetchAll(PDO::FETCH_ASSOC);

        // Associer manuellement par ordre (1er utilisateur → 1ère présence, etc.)
        $resultats = [];

        foreach ($utilisateurs as $index => $user) {
            $presence = $presences[$index] ?? null;

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
}