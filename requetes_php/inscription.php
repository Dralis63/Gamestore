<?php
require_once '../connexion_bdd.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

// Récupération et validation des données du formulaire
$data = json_decode(file_get_contents('php://input'), true);

$nom = trim($data['nom'] ?? '');
$prenom = trim($data['prenom'] ?? '');
$telephone = trim($data['telephone'] ?? '');
$adresse = trim($data['adresse'] ?? '');
$codePostal = trim($data['code_postal'] ?? '');
$ville = trim($data['ville'] ?? '');
$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';
$status = 'utilisateur';
// Validation du format d'email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Email non valide.']);
    exit;
}

// Validation de la longueur minimale du mot de passe
if (strlen($password) < 8) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Le mot de passe doit contenir au moins 8 caractères.']);
    exit;
}

// Vérification si l'email existe déjà
$sqlCheckEmail = "SELECT COUNT(*) AS count FROM users WHERE email = :email";
$stmtCheckEmail = $conn->prepare($sqlCheckEmail);
$stmtCheckEmail->bindParam(':email', $email);
$stmtCheckEmail->execute();
$row = $stmtCheckEmail->fetch(PDO::FETCH_ASSOC);

if ($row && $row['count'] > 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Cet email est déjà utilisé.']);
    exit;
}

// Hash du mot de passe
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insertion des données dans la base de données
$sqlInsert = "INSERT INTO users (nom, prenom, telephone, adresse, code_postal, ville, email, password, status)
              VALUES (:nom, :prenom, :telephone, :adresse, :codePostal, :ville, :email, :password, :status)";
$stmtInsert = $conn->prepare($sqlInsert);
$stmtInsert->bindParam(':nom', $nom);
$stmtInsert->bindParam(':prenom', $prenom);
$stmtInsert->bindParam(':telephone', $telephone);
$stmtInsert->bindParam(':adresse', $adresse);
$stmtInsert->bindParam(':codePostal', $codePostal);
$stmtInsert->bindParam(':ville', $ville);
$stmtInsert->bindParam(':email', $email);
$stmtInsert->bindParam(':password', $hashedPassword);
$stmtInsert->bindParam(':status', $status);

if ($stmtInsert->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'inscription. Veuillez réessayer.']);
}
?>