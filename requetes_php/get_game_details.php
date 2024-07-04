<?php
require_once '../connexion_bdd.php';

if (isset($_GET['id'])) {
    $game_id = $_GET['id'];

    try {
        $query = "SELECT nom_jeu, plateforme, description, genre, pegi, prix, prix_promo, stock, background_image FROM jeux WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $game_id, PDO::PARAM_INT);
        $stmt->execute();

        $jeu = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($jeu) {
            header('Content-Type: application/json');
            echo json_encode($jeu);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Jeu non trouvé.']);
        }

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Erreur : ' . $e->getMessage()]);
    }

} else {
    http_response_code(400);
    echo json_encode(['message' => 'ID du jeu non fourni']);
}

?>
