<?php

class AuthMiddleware {
    // Vérifie si l'utilisateur est connecté
    public static function requireAuth() {
        // session_start(); // <-- Supprimez cette ligne si session_start() est déjà appelé ailleurs
        if (!isset($_SESSION['user'])) {
            $_SESSION['flash_error'] = "Veuillez vous connecter pour accéder à cette page.";
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    // Vérifie si l'utilisateur a un rôle spécifique
    public static function requireRole($role) {
        // session_start(); // <-- Supprimez cette ligne si session_start() est déjà appelé ailleurs
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== $role) {
            $_SESSION['flash_error'] = "Vous n'avez pas les autorisations nécessaires pour accéder à cette page.";
            header('Location: ' . BASE_URL . '/login'); // Ou une autre page d'erreur/d'accueil
            exit;
        }
    }
}