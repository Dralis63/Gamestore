$(document).ready(function() {
    // Fonction pour charger les commandes à valider depuis le serveur
    function loadOrders() {
        $.ajax({
            url: 'requetes_php/get_orders_all_users.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    displayOrders(response.orders);
                } else {
                    console.error('Erreur lors du chargement des commandes:', response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error('Erreur AJAX lors du chargement des commandes:', error);
            }
        });
    }

    // Fonction pour afficher les commandes dans le tableau HTML
    function displayOrders(orders) {
        var ordersList = $('#orders-list');
        ordersList.empty(); // Efface le contenu existant
        
        orders.forEach(function(order) {
            var row = '<tr>' +
                        '<td>' + order.order_number + '</td>' +
                        '<td>' + order.client_name + '</td>' +
                        '<td>' + order.order_date + '</td>' +
                        '<td>' + order.status + '</td>' +
                        '<td><button class="btn-livrer" data-order-id="' + order.id + '">Passer à livré</button></td>' +
                      '</tr>';
            
            // Ajouter les détails des jeux commandés dans une liste
            row += '<tr class="order-details-row"><td colspan="5"><ul>';
            order.details.items.forEach(function(item) {
                row += '<li data-product-id="' + item.productId + '">' + item.name + ' - Quantité: ' + item.quantity + '</li>';
            });
            row += '</ul></td></tr>';
                        
            ordersList.append(row);
        });
    }

    // Fonction pour mettre à jour le statut de la commande à "LIVRÉ" et ajuster les stocks des jeux
    function updateOrderStatus(orderId, details) {
        console.log('Order ID:', orderId);
        console.log('Details:', details);
        
        $.ajax({
            url: 'requetes_php/update_order_status.php',
            type: 'POST',
            dataType: 'json',
            data: { orderId: orderId, details: JSON.stringify(details) },
            success: function(response) {
                if (response.success) {
                    console.log('Commande mise à jour avec succès');
                    loadOrders();
                } else {
                    console.error('Erreur lors de la mise à jour du statut de la commande:', response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error('Erreur AJAX lors de la mise à jour du statut de la commande:', error);
            }
        });
    }

    // Nouvelle fonction pour charger les commandes avec statut "LIVRÉ"
    function loadDeliveredOrders() {
        $.ajax({
            url: 'requetes_php/get_delivered_orders.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    generateSalesChart(response.orders);
                    displaySalesDetails(response.orders); // Appeler displaySalesDetails ici
                } else {
                    console.error('Erreur lors du chargement des commandes livrées:', response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error('Erreur AJAX lors du chargement des commandes livrées:', error);
            }
        });
    }

    // Fonction pour générer le graphique des ventes par article
    function generateSalesChart(orders) {
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
        var ctx = document.getElementById('salesChart').getContext('2d');
        var myChart = new Chart(ctx, {
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

    // Fonction pour afficher les détails des ventes dans le tableau
    function displaySalesDetails(orders) {
        var salesDetailsList = $('#sales-details-list');
        salesDetailsList.empty();

        orders.forEach(function(order) {
            order.details.items.forEach(function(item) {
                var row = '<tr>' +
                            '<td>' + new Date(order.order_date).toLocaleDateString() + '</td>' +
                            '<td>' + item.name + '</td>' +
                            '<td>' + item.quantity + '</td>' +
                            '<td>' + (item.quantity * parseFloat(item.price)).toFixed(2) + '</td>' +
                          '</tr>';
                salesDetailsList.append(row);
            });
        });
    }

    // Fonction utilitaire pour générer des couleurs aléatoires
    function getRandomColor() {
        var r = Math.floor(Math.random() * 256); // Valeur aléatoire pour le rouge
        var g = Math.floor(Math.random() * 256); // Valeur aléatoire pour le vert
        var b = Math.floor(Math.random() * 256); // Valeur aléatoire pour le bleu
        return `rgb(${r}, ${g}, ${b})`;
    }

    // Gestionnaire d'événements pour le bouton "Passer à livré"
    $(document).on('click', '.btn-livrer', function() {
        var orderId = $(this).data('order-id');
        var details = $(this).closest('tr').next('.order-details-row').find('ul li').map(function() {
            return {
                product_id: $(this).data('product-id'),
                quantity: parseInt($(this).text().split(' - ')[1].trim().split(':')[1].trim())
            };
        }).get();

        updateOrderStatus(orderId, { items: details });
    });

    // Gestionnaire d'événements pour le bouton "Détails des ventes"
    $('.btn-details-ventes').click(function() {
        $('.details-ventes').toggle(); // Toggle pour afficher ou cacher la section
    });

    // Charger les commandes initiales et les commandes livrées
    loadOrders();
    loadDeliveredOrders();
});