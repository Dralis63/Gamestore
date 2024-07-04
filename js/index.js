document.addEventListener('DOMContentLoaded', function() {
    fetchAndDisplayLatestGames();
    fetchAndDisplayPromotionalGames();
});

function fetchAndDisplayLatestGames() {
    var xhrGames = new XMLHttpRequest();
    xhrGames.open('GET', 'requetes_php/derniers_jeux.php', true);

    xhrGames.onload = function() {
        if (xhrGames.status >= 200 && xhrGames.status < 400) {
            var gamesResponse = JSON.parse(xhrGames.responseText);
            displayGames(gamesResponse, '.affichage_jeux', gameHTML);
            attachGameClickHandlers('.affichage_jeux');
        } else {
            console.error('Erreur lors de la récupération des derniers jeux.');
        }
    };

    xhrGames.onerror = function() {
        console.error('Erreur de connexion pour récupérer les derniers jeux.');
    };

    xhrGames.send();
}

function fetchAndDisplayPromotionalGames() {
    var xhrPromo = new XMLHttpRequest();
    xhrPromo.open('GET', 'requetes_php/dernieres_promo.php', true);

    xhrPromo.onload = function() {
        if (xhrPromo.status >= 200 && xhrPromo.status < 400) {
            var promoResponse = JSON.parse(xhrPromo.responseText);
            displayGames(promoResponse, '.affichage_jeux_promo', promotionalGameHTML);
            attachGameClickHandlers('.affichage_jeux_promo');
        } else {
            console.error('Erreur lors de la récupération des jeux en promotion.');
        }
    };

    xhrPromo.onerror = function() {
        console.error('Erreur de connexion pour récupérer les jeux en promotion.');
    };

    xhrPromo.send();
}

function displayGames(jeux, containerSelector, templateFunction) {
    var gameContainer = document.querySelector(containerSelector);
    gameContainer.innerHTML = jeux.length > 0 ? jeux.map(templateFunction).join('') : '<p>Aucun jeu trouvé.</p>';
}

function gameHTML(jeu) {
    return `
        <div class="jeu-card" data-id="${jeu.id}">
            <img src="img/pochettes_jeux/${jeu.cover_image}" alt="${jeu.nom_jeu}" class="jeu-img">
            <div class="jeu-details">
                <div class="jeu-name">${jeu.nom_jeu}</div>
                <div class="jeu-pegi">PEGI: ${jeu.pegi}</div>
                <div class="jeu-price">Prix: ${jeu.prix} €</div>
            </div>
        </div>
    `;
}

function promotionalGameHTML(jeu) {
    return `
        <div class="jeu-card" data-id="${jeu.id}">
            <div class="promo-badge">PROMO</div>
            <img src="img/pochettes_jeux/${jeu.cover_image}" alt="${jeu.nom_jeu}" class="jeu-img">
            <div class="jeu-details">
                <div class="jeu-name">${jeu.nom_jeu}</div>
                <div class="jeu-pegi">PEGI: ${jeu.pegi}</div>
                <div class="jeu-price">
                    <span style="color: #CC0000;">Prix: ${jeu.prix_promo} €</span>
                    <span style="text-decoration: line-through; margin-left: 0.5rem;">${jeu.prix} €</span>
                </div>
            </div>
        </div>
    `;
}

function attachGameClickHandlers(containerSelector) {
    var gameContainer = document.querySelector(containerSelector);
    if (!gameContainer) return;

    gameContainer.addEventListener('click', function(event) {
        var jeuCard = event.target.closest('.jeu-card');
        if (!jeuCard) return;

        var gameId = jeuCard.getAttribute('data-id');
        if (gameId) {
            window.location.href = 'gamedetail.php?id=' + gameId;
        }
    });
}