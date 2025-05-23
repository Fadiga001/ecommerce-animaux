<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Utilisateurs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Gestion des Utilisateurs</h1>

    <?php if (isset($error) && !empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if (isset($success) && !empty($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div class="mb-3">
        <div class="d-flex justify-content-between">
            <a href="<?= BASE_URL ?>/register" class="btn btn-primary">Ajouter un utilisateur</a>
            <div class="text-end">
                <a href="<?= BASE_URL ?>/admin/dashboard-admin" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Adresse</th>
                    <th>Téléphone</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if (isset($users) && is_array($users) && count($users) > 0): ?>
                <?php foreach ($users as $index => $user): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($user['nom'] ?? '') ?></td>
                        <td><?= htmlspecialchars($user['email'] ?? '') ?></td>
                        <td>
                            <span class="badge bg-<?= ($user['role'] === 'admin') ? 'danger' : (($user['role'] === 'vendeur') ? 'warning' : 'secondary') ?>">
                                <?= htmlspecialchars(ucfirst($user['role'] ?? '')) ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($user['adresse'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($user['telephone'] ?? '-') ?></td>
                        <td>
                            <span class="badge bg-<?= ($user['statut'] === 'actif') ? 'success' : 'danger' ?>">
                                <?= htmlspecialchars(ucfirst($user['statut'] ?? '')) ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>/admin/edit-user?id=<?= urlencode($user['id']) ?>" class="btn btn-sm btn-info">Modifier</a>
                            <a href="<?= BASE_URL ?>/admin/delete-user?id=<?= urlencode($user['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
                            <?php if ($user['statut'] === 'actif'): ?>
                                <a href="<?= BASE_URL ?>/admin/suspend-user?id=<?= urlencode($user['id']) ?>" class="btn btn-sm btn-warning" onclick="return confirm('Êtes-vous sûr de vouloir suspendre cet utilisateur ?');">Suspendre</a>
                            <?php else: ?>
                                <a href="<?= BASE_URL ?>/admin/reactivate-user?id=<?= urlencode($user['id']) ?>" class="btn btn-sm btn-success" onclick="return confirm('Êtes-vous sûr de vouloir réactiver cet utilisateur ?');">Réactiver</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">Aucun utilisateur trouvé.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
