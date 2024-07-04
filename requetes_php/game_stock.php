<?php

require_once '../connexion_bdd.php';

try {
    $query = "SELECT id, nom_jeu, plateforme, stock FROM jeux ORDER BY nom_jeu ASC";
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