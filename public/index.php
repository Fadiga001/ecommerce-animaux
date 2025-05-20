<?php

    session_start();
    // Déterminer le chemin de base de l'application
    $basePath = dirname($_SERVER['SCRIPT_NAME']);
    // Assurer que le chemin de base est vide si l'application est à la racine,
    // sinon, il contient le sous-répertoire (sans slash final)
    $basePath = ($basePath === '/' || $basePath === '\\') ? '' : $basePath;
    define('BASE_URL', $basePath);

    require_once '../core/Router.php';
    require_once '../routes/web.php';
    $router->dispatch();