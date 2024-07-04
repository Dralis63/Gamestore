<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <?php
    if ($_SESSION['user']['status'] !== 'admin') {
        header('Location: index.php');
        exit;
    }
?>
    <main>
        <div class="conteneur-admin">
        <div class="btn-deconnexion">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="15" y1="9" x2="9" y2="15"></line>
                <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </div>
            <div class="menu-admin">
                <nav>
                    <ul>
                        <li><a href="#creation-jeu" class="link-section-admin">Création de jeux</a></li>
                        <li><a href="#gestion-stocks" class="link-section-admin">Gestion des Stocks</a></li>
                        <li><a href="#dashboard" class="link-section-admin">Dashboard</a></li>
                        <li><a href="#creation-compte" class="link-section-admin">Création de compte Employé</a></li>
                        <li><a href="#graphique-ventes" class="link-section-admin">Graphique des Ventes</a></li>
                        <li><a href="#details-ventes" class="link-section-admin">Détails des Ventes</a></li>
                    </ul>
                </nav>
            </div>

<section id="creation-jeu" class="section-admin">
    <h2>Création de jeu vidéo</h2>
    <form id="creation-jeu-form" enctype="multipart/form-data" method="POST">
        <div class="form-group">
            <input type="text" id="game-name" name="game-name" placeholder="Nom du jeu" required>

            <select id="plateforme" name="plateforme" required>
                <option value="" disabled selected>Plateforme</option>
                <option value="PC">PC</option>
                <option value="PlayStation 4">PlayStation 4</option>
                <option value="PlayStation 5">PlayStation 5</option>
                <option value="Xbox One">Xbox One</option>
                <option value="Xbox Series X">Xbox Series X</option>
                <option value="Nintendo Switch">Nintendo Switch</option>
            </select>
        </div>
        <div class="form-group">
            <label for="cover-image" class="file-label" id="cover-image-label">Image de la pochette</label>
            <input type="file" id="cover-image" name="cover-image" accept="image/*" required>
            <label for="background-image" class="file-label" id="background-image-label">Image de fond</label>
            <input type="file" id="background-image" name="background-image" accept="image/*" required>
        </div>
        <div class="form-group">
            <textarea id="description" name="description" rows="4" placeholder="Description" required></textarea>
        </div>
        <div class="form-group">
            <select id="pegi" name="pegi" required>
                <option value="" disabled selected>PEGI</option>
                <option value="3">3</option>
                <option value="7">7</option>
                <option value="12">12</option>
                <option value="16">16</option>
                <option value="18">18</option>
            </select>

            <select id="genre" name="genre" required>
                <option value="" disabled selected>Genre</option>
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
            <input type="number" id="price" name="price" step="0.01" placeholder="Prix" required>
            <input type="number" id="quantity" name="quantity" placeholder="Quantité" required>
        </div>
        <button type="submit">Créer le jeu</button>
    </form>
</section>

<section id="gestion-stocks" class="section-admin">
    <h2>Gestion des Stocks</h2>
        <table id="stock-table" class="orders-table">
            <thead>
                <tr>
                    <th>Nom du Jeu</th>
                    <th>Plateforme</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Contenu du tableau généré dynamiquement par JavaScript -->
            </tbody>
        </table>
</section>

            <section id="dashboard" class="section-admin">
                <h2>Dashboard</h2>
                <canvas id="dashboardChart"></canvas>
            </section>

            <section id="creation-compte" class="section-admin">
    <h2>Création de compte Employé</h2>
    <form id="creation-compte-form">
            <input type="email" id="email" name="email" required placeholder="Email">
            <input type="password" id="password" name="password" required placeholder="Mot de passe">
        <div>
            <button type="submit">Créer le compte</button>
        </div>
    </form>
</section>
    
            <section id="graphique-ventes" class="section-admin">
                <h2>Graphique des Ventes</h2>
                <canvas id="salesChart"></canvas>
            </section>
    
            <section id="details-ventes" class="section-admin">
                <h2>Détails des Ventes</h2>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/admin.js"></script>
</body>
</html>