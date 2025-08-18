<?php
session_start();

$erreur = false;

// Utilisation de la classe Database pour la connexion
require_once 'Database.php';
$database = new Database();
$pdo = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($nom) || empty($password)) {
        $erreur = true;
    } else {
        try {
            // Requête sur la table "Admin" (avec guillemets car nom en majuscule)
            $stmt = $pdo->prepare('SELECT "mot_de_passe", "idAdmin" FROM "Admin" WHERE "nom" = :nom');
            $stmt->execute(['nom' => $nom]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérification : nom existe et mot de passe correspond (en clair)
            if ($admin && $password === $admin['mot_de_passe']) {
                $_SESSION['admin_id'] = $admin['idAdmin'];
                $_SESSION['admin_nom'] = $nom;
                header('Location: Dashboard.php');
                exit;
            } else {
                $erreur = true;
            }
        } catch (PDOException $e) {
            $erreur = true;
            // En production : ne pas afficher l'erreur
            // error_log($e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Biopalm - Connexion</title>
    <link rel="stylesheet" href="styleconnexion.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"/>
</head>
<body>
    <div class="container">
        <div class="logo">
            <h1>Biopalm</h1>
            <p>Sécurité biométrique palmaire</p>
        </div>

        <form class="login-form" method="POST" action="">
            <div class="input-group">
                <label for="nom">Nom d'utilisateur</label>
                <input type="text" id="nom" name="nom" placeholder="Entrez votre nom" required value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" />
            </div>

            <div class="input-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required />
            </div>

            <button type="submit" class="btn-login">Se connecter</button>

            <?php if ($erreur): ?>
                <div class="error">Nom ou mot de passe incorrect</div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>