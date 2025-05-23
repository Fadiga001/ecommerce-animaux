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

        //Récupérer tous les utilisateurs vendeurs et clients 
        public function userVendorAndClient(){
            $stmt = $this->db->prepare("SELECT id, nom, email, role, adresse, telephone, statut FROM utilisateurs WHERE role IN ('client', 'vendeur')");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Récupérer tous les utilisateurs
        public function getAll() {
            $stmt = $this->db->prepare("SELECT id, nom, email, role, adresse, telephone, statut FROM utilisateurs");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Suspendre un utilisateur
        public function suspendUser($id) {
            $stmt = $this->db->prepare("UPDATE utilisateurs SET statut = 'suspendu' WHERE id = ?");
            return $stmt->execute([$id]);
        }

        // Réactiver un utilisateur
        public function reactivateUser($id) {
            $stmt = $this->db->prepare("UPDATE utilisateurs SET statut = 'actif' WHERE id = ?");
            return $stmt->execute([$id]);
        }

        //Gérer les utilisateurs
        public function manageUsers($id, $action) {
            if ($action == 'suspendre') {
                return $this->suspendUser($id);
            } elseif ($action == 'reactiver') {
                return $this->reactivateUser($id);
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

        // Supprimer un utilisateur
        public function deleteUser($id) {
            $stmt = $this->db->prepare("DELETE FROM utilisateurs WHERE id = ?");
            return $stmt->execute([$id]);
        }

    /**
     * Récupère la liste des vendeurs inscrits avec leurs documents associés.
     * Retourne un tableau où chaque vendeur contient un sous-tableau 'documents' listant ses documents.
     */
    public function getVendeursAvecDocuments() {
        $sql = "SELECT 
                    u.id AS id,
                    u.nom,
                    u.email,
                    u.telephone,
                    u.adresse,
                    u.statut,
                    u.etat,
                    d.id AS document_id,
                    d.user_id,
                    d.type_document,
                    d.chemin_fichier,
                    d.date_upload,
                    d.statut AS document_statut
                FROM utilisateurs u
                LEFT JOIN documents d ON u.id = d.user_id
                WHERE u.role = 'vendeur'
                ORDER BY u.id, d.date_upload DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $vendeurs = [];
        foreach ($rows as $row) {
            $id = $row['id'];
            if (!isset($vendeurs[$id])) {
                $vendeurs[$id] = [
                    'id'        => $row['id'],
                    'nom'       => $row['nom'],
                    'email'     => $row['email'],
                    'telephone' => $row['telephone'],
                    'adresse'   => $row['adresse'],
                    'statut'    => $row['statut'],
                    'etat'      => $row['etat'],
                    'documents' => []
                ];
            }
            // Si le vendeur a un document associé, on l'ajoute
            if (!empty($row['document_id'])) {
                $vendeurs[$id]['documents'][] = [
                    'id'             => $row['document_id'],
                    'type_document'  => $row['type_document'],
                    'chemin_fichier' => $row['chemin_fichier'],
                    'date_upload'    => $row['date_upload'],
                    'statut'         => $row['document_statut']
                ];
            }
        }
        // Réindexer le tableau pour avoir une liste simple
        return array_values($vendeurs);
    }

    /**
     * Met à jour l'état d'un vendeur (approuver ou rejeter l'inscription).
     * @param int $vendeur_id
     * @param string $action 'approuver' ou 'rejeter'
     * @return bool
     */
    public function validerOuRejeterVendeur($vendeur_id, $action) {
        if ($action === 'approuver') {
            $etat = 'valide';
        } elseif ($action === 'rejeter') {
            $etat = 'rejete';
        } else {
            return false;
        }
        $stmt = $this->db->prepare("UPDATE utilisateurs SET etat = ? WHERE id = ? AND role = 'vendeur'");
        return $stmt->execute([$etat, $vendeur_id]);
    }

    /**
     * Récupère les documents d'un vendeur spécifique.
     * @param int $vendeur_id
     * @return array
     */
    public function getDocumentsByVendeur($vendeur_id) {
        $stmt = $this->db->prepare("SELECT id, type_document, chemin_fichier, date_upload, statut FROM documents WHERE vendeur_id = ?");
        $stmt->execute([$vendeur_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
        

        

   

    
    }