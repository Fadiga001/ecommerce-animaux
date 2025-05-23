<?php

require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../core/AuthMiddleware.php';

class VendorCategoryController {

    private $categoryModel;

    public function __construct() {
        AuthMiddleware::requireRole('vendeur');
        $this->categoryModel = new Category();
    }

    public function index() {
        $categories = $this->categoryModel->getAllCategories();
        require_once __DIR__ . '/../views/vendor/categories/indexCategorie.php';
    }

    // Ajouter une nouvelle catégorie
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $description = $_POST['description'];
            $this->categoryModel->createCategory($nom, $description);
            header('Location: ' . BASE_URL . '/vendor/categories/indexCategorie');
            exit();
        }
        require_once __DIR__ . '/../views/vendor/categories/createCategorie.php';
    }
}