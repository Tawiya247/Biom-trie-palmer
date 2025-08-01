<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BioPalmer - Contrôle de présence biométrique</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@300;400;500;600;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: 'Urbanist', sans-serif;
      background-color: #f8fafc;
    }
    
    .rotate-animation {
      transition: transform 0.6s ease;
    }
    
    .rotate-animation:hover {
      transform: rotate(15deg) scale(1.05);
    }
    
    .pulse-animation {
      animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
      0% {
        transform: scale(1);
      }
      50% {
        transform: scale(1.05);
      }
      100% {
        transform: scale(1);
      }
    }
    
    .gradient-text {
      background: linear-gradient(90deg, #0b7285 0%, #0e7490 50%, #0891b2 100%);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }
    
    .feature-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
  </style>
</head>
<body class="min-h-screen flex flex-col"> 
  <!-- Navigation -->
  <nav class="bg-white shadow-sm py-4 px-6 lg:px-12 flex items-center justify-between">
    <div class="flex items-center space-x-2">
    <img src="PayGate Logo.png" alt="Logo BioPalmer" class="w-16 h-16 object-contain">
    <!-- <span class="text-xl font-bold text-gray-800">Bio<span class="text-blue-600">Palmer</span></span> -->
  </div>
    
    <div class="hidden md:flex items-center space-x-8">
      <a href="#" class="text-gray-600 hover:text-blue-600 transition">Accueil</a>
      <a href="fonctionnalité.html" class="text-gray-600 hover:text-blue-600 transition">Fonctionnalités</a>
      <!-- <a href="#" class="text-gray-600 hover:text-blue-600 transition">Contact</a> -->
    </div>
    
    <a href="Connexion.php" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition shadow-md hover:shadow-lg">
      Connexion
    </a>
    
    <button class="md:hidden text-gray-600">
      <i class="fas fa-bars text-2xl"></i>
    </button>
  </nav>

  <!-- Hero Section -->
  <main class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <div class="lg:grid lg:grid-cols-2 lg:gap-12 items-center">
        <div class="text-center lg:text-left mb-12 lg:mb-0">
          <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6">
            <span class="gradient-text">Contrôle de présence</span><br>
            par reconnaissance palmaire
          </h1>
          <p class="text-lg md:text-xl text-gray-600 mb-8 max-w-lg mx-auto lg:mx-0">
            Une solution biométrique fiable, rapide et sécurisée pour gérer les présences de votre organisation.
          </p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
            <a href="Connexion.php" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-medium text-lg transition shadow-md hover:shadow-lg flex items-center justify-center">
              <i class="fas fa-sign-in-alt mr-2"></i> Se connecter
            </a>
            <a href="https://www.youtube.com/watch?v=XB8TKwMBAww&t=20s" class="border-2 border-blue-600 text-blue-600 hover:bg-blue-50 px-8 py-3 rounded-lg font-medium text-lg transition flex items-center justify-center">
              <i class="fas fa-play-circle mr-2"></i> Voir la démo
            </a>
          </div>
          
          <div class="mt-10 flex items-center justify-center lg:justify-start space-x-4">
            <!-- <div class="flex -space-x-2">
              <img class="w-10 h-10 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/women/12.jpg" alt="">
              <img class="w-10 h-10 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/men/32.jpg" alt="">
              <img class="w-10 h-10 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/women/44.jpg" alt="">
            </div> -->
            <div class="text-left">
              <!-- <p class="text-sm text-gray-600">Utilisé par plus de <span class="font-bold">500+</span> entreprises</p> -->
              <!-- <div class="flex items-center">
                <i class="fas fa-star text-yellow-400"></i>
                <i class="fas fa-star text-yellow-400"></i>
                <i class="fas fa-star text-yellow-400"></i>
                <i class="fas fa-star text-yellow-400"></i>
                <i class="fas fa-star text-yellow-400"></i>
                <span class="ml-2 text-sm font-medium text-gray-600">4.9/5</span>
              </div> -->
            </div>
          </div>
        </div>
        
        <div class="relative">
          <!-- <div class="bg-blue-600 rounded-3xl p-1 w-full max-w-md mx-auto shadow-xl"> -->
            <img src="aeef455916b11c8df6cc1975b650f843-removebg-preview.png" 
     alt="Reconnaissance palmaire" 
     class="rounded-2xl w-3/4 max-w-md mx-auto h-auto rotate-animation pulse-animation">
          </div>
          <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-xl shadow-lg hidden lg:block">
            <!-- <div class="flex items-center">
              <div class="bg-green-100 p-3 rounded-full mr-3">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
              </div> -->
              <div>
                <!-- <p class="font-bold text-gray-800">99.9% de précision</p>
                <p class="text-sm text-gray-600">Reconnaissance instantanée</p> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Features Section -->
  <section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Pourquoi choisir BioPalmer ?</h2>
        <p class="text-lg text-gray-600 max-w-3xl mx-auto">
          Une solution complète pour une gestion optimale des présences grâce à la biométrie palmaire.
        </p>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Feature 1 -->
        <div class="bg-gray-50 rounded-xl p-8 feature-card transition duration-300">
          <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-bolt text-blue-600 text-2xl"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">Rapidité</h3>
          <p class="text-gray-600">
            Enregistrement des présences en moins d'une seconde avec une simple reconnaissance de la paume.
          </p>
        </div>
        
        <!-- Feature 2 -->
        <div class="bg-gray-50 rounded-xl p-8 feature-card transition duration-300">
          <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-shield-alt text-green-600 text-2xl"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">Sécurité</h3>
          <p class="text-gray-600">
            Technologie anti-fraude avancée qui empêche toute tentative de contournement du système.
          </p>
        </div>
        
        <!-- Feature 3 -->
        <div class="bg-gray-50 rounded-xl p-8 feature-card transition duration-300">
          <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-chart-line text-purple-600 text-2xl"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">Analytique</h3>
          <p class="text-gray-600">
            Rapports détaillés et tableaux de bord pour une analyse complète des présences.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="py-16 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h2 class="text-3xl md:text-4xl font-bold mb-6">Prêt à révolutionner votre gestion des présences ?</h2>
      <p class="text-xl mb-8 max-w-3xl mx-auto">
        BioPalmer est là pour vous sérvir.
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <!-- <a href="#" class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-medium text-lg transition shadow-md hover:shadow-lg">
          <i class="fas fa-calendar-check mr-2"></i> Demander une démo
        </a> -->
        <!-- <a href="#" class="border-2 border-white text-white hover:bg-blue-700 px-8 py-3 rounded-lg font-medium text-lg transition">
          <i class="fas fa-phone-alt mr-2"></i> Nous contacter
        </a> -->
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
          <div class="flex items-center space-x-2 mb-4">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
              <i class="fas fa-fingerprint text-white text-lg"></i>
            </div>
            <span class="text-xl font-bold">Bio<span class="text-blue-400">Palmer</span></span>
          </div>
          <p class="text-gray-400">
            La solution biométrique ultime pour une gestion optimale des présences.
          </p>
          <!-- <div class="flex space-x-4 mt-4">
            <a href="#" class="text-gray-400 hover:text-white transition">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="text-gray-400 hover:text-white transition">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="text-gray-400 hover:text-white transition">
              <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="#" class="text-gray-400 hover:text-white transition">
              <i class="fab fa-instagram"></i>
            </a>
          </div>
        </div> -->
        
        <div>
          <h3 class="text-lg font-semibold mb-4">Produit</h3>
          <ul class="space-y-2">
            <li><a href="fonctionnalité.html" class="text-gray-400 hover:text-white transition">Fonctionnalités</a></li>
            <!-- <li><a href="#" class="text-gray-400 hover:text-white transition">Tarifs</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition">API</a></li> -->
            <!-- <li><a href="#" class="text-gray-400 hover:text-white transition">Documentation</a></li> -->
          </ul>
        </div>
        
        <div>
          <!-- <h3 class="text-lg font-semibold mb-4">Entreprise</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-400 hover:text-white transition">À propos</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition">Carrières</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition">Blog</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition">Partenaires</a></li>
          </ul>
        </div>
        
        <div>
          <h3 class="text-lg font-semibold mb-4">Support</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-400 hover:text-white transition">Centre d'aide</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition">Contact</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition">Statut</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition">Confidentialité</a></li>
          </ul>
        </div>
      </div> -->
      
      <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
        <p class="text-gray-400 text-sm">
          © 2025 BioPalmer. Tous droits réservés.
        </p>
        <!-- <div class="flex space-x-6 mt-4 md:mt-0">
          <a href="#" class="text-gray-400 hover:text-white text-sm transition">Conditions</a>
          <a href="#" class="text-gray-400 hover:text-white text-sm transition">Politique de confidentialité</a>
          <a href="#" class="text-gray-400 hover:text-white text-sm transition">Cookies</a>
        </div> -->
      </div>
    </div>
  </footer>

  <script>
    // Simple animation for the palm image
    document.addEventListener('DOMContentLoaded', function() {
      const palmImage = document.querySelector('.rotate-animation');
      
      palmImage.addEventListener('click', function() {
        this.classList.add('rotate-45');
        setTimeout(() => {
          this.classList.remove('rotate-45');
        }, 600);
      });
    });
  </script>
</body>
</html>