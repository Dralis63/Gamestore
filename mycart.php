<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon panier</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <main>
        <div class="container-mycart">
            <h2>Mon Panier</h2>
            <div class="cart-items">
                <!-- Les articles seront ajoutés ici dynamiquement par JavaScript -->
            </div>
            <select id="agence">
            <option value="">Agence de Retrait</option>
            <option value="bordeaux">Bordeaux</option>
            <option value="lille">Lille</option>
            <option value="nante">Nante</option>
            <option value="paris">Paris</option>
            <option value="toulouse">Toulouse</option>
        </select>
        <select id="date">
            <option value="">Date de Retrait</option>
        </select>
        <span class="total-price"></span>
        <button type="button" class="btn-order">Valider la Commande</button>
        </div>
    </main>
    <?php include 'templates/footer.php'; ?>
    <script src="js/mycart.js"></script>
</body>
</html>