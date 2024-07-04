<?php
session_start();
require_once '../connexion_bdd.php';

if (isset($_SESSION['user']['id'])) {
    $userId = $_SESSION['user']['id'];

    try {

        $sql = "SELECT * FROM cart WHERE user_id = :userId";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($cartItems);
    } catch (PDOException $e) {
        die("Erreur lors de la récupération des articles du panier : " . $e->getMessage());
    }
} else {
    echo json_encode([]);
}
?>