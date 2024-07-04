<?php
    session_start();
    if(isset($_SESSION['user'])){
        header('Location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <main>
        <section class="connexion" id="connexion">
            <h2>Connexion</h2>
            <div class="form">
                <input type="email" id="email" name="email" placeholder="Email" required/>
                <input type="password" id="password" name="password" placeholder="Mot de passe" required/>
                <button type="button" class="btn-connect">Se connecter</button>
            </div>
            <p>Mot de passe oublié ?</p>
        </section>

        <div class="centered">
            <p>Pas encore inscrit ?</p>
            <p><i class="fas fa-chevron-down"></i></p>
        </div>

        <section class="create-account">
            <h2>Création de compte</h2>
            <div class="form">
                <input type="text" id="nom" name="nom" placeholder="Nom" required/>
                <input type="text" id="prenom" name="prenom" placeholder="Prénom" required/>
                <input type="tel" id="telephone" name="telephone" placeholder="Téléphone" required/>
            </div>
            <div class="form">
                <input type="text" id="adresse" name="adresse" placeholder="Adresse" required/>
                <input type="text" id="code_postal" name="code_postal" placeholder="Code Postal" required/>
                <input type="text" id="ville" name="ville" placeholder="Ville" required/>
            </div>
            <div class="form">
                <input type="email" id="email_inscription" name="email_inscription" placeholder="Email" required/>
                <input type="password" id="password_inscription" name="password_inscription" placeholder="Mot de passe" required/>
            </div>
            <button type="button" class="btn-inscrire">S'inscrire</button>
        </section>
    </main>
    <?php include 'templates/footer.php'; ?>
    <script src="js/register.js"></script>
</body>
</html>