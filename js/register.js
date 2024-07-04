document.addEventListener('DOMContentLoaded', function() {
    var btnInscrire = document.querySelector('.btn-inscrire');
    var btnConnecter = document.querySelector('.btn-connect');

    btnInscrire.addEventListener('click', function() {
        var nom = document.getElementById('nom').value.trim();
        var prenom = document.getElementById('prenom').value.trim();
        var telephone = document.getElementById('telephone').value.trim();
        var adresse = document.getElementById('adresse').value.trim();
        var codePostal = document.getElementById('code_postal').value.trim();
        var ville = document.getElementById('ville').value.trim();
        var email = document.getElementById('email_inscription').value.trim();
        var password = document.getElementById('password_inscription').value.trim();

        // Validation côté client
        if (!nom || !prenom || !telephone || !adresse || !codePostal || !ville || !email || !password) {
            alert('Tous les champs sont obligatoires.');
            return;
        }

        // Vérification du format de l'email côté client
        if (!isValidEmail(email)) {
            alert('L\'adresse email n\'est pas valide.');
            return;
        }

        // Vérification de la longueur du mot de passe
        if (password.length < 8) {
            alert('Le mot de passe doit contenir au moins 8 caractères.');
            return;
        }

        // Création de l'objet contenant les données à envoyer
        var data = {
            nom: nom,
            prenom: prenom,
            telephone: telephone,
            adresse: adresse,
            code_postal: codePostal,
            ville: ville,
            email: email,
            password: password
        };

        // Envoi de la requête AJAX avec fetch
        fetch('requetes_php/inscription.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(function(response) {
            if (!response.ok) {
                throw new Error('Erreur HTTP: ' + response.status);
            }
            return response.json();
        })
        .then(function(data) {
            if (data.success) {
                alert('Inscription réussie ! Vous pouvez maintenant vous connecter.');

                // Redirection vers la section de connexion (exemple avec ancre '#connexion')
                window.location.href = '#connexion';

                // Remplir les champs d'email et de mot de passe dans le formulaire de connexion
                document.getElementById('email').value = email;
                document.getElementById('password').value = password;
            } else {
                // Afficher les erreurs
                alert('Erreur lors de l\'inscription : ' + data.message);
            }
        })
        .catch(function(error) {
            console.error('Erreur lors de la communication avec le serveur : ' + error.message);
        });
    });

    btnConnecter.addEventListener('click', function() {
        var email = document.getElementById('email').value.trim();
        var password = document.getElementById('password').value.trim();

        // Vérifier si les champs d'email et de mot de passe ne sont pas vides
        if (!email || !password) {
            alert('Veuillez remplir tous les champs.');
            return;
        }

        // Créer un objet contenant les données à envoyer
        var data = {
            email: email,
            password: password
        };

        // Envoi de la requête AJAX avec fetch
        fetch('requetes_php/connexion.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(function(response) {
            if (!response.ok) {
                throw new Error('Erreur HTTP: ' + response.status);
            }
            return response.json();
        })
        .then(function(data) {
            if (data.success) {
                alert('Connexion réussie !');

                window.location.href = 'index.php';

                // Effacer les champs d'email et de mot de passe du formulaire de connexion
                document.getElementById('email').value = '';
                document.getElementById('password').value = '';
            } else {
                alert('Erreur lors de la connexion : ' + data.message);
            }
        })
        .catch(function(error) {
            console.error('Erreur lors de la communication avec le serveur : ' + error.message);
        });
    });

    // Fonction utilitaire pour vérifier le format de l'email
    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
});