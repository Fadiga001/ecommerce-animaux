<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Vendeur | E-commerce Animaux</title>
    <!-- Inclure Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Lien vers votre CSS personnalisé (peut être utilisé pour surcharger ou ajouter des styles) -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css">
    <style>
    /* Styles spécifiques pour ajuster le layout Bootstrap si nécessaire */
    body {
        background-color: #f8f9fa;
        /* Couleur de fond légère */
    }

    .dashboard-wrapper {
        margin-top: 0;
    }

    .sidebar {
        background-color: #343a40;
        /* Couleur sombre pour la barre latérale */
        color: white;
        padding: 20px;
        min-height: calc(100vh - 40px);
        /* Hauteur minimale pour remplir l'écran */
    }

    .sidebar a {
        color: #adb5bd;
        /* Couleur des liens */
        text-decoration: none;
        display: block;
        padding: 10px 0;
        transition: color 0.2s ease-in-out, background-color 0.2s ease-in-out;
    }

    .sidebar a:hover {
        color: white;
        background-color: #495057;
    }

    .sidebar .nav-link.active {
        color: white;
        font-weight: bold;
    }

    .content-area {
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    /* Ajustements pour les cartes Bootstrap */
    .dashboard-card.card {
        background-color: #f9f9f9;
        border: 1px solid #eee;
        height: 100%;
        /* Assure que les cartes ont la même hauteur dans la grille */
    }

    .dashboard-card .card-body {
        padding: 15px;
        /* Ajuste le padding à l'intérieur du corps de la carte */
    }

    .dashboard-card h3 {
        margin-top: 0;
        color: #333;
        font-size: 1.1em;
        margin-bottom: 10px;
    }

    .dashboard-card p {
        font-size: 1.4em;
        font-weight: bold;
        margin-bottom: 0;
    }

    .dashboard-section {
        margin-bottom: 30px;
    }

    .dashboard-section h2 {
        color: #4CAF50;
        margin-bottom: 15px;
        border-bottom: 1px solid #eee;
        padding-bottom: 5px;
    }

    /* Ajoutez d'autres styles pour les tableaux, listes, etc. si nécessaire */
    </style>
</head>

<body>

    <div class="container-fluid dashboard-wrapper">
        <div class="row">
            <!-- Barre de navigation verticale (colonne gauche) -->
            <div class="col-md-3 col-lg-2 sidebar">
                <h2 class="text-light mb-4">Menu Vendeur</h2>
                <nav class="nav flex-column">
                    <a class="nav-link active" href="<?php echo BASE_URL; ?>/vendor/dashboard">Tableau de Bord</a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/vendor/products">Gérer les Produits</a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/vendor/orders">Commandes Reçues</a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/vendor/profile">Mon Profil</a>
                    <hr class="bg-secondary my-3">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/logout">Déconnexion</a>
                </nav>
            </div>

            <!-- Contenu principal (colonne droite) -->
            <div class="col-md-9 col-lg-10 content-area">
                <h1>Tableau de Bord Vendeur</h1>

                <?php if (isset($_SESSION['user'])): ?>
                <p class="lead">Bienvenue, <?php echo htmlspecialchars($_SESSION['user']['nom']); ?> !</p>
                <?php endif; ?>

                <!-- Section Statistiques Rapides (KPIs) -->
                <div class="dashboard-section">
                    <h2>Statistiques Rapides</h2>
                    <div class="row">
                        <!-- Utilisation de la grille Bootstrap pour les cartes de stats -->
                        <div class="col-md-4 col-lg-2 mb-3">
                            <div class="dashboard-card card">
                                <div class="card-body">
                                    <h3>Ventes Total (Mois)</h3>
                                    <p>[Montant total]</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-2 mb-3">
                            <div class="dashboard-card card">
                                <div class="card-body">
                                    <h3>Commandes Reçues (Mois)</h3>
                                    <p>[Nombre total]</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-2 mb-3">
                            <div class="dashboard-card card">
                                <div class="card-body">
                                    <h3>Commandes en Attente</h3>
                                    <p>[Nombre à traiter]</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-2 mb-3">
                            <div class="dashboard-card card">
                                <div class="card-body">
                                    <h3>Produits Listés</h3>
                                    <p>[Nombre total]</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-2 mb-3">
                            <div class="dashboard-card card">
                                <div class="card-body">
                                    <h3>Produits Faible Stock</h3>
                                    <p>[Nombre bas stock]</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-2 mb-3">
                            <div class="dashboard-card card">
                                <div class="card-body">
                                    <h3>Nouveaux Avis</h3>
                                    <p>[Nombre nouveaux]</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Graphique Évolution des Ventes -->
                <div class="dashboard-section">
                    <h2>Évolution des Ventes (Mois)</h2>
                    <!-- Placeholder pour le graphique. Nécessite une librairie JS (Chart.js, etc.) et des données -->
                    <div id="salesChartPlaceholder"
                        style="height: 300px; background-color: #f9f9f9; border: 1px solid #eee; display: flex; align-items: center; justify-content: center;">
                        [Graphique des ventes à implémenter ici avec JS]
                    </div>
                </div>


                <!-- Section Commandes Récentes -->
                <div class="dashboard-section">
                    <h2>Commandes Récentes</h2>
                    <!-- Ici, vous afficherez une liste ou un tableau des dernières commandes -->
                    <div class="table-responsive">
                        <!-- Rendre le tableau responsive -->
                        <table class="table table-striped table-hover">
                            <!-- Styles de tableau Bootstrap -->
                            <thead>
                                <tr>
                                    <th>N° Commande</th>
                                    <th>Client</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Statut</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Boucle PHP pour afficher les commandes -->
                                <?php
                                    // Exemple de boucle (à remplacer par vos données réelles)
                                    $recentOrders = []; // Remplacez par la récupération de vos données
                                    if (empty($recentOrders)) {
                                        echo '<tr><td colspan="6" class="text-center">Aucune commande récente pour l\'instant.</td></tr>';
                                    } else {
                                        foreach ($recentOrders as $order) {
                                            echo '<tr>';
                                            echo '<td>' . htmlspecialchars($order['order_number']) . '</td>';
                                            echo '<td>' . htmlspecialchars($order['client_name']) . '</td>'; // Assurez-vous de ne pas exposer d'infos sensibles
                                            echo '<td>' . htmlspecialchars($order['order_date']) . '</td>';
                                            echo '<td>' . htmlspecialchars($order['total_amount']) . '</td>';
                                            echo '<td>' . htmlspecialchars($order['status']) . '</td>';
                                            echo '<td><a href="' . BASE_URL . '/vendor/order/view/' . htmlspecialchars($order['id']) . '" class="btn btn-sm btn-primary">Voir Détail</a></td>';
                                            echo '</tr>';
                                        }
                                    }
                                ?>
                                <!-- Fin de la boucle -->
                            </tbody>
                        </table>
                    </div>
                    <p class="text-end"><a href="<?php echo BASE_URL; ?>/vendor/orders">Voir toutes les commandes
                            &raquo;</a></p>
                </div>

                <!-- Section Alertes Stock -->
                <div class="dashboard-section">
                    <h2>Alertes Stock</h2>
                    <!-- Ici, vous afficherez une liste des produits dont le stock est faible -->
                    <ul class="list-group">
                        <!-- Liste Bootstrap -->
                        <!-- Boucle PHP pour afficher les alertes -->
                        <?php
                            // Exemple de boucle (à remplacer par vos données réelles)
                            $lowStockProducts = []; // Remplacez par la récupération de vos données
                            if (empty($lowStockProducts)) {
                                echo '<li class="list-group-item text-center">Aucun produit en faible stock.</li>';
                            } else {
                                foreach ($lowStockProducts as $product) {
                                    echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                                    echo htmlspecialchars($product['name']) . ' - Stock restant : ' . htmlspecialchars($product['quantity']);
                                    echo '<a href="' . BASE_URL . '/vendor/product/edit/' . htmlspecialchars($product['id']) . '" class="btn btn-sm btn-secondary">Modifier</a>';
                                    echo '</li>';
                                }
                            }
                         ?>
                        <!-- Fin de la boucle -->
                    </ul>
                    <p class="text-end"><a href="<?php echo BASE_URL; ?>/vendor/products?filter=low_stock">Voir tous les
                            produits en faible stock &raquo;</a></p>
                </div>

                <!-- Section Avis Récents -->
                <div class="dashboard-section">
                    <h2>Avis Récents</h2>
                    <!-- Ici, vous afficherez une liste ou un tableau des derniers avis sur les produits du vendeur -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Note</th>
                                    <th>Commentaire</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Boucle PHP pour afficher les avis -->
                                <?php
                                    // Exemple de boucle (à remplacer par vos données réelles)
                                    $recentReviews = []; // Remplacez par la récupération de vos données
                                    if (empty($recentReviews)) {
                                        echo '<tr><td colspan="5" class="text-center">Aucun avis récent pour l\'instant.</td></tr>';
                                    } else {
                                        foreach ($recentReviews as $review) {
                                            echo '<tr>';
                                            echo '<td>' . htmlspecialchars($review['product_name']) . '</td>';
                                            echo '<td>' . htmlspecialchars($review['rating']) . ' / 5</td>';
                                            echo '<td>' . htmlspecialchars($review['comment']) . '</td>';
                                            echo '<td>' . htmlspecialchars($review['date']) . '</td>';
                                            echo '<td><a href="#" class="btn btn-sm btn-outline-primary">Répondre</a></td>'; // Lien Répondre (à implémenter)
                                            echo '</tr>';
                                        }
                                    }
                                ?>
                                <!-- Fin de la boucle -->
                            </tbody>
                        </table>
                    </div>
                    <!-- Optionnel: Lien vers une page de gestion des avis -->
                    <!-- <p class="text-end"><a href="<?php echo BASE_URL; ?>/vendor/reviews">Voir tous les avis &raquo;</a></p> -->
                </div>


                <!-- Ajoutez d'autres sections si nécessaire -->

            </div>
        </div>
    </div>

    <!-- Inclure Bootstrap JS (optionnel pour ce layout, mais utile pour d'autres composants) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <!-- Script pour le graphique (si vous utilisez une librairie comme Chart.js) -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
    <script>
    // Code JavaScript pour initialiser le graphique ici
    // Exemple très basique avec Chart.js (nécessite d'inclure la librairie ci-dessus)
    /*
    const ctx = document.getElementById('salesChartPlaceholder').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line', // ou 'bar'
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin'], // Remplacez par vos labels de date
            datasets: [{
                label: 'Ventes Mensuelles',
                data: [1200, 1900, 3000, 5000, 2300, 3500], // Remplacez par vos données de ventes
                borderColor: '#4CAF50',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Important si vous définissez une hauteur sur le conteneur
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        });
    */
    </script>
</body>

</html>