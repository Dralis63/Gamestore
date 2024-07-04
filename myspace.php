<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Espace</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">

</head>
<body>
    <?php include 'templates/header.php'; ?>
    <?php
    if ($_SESSION['user']['status'] !== 'utilisateur') {
        header('Location: index.php');
        exit;
    }
?>
    <main>
        <div class="container-myspace">
            <div class="btn-deconnexion">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="15" y1="9" x2="9" y2="15"></line>
                <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </div>

            <h2>Mon Espace</h2>  

            <section class="info-section">
    <h3>Historique des commandes</h3>
    <table class="orders-table">
        <thead>
            <tr>
                <th>Numéro de commande</th>
                <th>Date de la commande</th>
                <th>Agence de Retrait</th>
                <th>Delais de Retrait</th>
                <th>Statut</th>
                <th>Prix Total</th>
            </tr>
        </thead>
        <tbody id="orders-list">
        </tbody>
    </table>
</section>

            <section class="info-section">
                <h3>Infos Personnelles</h3>
                <div class="form">
                    <input type="text" id="nom" name="nom" placeholder="Nom" required/>
                    <input type="text" id="prenom" name="prenom" placeholder="Prénom" required/>
                </div>
                <div class="form">
                    <input type="text" id="adresse" name="adresse" placeholder="Adresse" required/>
                    <input type="text" id="code_postal" name="code_postal" placeholder="Code Postal" required/>
                    <input type="text" id="ville" name="ville" placeholder="Ville" required/>
                </div>
                <div class="form">
                    <input type="email" id="email" name="email" placeholder="Email" required/>
                    <input type="tel" id="telephone" name="telephone" placeholder="Téléphone" required/>
                </div>
                <button type="button" class="btn-save">Sauvegarder</button>
            </section>
        </div>
    </main>
    <?php include 'templates/footer.php'; ?>
    <script src="js/myspace.js"></script>
</body>
</html>