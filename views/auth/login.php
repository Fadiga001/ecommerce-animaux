<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | E-commerce Animaux</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>

<body class="register-body">
    <!-- Réutilisation de la classe de style pour le corps -->
    <div class="register-container">
        <!-- Réutilisation de la classe de style pour le conteneur -->
        <h1>Connexion</h1>
        <?php if (!empty($error)): ?>
        <div class="message error">
            <?php echo $error; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
        <div class="message success">
            <?php echo $success; ?>
        </div>
        <?php endif; ?>
        <form action="<?php echo BASE_URL; ?>/login" method="POST">
            <div class="form-group-full">
                <!-- Utilisation de form-group-full pour les champs uniques -->
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="E-mail" required>
            </div>
            <div class="form-group-full">
                <!-- Utilisation de form-group-full pour les champs uniques -->
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Mot de passe" required>
            </div>
            <div class="form-group-full">
                <button type="submit">Se connecter</button>
            </div>
        </form>
        <div class="register-link">
            <!-- Réutilisation de la classe de style pour le lien -->
            Pas encore inscrit ? <a href="<?php echo BASE_URL; ?>/register">Inscription</a>
        </div>
    </div>
</body>

</html>