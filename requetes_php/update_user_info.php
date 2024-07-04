<?php
session_start();
require_once '../connexion_bdd.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Utilisateur non authentifié']);
    exit;
}

$user_id = $_SESSION['user']['id'];

$data = json_decode(file_get_contents('php://input'), true);

$nom = trim($data['nom'] ?? '');
$prenom = trim($data['prenom'] ?? '');
$telephone = trim($data['telephone'] ?? '');
$adresse = trim($data['adresse'] ?? '');
$codePostal = trim($data['code_postal'] ?? '');
$ville = trim($data['ville'] ?? '');
$email = trim($data['email'] ?? '');

$sql = "UPDATE users SET nom = :nom, prenom = :prenom, telephone = :telephone, adresse = :adresse, code_postal = :code_postal, ville = :ville, email = :email WHERE id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':nom', $nom);
$stmt->bindParam(':prenom', $prenom);
$stmt->bindParam(':telephone', $telephone);
$stmt->bindParam(':adresse', $adresse);
$stmt->bindParam(':code_postal', $codePostal);
$stmt->bindParam(':ville', $ville);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':user_id', $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour des informations utilisateur']);
}
?>