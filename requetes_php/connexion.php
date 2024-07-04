<?php
require_once '../connexion_bdd.php';
header('Content-Type: application/json');

// Démarrer la session
session_start();

// Vérification si la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit(json_encode(['success' => false, 'message' => 'Méthode non autorisée']));
}

// Récupération des données POST en JSON
$data = json_decode(file_get_contents('php://input'), true);

// Vérification de la présence des paramètres
if (!isset($data['email']) || !isset($data['password'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Veuillez remplir tous les champs.']);
    exit;
}

$email = htmlspecialchars($data['email']);
$password = htmlspecialchars($data['password']);

// Requête pour vérifier les informations d'identification
$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérification du mot de passe haché
if (!$user || !password_verify($password, $user['password'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Email ou mot de passe incorrect.']);
    exit;
}

// Authentification réussie
// Stocker les informations de l'utilisateur dans la session
$_SESSION['user'] = [
    'id' => $user['id'],
    'nom' => $user['nom'],
    'prenom' => $user['prenom'],
    'status' => $user['status'],
    'email' => $user['email'], // Ajout de l'email dans la session
];

http_response_code(200);
echo json_encode(['success' => true, 'message' => 'Connexion réussie ! Bienvenue, ' . $user['prenom'] . ' ' . $user['nom']]);
?>