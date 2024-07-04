<?php
require_once '../connexion_bdd.php';

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $gameName = $_POST['game-name'];
    $description = $_POST['description'];
    $pegi = $_POST['pegi'];
    $genre = $_POST['genre'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $plateforme = $_POST['plateforme']; // Nouvelle ligne pour récupérer la plateforme sélectionnée

    // Gérer le téléchargement des images
    $coverImage = $_FILES['cover-image'];
    $backgroundImage = $_FILES['background-image'];

    // Chemins des répertoires de téléchargement
    $coverImageDir = '../img/pochettes_jeux/';
    $backgroundImageDir = '../img/fond_jeux/';

    // Créer les répertoires s'ils n'existent pas
    if (!is_dir($coverImageDir)) {
        mkdir($coverImageDir, 0777, true);
    }
    if (!is_dir($backgroundImageDir)) {
        mkdir($backgroundImageDir, 0777, true);
    }

    // Générer des noms de fichiers uniques
    $coverImageName = date('Ymd_His') . '_' . $coverImage['name'];
    $backgroundImageName = date('Ymd_His') . '_' . $backgroundImage['name'];

    // Définir les chemins complets des fichiers uploadés
    $coverImagePath = $coverImageDir . $coverImageName;
    $backgroundImagePath = $backgroundImageDir . $backgroundImageName;

    // Déplacer les fichiers uploadés dans le répertoire cible
    if (move_uploaded_file($coverImage['tmp_name'], $coverImagePath) && move_uploaded_file($backgroundImage['tmp_name'], $backgroundImagePath)) {
        // Préparer la requête SQL
        $sql = "INSERT INTO jeux (nom_jeu, description, pegi, genre, prix, stock, cover_image, background_image, plateforme, date_ajout)
                VALUES (:gameName, :description, :pegi, :genre, :price, :quantity, :coverImageName, :backgroundImageName, :plateforme, NOW())";

        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':gameName', $gameName);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':pegi', $pegi);
            $stmt->bindParam(':genre', $genre);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':coverImageName', $coverImageName);
            $stmt->bindParam(':backgroundImageName', $backgroundImageName);
            $stmt->bindParam(':plateforme', $plateforme); // Nouvelle ligne pour lier la plateforme

            if ($stmt->execute()) {
                $response['success'] = true;
            } else {
                $response['error'] = 'Erreur lors de l\'insertion dans la base de données.';
            }
        } catch (PDOException $e) {
            $response['error'] = 'Erreur SQL : ' . $e->getMessage();
        }
    } else {
        $response['error'] = 'Erreur lors du téléchargement des images.';
    }
} else {
    $response['error'] = 'Méthode de requête invalide.';
}

echo json_encode($response);
?>