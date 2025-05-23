<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription | E-commerce Animaux</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>

<body class="register-body">
    <div class="register-container">
        <h1>Inscription</h1>
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
        <form action="<?php echo BASE_URL; ?>/register-admin" method="POST">
            <div class="form-group">
                <label for="nom">Nom et Prénom(s)</label>
                <input type="text" id="nom" name="nom" placeholder="Nom et Prénom" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="E-mail" required>
            </div>
            <div class="form-group">
                <label for="adresse">Adresse</label>
                <input type="text" id="adresse" name="adresse" placeholder="Adresse">
            </div>
            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="text" id="telephone" name="telephone" placeholder="Téléphone">
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Mot de passe" required>
            </div>
            
            <div class="form-group-full">
                <button type="submit">S'inscrire</button>
            </div>
        </form>
        <div class="register-link">
            Déjà inscrit ? <a href="<?php echo BASE_URL; ?>/login">Connexion</a>
        </div>
    </div>
</body>

</html>