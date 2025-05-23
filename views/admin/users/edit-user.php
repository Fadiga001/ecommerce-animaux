<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un utilisateur</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Modifier un utilisateur</h1>

        <?php
            // Affichage des messages flash
            if (isset($_SESSION['flash_error'])) {
                echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['flash_error']) . '</div>';
                unset($_SESSION['flash_error']);
            }
            if (isset($_SESSION['flash_success'])) {
                echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['flash_success']) . '</div>';
                unset($_SESSION['flash_success']);
            }

            // Récupérer l'utilisateur à modifier
            if (!isset($userToEdit)) {
                // On suppose que $id est passé via GET
                $userModel = new User();
                $userToEdit = $userModel->getById($_GET['id'] ?? null);
            }
        ?>

        <?php if ($userToEdit): ?>
            <form action="<?= BASE_URL ?>/admin/users/edit-user?id=<?= urlencode($userToEdit['id']) ?>" method="post">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($userToEdit['nom'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($userToEdit['email'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="adresse" class="form-label">Adresse</label>
                    <input type="text" class="form-control" id="adresse" name="adresse" value="<?= htmlspecialchars($userToEdit['adresse'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="telephone" class="form-label">Téléphone</label>
                    <input type="text" class="form-control" id="telephone" name="telephone" value="<?= htmlspecialchars($userToEdit['telephone'] ?? '') ?>">
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                <a href="<?= BASE_URL ?>/admin/users/user-management" class="btn btn-secondary ms-2">Annuler</a>
            </form>
        <?php else: ?>
            <div class="alert alert-warning">Utilisateur introuvable.</div>
            <a href="<?= BASE_URL ?>/admin/users/user-management" class="btn btn-secondary">Retour</a>
        <?php endif; ?>
    </div>
</body>
</html>

