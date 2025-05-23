<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Catégorie | Tableau de Bord Vendeur</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .dashboard-wrapper {
            margin-top: 20px;
        }
        .sidebar {
            background-color: #343a40;
            color: white;
            padding: 20px;
            min-height: calc(100vh - 40px);
        }
        .sidebar a {
            color: #adb5bd;
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
    </style>
</head>

<body>
    <div class="container-fluid dashboard-wrapper">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <h2 class="text-light mb-4">Menu Vendeur</h2>
                <nav class="nav flex-column">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/vendor/dashboard">Tableau de Bord</a>
                    <a class="nav-link active" href="<?php echo BASE_URL; ?>/vendor/categories/indexCategorie">Gérer les Catégories</a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/vendor/products">Gérer les Produits</a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/vendor/orders">Commandes Reçues</a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/vendor/profile">Mon Profil</a>
                    <hr class="bg-secondary my-3">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/logout">Déconnexion</a>
                </nav>
            </div>
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 content-area">
                <h1>Ajouter une nouvelle catégorie</h1>

                <?php
                // Afficher les messages flash (erreur ou succès)
                if (isset($_SESSION['flash_error'])) {
                    echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['flash_error']) . '</div>';
                    unset($_SESSION['flash_error']);
                }
                if (isset($_SESSION['flash_success'])) {
                    echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['flash_success']) . '</div>';
                    unset($_SESSION['flash_success']);
                }
                ?>

                <form action="<?php echo BASE_URL; ?>/vendor/categories/create" method="POST" class="mt-4">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom de la catégorie <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nom" name="nom" required maxlength="100" placeholder="Ex : Accessoires pour chiens">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description (optionnelle)</label>
                        <textarea class="form-control" id="description" name="description" rows="3" maxlength="255" placeholder="Décrivez la catégorie..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Créer la catégorie</button>
                    <a href="<?php echo BASE_URL; ?>/vendor/categories/indexCategorie" class="btn btn-secondary ms-2">Annuler</a>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>
</html>
