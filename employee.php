<?php
    session_start();
    if ($_SESSION['user']['status'] !== 'employee') {
        header('Location: index.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Employé</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <main>
        <div class="employee">
            <h2>Espace Employé</h2>
            <section class="commande-a-valider">
                <h3>Commande à valider</h3>
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Numéro de commande</th>
                            <th>Nom du client</th>
                            <th>Date de la commande</th>
                            <th>Statut</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="orders-list">
                        <!-- Contenu des commandes chargé via JavaScript -->
                    </tbody>
                </table>
            </section>
            <section class="graphique-ventes">
                <h3>Graphique des ventes par article</h3>
                <canvas id="salesChart" width="800" height="400"></canvas>
            </section>
            <button class="btn-details-ventes">Détails des Ventes</button>
            <section class="details-ventes">
                <h3>Détails des Ventes</h3>
                <select id="filtre">
    <option value="">Filtrer par :</option>
    <option value="dateCroissante">Date (croissante)</option>
    <option value="dateDecroissante">Date (décroissante)</option>
    <option value="nomAZ">Nom (A-Z)</option>
    <option value="nomZA">Nom (Z-A)</option>
    <option value="ventesMoins">Nombre de vente <</option>
    <option value="ventesPlus">Nombre de vente ></option>
    <option value="prixCroissant">Prix croissant</option>
    <option value="prixDecroissant">Prix décroissant</option>
</select>
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Nom de l'article</th>
                            <th>Nombre de ventes/jour</th>
                            <th>Prix total</th>
                        </tr>
                    </thead>
                    <tbody id="sales-details-list">
                        <!-- Contenu des détails des ventes chargé via JavaScript -->
                    </tbody>
                </table>
            </section>
        </div>
    </main>
    <?php include 'templates/footer.php'; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/employee.js"></script>
</body>
</html>