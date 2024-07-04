document.addEventListener('DOMContentLoaded', function() {

    fetchUserInfo();
    fetchUserOrders();

    function fetchUserInfo() {
        fetch('requetes_php/get_user_info.php', {
            method: 'GET',
        })
        .then(handleResponse)
        .then(function(data) {
            if (data.success) {
                document.getElementById('nom').value = data.nom;
                document.getElementById('prenom').value = data.prenom;
                document.getElementById('adresse').value = data.adresse;
                document.getElementById('code_postal').value = data.code_postal;
                document.getElementById('ville').value = data.ville;
                document.getElementById('email').value = data.email;
                document.getElementById('telephone').value = data.telephone;
            } else {
                console.error('Erreur lors de la récupération des informations utilisateur : ' + data.message);
            }
        })
        .catch(function(error) {
            console.error('Erreur lors de la communication avec le serveur : ' + error.message);
        });
    }

    function fetchUserOrders() {
        fetch('requetes_php/get_user_orders.php', {
            method: 'GET',
        })
        .then(handleResponse)
        .then(function(data) {
            if (data.success && data.orders.length > 0) {
               
                var ordersList = document.getElementById('orders-list');
                ordersList.innerHTML = '';

                data.orders.forEach(function(order) {
                    var orderRow = document.createElement('tr');

                    var orderDetailsHTML = `
                        <td>${order.order_number}</td>
                        <td>${order.order_date}</td>
                        <td>${order.agency_withdrawal.toUpperCase()}</td>
                        <td>${order.date_withdrawal}</td>
                        <td>${order.status}</td>
                        <td>${order.total_price} EUR</td>
                    `;

                    orderRow.innerHTML = orderDetailsHTML;

                    ordersList.appendChild(orderRow);
                });
            } else {
                var ordersList = document.getElementById('orders-list');
                ordersList.innerHTML = '<tr><td colspan="4">Aucune commande.</td></tr>';
            }
        })
        .catch(function(error) {
            console.error('Erreur lors de la récupération des commandes utilisateur : ' + error.message);
        });
    }

    function handleResponse(response) {
        if (!response.ok) {
            throw new Error('Erreur HTTP: ' + response.status);
        }
        return response.json();
    }

    function isValidEmail(email) {

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    var btnSave = document.querySelector('.btn-save');
    btnSave.addEventListener('click', function() {
        
        var nom = document.getElementById('nom').value.trim();
        var prenom = document.getElementById('prenom').value.trim();
        var adresse = document.getElementById('adresse').value.trim();
        var codePostal = document.getElementById('code_postal').value.trim();
        var ville = document.getElementById('ville').value.trim();
        var email = document.getElementById('email').value.trim();
        var telephone = document.getElementById('telephone').value.trim();

        if (!isValidEmail(email)) {
            alert('Veuillez saisir une adresse email valide.');
            return;
        }
        
        var userData = {
            nom: nom,
            prenom: prenom,
            adresse: adresse,
            code_postal: codePostal,
            ville: ville,
            email: email,
            telephone: telephone
        };

        fetch('requetes_php/update_user_info.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(userData)
        })
        .then(handleResponse)
        .then(function(data) {
            if (data.success) {
                alert('Informations mises à jour avec succès !');
            } else {
                alert('Erreur lors de la mise à jour des informations : ' + data.message);
            }
        })
        .catch(function(error) {
            console.error('Erreur lors de la communication avec le serveur : ' + error.message);
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