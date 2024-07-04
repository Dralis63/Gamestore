document.addEventListener('DOMContentLoaded', function() {
    // Sélection des éléments du menu et des sections
    const links = document.querySelectorAll('.link-section-admin');
    const sections = document.querySelectorAll('.conteneur-admin > section');

    // Fonction pour activer une section et un lien
    function activateSection(sectionId) {
        // Retirer la classe active de tous les liens
        links.forEach(link => link.classList.remove('active'));
    
        // Ajouter la classe active au lien correspondant
        const activeLink = document.querySelector(`.link-section-admin[href="#${sectionId}"]`);
        if (activeLink) {
            activeLink.classList.add('active');
        }
    
        // Masquer toutes les sections d'abord
        sections.forEach(section => {
            section.style.display = 'none';
        });
    
        // Afficher la section correspondante
        const activeSection = document.getElementById(sectionId);
        if (activeSection) {
            activeSection.style.display = 'block';
    
            // Charger les détails des ventes et le graphique des ventes si c'est la section appropriée
            if (sectionId === 'details-ventes' || sectionId === 'graphique-ventes' || sectionId === 'dashboard') {
                loadSalesDetails();
            }
        }
    }

    // Fonction pour charger les détails des ventes via AJAX et afficher à la fois les détails et le graphique des ventes
    function loadSalesDetails() {
        $.ajax({
            url: 'requetes_php/get_delivered_orders.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    displaySalesDetails(response.orders);
                    generateSalesChart(response.orders);
                    generateGenreSalesChart(response.orders);
                } else {
                    console.error('Erreur lors du chargement des détails des ventes:', response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error('Erreur AJAX lors du chargement des détails des ventes:', error);
            }
        });
    }

    // Fonction pour afficher les détails des ventes dans la table
    function displaySalesDetails(orders) {
        const salesDetailsList = document.getElementById('sales-details-list');
        salesDetailsList.innerHTML = ''; // Effacer le contenu actuel de la table

        // Générer les lignes de détails des ventes
        orders.forEach(function(order) {
            order.details.items.forEach(function(item) {
                var row = '<tr>' +
                            '<td>' + new Date(order.order_date).toLocaleDateString() + '</td>' +
                            '<td>' + item.name + '</td>' +
                            '<td>' + item.quantity + '</td>' +
                            '<td>' + (item.quantity * parseFloat(item.price)).toFixed(2) + '</td>' +
                          '</tr>';
                salesDetailsList.innerHTML += row;
            });
        });
    }


// Fonction pour afficher le graphique des ventes avec Chart.js
function generateSalesChart(orders) {
    // Récupérer le canvas existant
    var ctx = document.getElementById('salesChart').getContext('2d');

    // Vérifier s'il existe déjà un graphique attaché à ce canvas
    if (window.myChart instanceof Chart) {
        // Détruire l'instance précédente du graphique
        window.myChart.destroy();
    }

    // Préparer les données pour le graphique
    var salesData = {};

    // Remplir salesData avec les quantités vendues par produit et par date
    orders.forEach(function(order) {
        order.details.items.forEach(function(item) {
            var productName = item.name;
            var quantitySold = item.quantity;

            if (!salesData[productName]) {
                salesData[productName] = {};
            }

            // Utiliser la date de la commande pour regrouper les ventes
            var orderDate = new Date(order.order_date).toLocaleDateString();
            if (!salesData[productName][orderDate]) {
                salesData[productName][orderDate] = 0;
            }

            salesData[productName][orderDate] += quantitySold;
        });
    });

    // Trier les dates dans l'ordre chronologique
    var sortedDates = Object.keys(salesData).flatMap(product => Object.keys(salesData[product])).sort(function(a, b) {
        return new Date(a) - new Date(b);
    });

    // Supprimer les doublons et conserver l'ordre
    var chartLabels = Array.from(new Set(sortedDates));

    // Convertir les données en format utilisable par Chart.js
    var chartDatasets = [];

    Object.keys(salesData).forEach(function(productName) {
        var data = chartLabels.map(function(date) {
            return salesData[productName][date] || 0; // Si aucune vente ce jour-là, retourner 0
        });

        var dataset = {
            label: productName,
            data: data,
            fill: false,
            borderColor: getRandomColor(),
            tension: 0.1
        };
        chartDatasets.push(dataset);
    });

    // Afficher le graphique à l'aide de Chart.js
    window.myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: chartDatasets
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Ventes par article (Commandes LIVRÉES)'
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Quantité vendue'
                    }
                }
            }
        }
    });
}

// Variable pour stocker la référence du graphique actuel
var genreSalesChart = null;

// Fonction pour générer le graphique des ventes par genre de jeu
function generateGenreSalesChart(orders) {
    // Détruire le graphique existant s'il y en a un
    if (genreSalesChart) {
        genreSalesChart.destroy();
    }

    // Préparer les données pour le graphique
    var salesData = {};

    // Remplir salesData avec les quantités vendues par genre
    orders.forEach(function(order) {
        order.details.items.forEach(function(item) {
            var genreName = item.genre;
            var quantitySold = item.quantity;

            if (!salesData[genreName]) {
                salesData[genreName] = [];
            }

            // Utiliser la date de la commande pour regrouper les ventes (ici, nous utilisons une date factice)
            var sale = {
                date: new Date(order.order_date).toLocaleDateString(), // Convertir la date de commande en format lisible
                quantity: quantitySold
            };

            salesData[genreName].push(sale);
        });
    });

    // Trier les dates dans l'ordre chronologique
    var sortedDates = Object.keys(salesData).flatMap(genre => salesData[genre].map(sale => sale.date)).sort(function(a, b) {
        return new Date(a) - new Date(b);
    });

    // Supprimer les doublons et conserver l'ordre
    var chartLabels = Array.from(new Set(sortedDates));

    // Convertir les données en format utilisable par Chart.js
    var chartDatasets = [];

    Object.keys(salesData).forEach(function(genreName) {
        var data = chartLabels.map(function(date) {
            var totalQuantity = salesData[genreName].reduce(function(acc, sale) {
                if (sale.date === date) {
                    acc += sale.quantity;
                }
                return acc;
            }, 0);
            return totalQuantity || 0; // Si aucune vente ce jour-là, retourner 0
        });

        var dataset = {
            label: genreName,
            data: data,
            fill: false,
            borderColor: getRandomColor(),
            tension: 0.1
        };
        chartDatasets.push(dataset);
    });

    // Afficher le graphique à l'aide de Chart.js
    var ctx = document.getElementById('dashboardChart').getContext('2d');
    genreSalesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: chartDatasets
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Ventes par genre de jeu'
                },
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Quantité vendue'
                    }
                }
            }
        }
    });
}
    // Fonction utilitaire pour générer des couleurs aléatoires
    function getRandomColor() {
        var r = Math.floor(Math.random() * 256); // Valeur aléatoire pour le rouge
        var g = Math.floor(Math.random() * 256); // Valeur aléatoire pour le vert
        var b = Math.floor(Math.random() * 256); // Valeur aléatoire pour le bleu
        return `rgb(${r}, ${g}, ${b})`;
    }
    // Ajouter un gestionnaire d'événement à chaque lien du menu
    links.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Empêcher le comportement par défaut du lien
            const sectionId = this.getAttribute('href').substring(1); // Récupérer l'ID de la section
            activateSection(sectionId); // Activer la section correspondante
        });
    });

    // Afficher la première section par défaut
    if (sections.length > 0) {
        activateSection(sections[0].id); // Activer la première section
    }
    
// Gestion de la soumission du formulaire de création de jeu
document.getElementById('creation-jeu-form').addEventListener('submit', function(event) {
    event.preventDefault();

    // Récupérer les données du formulaire
    var formData = new FormData(this);

    // Envoyer les données via AJAX
    $.ajax({
        url: 'requetes_php/create_game.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert('Le jeu a été créé avec succès.');
                // Réinitialiser le formulaire
                document.getElementById('creation-jeu-form').reset();
            } else {
                alert('Erreur lors de la création du jeu: ' + response.error);
            }
        },
        error: function(xhr, status, error) {
            console.error('Erreur AJAX lors de la création du jeu:', error);
            alert('Erreur AJAX: ' + error);
        }
    });
});



const stockTable = document.getElementById('stock-table').querySelector('tbody');
// Fonction pour charger et afficher les jeux avec les stocks
function loadGames() {
    $.ajax({
        url: 'requetes_php/game_stock.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.message) {
                return;
            }

            // Effacer le contenu actuel de la table
            stockTable.innerHTML = '';

            // Afficher chaque jeu dans le tableau
            response.forEach(function(jeu) {
                var row = '<tr>' +
                    '<td>' + jeu.nom_jeu + '</td>' +
                    '<td>' + jeu.plateforme + '</td>' +
                    '<td><input type="number" id="stock-' + jeu.id + '" name="stock-' + jeu.id + '" value="' + jeu.stock + '"></td>' +
                    '<td><button class="btn-livrer" data-game-id="' + jeu.id + '">Update</button></td>' +
                    '</tr>';
                stockTable.innerHTML += row;
            });
        },
        error: function(xhr, status, error) {
            console.error('Erreur AJAX lors du chargement des jeux:', error);
        }
    });
}
loadGames();

stockTable.addEventListener('click', function(event) {
    if (event.target && event.target.classList.contains('btn-livrer')) {
        var gameId = event.target.getAttribute('data-game-id');
        updateStock(gameId);
    }
});

// Fonction pour mettre à jour le stock d'un jeu via AJAX
function updateStock(gameId) {
    var newStock = document.getElementById('stock-' + gameId).value;

    $.ajax({
        url: 'requetes_php/update_stock.php',
        type: 'POST',
        data: {
            game_id: gameId,
            new_stock: newStock
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert('Stock mis à jour avec succès pour le jeu ID ' + gameId);
                loadGames(); // Recharger les jeux après la mise à jour
            } else {
                console.error('Erreur lors de la mise à jour du stock:', response.error);
            }
        },
        error: function(xhr, status, error) {
            console.error('Erreur AJAX lors de la mise à jour du stock:', error);
        }
    });
}


const creationCompteForm = document.getElementById('creation-compte-form');

    creationCompteForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Empêcher l'envoi du formulaire par défaut

        // Récupérer les valeurs du formulaire
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        // Effectuer la requête AJAX pour créer le compte
        $.ajax({
            url: 'requetes_php/create_user.php',
            type: 'POST',
            data: {
                email: email,
                password: password
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Compte employé créé avec succès.');
                    creationCompteForm.reset(); // Réinitialiser le formulaire après la création du compte
                } else {
                    alert('Erreur lors de la création du compte: ' + response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error('Erreur AJAX lors de la création du compte:', error);
                alert('Erreur AJAX lors de la création du compte: ' + error);
            }
        });
    });
    function deconnexion() {
        // Effectuer une requête AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'deconnexion.php', true);
    
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Redirection après déconnexion
                window.location.href = 'index.php';
            } else {
                console.log('Erreur lors de la déconnexion : ' + xhr.status);
            }
        };
    
        xhr.send();
    }
    var btnDeconnexion = document.querySelector('.btn-deconnexion');
    btnDeconnexion.addEventListener('click', function() {
        deconnexion();
    });
});
