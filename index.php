<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <main>
        <section class="infosEntreprise">
            <h2>Bienvenu chez Gamestore !</h2>
            <p>Bienvenue chez Gamestore, votre destination incontournable pour tous vos besoins en matière de jeux vidéo ! Fondée sur une passion inébranlable pour le divertissement numérique, Gamestore est spécialisée dans la vente de jeux vidéo de qualité pour toutes les plateformes populaires. Avec cinq magasins situés stratégiquement à travers la France - à Nantes, Lille, Bordeaux, Paris et Toulouse - nous sommes fiers de servir les gamers de toutes les régions.</p>
            <a href="allgames.php" class="button">Explorer les jeux</a>
        </section>
        <section class="JeuxVideo">
            <h2>Derniers Jeux Vidéos</h2>
            <div class="affichage_jeux"></div>
        </section>
        <section class="JeuxVideo">
            <h2>Dernieres Promotions</h2>
            <div class="affichage_jeux_promo"></div>
        </section>
    </main>
    <?php include 'templates/footer.php'; ?>
    <script src="js/index.js"></script>
</body>
</html>