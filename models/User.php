<?php

    require_once __DIR__ . '/../core/Database.php';

    class User {
        private $db;

        public function __construct() {
            $database = new Database();
            $this->db = $database->connect();
        }

        // Inscription d'un utilisateur avec gestion d'unicité et validation simple
        public function register($nom, $email, $mot_de_passe, $role, $adresse = null, $telephone = null) {
            // Validation basique
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return ['success' => false, 'message' => "Email invalide"];
            }
            if (strlen($mot_de_passe) < 6) {
                return ['success' => false, 'message' => "Le mot de passe doit contenir au moins 6 caractères"];
            }
            // Vérification unicité email
            $stmtCheck = $this->db->prepare("SELECT id FROM utilisateurs WHERE email = ?");
            $stmtCheck->execute([$email]);
            if ($stmtCheck->rowCount() > 0) {
                return ['success' => false, 'message' => "Cet email est déjà utilisé"];
            }
            // Insertion
            $hash = password_hash($mot_de_passe, PASSWORD_BCRYPT);
            $stmt = $this->db->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe, role, adresse, telephone) VALUES (?, ?, ?, ?, ?, ?)");
            $result = $stmt->execute([$nom, $email, $hash, $role, $adresse, $telephone]);
            if ($result) {
                return ['success' => true, 'message' => "Inscription réussie"];
            } else {
                return ['success' => false, 'message' => "Erreur lors de l'inscription"];
            }
        }

        // Connexion utilisateur
        public function login($email, $mot_de_passe) {
            $stmt = $this->db->prepare("SELECT * FROM utilisateurs WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
                // On retire le mot de passe du tableau retourné pour la sécurité
                unset($user['mot_de_passe']);
                return $user;
            }
            return false;
        }

        // Récupérer un utilisateur par ID
        public function getById($id) {
            $stmt = $this->db->prepare("SELECT id, nom, email, role, adresse, telephone, statut FROM utilisateurs WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // Mettre à jour le profil utilisateur
        public function updateProfile($id, $nom, $email, $adresse, $telephone) {
            $stmt = $this->db->prepare("UPDATE utilisateurs SET nom = ?, email = ?, adresse = ?, telephone = ? WHERE id = ?");
            return $stmt->execute([$nom, $email, $adresse, $telephone, $id]);
        }
    }