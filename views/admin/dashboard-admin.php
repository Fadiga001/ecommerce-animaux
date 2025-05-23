<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Admin | E-commerce Animaux</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome pour les icônes (optionnel) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
    body {
        background-color: #f8f9fa;
    }

    .admin-dashboard {
        padding: 40px 0;
    }

    .dashboard-title {
        font-weight: bold;
        margin-bottom: 30px;
    }

    .card {
        border-radius: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: transform 0.1s;
    }

    .card:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.10);
    }

    .card .card-icon {
        font-size: 2.5rem;
        color: #0d6efd;
        margin-bottom: 10px;
    }

    @media (max-width: 767px) {
        .admin-dashboard {
            padding: 20px 0;
        }
    }
    </style>
</head>

<body>
    <div class="container admin-dashboard">
        <h1 class="dashboard-title text-center mb-5">Tableau de Bord Administrateur</h1>
        <div class="text-center mb-4">
            <h2>Bienvenue, <?php echo htmlspecialchars($user['nom']); ?> !</h2>
            <p>Vous êtes connecté en tant qu'administrateur.</p>
            <div class="text-end mb-3">
                <a href="<?php echo BASE_URL; ?>/login" class="btn btn-danger">Déconnexion</a>
            </div>
        </div>
        <div class="row g-4 justify-content-center">
            <!-- Gestion des utilisateurs -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 text-center">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <div class="card-icon mb-2"><i class="fas fa-users"></i></div>
                        <h5 class="card-title">Gestion des utilisateurs</h5>
                        <p class="card-text">Voir, suspendre ou supprimer les comptes clients et vendeurs.</p>
                        <!--appeler la route pour la gestion des utilisateurs-->                     
                        <a href="<?= htmlspecialchars(BASE_URL . '/admin/users/user-management') ?>" class="btn btn-primary mt-auto w-100" title="Accéder à la gestion des utilisateurs">
                            <i class="fas fa-users-cog me-2"></i>Gérer les utilisateurs
                        </a>  
                    </div>
                </div>
            </div>
            <!-- Validation des vendeurs -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 text-center">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <div class="card-icon mb-2"><i class="fas fa-user-check"></i></div>
                        <h5 class="card-title">Validation des vendeurs</h5>
                        <p class="card-text">Approuver ou rejeter les inscriptions des vendeurs.</p>
                        <!--appeler la route pour la validation des vendeurs-->
                        <a href="<?= htmlspecialchars(BASE_URL . '/admin/vendor/liste-vendor') ?>" class="btn btn-primary mt-auto w-100">
                            Valider les vendeurs
                        </a>
                    </div>
                </div>
            </div>
            <!-- Gestion des produits -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 text-center">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <div class="card-icon mb-2"><i class="fas fa-box-open"></i></div>
                        <h5 class="card-title">Gestion des produits</h5>
                        <p class="card-text">Voir, modifier ou supprimer tous les produits du site.</p>
                        <a href="product-management.php" class="btn btn-primary mt-auto w-100">Gérer les
                            produits</a>
                    </div>
                </div>
            </div>
            <!-- Gestion des commandes -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 text-center">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <div class="card-icon mb-2"><i class="fas fa-shopping-cart"></i></div>
                        <h5 class="card-title">Gestion des commandes</h5>
                        <p class="card-text">Superviser, modifier ou annuler les commandes clients.</p>
                        <a href="order-management.php" class="btn btn-primary mt-auto w-100">Gérer les commandes</a>
                    </div>
                </div>
            </div>
            <!-- Gestion des catégories -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 text-center">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <div class="card-icon mb-2"><i class="fas fa-tags"></i></div>
                        <h5 class="card-title">Gestion des catégories</h5>
                        <p class="card-text">Ajouter, modifier ou supprimer les catégories de produits.</p>
                        <a href="category-management.php" class="btn btn-primary mt-auto w-100">Gérer les
                            catégories</a>
                    </div>
                </div>
            </div>
            <!-- Statistiques et rapports -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 text-center">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <div class="card-icon mb-2"><i class="fas fa-chart-line"></i></div>
                        <h5 class="card-title">Statistiques &amp; Rapports</h5>
                        <p class="card-text">Consulter les statistiques de ventes et rapports d'activité.</p>
                        <a href="stats-reports.php" class="btn btn-primary mt-auto w-100">Voir les statistiques</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>