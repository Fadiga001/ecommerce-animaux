<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Validation des vendeurs - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome pour les icônes (optionnel) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .vendor-table th, .vendor-table td {
            vertical-align: middle;
        }
        .page-title {
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .action-btns .btn {
            margin-right: 0.5rem;
        }
        .doc-table {
            background: #fff;
            border-radius: 0.5rem;
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }
        .doc-table th, .doc-table td {
            font-size: 0.95em;
            padding: 0.3rem 0.5rem;
        }
        .doc-badge {
            font-size: 0.85em;
        }
        .no-docs {
            color: #888;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="page-title text-center">Validation des vendeurs</h1>
        <div class="mb-4 text-end">
            <a href="<?= htmlspecialchars(BASE_URL . '/admin/dashboard-admin') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour au tableau de bord
            </a>
        </div>
        <?php if (isset($vendeur) && count($vendeur) > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover vendor-table align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Adresse</th>
                            <th>Téléphone</th>
                            <th>Statut</th>
                            <th>État</th>
                            <th>Documents</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($vendeur as $index => $v): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($v['nom']) ?></td>
                                <td><?= htmlspecialchars($v['email']) ?></td>
                                <td><?= htmlspecialchars($v['adresse']) ?></td>
                                <td><?= htmlspecialchars($v['telephone']) ?></td>
                                <td>
                                    <?php if ($v['statut'] === 'actif'): ?>
                                        <span class="badge bg-success">Actif</span>
                                    <?php elseif ($v['statut'] === 'suspendu'): ?>
                                        <span class="badge bg-danger">Suspendu</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><?= htmlspecialchars($v['statut']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($v['etat'] === 'en attente'): ?>
                                        <span class="badge bg-warning text-dark">En attente</span>
                                    <?php elseif ($v['etat'] === 'valide'): ?>
                                        <span class="badge bg-success">Approuvé</span>
                                    <?php elseif ($v['etat'] === 'rejete'): ?>
                                        <span class="badge bg-danger">Rejeté</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><?= htmlspecialchars($v['etat']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($v['documents'])): ?>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered doc-table mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Type</th>
                                                        <th>Fichier</th>
                                                        <th>Date</th>
                                                        <th>Statut</th>
                                                        <th>Télécharger</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($v['documents'] as $doc): ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($doc['type_document']) ?></td>
                                                            <td>
                                                                <?php
                                                                    $filename = basename($doc['chemin_fichier']);
                                                                ?>
                                                                <?= htmlspecialchars($filename) ?>
                                                            </td>
                                                            <td><?= date('d/m/Y H:i', strtotime($doc['date_upload'])) ?></td>
                                                            <td>
                                                                <?php
                                                                    if ($doc['statut'] === 'valide') {
                                                                        echo '<span class="badge bg-success doc-badge">Valide</span>';
                                                                    } elseif ($doc['statut'] === 'en attente') {
                                                                        echo '<span class="badge bg-warning text-dark doc-badge">En attente</span>';
                                                                    } elseif ($doc['statut'] === 'rejete') {
                                                                        echo '<span class="badge bg-danger doc-badge">Rejeté</span>';
                                                                    } else {
                                                                        echo '<span class="badge bg-secondary doc-badge">'.htmlspecialchars($doc['statut']).'</span>';
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php if (!empty($doc['chemin_fichier'])): ?>
                                                                    <a href="<?= htmlspecialchars($doc['chemin_fichier']) ?>" class="btn btn-outline-primary btn-sm" target="_blank" title="Télécharger ou voir le document">
                                                                        <i class="fas fa-download"></i>
                                                                    </a>
                                                                <?php else: ?>
                                                                    <span class="text-muted">-</span>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <span class="no-docs">Aucun document</span>
                                    <?php endif; ?>
                                </td>
                                <td class="action-btns">
                                    <!-- Actions d'approbation/rejet -->
                                    <form method="post" action="<?= htmlspecialchars(BASE_URL . '/admin/seller-validation') ?>" class="d-inline">
                                        <input type="hidden" name="vendeur_id" value="<?= $v['id'] ?>">
                                        <button type="submit" name="action" value="approuver" class="btn btn-success btn-sm" title="Approuver" <?= ($v['etat'] === 'valide') ? 'disabled' : '' ?>>
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form method="post" action="<?= htmlspecialchars(BASE_URL . '/admin/seller-validation') ?>" class="d-inline">
                                        <input type="hidden" name="vendeur_id" value="<?= $v['id'] ?>">
                                        <button type="submit" name="action" value="rejeter" class="btn btn-danger btn-sm" title="Rejeter" <?= ($v['etat'] === 'rejete') ? 'disabled' : '' ?>>
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                Aucun vendeur en attente de validation pour le moment.
            </div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
