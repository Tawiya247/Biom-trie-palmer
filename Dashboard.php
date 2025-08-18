<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: Connexion.php');
    exit();
}
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
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .status-badge {
            border-radius: 50px;
            padding: 6px 16px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .present {
            background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
            color: #065f46;
        }
        .absent {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            color: #991b1b;
        }
        .late {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            color: #92400e;
        }
        .glassmorphism {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        .sidebar {
            background: linear-gradient(180deg, #2d3748 0%, #1a202c 100%);
            transition: all 0.3s ease;
        }
        .nav-item {
            transition: all 0.3s ease;
            border-radius: 12px;
            margin-bottom: 8px;
        }
        .nav-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(4px);
        }
        .nav-item.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
        }
        .search-input {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }
        .search-input:focus {
            background: white;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <!-- Mobile menu button -->
    <div class="md:hidden fixed top-6 left-6 z-50">
        <button id="menuToggle" class="p-3 rounded-xl bg-white shadow-lg glassmorphism">
            <i class="fas fa-bars text-gray-700"></i>
        </button>
    </div>
    <!-- Sidebar Navigation -->
    <div id="sidebar" class="sidebar fixed inset-y-0 left-0 w-72 text-white p-6 shadow-2xl z-40">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">BioPalmer</h1>
                <p class="text-sm text-gray-300 mt-1">Gestion des présences</p>
            </div>
            <button id="closeMenu" class="md:hidden p-2 hover:bg-white/10 rounded-lg transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <nav class="mb-8">
            <ul class="space-y-2">
                <li>
                    <a href="#" class="nav-item active flex items-center p-4 text-white"> <!-- Ajout de 'active' ici -->
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center mr-4">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div>
                            <span class="font-medium">Tableau de bord</span>
                            <p class="text-xs text-gray-300">Suivi du jour</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#rapport" class="nav-item flex items-center p-4 text-white"> <!-- Retrait de 'active' ici -->
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center mr-4">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div>
                            <span class="font-medium">Rapports</span>
                            <p class="text-xs text-gray-300">Analyses</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#direction" class="nav-item flex items-center p-4 text-white"> <!-- Retrait de 'active' ici -->
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center mr-4">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <div>
                            <span class="font-medium">Directions</span>
                            <p class="text-xs text-gray-300">Départements</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#employés" class="nav-item flex items-center p-4 text-white"> <!-- Retrait de 'active' ici -->
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center mr-4">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div>
                            <span class="font-medium">Employés</span>
                            <p class="text-xs text-gray-300">Travailleurs</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="deconnexion.php" class="nav-item flex items-center p-4 text-white">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center mr-4">
                            <i class="fas fa-sign-out-alt"></i>
                        </div>
                        <div>
                            <span class="font-medium">Déconnexion</span>
                            <p class="text-xs text-gray-300">Se déconnecter</p>
                        </div>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="absolute bottom-6 left-6 right-6">
            <div class="glassmorphism p-4 rounded-xl">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-400 to-purple-400 flex items-center justify-center mr-3">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-300">Connecté</p>
                        <p class="font-medium">Administrateur</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content -->
    <div class="md:ml-72 min-h-screen">
        <!-- Header -->
        <header class="w-full bg-white shadow mb-4">
            <div class="px-6 py-4 flex flex-col md:flex-row justify-between items-center">
                <!-- Ajoutez ici du contenu si besoin -->
            </div>
        </header>
        <!-- Dashboard Content -->
        <main class="px-6 pb-6"> <!-- Retrait de 'hidden' ici -->
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Présents</p>
                            <h3 class="text-3xl font-bold text-gray-800"><?php echo $presentCount; ?></h3>
                            <p class="text-sm text-green-600 mt-1">
                                <i class="fas fa-arrow-up mr-1"></i>
                            </p>
                        </div>
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-r from-green-400 to-emerald-400 flex items-center justify-center">
                            <i class="fas fa-user-check text-white text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Absents</p>
                            <h3 class="text-3xl font-bold text-gray-800"><?php echo $absentCount; ?></h3>
                            <p class="text-sm text-red-600 mt-1">
                                <i class="fas fa-arrow-down mr-1"></i>
                            </p>
                        </div>
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-r from-red-400 to-pink-400 flex items-center justify-center">
                            <i class="fas fa-user-times text-white text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                    <!-- <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">En retard</p>
                            <h3 class="text-3xl font-bold text-gray-800"><?php echo $lateCount; ?></h3>
                            <p class="text-sm text-yellow-600 mt-1">
                                <i class="fas fa-minus mr-1"></i>0.0%
                            </p>
                        </div>
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-r from-yellow-400 to-orange-400 flex items-center justify-center">
                            <i class="fas fa-clock text-white text-xl"></i>
                        </div>
                    </div> -->
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total</p>
                            <h3 class="text-3xl font-bold text-gray-800"><?php echo count($resultats); ?></h3>
                            <p class="text-sm text-blue-600 mt-1">
                                <i class="fas fa-users mr-1"></i>Employés
                            </p>
                        </div>
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-r from-blue-400 to-purple-400 flex items-center justify-center">
                            <i class="fas fa-users text-white text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Presence Table -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Liste des présences</h2>
                <p class="text-gray-600 text-sm mt-1">Suivi en temps réel</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <div class="relative">
                    <input type="text" placeholder="Rechercher un employé..." class="search-input pl-12 pr-4 py-3 rounded-xl focus:outline-none w-full md:w-80">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <select class="search-input px-4 py-3 rounded-xl focus:outline-none">
                    <option>Tous les statuts</option>
                    <option>Présent</option>
                    <option>Absent</option>
                </select>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Employé</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Poste</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Heure d'arrivée</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach ($resultats as $row): ?>
                    <?php 
                        $statusClass = '';
                        if (isset($row['statut'])) {
                            $status = strtolower($row['statut']);
                            if ($status === 'présent') {
                                $statusClass = 'present';
                            } elseif ($status === 'absent') {
                                $statusClass = 'absent';
                            } elseif ($status === 'en retard') {
                                $statusClass = 'late';
                            }
                        }
                    ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-400 to-purple-400 flex items-center justify-center mr-4">
                                    <span class="text-white font-medium text-sm">
                                        <?php echo strtoupper(substr($row['prenom'], 0, 1) . substr($row['nom'], 0, 1)); ?>
                                    </span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">
                                        <?php echo htmlspecialchars($row['prenom'] . ' ' . $row['nom']); ?>
                                    </p>
                                    <p class="text-sm text-gray-500">ID: #<?php echo $row['id'] ?? '000'; ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <?php echo htmlspecialchars($row['poste']); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="status-badge <?php echo $statusClass; ?>">
                                <?php echo htmlspecialchars($row['statut'] ?? 'Absent'); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-clock mr-2 text-gray-400"></i>
                                <?php echo htmlspecialchars($row['heure_arrivee'] ?? '-'); ?>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <button class="p-2 text-gray-600 hover:bg-gray-50 rounded-lg transition edit-btn" 
                                        data-id="<?php echo $row['id']; ?>"
                                        data-prenom="<?php echo htmlspecialchars($row['prenom']); ?>"
                                        data-nom="<?php echo htmlspecialchars($row['nom']); ?>"
                                        data-poste="<?php echo htmlspecialchars($row['poste']); ?>"
                                        data-statut="<?php echo htmlspecialchars($row['statut'] ?? 'Absent'); ?>"
                                        data-heure="<?php echo htmlspecialchars($row['heure_arrivee'] ?? ''); ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition delete-btn" data-id="<?php echo $row['id']; ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
        </main>
        <!-- End of Dashboard Content -->
        <!-- Rapport Section -->
        <div id="rapport" class="px-6 pb-6 hidden"> <!-- Ajout de 'hidden' ici -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">Rapport des présences</h2>
                            <p class="text-gray-600 text-sm mt-1">Analyses détaillées</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <input type="date" class="search-input px-4 py-3 rounded-xl focus:outline-none">
                            <select class="search-input px-4 py-3 rounded-xl focus:outline-none">
                                <option>Tous les postes</option>
                                <option>Développeur</option>
                                <option>Designer</option>
                                <option>Manager</option>
                            </select>
                            <button class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-xl hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 flex items-center">
                                <i class="fas fa-filter mr-2"></i> Filtrer
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="text-center py-20">
                        <div class="w-20 h-20 rounded-full bg-gradient-to-r from-blue-400 to-purple-400 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-chart-line text-white text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-800 mb-2">Rapport en cours de développement</h3>
                        <p class="text-gray-600 max-w-md mx-auto">Les analyses détaillées et les graphiques seront bientôt disponibles dans cette section.</p>
                        <div class="flex justify-center gap-3 mt-8">
                            <a href="export_excel.php" class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 flex items-center">
                                <i class="fas fa-file-excel mr-2"></i> Exporter Excel
                            </a>
                            <a href="export_pdf.php" class="px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 flex items-center">
                                <i class="fas fa-file-pdf mr-2"></i> Exporter PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Direction Section -->
        <div id="direction" class="px-6 pb-6 hidden"> <!-- Ajout de 'hidden' ici -->
            <div class="bg-white rounded-2xl shadow-lg p-6 glassmorphism mb-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Gestion des Départements</h1>
                <p class="text-gray-600">Liste des départements et directeurs</p>
            </div>
            <!-- Formulaire ajout -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover mb-6">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800">Ajouter un Département</h2>
                    <p class="text-gray-600 text-sm mt-1">Créer un nouveau département</p>
                </div>
                <div class="p-6">
                    <form id="addForm" class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <input type="text" id="deptName" placeholder="Nom du Département" class="search-input pl-12 pr-4 py-3 rounded-xl focus:outline-none w-full" required>
                            <i class="fas fa-building absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <div class="relative flex-1">
                            <input type="text" id="director" placeholder="Directeur" class="search-input pl-12 pr-4 py-3 rounded-xl focus:outline-none w-full" required>
                            <i class="fas fa-user absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-xl hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 flex items-center">
                            <i class="fas fa-plus mr-2"></i> Ajouter
                        </button>
                    </form>
                </div>
            </div>
            <!-- Tableau départements -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Tableau des Départements</h2>
                        <p class="text-gray-600 text-sm mt-1">Liste complète des départements</p>
                    </div>
                    <div class="relative">
                        <input type="text" id="searchDept" placeholder="Rechercher un département..." class="search-input pl-12 pr-4 py-3 rounded-xl focus:outline-none w-full md:w-80">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nom du Département</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Directeur</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="deptTableBody" class="divide-y divide-gray-100"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Employés Section -->
        <div id="employés" class="px-6 pb-6 hidden"> <!-- Ajout de 'hidden' ici -->
            <div class="bg-white rounded-2xl shadow-lg p-6 glassmorphism mb-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Gestion des Employés</h1>
                <p class="text-gray-600">Ajouter, modifier ou supprimer des employés</p>
            </div>
            <!-- Formulaire ajout employé -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover mb-6">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800">Ajouter un Employé</h2>
                    <p class="text-gray-600 text-sm mt-1">Enregistrer un nouvel employé</p>
                </div>
                <div class="p-6">
                    <form id="addEmployeeForm" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        <div class="relative">
                            <input type="text" id="nom" placeholder="Nom" class="search-input pl-12 pr-4 py-3 rounded-xl focus:outline-none w-full" required>
                            <i class="fas fa-user absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <div class="relative">
                            <input type="text" id="prenom" placeholder="Prénom" class="search-input pl-12 pr-4 py-3 rounded-xl focus:outline-none w-full" required>
                            <i class="fas fa-user absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <div class="relative">
                            <input type="tel" id="telephone" placeholder="Téléphone" class="search-input pl-12 pr-4 py-3 rounded-xl focus:outline-none w-full" required>
                            <i class="fas fa-phone absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <div class="relative">
                            <input type="text" id="poste" placeholder="Poste" class="search-input pl-12 pr-4 py-3 rounded-xl focus:outline-none w-full" required>
                            <i class="fas fa-briefcase absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <div class="relative">
                            <input type="text" id="departement" placeholder="Département" class="search-input pl-12 pr-4 py-3 rounded-xl focus:outline-none w-full" required>
                            <i class="fas fa-building absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <div class="md:col-span-2 lg:col-span-5 flex justify-end">
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-xl hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 flex items-center">
                                <i class="fas fa-plus mr-2"></i> Ajouter l'employé
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Tableau employés -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Liste des Employés</h2>
                        <p class="text-gray-600 text-sm mt-1">Tous les employés enregistrés</p>
                    </div>
                    <div class="relative">
                        <input type="text" id="searchEmployee" placeholder="Rechercher un employé..." class="search-input pl-12 pr-4 py-3 rounded-xl focus:outline-none w-full md:w-80">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nom</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Prénom</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Téléphone</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Poste</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Département</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="employeeTableBody" class="divide-y divide-gray-100">
                            <!-- Les employés seront ajoutés ici dynamiquement -->
                        </tbody>
                    </table>
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
                // Permettre le comportement normal pour le lien de déconnexion
                if (this.getAttribute('href') === 'deconnexion.php') {
                    return; // Laisser le navigateur gérer la navigation vers deconnexion.php
                }
                // Supprimer la condition qui permettait de charger des fichiers externes
                // if (this.getAttribute('href').includes('.html')) {
                //     return; // Allow navigation to external pages like employés.html and paramètre.html
                // }
                e.preventDefault();
                // Remove active class from all nav items
                document.querySelectorAll('.nav-item').forEach(item => {
                    item.classList.remove('active');
                });
                // Add active class to clicked item
                this.classList.add('active');
                // Hide all sections
                document.querySelectorAll('main, #rapport, #direction, #employés').forEach(section => {
                    section.classList.add('hidden');
                });
                // Show the selected section
                const target = this.getAttribute('href');
                if (target === '#rapport') {
                    document.getElementById('rapport').classList.remove('hidden');
                } else if (target === '#direction') {
                    document.getElementById('direction').classList.remove('hidden');
                } else if (target === '#employés') {
                    document.getElementById('employés').classList.remove('hidden');
                } else {
                    document.querySelector('main').classList.remove('hidden');
                }
                // Close mobile menu if open
                document.getElementById('sidebar').classList.remove('open');
            });
        });
        // Search functionality for employees
        document.querySelector('input[placeholder="Rechercher un employé..."]').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const employeeName = row.querySelector('td:first-child p').textContent.toLowerCase();
                if (employeeName.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        // Status filter for employees
        document.querySelector('select').addEventListener('change', function() {
            const selectedStatus = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const statusBadge = row.querySelector('.status-badge');
                if (selectedStatus === 'tous les statuts' || 
                    statusBadge.textContent.toLowerCase().includes(selectedStatus.replace('tous les statuts', ''))) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        // Add smooth animations on page load
        window.addEventListener('load', function() {
            const cards = document.querySelectorAll('.card-hover');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'all 0.6s ease';
                    requestAnimationFrame(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    });
                }, index * 100);
            });
        });
        // Gestion départements
        let departments = [];
        function renderTable() {
            const tbody = document.getElementById('deptTableBody');
            tbody.innerHTML = '';
            departments.forEach((d, i) => {
                tbody.innerHTML += `
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4"><span>${d.name}</span></td>
                        <td class="px-6 py-4"><span>${d.director}</span></td>
                        <td class="px-6 py-4"><button onclick="removeDept(${i})" class="text-red-500">Supprimer</button></td>
                    </tr>`;
            });
        }
        document.getElementById('addForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const deptName = document.getElementById('deptName');
            const director = document.getElementById('director');
            departments.push({ name: deptName.value, director: director.value });
            deptName.value = '';
            director.value = '';
            renderTable();
        });
        function removeDept(i) {
            departments.splice(i, 1);
            renderTable();
        }
        // Search functionality for departments
        document.getElementById('searchDept').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.getElementById('deptTableBody').querySelectorAll('tr');
            rows.forEach(row => {
                const deptName = row.querySelector('td:first-child span').textContent.toLowerCase();
                if (deptName.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        // Gestion employés
        let employees = [];
        function renderEmployeeTable() {
            const tbody = document.getElementById('employeeTableBody');
            tbody.innerHTML = '';
            employees.forEach((emp, i) => {
                tbody.innerHTML += `
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">${emp.nom}</td>
                        <td class="px-6 py-4">${emp.prenom}</td>
                        <td class="px-6 py-4">${emp.telephone}</td>
                        <td class="px-6 py-4">${emp.poste}</td>
                        <td class="px-6 py-4">${emp.departement}</td>
                        <td class="px-6 py-4">
                            <button onclick="removeEmployee(${i})" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>`;
            });
        }
        document.getElementById('addEmployeeForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const nom = document.getElementById('nom').value;
            const prenom = document.getElementById('prenom').value;
            const telephone = document.getElementById('telephone').value;
            const poste = document.getElementById('poste').value;
            const departement = document.getElementById('departement').value;
            employees.push({ nom, prenom, telephone, poste, departement });
            // Réinitialiser le formulaire
            document.getElementById('addEmployeeForm').reset();
            renderEmployeeTable();
        });
        function removeEmployee(i) {
            employees.splice(i, 1);
            renderEmployeeTable();
        }
        // Search functionality for employees in employee section
        document.getElementById('searchEmployee').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.getElementById('employeeTableBody').querySelectorAll('tr');
            rows.forEach(row => {
                const nom = row.querySelector('td:first-child').textContent.toLowerCase();
                const prenom = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                if (nom.includes(searchTerm) || prenom.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
