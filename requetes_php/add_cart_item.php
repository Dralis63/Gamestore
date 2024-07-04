<?php
require_once '../connexion_bdd.php';

session_start();
header('Content-Type: application/json');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user']['id'])) {
    echo json_encode(array('success' => false, 'error' => 'Utilisateur non connecté.'));
    exit;
}

// Récupérer les données envoyées par la requête AJAX
$data = json_decode(file_get_contents("php://input"));

// Vérifier si les données sont bien reçues
if (isset($data->gameId)) {
    $gameId = htmlspecialchars(strip_tags($data->gameId));
    $userId = $_SESSION['user']['id']; // Récupérer l'ID de l'utilisateur depuis la session

    try {
        // Récupérer le nom, le prix, le prix promotionnel, la plateforme et le genre du jeu depuis la base de données
        $stmt_game = $conn->prepare("SELECT nom_jeu, prix, prix_promo, plateforme, genre FROM jeux WHERE id = :gameId");
        $stmt_game->bindParam(':gameId', $gameId);
        $stmt_game->execute();
        $game = $stmt_game->fetch(PDO::FETCH_ASSOC);

        if (!$game) {
            echo json_encode(array('success' => false, 'error' => 'Jeu non trouvé.'));
            exit;
        }

        // Déterminer le prix à utiliser (prix normal ou prix promotionnel)
        $product_name = $game['nom_jeu'];
        $product_price = ($game['prix_promo'] > 0.00) ? $game['prix_promo'] : $game['prix'];
        $plateforme = $game['plateforme'];
        $genre = $game['genre'];
        $quantity = 1; // Quantité par défaut à ajouter au panier

        // Vérifier si l'article est déjà dans le panier de l'utilisateur par `product_id`
        $stmt_check = $conn->prepare("SELECT * FROM cart WHERE product_id = :gameId AND user_id = :user_id");
        $stmt_check->bindParam(':gameId', $gameId);
        $stmt_check->bindParam(':user_id', $userId);
        $stmt_check->execute();
        $existing_item = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if ($existing_item) {
            // Mettre à jour la quantité si l'article est déjà dans le panier
            $new_quantity = $existing_item['quantity'] + $quantity;
            $stmt_update = $conn->prepare("UPDATE cart SET quantity = :quantity WHERE id = :id");
            $stmt_update->bindParam(':quantity', $new_quantity);
            $stmt_update->bindParam(':id', $existing_item['id']);
            $stmt_update->execute();
        } else {
            // Ajouter un nouvel article au panier si ce n'est pas déjà présent
            $query = "INSERT INTO cart (user_id, product_id, product_name, product_price, plateforme, genre, quantity) VALUES (:user_id, :gameId, :product_name, :product_price, :plateforme, :genre, :quantity)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':gameId', $gameId);
            $stmt->bindParam(':product_name', $product_name);
            $stmt->bindParam(':product_price', $product_price);
            $stmt->bindParam(':plateforme', $plateforme);
            $stmt->bindParam(':genre', $genre);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->execute();
        }

        // Retourner une réponse JSON indiquant le succès de l'opération
        echo json_encode(array('success' => true));

    } catch(PDOException $e) {
        // En cas d'erreur de connexion à la base de données
        echo json_encode(array('success' => false, 'error' => 'Erreur de connexion à la base de données: ' . $e->getMessage()));
    }

    // Pas besoin de fermer la connexion à la base de données car elle est incluse via require_once
} else {
    // Si les données ne sont pas reçues correctement
    echo json_encode(array('success' => false, 'error' => 'Données manquantes.'));
}
?>
