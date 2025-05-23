<?php

require_once __DIR__ . '/../models/User.php';

class AdminDashController {
   
    public function adminDashboard() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            $_SESSION['flash_error'] = "Veuillez vous connecter pour accéder à cette page.";
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Vérifier si l'utilisateur a le rôle 'admin'
        if ($_SESSION['user']['role'] !== 'admin') {
            $_SESSION['flash_error'] = "Vous n'avez pas les autorisations nécessaires pour accéder à cette page.";
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Récupérer les informations de l'utilisateur connecté
        $user = $_SESSION['user'];

        require_once '../views/admin/dashboard-admin.php';
    }

    //voir tous les utilisateurs
    public function voirTousLesUtilisateurs() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            $_SESSION['flash_error'] = "Veuillez vous connecter pour accéder à cette page.";
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Vérifier si l'utilisateur a le rôle 'admin'
        if ($_SESSION['user']['role'] !== 'admin') {
            $_SESSION['flash_error'] = "Vous n'avez pas les autorisations nécessaires pour accéder à cette page.";
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $userModel = new User();
        $users = $userModel->userVendorAndClient();

        require_once '../views/admin/users/user-management.php';
    }
    
    //suspendre un utilisateur
    public function suspendreUtilisateur($id) {
        $userModel = new User();
        $userModel->suspendUser($id);
        header('Location: ' . BASE_URL . '/admin/users/user-management');
        exit;
    }

    //réactiver un utilisateur
    public function reactiverUtilisateur($id) {
        $userModel = new User();
        $userModel->reactivateUser($id);
        header('Location: ' . BASE_URL . '/admin/users/user-management');
        exit;
    }

    //modifier un utilisateur
    public function modifierUtilisateur($id) {

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            $_SESSION['flash_error'] = "Veuillez vous connecter pour accéder à cette page.";
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Vérifier si l'utilisateur a le rôle 'admin'
        if ($_SESSION['user']['role'] !== 'admin') {
            $_SESSION['flash_error'] = "Vous n'avez pas les autorisations nécessaires pour accéder à cette page.";
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Récupérer les informations de l'utilisateur connecté
        $user = $_SESSION['user'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $user = $userModel->updateProfile($id, $_POST['nom'], $_POST['email'], $_POST['adresse'], $_POST['telephone']);

            if($user) {
                $_SESSION['flash_success'] = "Utilisateur modifié avec succès.";
                header('Location: ' . BASE_URL . '/admin/users/user-management');
            } else {
                $_SESSION['flash_error'] = "Une erreur est survenue lors de la modification de l'utilisateur.";
                header('Location: ' . BASE_URL . '/admin/users/edit-user?id=' . $id);
            }
            exit;
        }

        require_once '../views/admin/users/edit-user.php';
    }

    //supprimer un utilisateur
    public function supprimerUtilisateur($id) {
        $userModel = new User();
        $userModel->deleteUser($id);
        header('Location: ' . BASE_URL . '/admin/users/user-management');
        exit;
    }
    
    //Approuver ou rejeter les inscriptions des vendeurs.

    //Afficher les inscriptions des vendeurs 
    public function listeVendeursInscrits() {

        //Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            $_SESSION['flash_error'] = "Veuillez vous connecter pour accéder à cette page.";
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        //Vérifier si l'utilisateur a le rôle 'admin'
        if ($_SESSION['user']['role'] !== 'admin') {
            $_SESSION['flash_error'] = "Vous n'avez pas les autorisations nécessaires pour accéder à cette page.";
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        //Récupérer les informations de l'utilisateur connecté
        $user = $_SESSION['user'];

        //Récupérer les inscriptions des vendeurs
        $userModel = new User();
        $vendeur = $userModel->getVendeursAvecDocuments();
        

        require_once '../views/admin/vendor/liste-vendor.php';
    }
    
}