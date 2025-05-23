<?php

require_once __DIR__ . '/../core/Database.php';

class Category {
    private $db; // Instance de votre connexion à la base de données

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Récupère toutes les catégories
    public function getAllCategories() {
        try {
            $stmt = $this->db->prepare("SELECT * FROM categories");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des catégories : " . $e->getMessage());
        }
    }

    // Crée une nouvelle catégorie
    public function createCategory($name, $description = null) {
        try {
            $stmt = $this->db->prepare("INSERT INTO categories (nom, description) VALUES (?, ?)");
            $stmt->execute([$name, $description]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Erreur lors de la création de la catégorie : " . $e->getMessage());
            return false;
        }
    }

    // Récupère une catégorie par son ID
    public function getCategoryById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de la catégorie par ID : " . $e->getMessage());
            return false;
        }
    }
    
    // Met à jour une catégorie par son ID
    public function updateCategory($id, $name, $description = null) {
        try {
            $stmt = $this->db->prepare("UPDATE categories SET nom = ?, description = ? WHERE id = ?");
            $stmt->execute([$name, $description, $id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour de la catégorie : " . $e->getMessage());
            return false;
        }
    }

    // Supprime une catégorie par son ID
    public function deleteCategory($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression de la catégorie : " . $e->getMessage());
            return false;
        }
    }
}