<?php
require_once '../connexion_bdd.php';
session_start();
header('Content-Type: application/json');

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user']['id'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit();
}

// Vérifiez que la requête est une requête POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userId = $_SESSION['user']['id'];
    $data = json_decode(file_get_contents('php://input'), true);
    $selectedDate = $data['selectedDate'];
    $selectedAgence = $data['selectedAgence'];
    $totalPrice = $data['totalPrice'];
    $items = $data['items']; // Supposons que les articles sont envoyés avec la requête

    // Générer un numéro de commande unique
    $orderNumber = uniqid('order_');

    // Formater les détails des articles commandés pour l'insertion dans la colonne 'details'
    $orderDetails = json_encode(['items' => $items]);

    try {
        // Commencer une transaction pour assurer l'intégrité des données
        $conn->beginTransaction();

        // Préparer la requête pour insérer la commande dans la table 'orders'
        $stmt = $conn->prepare('INSERT INTO orders (user_id, order_number, order_date, agency_withdrawal, date_withdrawal, total_price, details) VALUES (?, ?, CURDATE(), ?, ?, ?, ?)');
        $stmt->execute([$userId, $orderNumber, $selectedAgence, $selectedDate, $totalPrice, $orderDetails]);

        // Récupérer l'ID de la commande insérée
        $orderId = $conn->lastInsertId();

        // Supprimer les articles du panier de l'utilisateur
        $stmtDeleteCart = $conn->prepare('DELETE FROM cart WHERE user_id = ?');
        $stmtDeleteCart->execute([$userId]);

        // Valider la transaction
        $conn->commit();

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        // En cas d'erreur, annuler la transaction et renvoyer une erreur
        $conn->rollBack();
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>