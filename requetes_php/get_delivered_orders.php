<?php
require_once '../connexion_bdd.php';
header('Content-Type: application/json');

try {
    // Requête SQL pour récupérer les commandes avec le statut "LIVRÉ"
    $stmt = $conn->prepare('SELECT * FROM orders WHERE status = "LIVRÉ"');
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Préparation des données pour chaque commande
    foreach ($orders as &$order) {
        // Décoder les détails des produits depuis la colonne `details` (JSON)
        $details = json_decode($order['details'], true);

        // Structure des détails des produits
        $order['details'] = ['items' => $details['items']]; // Adaptation selon votre structure réelle
    }

    echo json_encode(['success' => true, 'orders' => $orders]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>