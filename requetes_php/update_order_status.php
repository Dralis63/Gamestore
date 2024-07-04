<?php
require_once '../connexion_bdd.php';
header('Content-Type: application/json');

try {
    // Récupérer les données de la requête POST
    $orderId = $_POST['orderId'];
    $details = json_decode($_POST['details'], true);

    // Mettre à jour le statut de la commande à "LIVRÉ"
    $stmtUpdateOrder = $conn->prepare('UPDATE orders SET status = "LIVRÉ" WHERE id = ?');
    $stmtUpdateOrder->execute([$orderId]);

    // Ajuster les stocks des jeux correspondants
    foreach ($details['items'] as $item) {
        $productId = $item['product_id'];
        $quantity = $item['quantity'];

        // Mettre à jour le stock dans la table des jeux
        $stmtUpdateStock = $conn->prepare('UPDATE jeux SET stock = stock - ? WHERE id = ?');
        $stmtUpdateStock->execute([$quantity, $productId]);
    }

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>