<?php

require_once __DIR__ . '/../models/Product.php'; // Assurez-vous d'avoir un modèle Product
require_once __DIR__ . '/../core/AuthMiddleware.php'; // Nous aurons besoin d'un middleware pour protéger ces routes

class VendorProductController {

    private $productModel;

    public function __construct() {
        // Appliquer le middleware d'authentification et de rôle vendeur
        AuthMiddleware::requireRole('vendeur');
        $this->productModel = new Product(); // Instancier le modèle Product
    }

    // Affiche la liste des produits du vendeur connecté
    public function index() {
        // Récupérer l'ID du vendeur connecté depuis la session
        $vendorId = $_SESSION['user']['id'] ?? null;

        if (!$vendorId) {
            // Gérer l'erreur si l'ID du vendeur n'est pas en session (ne devrait pas arriver avec le middleware)
            $_SESSION['flash_error'] = "Impossible de récupérer les produits du vendeur.";
            header('Location: ' . BASE_URL . '/vendor/dashboard');
            exit;
        }

        // Récupérer les produits de ce vendeur depuis le modèle
        $products = $this->productModel->getProductsByVendorId($vendorId); // Cette méthode doit exister dans votre modèle Product

        // Inclure la vue pour afficher la liste
        require __DIR__ . '/../views/vendor/products.php';
    }

    // Affiche le formulaire pour ajouter un nouveau produit
    public function create() {
        // Vous pourriez avoir besoin de charger des catégories, marques, etc. ici
        $categories = []; // Exemple : $this->productModel->getAllCategories();

        // Inclure la vue du formulaire (qui servira aussi pour l'édition)
        $isEditing = false; // Indiquer à la vue qu'on est en mode ajout
        $product = null; // Pas de données produit pour l'ajout
        require __DIR__ . '/../views/vendor/product_form.php'; // Créez ce fichier de vue
    }

    // Traite la soumission du formulaire d'ajout de produit
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/vendor/products/create');
            exit;
        }

        // Récupérer et nettoyer les données du formulaire
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = floatval($_POST['price'] ?? 0); // Convertir en nombre flottant
        $stock = intval($_POST['stock'] ?? 0); // Convertir en entier
        $categoryId = intval($_POST['category_id'] ?? 0); // Exemple
        // Gérer l'upload de l'image ($_FILES)
        $imagePath = null; // Chemin de l'image après upload

        $vendorId = $_SESSION['user']['id'] ?? null;

        // Validation basique
        if (empty($name) || $price <= 0 || $stock < 0 || !$vendorId) {
             $_SESSION['flash_error'] = "Veuillez remplir tous les champs obligatoires et vérifier les valeurs.";
             // Rediriger vers le formulaire avec les données saisies si possible
             // header('Location: ' . BASE_URL . '/vendor/products/create'); exit;
        } else {
            // Appeler le modèle pour ajouter le produit
            $result = $this->productModel->createProduct($vendorId, $name, $description, $price, $stock, $categoryId, $imagePath); // Cette méthode doit exister

            if ($result) {
                $_SESSION['flash_success'] = "Produit ajouté avec succès !";
                header('Location: ' . BASE_URL . '/vendor/products'); // Rediriger vers la liste
                exit;
            } else {
                $_SESSION['flash_error'] = "Erreur lors de l'ajout du produit.";
                 // Rediriger vers le formulaire avec les données saisies si possible
                 // header('Location: ' . BASE_URL . '/vendor/products/create'); exit;
            }
        }

         // Si validation ou ajout échoue, réafficher le formulaire avec les erreurs
         // Vous devrez passer les données POST et les erreurs à la vue
         $error = $_SESSION['flash_error'] ?? ''; unset($_SESSION['flash_error']);
         $success = $_SESSION['flash_success'] ?? ''; unset($_SESSION['flash_success']);
         $isEditing = false;
         $product = $_POST; // Repopuler le formulaire avec les données saisies
         require __DIR__ . '/../views/vendor/product_form.php';
    }

    // Affiche le formulaire pour modifier un produit existant
    // Nécessite l'ID du produit (ex: /vendor/products/edit?id=123)
    public function edit() {
        $productId = intval($_GET['id'] ?? 0); // Récupérer l'ID depuis l'URL (paramètre GET)
        $vendorId = $_SESSION['user']['id'] ?? null;

        if (!$productId || !$vendorId) {
             $_SESSION['flash_error'] = "Produit introuvable.";
             header('Location: ' . BASE_URL . '/vendor/products');
             exit;
        }

        // Récupérer le produit depuis le modèle, en s'assurant qu'il appartient bien au vendeur connecté
        $product = $this->productModel->getProductByIdAndVendorId($productId, $vendorId); // Cette méthode doit exister

        if (!$product) {
            $_SESSION['flash_error'] = "Produit introuvable ou vous n'avez pas les droits.";
            header('Location: ' . BASE_URL . '/vendor/products');
            exit;
        }

        // Vous pourriez avoir besoin de charger des catégories, marques, etc. ici
        $categories = []; // Exemple : $this->productModel->getAllCategories();

        // Inclure la vue du formulaire
        $isEditing = true; // Indiquer à la vue qu'on est en mode édition
        require __DIR__ . '/../views/vendor/product_form.php'; // Créez ce fichier de vue
    }

    // Traite la soumission du formulaire de modification de produit
    public function update() {
         if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/vendor/products'); // Rediriger si pas une requête POST
            exit;
        }

        // Récupérer les données du formulaire, y compris l'ID du produit (souvent dans un champ caché)
        $productId = intval($_POST['product_id'] ?? 0); // Assurez-vous que l'ID est passé dans le formulaire
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = floatval($_POST['price'] ?? 0);
        $stock = intval($_POST['stock'] ?? 0);
        $categoryId = intval($_POST['category_id'] ?? 0); // Exemple
        // Gérer l'upload de la nouvelle image si elle est présente
        $imagePath = null; // Nouveau chemin de l'image après upload (ou null si pas de nouvelle image)

        $vendorId = $_SESSION['user']['id'] ?? null;

         // Validation basique
        if (!$productId || empty($name) || $price <= 0 || $stock < 0 || !$vendorId) {
             $_SESSION['flash_error'] = "Données invalides pour la mise à jour.";
             header('Location: ' . BASE_URL . '/vendor/products'); // Rediriger vers la liste ou le formulaire d'édition
             exit;
        }

        // Appeler le modèle pour mettre à jour le produit
        // La méthode updateProduct doit vérifier que le produit appartient bien au vendeur
        $result = $this->productModel->updateProduct($productId, $vendorId, $name, $description, $price, $stock, $categoryId, $imagePath); // Cette méthode doit exister

        if ($result) {
            $_SESSION['flash_success'] = "Produit mis à jour avec succès !";
            header('Location: ' . BASE_URL . '/vendor/products'); // Rediriger vers la liste
            exit;
        } else {
            $_SESSION['flash_error'] = "Erreur lors de la mise à jour du produit ou produit introuvable.";
             header('Location: ' . BASE_URL . '/vendor/products'); // Rediriger vers la liste ou le formulaire d'édition
             exit;
        }
    }

    // Traite la suppression d'un produit
    // Nécessite l'ID du produit (souvent via POST ou un paramètre d'URL)
    public function delete() {
        // Idéalement, utiliser une requête POST pour la suppression
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
             $_SESSION['flash_error'] = "Méthode non autorisée pour la suppression.";
             header('Location: ' . BASE_URL . '/vendor/products');
             exit;
        }

        $productId = intval($_POST['product_id'] ?? 0); // Récupérer l'ID depuis le formulaire POST
        $vendorId = $_SESSION['user']['id'] ?? null;

         if (!$productId || !$vendorId) {
             $_SESSION['flash_error'] = "Produit introuvable.";
             header('Location: ' . BASE_URL . '/vendor/products');
             exit;
        }

        // Appeler le modèle pour supprimer le produit, en s'assurant qu'il appartient bien au vendeur
        $result = $this->productModel->deleteProduct($productId, $vendorId); // Cette méthode doit exister

        if ($result) {
            $_SESSION['flash_success'] = "Produit supprimé avec succès !";
        } else {
            $_SESSION['flash_error'] = "Erreur lors de la suppression du produit ou produit introuvable.";
        }

        header('Location: ' . BASE_URL . '/vendor/products'); // Rediriger vers la liste
        exit;
    }

    // Note : Vous aurez besoin d'un modèle Product.php avec les méthodes :
    // - getProductsByVendorId($vendorId)
    // - createProduct($vendorId, $name, $description, $price, $stock, $categoryId, $imagePath)
    // - getProductByIdAndVendorId($productId, $vendorId)
    // - updateProduct($productId, $vendorId, $name, $description, $price, $stock, $categoryId, $imagePath)
    // - deleteProduct($productId, $vendorId)

    // Note 2 : Vous aurez besoin d'un AuthMiddleware pour protéger ces routes.
    // Ce middleware vérifierait si $_SESSION['user'] existe et si $_SESSION['user']['role'] est 'vendeur'.
    // J'ai ajouté un appel basique dans le constructeur, mais une implémentation complète de middleware est recommandée.
}