<?php
require_once '../connexion_bdd.php';
header('Content-Type: application/json');

try {
    $stmt = $conn->prepare('SELECT o.id, o.order_number, CONCAT(u.nom, " ", u.prenom) AS client_name, o.order_date, o.status, o.details 
                            FROM orders o
                            INNER JOIN users u ON o.user_id = u.id
                            WHERE o.status = "VALIDÉ"');
    $stmt->execute();
    
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($orders as &$order) {
        $details = json_decode($order['details'], true);
        $order['details'] = $details;
    }

    echo json_encode(['success' => true, 'orders' => $orders]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>