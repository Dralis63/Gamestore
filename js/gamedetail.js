document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const gameId = urlParams.get('id');

    if (gameId) {
        const url = `requetes_php/get_game_details.php?id=${gameId}`;

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur HTTP ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                displayGameDetails(data);
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des détails du jeu : ', error);
            });
    } else {
        console.error('ID du jeu non trouvé dans l\'URL');
    }

    function displayGameDetails(gameDetails) {
        const prixHTML = gameDetails.prix_promo > 0
            ? `<span style="color: #CC0000;">Prix: ${gameDetails.prix_promo} €</span><span style="text-decoration: line-through; margin-left: 0.5rem;">${gameDetails.prix} €</span>`
            : `Prix: ${gameDetails.prix} €`;
        
        let btnText = gameDetails.stock == 0 ? 'En rupture' : 'Ajouter';
        let btnClass = 'btn-add-panier';
        let btnDisabled = gameDetails.stock == 0 || !isUserLoggedIn || userStatus != 'utilisateur' ? 'disabled' : '';

        if (gameDetails.stock > 0 && isUserLoggedIn && userStatus == 'utilisateur') {
            btnClass += ' btn-add';
        }

        const btn = `<button id="addToCartBtn" class="${btnClass}" type="button" ${btnDisabled}>${btnText}</button>`;

        const gameDetailsHTML = `
            <div class="background-game">
                <img src="img/fond_jeux/${gameDetails.background_image}">
            </div>
            <section class="detail-jeu">
                <div class="detail-jeu-content">
                    <h2>${gameDetails.nom_jeu}</h2>
                    <p>${gameDetails.description}</p>
                    <p>Plateforme : ${gameDetails.plateforme}</p>
                    <p>Genre : ${gameDetails.genre}</p>
                    <p>PEGI : ${gameDetails.pegi}</p>
                    <p>${prixHTML}</p>
                    <p>Quantité disponible : ${gameDetails.stock}</p>
                    ${btn}
                </div>
            </section>
        `;

        document.querySelector('main').innerHTML = gameDetailsHTML;

        // Ajouter l'événement onclick dynamiquement
        document.getElementById('addToCartBtn').addEventListener('click', function() {
            addToCart(gameId);
        });
    }

    function addToCart(gameId) {
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
    }
});