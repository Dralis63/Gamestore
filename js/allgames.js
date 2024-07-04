document.addEventListener('DOMContentLoaded', function() {
    const filters = ['prix', 'genre', 'plateforme'];
    filters.forEach(filter => {
        document.getElementById(filter).addEventListener('change', applyFilters);
    });

    resetFilters();
    fetchAndDisplayAllGames();
});

function resetFilters() {
    ['prix', 'genre', 'plateforme'].forEach(filter => {
        document.getElementById(filter).value = '';
    });
}

function fetchAndDisplayAllGames() {
    fetchGames('requetes_php/tous_les_jeux.php', displayGames);
}

function applyFilters() {
    const genre = document.getElementById('genre').value;
    const prix = document.getElementById('prix').value;
    const plateforme = document.getElementById('plateforme').value;

    const url = `requetes_php/tous_les_jeux.php?genre=${genre}&prix=${prix}&plateforme=${plateforme}`;
    fetchGames(url, displayGames);
}

function fetchGames(url, callback) {
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur HTTP ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            callback(data, '.affichage_jeux_all', allGameHTML);
            attachGameClickHandlers('.affichage_jeux_all');
        })
        .catch(error => {
            console.error('Erreur de récupération des jeux : ', error);
        });
}

function displayGames(jeux, containerSelector, templateFunction) {
    const gameContainer = document.querySelector(containerSelector);
    gameContainer.innerHTML = jeux.length > 0 ? jeux.map(templateFunction).join('') : '<p>Aucun jeu trouvé.</p>';

    gameContainer.querySelectorAll('.btn-add-panier').forEach(button => {
        button.addEventListener('click', function(event) {
            event.stopPropagation(); // Empêche la propagation de l'événement de clic

            const gameId = this.closest('.jeu-card-all').dataset.id;

            // Envoyer une requête AJAX pour ajouter le jeu au panier
            fetch('requetes_php/add_cart_item.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ gameId: gameId }),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur HTTP ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    console.error('Erreur lors de l\'ajout au panier : ', data.error);
                    alert('Erreur lors de l\'ajout au panier : ' + data.error);
                }
            })
            .catch(error => {
                console.error('Erreur lors de l\'ajout au panier : ', error);
                alert('Erreur lors de l\'ajout au panier : ' + error.message);
            });
        });
    });
}

function allGameHTML(jeu) {
    const prixHTML = jeu.prix_promo > 0
        ? `<span style="color: #CC0000;">Prix: ${jeu.prix_promo} €</span><span style="text-decoration: line-through; margin-left: 0.5rem;">${jeu.prix} €</span>`
        : `Prix: ${jeu.prix} €`;

    const stock = jeu.stock == 0
        ? `<div class="jeu-noStock-all">Rupture de stock</div>`
        : `<div class="jeu-stock-all">En stock</div>`;

    let btnText = jeu.stock == 0 ? 'En rupture' : 'Ajouter';
    let btnClass = 'btn-add-panier';
    let btnDisabled = jeu.stock == 0 || !isUserLoggedIn || userStatus != 'utilisateur' ? 'disabled' : '';
    console.log(userStatus);
    if (jeu.stock > 0 && isUserLoggedIn && userStatus == 'utilisateur') {
        btnClass += ' btn-add';
    }

    const btn = `<button class="${btnClass}" type="button" ${btnDisabled}>${btnText}</button>`;

    return `
        <div class="jeu-card-all" data-id="${jeu.id}">
            <img src="img/pochettes_jeux/${jeu.cover_image}" alt="${jeu.nom_jeu}" class="jeu-img-all">
            <div class="jeu-details-all">
                <div class="jeu-name-all">${jeu.nom_jeu}</div>
                <div class="jeu-pegi-all">PEGI: ${jeu.pegi}</div>
                <div class="jeu-price-all">${prixHTML}</div>
                ${btn}
                ${stock}
            </div>
        </div>
    `;
}

function attachGameClickHandlers(containerSelector) {
    var gameContainer = document.querySelector(containerSelector);
    if (!gameContainer) return;

    gameContainer.addEventListener('click', function(event) {
        var jeuCard = event.target.closest('.jeu-card-all');
        if (!jeuCard) return;

        var gameId = jeuCard.getAttribute('data-id');
        if (gameId) {
            window.location.href = 'gamedetail.php?id=' + gameId;
        }
    });
}