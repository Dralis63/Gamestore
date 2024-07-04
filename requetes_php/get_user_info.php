<?php
session_start();
require_once '../connexion_bdd.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Utilisateur non authentifié']);
    exit;
}

$user_id = $_SESSION['user']['id'];

$sql = "SELECT nom, prenom, telephone, adresse, code_postal, ville, email FROM users WHERE id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo json_encode([
        'success' => true,
        'nom' => $user['nom'],
        'prenom' => $user['prenom'],
        'telephone' => $user['telephone'],
        'adresse' => $user['adresse'],
        'code_postal' => $user['code_postal'],
        'ville' => $user['ville'],
        'email' => $user['email']
    ]);
} else {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Utilisateur non trouvé']);
}
?>