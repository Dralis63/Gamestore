<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Games</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <div class="filters-bar">
        <select id="prix">
            <option value="">Par prix :</option>
            <option value="croissant">Croissant</option>
            <option value="decroissant">Décroissant</option>
        </select>
        <select id="genre">
            <option value="">Par genre :</option>
            <option value="action">Action</option>
            <option value="aventure">Aventure</option>
            <option value="rpg">RPG</option>
            <option value="strategy">Stratégie</option>
            <option value="fps">FPS</option>
            <option value="simulation">Simulation</option>
            <option value="sport">Sport</option>
            <option value="course">Course</option>
            <option value="combat">Combat</option>
            <option value="puzzle">Puzzle</option>
            <option value="sandbox">Sandbox</option>
            <option value="survival">Survival</option>
            <option value="horror">Horror</option>
            <option value="mmo">MMO</option>
            <option value="moba">MOBA</option>
            <option value="musique">Musique</option>
            <option value="educatif">Éducatif</option>
        </select>
        <select id="plateforme">
            <option value="">Par plateforme :</option>
            <option value="PC">PC</option>
            <option value="PlayStation 4">PlayStation 4</option>
            <option value="PlayStation 5">PlayStation 5</option>
            <option value="Xbox One">Xbox One</option>
            <option value="Xbox Series X">Xbox Series X</option>
            <option value="Nintendo Switch">Nintendo Switch</option>
        </select>            
    </div>
    <main>
        <div class="affichage_jeux_all"></div>
    </main>
    <?php include 'templates/footer.php'; ?>
    <script src="js/allgames.js"></script>
</body>
</html>