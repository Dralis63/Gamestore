<?php
require_once '../connexion_bdd.php';

// Vérifie si les données ont été correctement envoyées
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $game_id = isset($_POST['game_id']) ? $_POST['game_id'] : null;
    $new_stock = isset($_POST['new_stock']) ? $_POST['new_stock'] : null;

    if ($game_id === null || $new_stock === null) {
        echo json_encode(['error' => 'Paramètres manquants']);
        exit;
    }

    // Assurez-vous de filtrer et valider les données ici si nécessaire

    try {
        // Préparez et exécutez votre requête SQL pour mettre à jour le stock
        $query = "UPDATE jeux SET stock = :new_stock WHERE id = :game_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':new_stock', $new_stock, PDO::PARAM_INT);
        $stmt->bindParam(':game_id', $game_id, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Erreur lors de la mise à jour du stock: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Méthode non autorisée']);
}
?>