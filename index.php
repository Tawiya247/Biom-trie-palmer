<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BioPalmer</title>
  <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;700&display=swap" rel="stylesheet" />
  <style>
    body {
      margin: 0;
      font-family: 'Urbanist', sans-serif;
      background-color: #f7f9fc;
      color: #222;
    }

    /* NAVBAR */
    nav {
      display: flex;
      align-items: center;
      justify-content: flex-start;
      padding: 1rem 2rem;
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .logo {
      height: 50px;
    }

    .container {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 2rem 1rem;
      text-align: center;
    }

    /* IMAGE + ANIMATION */
    .main-image {
      width: 250px;
      max-width: 100%;
      transition: transform 0.6s ease;
      cursor: pointer;
    }

    .main-image.rotate {
      transform: rotate(360deg);
    }

    /* BOUTON CONNEXION */
    .login-btn {
      margin-top: 1.5rem;
      padding: 0.7rem 1.6rem;
      background-color: #0b7285;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 1.1rem;
      transition: background-color 0.3s;
    }

    .login-btn:hover {
      background-color: #086e75;
    }

    /* TEXTE */
    h1 {
      margin-top: 2rem;
      font-size: 2.2rem;
    }

    p {
      font-size: 1.1rem;
      max-width: 600px;
      margin: 1rem auto;
      color: #555;
    }
  </style>
</head>
<body>

  <!-- NAVBAR avec logo -->
  <nav>
    <img src="PayGate Logo.png" alt="Logo BioPalmer" class="logo" />
  </nav>

  <!-- CONTENU PRINCIPAL -->
  <div class="container">
    <img src="bioo-removebg-preview.png" alt="Image biométrique" class="main-image" onclick="rotateImage(this)" />

    <button class="login-btn"><a href="Connexion.php">Connexion</a></button>

    <h1>Bienvenue sur BioPalmer</h1>
    <p>Un système intelligent de contrôle de présence par reconnaissance biométrique palmaire, fiable, rapide et sécurisé.</p>
  </div>

  <!-- SCRIPT pour rotation -->
  <script>
    function rotateImage(img) {
      img.classList.add("rotate");
      setTimeout(() => {
        img.classList.remove("rotate");
      }, 600); // correspond à la durée de l'animation
    }
  </script>

</body>
</html>
