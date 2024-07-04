<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['productId'])) {
        $productId = $data['productId'];

        require_once '../connexion_bdd.php'; 

        $checkQuantitySql = "SELECT quantity FROM cart WHERE id = :productId";
        try {
            $stmt = $conn->prepare($checkQuantitySql);
            $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $currentQuantity = $row['quantity'];
                if ($currentQuantity > 1) {
                   
                    $updateSql = "UPDATE cart SET quantity = quantity - 1 WHERE id = :productId";
                    $stmt = $conn->prepare($updateSql);
                    $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
                    $stmt->execute();
                } else {
                    
                    $deleteSql = "DELETE FROM cart WHERE id = :productId";
                    $stmt = $conn->prepare($deleteSql);
                    $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
                    $stmt->execute();
                }

                echo json_encode(['success' => true, 'message' => 'Article mis à jour avec succès']);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Article non trouvé dans le panier']);
            }

        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur lors de la mise à jour/suppression de l\'article: ' . $e->getMessage()]);
        }

        $conn = null;
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Identifiant de produit non spécifié']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
}
?>