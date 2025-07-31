<?php
session_start();

$erreur = false;

// Connexion à PostgreSQL
try {
    $pdo = new PDO('pgsql:host=localhost;dbname=gestion_presence', 'postgres', 'root');
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $password = $_POST['password'] ?? '';

    // Prépare la requête pour récupérer l'utilisateur
    $stmt = $pdo->prepare('SELECT motdepasse FROM utilisateurs WHERE nom = :nom');
    $stmt->execute(['nom' => $nom]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifie le mot de passe (en clair ici, à sécuriser avec password_hash en prod)
    if ($user && $password === $user['motdepasse']) {
        $_SESSION['connecte'] = true;
        header('Location: Dashboard.php');
        exit;
    } else {
        $erreur = true;
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
            <h1>Biopalmer</h1>
            <p>Sécurité biométrique palmaire</p>
        </div>

        <form class="login-form" method="POST" action="">
            <div class="input-group">
                <label for="nom">Nom d'utilisateur</label>
                <input type="text" id="nom" name="nom" placeholder="Entrez votre nom" required />
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