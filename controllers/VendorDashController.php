<?php 

    require_once __DIR__ . '/../models/User.php';
    
    class VendorDashController {
        public function vendorDashboard() {
            // Vérifier si l'utilisateur est connecté
            if (!isset($_SESSION['user'])) {
                // Rediriger vers la page de connexion si non connecté
                $_SESSION['flash_error'] = "Veuillez vous connecter pour accéder à cette page.";
                header('Location: ' . BASE_URL . '/login');
                exit;
            }

            // Vérifier si l'utilisateur a le rôle 'vendeur'
            if ($_SESSION['user']['role'] !== 'vendeur') {
                // Rediriger vers une page d'erreur ou d'accueil si le rôle n'est pas vendeur
                // Pour l'instant, redirigeons vers l'accueil avec un message
                 $_SESSION['flash_error'] = "Vous n'avez pas les autorisations nécessaires pour accéder à cette page.";
                 header('Location: ' . BASE_URL . '/login'); // Rediriger vers la page d'accueil client
                 exit;
            }

            // Si l'utilisateur est connecté et est un vendeur, inclure la vue du tableau de bord
            // Vous pourriez charger des données ici (statistiques, commandes, etc.) pour les passer à la vue
            $user = $_SESSION['user']; // Récupérer les informations de l'utilisateur connecté

            require __DIR__ . '/../views/vendor/dashboard.php';
        }
    }
?>