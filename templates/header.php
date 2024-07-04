<?php
require_once __DIR__ . '/../connexion_bdd.php';
session_start();

// Vérification de l'utilisateur connecté et récupération des informations de session
$isUserLoggedIn = isset($_SESSION['user']);
$userStatus = $isUserLoggedIn ? $_SESSION['user']['status'] : '';
$userId = $isUserLoggedIn ? $_SESSION['user']['id'] : '';

// Fonction pour déterminer la classe 'active' pour les liens de navigation
function isActive($page) {
    return basename($_SERVER['PHP_SELF']) == $page ? 'active' : '';
}

// Récupération du nombre d'articles dans le panier si l'utilisateur est connecté
$cartItemCount = 0;
if ($isUserLoggedIn && $userId) {
    $sql = "SELECT SUM(quantity) AS itemCount FROM cart WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $cartItemCount = $result ? $result['itemCount'] : 0;
}
?>
<script>
    var isUserLoggedIn = <?= json_encode($isUserLoggedIn); ?>;
    var userStatus = <?= json_encode($userStatus); ?>;
</script>
<header>
    <h1>GAMESTORE</h1>
    <?php if ($cartItemCount > 0): ?>
        <a href="mycart.php" class="cart-icon">
            <img src="img/cart.png" alt="Panier">
            <span class="cart-count"><?= $cartItemCount; ?></span>
        </a>
    <?php endif; ?>
    <nav>
        <ul>
            <li><a href="index.php" class="<?= isActive('index.php'); ?>">Accueil</a></li>
            <li><a href="allgames.php" class="<?= isActive('allgames.php'); ?>">Tous les jeux</a></li>
            
            <?php if ($isUserLoggedIn): ?>
                <?php $roleLinks = [
                    'utilisateur' => 'myspace.php',
                    'employee' => 'employee.php',
                    'admin' => 'admin.php'
                ]; ?>
                <?php if (isset($roleLinks[$userStatus])): ?>
                    <li><a href="<?= $roleLinks[$userStatus]; ?>" class="<?= isActive($roleLinks[$userStatus]); ?>">
                        <?= ucfirst($userStatus === 'utilisateur' ? 'Mon espace' : ($userStatus === 'employee' ? 'Espace Employé' : 'Espace Admin')); ?>
                    </a></li>
                <?php endif; ?>
            <?php else: ?>
                <li><a href="register.php" class="<?= isActive('register.php'); ?>">Connexion/Inscription</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>