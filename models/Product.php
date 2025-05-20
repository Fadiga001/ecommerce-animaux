<?php

class Product {
    private $db; // Instance de votre connexion à la base de données

    public function __construct() {
        // Initialiser la connexion à la base de données en utilisant votre classe Database
        $database = new Database();
        $this->db = $database->connect();
    }

    // Récupère tous les produits d'un vendeur spécifique
    public function getProductsByVendorId($vendorId) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM produits WHERE vendeur_id = ?");
            $stmt->execute([$vendorId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Gérer l'erreur (log, afficher un message, etc.)
            error_log("Erreur lors de la récupération des produits du vendeur : " . $e->getMessage());
            return false; // Ou lancer une exception, selon votre stratégie de gestion des erreurs
        }
    }

    // Crée un nouveau produit pour un vendeur
    public function createProduct($vendorId, $name, $description, $price, $stock, $categoryId, $imagePath = null) {
        try {
            $stmt = $this->db->prepare("INSERT INTO produits (vendeur_id, nom, description, prix, stock, categorie_id, image_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$vendorId, $name, $description, $price, $stock, $categoryId, $imagePath]);
            return true;
        } catch (PDOException $e) {
            error_log("Erreur lors de la création du produit : " . $e->getMessage());
            return false;
        }
    }

    // Récupère un produit spécifique par son ID et l'ID du vendeur (pour vérifier l'appartenance)
    public function getProductByIdAndVendorId($productId, $vendorId) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM produits WHERE id = ? AND vendeur_id = ?");
            $stmt->execute([$productId, $vendorId]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            return $product ? $product : false; // Retourne false si aucun produit n'est trouvé
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération du produit : " . $e->getMessage());
            return false;
        }
    }

    // Met à jour un produit existant (vérifie l'appartenance au vendeur)
    public function updateProduct($productId, $vendorId, $name, $description, $price, $stock, $categoryId, $imagePath = null) {
        try {
            // Utiliser une requête préparée pour éviter les injections SQL
            $sql = "UPDATE produits SET nom = ?, description = ?, prix = ?, stock = ?, categorie_id = ?";
            // Ajouter la mise à jour de l'image uniquement si un nouveau chemin est fourni
            if ($imagePath !== null) {
                $sql .= ", image_path = ?";
            }
            $sql .= " WHERE id = ? AND vendeur_id = ?";

            $stmt = $this->db->prepare($sql);

            $params = [$name, $description, $price, $stock, $categoryId];
            if ($imagePath !== null) {
                $params[] = $imagePath;
            }
            $params[] = $productId;
            $params[] = $vendorId;

            $stmt->execute($params);

            // Vérifier si une ligne a été affectée (si le produit existait et appartenait au vendeur)
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour du produit : " . $e->getMessage());
            return false;
        }
    }

    // Supprime un produit (vérifie l'appartenance au vendeur)
    public function deleteProduct($productId, $vendorId) {
        try {
            $stmt = $this->db->prepare("DELETE FROM produits WHERE id = ? AND vendeur_id = ?");
            $stmt->execute([$productId, $vendorId]);
            return $stmt->rowCount() > 0; // Retourne true si une ligne a été supprimée
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression du produit : " . $e->getMessage());
            return false;
        }
    }

    // Vous pouvez ajouter d'autres méthodes ici, comme :
    // - getAllCategories() : pour récupérer la liste des catégories de produits
    // - getProductImage($productId) : pour récupérer le chemin de l'image d'un produit
}