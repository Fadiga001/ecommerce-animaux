<?php

    $router = new Router();


    // Routes publiques (accessibles sans connexion)
    $router->add('/', 'AuthController', 'register'); // Page d'accueil par défaut (inscription)
    $router->add('/register', 'AuthController', 'register');
    $router->add('/login', 'AuthController', 'login');

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

?>