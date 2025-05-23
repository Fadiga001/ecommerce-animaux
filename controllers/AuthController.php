<?php
    
    require_once __DIR__ . '/../models/User.php';

    // Assurez-vous que session_start() est appelé une seule fois au début de votre application (par exemple, dans public/index.php)
    // session_start(); // <-- Cette ligne devrait être dans index.php ou un fichier d'initialisation global

    class AuthController {
        // Affiche le formulaire de connexion et traite la connexion
        public function login() {
            $error = ''; // Initialisation pour la vue

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $email = trim($_POST['email'] ?? ''); // Nettoyer l'entrée
                $mot_de_passe = $_POST['mot_de_passe'] ?? '';

                // Validation basique dans le contrôleur
                if (empty($email) || empty($mot_de_passe)) {
                     $_SESSION['flash_error'] = "Veuillez saisir votre E-mail et votre mot de passe.";
                     header('Location: ' . BASE_URL . '/login'); // Rediriger vers le formulaire avec l'erreur
                     exit;
                }

                $userModel = new User();
                $user = $userModel->login($email, $mot_de_passe);

                if ($user) {
                    // Connexion réussie
                    session_regenerate_id(true); // Régénérer l'ID de session pour la sécurité
                    $_SESSION['user'] = $user;
                    // Nettoyer les messages flash avant de rediriger vers le tableau de bord
                    unset($_SESSION['flash_error']);
                    unset($_SESSION['flash_success']);
                    // Rediriger en fonction du rôle
                    if ($user['role'] === 'vendeur') {
                         header('Location: ' . BASE_URL . '/vendor/dashboard'); // Rediriger vers le tableau de bord vendeur
                    } elseif ($user['role'] === 'admin') {
                         header('Location: ' . BASE_URL . '/admin/dashboard-admin'); // Rediriger vers le tableau de bord admin
                    } else {
                         header('Location: ' . BASE_URL . '/login'); // Rediriger vers la page d'accueil client par défaut
                    } // Rediriger vers la page d'accueil/tableau de bord
                    exit;
                } else {
                    // Identifiants incorrects
                    $_SESSION['flash_error'] = "Identifiants incorrects";
                    header('Location: ' . BASE_URL . '/login'); // Rediriger vers le formulaire avec l'erreur
                    exit;
                }
            }

            // Récupérer le message d'erreur flash s'il existe pour l'afficher dans la vue
            if (isset($_SESSION['flash_error'])) {
                $error = $_SESSION['flash_error'];
                unset($_SESSION['flash_error']); // Supprimer le message après l'avoir lu
            }

            // Inclure la vue de connexion
            require __DIR__ . '/../views/auth/login.php';
        }

        // Affiche le formulaire d'inscription et traite l'inscription
        public function register() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nom = trim($_POST['nom'] ?? ''); // Nettoyer l'entrée
                $email = trim($_POST['email'] ?? ''); // Nettoyer l'entrée
                $mot_de_passe = $_POST['mot_de_passe'] ?? '';
                // Vérifier si l'utilisateur est un admin
                $is_admin = isset($_POST['is_admin']) ? 1 : 0;
                $role = $is_admin ? 'admin' : $_POST['role'] ?? '';
                $adresse = trim($_POST['adresse'] ?? ''); // Nettoyer l'entrée
                $telephone = trim($_POST['telephone'] ?? ''); // Nettoyer l'entrée

                // Validation basique dans le contrôleur
                if (empty($nom) || empty($email) || empty($mot_de_passe) || empty($role)) {
                    $_SESSION['flash_error'] = "Tous les champs obligatoires (Nom, E-mail, Mot de passe, Rôle) doivent être remplis.";
                    header('Location: ' . BASE_URL . '/register'); // Rediriger vers le formulaire avec l'erreur
                    exit;
                }

                $userModel = new User();
                // Passer null pour les champs optionnels vides si le modèle l'attend
                $adresse = empty($adresse) ? null : $adresse;
                $telephone = empty($telephone) ? null : $telephone;

                $result = $userModel->register($nom, $email, $mot_de_passe, $role, $adresse, $telephone);

                if ($result['success']) {
                    $_SESSION['flash_success'] = $result['message'];
                    header('Location: ' . BASE_URL . '/login'); // Rediriger vers la page de connexion après l'inscription réussie
                    exit;
                } else {
                    $_SESSION['flash_error'] = $result['message'];
                    header('Location: ' . BASE_URL . '/register'); // Rediriger vers le formulaire avec l'erreur
                    exit;
                }
            }

            // Récupérer les messages flash s'ils existent pour les afficher dans la vue
            if (isset($_SESSION['flash_error'])) {
                $error = $_SESSION['flash_error'];
                unset($_SESSION['flash_error']); // Supprimer le message après l'avoir lu
            }
             if (isset($_SESSION['flash_success'])) {
                $success = $_SESSION['flash_success'];
                unset($_SESSION['flash_success']); // Supprimer le message après l'avoir lu
            }

            // Inclure la vue d'inscription
            require __DIR__ . '/../views/auth/register.php';
        }

        // Affiche le formulaire d'inscription pour les admins
        public function registerAdmin() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nom = trim($_POST['nom'] ?? ''); // Nettoyer l'entrée
                $email = trim($_POST['email'] ?? ''); // Nettoyer l'entrée
                $mot_de_passe = $_POST['mot_de_passe'] ?? '';;
                $role = 'admin';
                $adresse = trim($_POST['adresse'] ?? ''); // Nettoyer l'entrée
                $telephone = trim($_POST['telephone'] ?? ''); // Nettoyer l'entrée

                // Validation basique dans le contrôleur
                if (empty($nom) || empty($email) || empty($mot_de_passe)) {
                    $_SESSION['flash_error'] = "Tous les champs obligatoires (Nom, E-mail, Mot de passe, Rôle) doivent être remplis.";
                    header('Location: ' . BASE_URL . '/register-admin'); // Rediriger vers le formulaire avec l'erreur
                    exit;
                }

                $userModel = new User();
                // Passer null pour les champs optionnels vides si le modèle l'attend
                $adresse = empty($adresse) ? null : $adresse;
                $telephone = empty($telephone) ? null : $telephone;

                $result = $userModel->register($nom, $email, $mot_de_passe, $role, $adresse, $telephone);

                if ($result['success']) {
                    $_SESSION['flash_success'] = $result['message'];
                    header('Location: ' . BASE_URL . '/login'); // Rediriger vers la page de connexion après l'inscription réussie
                    exit;
                } else {
                    $_SESSION['flash_error'] = $result['message'];
                    header('Location: ' . BASE_URL . '/register-admin'); // Rediriger vers le formulaire avec l'erreur
                    exit;
                }
            }

            // Récupérer les messages flash s'ils existent pour les afficher dans la vue
            if (isset($_SESSION['flash_error'])) {
                $error = $_SESSION['flash_error'];
                unset($_SESSION['flash_error']); // Supprimer le message après l'avoir lu
            }
             if (isset($_SESSION['flash_success'])) {
                $success = $_SESSION['flash_success'];
                unset($_SESSION['flash_success']); // Supprimer le message après l'avoir lu
            }

            require __DIR__ . '/../views/auth/register-admin.php';
        }

        // Déconnexion
        public function logout() {
            // session_start() est supposé être appelé ailleurs

            // Détruire toutes les données de session
            session_destroy();

            // Supprimer le cookie de session.
            // Note : cela détruira la session, et non seulement les données de session !
            // Il est important de le faire pour une déconnexion complète.
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }

            // Rediriger vers la page de connexion
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

?>