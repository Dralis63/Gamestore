<?php

require_once '../connexion_bdd.php';

try {
    $conditions = [];
    $params = [];

    if (isset($_GET['genre']) && $_GET['genre'] != '') {
        $conditions[] = "genre = :genre";
        $params[':genre'] = $_GET['genre'];
    }

    // Initialiser l'ordre par défaut à vide
    $orderBy = "";

    // Vérifier le tri par prix
    if (isset($_GET['prix']) && $_GET['prix'] != '') {
        // Déterminer si on trie par prix croissant ou décroissant
        $orderBy = ($_GET['prix'] == 'croissant') ? "prix_sort ASC" : "prix_sort DESC";
    }

    if (isset($_GET['plateforme']) && $_GET['plateforme'] != '') {
        $conditions[] = "plateforme = :plateforme";
        $params[':plateforme'] = $_GET['plateforme'];
    }

    // Construire la requête SQL en prenant en compte les conditions et l'ordre
    $query = "SELECT *, IF(prix_promo > 0.00 AND prix_promo < prix, prix_promo, prix) AS prix_sort FROM jeux";

    if (!empty($conditions)) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }

    if (!empty($orderBy)) {
        $query .= " ORDER BY " . $orderBy;
    }

    $stmt = $conn->prepare($query);
    $stmt->execute($params);

    $jeux = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(!empty($jeux) ? $jeux : ['message' => 'Aucun jeu trouvé.']);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur : ' . $e->getMessage()]);
}
?>