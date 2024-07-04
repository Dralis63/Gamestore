document.addEventListener('DOMContentLoaded', function() {
    const cartContainer = document.querySelector('.cart-items');
    const dateSelect = document.getElementById('date');
    const totalPriceElement = document.querySelector('.total-price');

    fetch('requetes_php/get_user_cart.php')
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                let totalPrice = 0;
                let items = [];

                data.forEach(item => {
                    const articleElement = document.createElement('div');
                    articleElement.classList.add('cart-item');

                    const subTotal = item.product_price * item.quantity;
                    totalPrice += subTotal;

                    items.push({
                        productId : item.product_id,
                        name: item.product_name,
                        plateforme: item.plateforme,
                        genre: item.genre,
                        price: item.product_price,
                        quantity: item.quantity
                    });

                    articleElement.innerHTML = `
                        <div class="cart-item-details">
                            <span>${item.product_name}</span>
                            <span>${item.product_price} €</span>
                            <span class="quantity">Quantité: ${item.quantity}</span>
                            <span>Sous-total: ${subTotal.toFixed(2)} €</span>
                            <button class="btn-delete" data-product-id="${item.id}">Supprimer</button>
                        </div>
                    `;

                    cartContainer.appendChild(articleElement);
                });

                totalPriceElement.textContent = `Total : ${totalPrice.toFixed(2)} €`;

                const today = new Date();
                const maxDate = new Date();
                maxDate.setDate(today.getDate() + 7);

                for (let i = 0; i < 7; i++) {
                    const date = new Date();
                    date.setDate(today.getDate() + i);

                    if (!isWeekendOrMonday(date)) {
                        const option = document.createElement('option');
                        option.value = formatDate(date);
                        option.textContent = formatDate(date, true);
                        dateSelect.appendChild(option);
                    }
                }

                const orderButton = document.querySelector('.btn-order');
                orderButton.addEventListener('click', function() {
                    const selectedDate = dateSelect.value;
                    const selectedAgence = document.getElementById('agence').value;
                    if (selectedDate && selectedAgence) {
                        fetch('requetes_php/add_user_order.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                selectedDate: selectedDate,
                                selectedAgence: selectedAgence,
                                totalPrice: totalPrice.toFixed(2),
                                items: items
                            })
                        })
                        .then(response => response.text()) // Récupérer le texte brut de la réponse
                        .then(text => {
                            return JSON.parse(text); // Analyser le texte en JSON
                        })
                        .then(data => {
                            if (data.success) {
                                window.location.href = 'myspace.php';
                            } else {
                                console.error('Erreur lors de la commande:', data.error);
                                alert('Erreur lors de la commande.');
                            }
                        })
                        .catch(error => {
                            console.error('Erreur lors de la commande:', error);
                            alert('Erreur lors de la commande.');
                        });
                    } else {
                        alert('Veuillez sélectionner une agence et une date de retrait.');
                    }
                });

                cartContainer.addEventListener('click', function(event) {
                    if (event.target.classList.contains('btn-delete')) {
                        const productId = event.target.getAttribute('data-product-id');

                        fetch('requetes_php/delete_cart_item.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ productId: productId }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                console.error('Erreur lors de la suppression de l\'article:', data.error);
                                alert('Erreur lors de la suppression de l\'article.');
                            }

                        })
                        .catch(error => {
                            console.error('Erreur lors de la suppression de l\'article:', error);
                            alert('Erreur lors de la suppression de l\'article.');
                        });
                    }
                });

            } else {
                cartContainer.innerHTML = '<p>Votre panier est vide.</p>';
            }
        })
        .catch(error => {
            console.error('Erreur lors de la récupération du panier:', error);
        });
});

function isWeekendOrMonday(date) {
    const dayOfWeek = date.getDay();
    return dayOfWeek === 0 || dayOfWeek === 1;
}

function formatDate(date, includeDay = false) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');

    if (includeDay) {
        const dayOfWeek = ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'][date.getDay()];
        return `${dayOfWeek} ${day}/${month}/${year}`;
    } else {
        return `${year}-${month}-${day}`;
    }
}