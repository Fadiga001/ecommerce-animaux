<?php

    $router = new Router();


    // Routes publiques (accessibles sans connexion)
    $router->add('/', 'AuthController', 'register'); // Page d'accueil par défaut (inscription)
    $router->add('/register', 'AuthController', 'register');
    $router->add('/login', 'AuthController', 'login');
    $router->add('/register-admin', 'AuthController', 'registerAdmin');

    
    // Route de déconnexion (accessible si connecté)
    $router->add('/logout', 'AuthController', 'logout');

    // Route pour le tableau de bord vendeur (nécessite d'être connecté et d'avoir le rôle vendeur)
    $router->add('/vendor/dashboard', 'VendorDashController', 'vendorDashboard');
    $router->add('/vendor/products', 'VendorProductController', 'index'); // Liste des produits
    $router->add('/vendor/products/create', 'VendorProductController', 'create'); // Formulaire d'ajout
    $router->add('/vendor/products/store', 'VendorProductController', 'store'); // Traitement de l'ajout (POST)
    $router->add('/vendor/products/edit', 'VendorProductController', 'edit'); // Formulaire de modification (nécessite un ID)
    $router->add('/vendor/products/update', 'VendorProductController', 'update'); // Traitement de la modification (POST, nécessite un ID)
    $router->add('/vendor/products/delete', 'VendorProductController', 'delete'); // Traitement de la suppression (POST, nécessite un ID)

    //Gestion des catégories
    $router->add('/vendor/categories/indexCategorie', 'VendorCategoryController', 'index'); // Liste des catégories
    $router->add('/vendor/categories/create', 'VendorCategoryController', 'create'); // Formulaire d'ajout
    $router->add('/vendor/categories/store', 'VendorCategoryController', 'store'); // Traitement de l'ajout (POST)
    

    // Route pour le tableau de bord admin (nécessite d'être connecté et d'avoir le rôle admin)
    $router->add('/admin/dashboard-admin', 'AdminDashController', 'adminDashboard');

    //Gestion des utilisateurs
    $router->add('/admin/users/user-management', 'AdminDashController', 'voirTousLesUtilisateurs');
    //Récupérer l'id de l'utilisateur
    $router->add('/admin/suspend-user?id=', 'AdminDashController', 'suspendreUtilisateur');
    $router->add('/admin/reactivate-user?id=', 'AdminDashController', 'reactiverUtilisateur');
    $router->add('/admin/edit-user?id=', 'AdminDashController', 'modifierUtilisateur');
    $router->add('/admin/delete-user?id=', 'AdminDashController', 'supprimerUtilisateur');

    //Approuver ou rejeter les inscriptions des vendeurs.
    $router->add('/admin/vendor/liste-vendor', 'AdminDashController', 'listeVendeursInscrits');

?>