<?php

require_once '../connexion_bdd.php';

try {
    $query = "SELECT * FROM jeux WHERE prix_promo = '0.00' ORDER BY date_ajout DESC LIMIT 5";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $jeux = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($jeux) > 0) {
        $json_data = json_encode($jeux);
        header('Content-Type: application/json');
        echo $json_data;
    } else {
        echo json_encode(['message' => 'Aucun jeu trouvé.']);
    }

} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur : ' . $e->getMessage()]);
}
?>