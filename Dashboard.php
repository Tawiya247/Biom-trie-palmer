<?php
session_start();

// 🔐 Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['connecte']) || !$_SESSION['connecte']) {
    header('Location: connexion.php');
    exit();
}

// Inclure le gestionnaire de présence
require_once 'PresenceManager.php';
$manager = new PresenceManager();

// Date du jour
$date = date("Y-m-d");
$resultats = $manager->getPresencesDuJour($date);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de présence</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .present-bg {
            background-color: #dcfce7;
        }
        .absent-bg {
            background-color: #fee2e2;
        }
        .late-bg {
            background-color: #fef3c7;
        }
        .present-text {
            color: #166534;
        }
        .absent-text {
            color: #991b1b;
        }
        .late-text {
            color: #92400e;
        }
        .sidebar {
            transition: all 0.3s ease;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Mobile menu button -->
    <div class="md:hidden fixed top-4 left-4 z-50">
        <button id="menuToggle" class="p-2 rounded-md bg-white shadow-md">
            <i class="fas fa-bars text-gray-700"></i>
        </button>
    </div>

    <!-- Sidebar Navigation -->
    <div id="sidebar" class="sidebar fixed inset-y-0 left-0 w-64 bg-blue-800 text-white p-4 shadow-lg">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-xl font-bold">Gestion Présence</h1>
            <button id="closeMenu" class="md:hidden p-2">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <nav>
            <ul class="space-y-2">
                <li>
                    <a href="#" class="flex items-center p-3 rounded-lg bg-blue-700">
                        <i class="fas fa-calendar-day mr-3"></i>
                        <span>Présences du jour</span>
                    </a>
                </li>
                <li>
                    <a href="#rapport" class="flex items-center p-3 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-file-alt mr-3"></i>
                        <span>Rapport</span>
                    </a>
                </li>
                <li>
        <a href="paramètre.html" class="flex items-center p-3 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-cog mr-3"></i>
            <span>Paramètres</span>
        </a>
    </li>
            </ul>
        </nav>
        <div class="absolute bottom-4 left-4 right-4">
            <div class="p-3 bg-blue-700 rounded-lg">
                <p class="text-sm">Connecté en tant que:</p>
                <p class="font-medium">Administrateur</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="md:ml-64 min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm p-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Présences du jour<?php echo $date; ?></h1>
                <div class="flex space-x-2">
                    <!-- Ancien bouton Excel -->
<a href="export_excel.php" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center">
    <i class="fas fa-file-excel mr-2"></i> Exporter Excel
</a>

<!-- Ancien bouton PDF -->
<a href="export_pdf.php" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition flex items-center">
    <i class="fas fa-file-pdf mr-2"></i> Exporter PDF
</a>

                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <main class="p-6">
            <!-- Stats Cards -->
            <?php
    $presentCount = 0;
    $absentCount = 0;
    $lateCount = 0;
    foreach ($resultats as $row) {
        if (isset($row['statut'])) {
            $statut = strtolower($row['statut']);
            if ($statut === 'présent') $presentCount++;
            elseif ($statut === 'absent') $absentCount++;
            elseif ($statut === 'en retard') $lateCount++;
        }
    }
?>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 mr-4">
                <i class="fas fa-user-check text-green-600"></i>
            </div>
            <div>
                <p class="text-gray-500">Présents</p>
                <h3 class="text-2xl font-bold"><?php echo $presentCount; ?></h3>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-100 mr-4">
                <i class="fas fa-user-times text-red-600"></i>
            </div>
            <div>
                <p class="text-gray-500">Absents</p>
                <h3 class="text-2xl font-bold"><?php echo $absentCount; ?></h3>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 mr-4">
                <i class="fas fa-clock text-yellow-600"></i>
            </div>
            <!-- <div>
                <p class="text-gray-500">Retards</p>
                <h3 class="text-2xl font-bold"><?php echo $lateCount; ?></h3>
            </div> -->
        </div>
    </div>
</div>
            <!-- Presence Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-4 border-b flex justify-between items-center">
                    <h2 class="text-lg font-semibold">Liste des présences</h2>
                    <div class="flex items-center">
                        <div class="relative mr-4">
                            <input type="text" placeholder="Rechercher..." class="pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <select class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Tous les statuts</option>
                            <option>Présent</option>
                            <option>Absent</option>
                            <option>En retard</option>
                        </select>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prénom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poste</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Heure d'arrivée</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($resultats as $row): ?>
                                <?php 
                                    $statusClass = '';
                                    $textClass = '';
                                    if (isset($row['statut'])) {
                                        $status = strtolower($row['statut']);
                                        if ($status === 'présent') {
                                            $statusClass = 'present-bg';
                                            $textClass = 'present-text';
                                        } elseif ($status === 'absent') {
                                            $statusClass = 'absent-bg';
                                            $textClass = 'absent-text';
                                        } elseif ($status === 'en retard') {
                                            $statusClass = 'late-bg';
                                            $textClass = 'late-text';
                                        }
                                    }
                                ?>
                                <tr class="<?php echo $statusClass; ?> hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($row['nom']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($row['prenom']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($row['poste']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm <?php echo $textClass; ?> font-medium">
                                        <?php echo htmlspecialchars($row['statut'] ?? 'Absent'); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($row['heure_arrivee'] ?? '-'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- <div class="px-4 py-3 bg-gray-50 border-t flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        Affichage de <span class="font-medium">1</span> à <span class="font-medium">10</span> sur <span class="font-medium">27</span> résultats
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 border rounded-md bg-white text-gray-700 hover:bg-gray-50">
                            Précédent
                        </button>
                        <button class="px-3 py-1 border rounded-md bg-blue-600 text-white">
                            1
                        </button>
                        <button class="px-3 py-1 border rounded-md bg-white text-gray-700 hover:bg-gray-50">
                            2
                        </button>
                        <button class="px-3 py-1 border rounded-md bg-white text-gray-700 hover:bg-gray-50">
                            Suivant
                        </button>
                    </div>
                </div> -->
            </div>
        </main>

        <!-- Rapport Section (hidden by default) -->
        <div id="rapport" class="p-6 hidden">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-4 border-b flex justify-between items-center">
                    <h2 class="text-lg font-semibold">Rapport des présences</h2>
                    <div class="flex space-x-2">
                        <div class="relative">
                            <input type="date" class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <select class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Tous les postes</option>
                            <option>Développeur</option>
                            <option>Designer</option>
                            <option>Manager</option>
                        </select>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
                            <i class="fas fa-filter mr-2"></i> Filtrer
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Employee Cards
                        <div class="border rounded-lg p-4 hover:shadow-md transition">
                            <div class="flex items-center mb-3">
                                <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-gray-500"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium">Jean Dupont</h3>
                                    <p class="text-sm text-gray-500">Développeur</p>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Présences:</span>
                                    <span class="font-medium">22/24</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Retards:</span>
                                    <span class="font-medium">3</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Absences:</span>
                                    <span class="font-medium">2</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="border rounded-lg p-4 hover:shadow-md transition">
                            <div class="flex items-center mb-3">
                                <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-gray-500"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium">Marie Martin</h3>
                                    <p class="text-sm text-gray-500">Designer</p>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Présences:</span>
                                    <span class="font-medium">24/24</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Retards:</span>
                                    <span class="font-medium">0</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Absences:</span>
                                    <span class="font-medium">0</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="border rounded-lg p-4 hover:shadow-md transition">
                            <div class="flex items-center mb-3">
                                <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-gray-500"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium">Pierre Bernard</h3>
                                    <p class="text-sm text-gray-500">Manager</p>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Présences:</span>
                                    <span class="font-medium">20/24</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Retards:</span>
                                    <span class="font-medium">5</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Absences:</span>
                                    <span class="font-medium">4</span>
                                </div>
                            </div>
                        </div> -->
                        
                        <!-- More employee cards would go here -->
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 border-t flex items-center justify-between">
                    <!-- <div class="text-sm text-gray-500">
                        Affichage de <span class="font-medium">1</span> à <span class="font-medium">6</span> sur <span class="font-medium">24</span> employés
                    </div> -->
                    <div class="flex space-x-2">
                        <!-- Ancien bouton Excel -->
<a href="export_excel.php" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center">
    <i class="fas fa-file-excel mr-2"></i> Exporter Excel
</a>

<!-- Ancien bouton PDF -->
<a href="export_pdf.php" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition flex items-center">
    <i class="fas fa-file-pdf mr-2"></i> Exporter PDF
</a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Toggle mobile menu
    document.getElementById('menuToggle').addEventListener('click', function() {
        document.getElementById('sidebar').classList.add('open');
    });

    document.getElementById('closeMenu').addEventListener('click', function() {
        document.getElementById('sidebar').classList.remove('open');
    });

    // Navigation between pages
    document.querySelectorAll('nav a').forEach(link => {
        link.addEventListener('click', function(e) {
            // Si le lien est "paramètre.html", laisser la redirection naturelle
            if (this.getAttribute('href') === 'paramètre.html') {
                return;
            }
            e.preventDefault();

            // Hide all sections
            document.querySelectorAll('main, #rapport').forEach(section => {
                section.classList.add('hidden');
            });

            // Show the selected section
            const target = this.getAttribute('href');
            if (target === '#rapport') {
                document.getElementById('rapport').classList.remove('hidden');
            } else {
                document.querySelector('main').classList.remove('hidden');
            }

            // Close mobile menu if open
            document.getElementById('sidebar').classList.remove('open');
        });
    });

    // Simulate export buttons
    document.querySelectorAll('button').forEach(button => {
        if (button.textContent.includes('Excel') || button.textContent.includes('PDF')) {
            button.addEventListener('click', function() {
                alert('Export fonctionnel dans une version complète avec backend');
            });
        }
    });
        </script>
</body>
</html>
