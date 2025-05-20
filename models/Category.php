<?php

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

    
}