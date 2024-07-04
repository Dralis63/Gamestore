<?php
require_once __DIR__ . '/../connexion_bdd.php';
session_start();
//session_destroy();
$isUserLoggedIn = isset($_SESSION['user']);
$userStatus = isset($_SESSION['user']['status']) ? $_SESSION['user']['status'] : '';
$userId = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : '';

function isActive($page) {
    return basename($_SERVER['PHP_SELF']) == $page ? 'active' : '';
}

$cartItemCount = 0;
if ($isUserLoggedIn && $userId) {
    // Requête SQL pour récupérer le nombre d'articles dans le panier
    $sql = "SELECT SUM(quantity) AS itemCount FROM cart WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $cartItemCount = $result['itemCount'];
    }
}
?>
<script>
    var isUserLoggedIn = <?php echo json_encode($isUserLoggedIn); ?>;
    var userStatus = <?php echo json_encode($userStatus); ?>;
</script>
<header>
    <h1>GAMESTORE</h1>
        <?php if ($cartItemCount > 0): ?>
            <a href="mycart.php" class="cart-icon">
                <img src="img/cart.png" alt="Panier">
                <span class="cart-count"><?php echo $cartItemCount; ?></span>
            </a>
        <?php endif; ?>
    <nav>
        <ul>
            <li><a href="index.php" class="<?php echo isActive('index.php'); ?>">Accueil</a></li>
            <li><a href="allgames.php" class="<?php echo isActive('allgames.php'); ?>">Tous les jeux</a></li>
            
            <?php if ($isUserLoggedIn): ?>
                <?php if ($userStatus === 'utilisateur'): ?>
                    <li><a href="myspace.php" class="<?php echo isActive('myspace.php'); ?>">Mon espace</a></li>
                <?php elseif ($userStatus === 'employee'): ?>
                    <li><a href="employee.php" class="<?php echo isActive('employee.php'); ?>">Espace Employé</a></li>
                <?php elseif ($userStatus === 'admin'): ?>
                    <li><a href="admin.php" class="<?php echo isActive('admin.php'); ?>">Espace Admin</a></li>
                <?php endif; ?>
            <?php else: ?>
                <li><a href="register.php" class="<?php echo isActive('register.php'); ?>">Connexion/Inscription</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>