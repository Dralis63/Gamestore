# Gamestore

## Description

Gamestore est un site web de vente de jeux vidéo. Ce projet permet aux utilisateurs de parcourir, rechercher et acheter des jeux vidéo.

## Prérequis

- [XAMPP](https://www.apachefriends.org/index.html)
- Un navigateur web (Google Chrome, Firefox, etc.)
- Git

## Installation

### 1. Installation de XAMPP

1. Téléchargez et installez XAMPP depuis [Apache Friends](https://www.apachefriends.org/index.html).
2. Lancez XAMPP Control Panel et démarrez les modules **Apache** et **MySQL**.

### 2. Cloner le dépôt

1. Ouvrez Git Bash (ou toute autre interface de ligne de commande).
2. Naviguez vers le répertoire `htdocs` de votre installation XAMPP. Par exemple :

   ```bash
   cd C:/xampp/htdocs
   ```

3. Clonez le dépôt dans ce répertoire :

   ```bash
   git clone https://github.com/Dralis63/Gamestore.git
   ```

### 3. Importation de la base de données

1. Ouvrez phpMyAdmin en accédant à `http://localhost/phpmyadmin` dans votre navigateur.
2. Importez le fichier `gamestore.sql` fourni dans le répertoire `annexes` du projet :

   - Cliquez sur **Importer**.
   - Sélectionnez le fichier `gamestore.sql` situé dans le répertoire `annexes` du projet et cliquez sur **Importer**.

### 4. Configuration des fichiers

1. Assurez-vous que le fichier `connexion_bdd.php` est configuré correctement pour se connecter à votre base de données locale. Le fichier devrait ressembler à ceci :

   ```php
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
   ```

### 5. Lancer le site

1. Assurez-vous que les modules **Apache** et **MySQL** de XAMPP sont en cours d'exécution.
2. Accédez au site en entrant `http://localhost/gamestore` dans votre navigateur.

## Utilisation

- **Parcourir les jeux** : Les utilisateurs peuvent parcourir les jeux disponibles sur la page d'accueil.
- **Rechercher des jeux** : Utilisez les filtres pour rechercher des jeux par genre, prix et plateforme.
- **Détails du jeu** : Cliquez sur un jeu pour voir ses détails et l'ajouter au panier.
- **Panier** : Ajoutez des jeux au panier et passez à la caisse pour finaliser l'achat.

## Auteurs

- **Seb** - *Développeur principal* - [Dralis63](https://github.com/Dralis63)