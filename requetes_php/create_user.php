<?php
require_once '../connexion_bdd.php'; // Assurez-vous d'avoir inclus votre fichier de connexion

// Vérifier si les données ont été envoyées via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    if (!$email || !$password) {
        echo json_encode(['error' => 'Veuillez fournir une adresse email et un mot de passe.']);
        exit;
    }

    // Vérifier si l'email existe déjà
    try {
        $query_check_email = "SELECT COUNT(*) AS count FROM users WHERE email = :email";
        $stmt_check_email = $conn->prepare($query_check_email);
        $stmt_check_email->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt_check_email->execute();
        $result_check_email = $stmt_check_email->fetch(PDO::FETCH_ASSOC);

        if ($result_check_email['count'] > 0) {
            echo json_encode(['error' => 'Cette adresse email est déjà utilisée.']);
            exit;
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Erreur lors de la vérification de l\'email: ' . $e->getMessage()]);
        exit;
    }

    // Hasher le mot de passe avant de l'enregistrer (utilisez les fonctions de hachage sécurisées appropriées)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Préparer et exécuter la requête SQL pour insérer un nouvel utilisateur avec le mot de passe haché
        $query_insert_user = "INSERT INTO users (email, password, status) VALUES (:email, :password, 'employee')";
        $stmt_insert_user = $conn->prepare($query_insert_user);
        $stmt_insert_user->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt_insert_user->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt_insert_user->execute();

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Erreur lors de la création du compte: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Méthode non autorisée']);
}
?>
