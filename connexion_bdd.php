<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gamestore";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, $options);

} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

?>