SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Base de données : `gamestore`

CREATE DATABASE IF NOT EXISTS `gamestore` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `gamestore`;

-- Structure de la table `cart`

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `plateforme` varchar(50) NOT NULL,
  `genre` varchar(50) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Structure de la table `jeux`

CREATE TABLE `jeux` (
  `id` int(11) NOT NULL,
  `nom_jeu` varchar(100) NOT NULL,
  `plateforme` varchar(50) NOT NULL,
  `genre` varchar(50) NOT NULL,
  `pegi` int(11) NOT NULL,
  `prix` decimal(11,2) NOT NULL,
  `prix_promo` decimal(11,2) NOT NULL,
  `description` text DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `date_ajout` timestamp NOT NULL DEFAULT current_timestamp(),
  `cover_image` varchar(255) DEFAULT NULL,
  `background_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Déchargement des données de la table `jeux`


INSERT INTO `jeux` (`id`, `nom_jeu`, `plateforme`, `genre`, `pegi`, `prix`, `prix_promo`, `description`, `stock`, `date_ajout`, `cover_image`, `background_image`) VALUES
(1, 'The Legend of Zelda: Breath of the Wild', 'Nintendo Switch', 'Aventure', 12, 59.99, 0.00, 'Explorez le vaste royaume d\'Hyrule dans ce jeu d\'action-aventure épique. Utilisez votre intelligence et votre courage pour découvrir des secrets, affronter des ennemis puissants et survivre dans un monde foisonnant de vie et d\'aventures sans fin. La liberté de choix et d\'exploration est au cœur de ce chef-d\'œuvre, vous offrant des heures de jeu captivantes.', 150, '2024-07-03 12:58:33', '1.jpg', 'fond1.jpg'),
(2, 'Red Dead Redemption 2', 'PlayStation 4', 'Action', 18, 49.99, 0.00, 'Vivez la vie d\'un hors-la-loi dans l\'immense et atmosphérique monde ouvert de la frontière américaine. Participez à des fusillades, des braquages, chassez, et interagissez avec une variété de personnages aux histoires profondes. Chaque décision que vous prenez influence le cours de l\'histoire, offrant une immersion totale dans cet univers de l\'Ouest sauvage.', 198, '2024-07-03 12:58:33', '2.jpg', 'fond2.jpg'),
(3, 'The Witcher 3: Wild Hunt', 'PC', 'RPG', 18, 39.99, 0.00, 'Partez pour un voyage épique en tant que Geralt de Riv, un chasseur de monstres à louer, dans ce RPG acclamé par la critique. Explorez un vaste monde ouvert rempli d\'histoires riches, de personnages complexes et de créatures féroces. Les choix que vous faites auront des conséquences significatives sur le déroulement de l\'histoire et la vie des habitants du monde.', 120, '2024-07-03 12:58:33', '3.jpg', 'fond3.jpg'),
(4, 'Minecraft', 'Xbox One', 'Sandbox', 7, 19.99, 0.00, 'Créez et explorez vos propres mondes, construisez des structures, et survivez contre diverses créatures dans ce jeu de bac à sable. La seule limite est votre imagination alors que vous rassemblez des ressources et fabriquez des outils. Que vous construisiez des palais ou surviviez la nuit contre les créatures, chaque partie de Minecraft est unique.', 299, '2024-07-03 12:58:33', '4.jpg', 'fond4.jpg'),
(5, 'Animal Crossing: New Horizons', 'Nintendo Switch', 'Simulation', 3, 59.99, 0.00, 'Construisez et personnalisez votre propre paradis insulaire dans ce jeu de simulation relaxant. Interagissez avec des villageois animaux charmants, décorez votre maison, et explorez votre environnement. Chaque jour apporte de nouvelles activités et découvertes, faisant de chaque session de jeu une expérience joyeuse et sereine.', 20, '2024-07-03 12:58:33', '5.jpg', 'fond5.jpg'),
(6, 'Cyberpunk 2077', 'PlayStation 4', 'RPG', 18, 29.99, 0.00, 'Plongez dans le monde futuriste de Night City, où vous pouvez personnaliser votre personnage et faire des choix qui façonnent le récit. Expérimentez un monde ouvert vaste avec d\'innombrables activités, quêtes et personnages. L\'histoire immersive et les graphismes époustouflants vous captiveront dans ce voyage dystopique.', 140, '2024-07-03 12:58:33', '6.jpg', 'fond6.jpg'),
(7, 'Grand Theft Auto V', 'PC', 'Action', 18, 29.99, 0.00, 'Explorez le monde ouvert de Los Santos et du comté de Blaine, participez à des missions palpitantes, et vivez une histoire captivante. Jouez en tant que trois personnages uniques, chacun ayant sa propre histoire et ses compétences. Le jeu offre une combinaison unique de narration et de liberté d\'exploration.', 250, '2024-07-03 12:58:33', '7.jpg', 'fond7.jpg'),
(8, 'Horizon Zero Dawn', 'PlayStation 4', 'Action', 16, 19.99, 0.00, 'Rejoignez Aloy dans son exploration d\'un monde luxuriant habité par des créatures mécanisées mystérieuses. Utilisez votre intelligence, votre agilité et vos armes pour découvrir les secrets du passé de la Terre et sauver l\'avenir. Chaque découverte apporte de nouvelles perspectives sur l\'histoire et le destin de l\'humanité.', 160, '2024-07-03 12:58:33', '8.jpg', 'fond8.jpg'),
(9, 'Overwatch', 'Xbox One', 'FPS', 12, 39.99, 0.00, 'Rejoignez les rangs d\'Overwatch et engagez-vous dans des combats en équipe à travers une variété de héros et de cartes uniques. Chaque héros possède des capacités et des rôles uniques à jouer dans les batailles rapides. La stratégie et la coopération sont essentielles pour dominer le champ de bataille.', 130, '2024-07-03 12:58:33', '9.jpg', 'fond9.jpg'),
(10, 'The Elder Scrolls V: Skyrim', 'PlayStation 4', 'RPG', 18, 19.99, 0.00, 'Plongez dans le monde fantastique épique de Skyrim, où vous pouvez explorer des donjons, combattre des dragons, et découvrir le pouvoir du Dragonborn. Le jeu offre des aventures infinies et une riche tradition. Chaque décision que vous prenez façonne le monde et influence votre destinée.', 170, '2024-07-03 12:58:33', '10.jpg', 'fond10.jpg'),
(11, 'DOOM Eternal', 'PC', 'FPS', 18, 29.99, 0.00, 'Déchaînez-vous à travers des hordes démoniaques dans ce jeu de tir à la première personne rapide et brutal. Utilisez un arsenal d\'armes puissantes et de compétences pour combattre des ennemis implacables à travers des paysages variés. Chaque niveau offre un défi intense et une action non-stop.', 109, '2024-07-03 12:58:33', NULL, NULL),
(12, 'FIFA 23', 'PlayStation 4', 'Sport', 3, 59.99, 0.00, 'Vivez l\'excitation du football avec un gameplay réaliste, des équipes mises à jour, et de nouvelles fonctionnalités dans FIFA 23. Construisez votre équipe de rêve et participez à divers modes, y compris Carrière et Ultimate Team. Le jeu offre une expérience de football immersive et authentique.', 209, '2024-07-03 12:58:33', NULL, NULL),
(13, 'Call of Duty: Modern Warfare', 'Xbox One', 'FPS', 18, 49.99, 0.00, 'Engagez-vous dans des combats tactiques intenses et des missions cinématographiques dans ce reboot de la série iconique Modern Warfare. Le jeu offre une campagne solo captivante et des modes multijoueurs expansifs. Chaque mission est une expérience palpitante et immersive.', 220, '2024-07-03 12:58:33', NULL, NULL),
(14, 'Among Us', 'PC', 'Simulation', 7, 4.99, 0.00, 'Travaillez ensemble avec votre équipage pour accomplir des tâches sur un vaisseau spatial, mais méfiez-vous des imposteurs essayant de saboter vos efforts. Engagez-vous dans des jeux de déduction sociale et de stratégie pour survivre. Chaque partie est une nouvelle aventure pleine de suspense.', 50, '2024-07-03 12:58:33', NULL, NULL),
(15, 'Assassin\'s Creed Valhalla', 'PlayStation 5', 'Action', 18, 59.99, 0.00, 'Devenez un guerrier viking légendaire en quête de gloire dans Assassin\'s Creed Valhalla. Pillez vos ennemis, développez votre colonie, et construisez votre pouvoir politique pour gagner une place parmi les dieux. Le jeu offre une exploration immersive et des combats épiques.', 50, '2024-07-03 12:58:33', NULL, NULL),
(16, 'Spider-Man: Miles Morales', 'PlayStation 5', 'Aventure', 16, 49.99, 0.00, 'Vivez l\'ascension de Miles Morales alors qu\'il maîtrise des pouvoirs nouveaux et explosifs pour devenir son propre Spider-Man. Parcourez la ville de New York et affrontez de nouveaux ennemis dans des combats spectaculaires. Le jeu offre une aventure dynamique et captivante.', 200, '2024-07-03 12:58:33', NULL, NULL),
(17, 'God of War', 'PlayStation 4', 'Aventure', 18, 19.99, 0.00, 'Parcourez les royaumes nordiques dans ce conte épique de père et fils. Combattez des créatures redoutables et explorez des paysages à couper le souffle alors que Kratos cherche la rédemption et renforce sa relation avec son fils. Chaque bataille est une épreuve de force et de stratégie.', 150, '2024-07-03 12:58:33', NULL, NULL),
(18, 'Super Mario Odyssey', 'Nintendo Switch', 'Aventure', 3, 59.99, 0.00, 'Rejoignez Mario dans une aventure 3D massive à travers le monde et utilisez ses nouvelles capacités incroyables pour collecter des lunes. Explorez des environnements époustouflants et sauvez la princesse Peach des plans de mariage de Bowser. Le jeu offre une aventure joyeuse et pleine de surprises.', 250, '2024-07-03 12:58:33', NULL, NULL),
(19, 'Resident Evil Village', 'PlayStation 5', 'Survival', 18, 59.99, 0.00, 'Vivez l\'horreur de la survie comme jamais auparavant dans le huitième opus majeur de la franchise Resident Evil. Combattez des ennemis terrifiants et découvrez des secrets sombres dans un village mystérieux. Chaque instant est rempli de tension et de suspense.', 130, '2024-07-03 12:58:33', NULL, NULL),
(20, 'Mass Effect Édition Légendaire', 'PC', 'RPG', 18, 59.99, 0.00, 'Revivez la légende du Commandant Shepard dans la trilogie Mass Effect acclamée par la critique avec l\'Édition Légendaire. Expérimentez la saga épique du conflit humain-alien et des romances. Chaque décision façonne l\'histoire et influence le destin de l\'univers.', 140, '2024-07-03 12:58:33', NULL, NULL),
(21, 'Halo Infinite', 'Xbox Series X', 'FPS', 0, 59.99, 0.00, 'Le Master Chief revient dans Halo Infinite – le prochain chapitre de la légendaire franchise. Explorez des environnements expansifs, engagez-vous dans des batailles épiques, et découvrez le mystère derrière les Banished. Le jeu offre une aventure captivante et immersive.', 200, '2024-07-03 12:58:33', NULL, NULL),
(22, 'Ghost of Tsushima', 'PlayStation 4', 'Aventure', 16, 59.99, 0.00, 'À la fin du 13ème siècle, une armée mongole impitoyable envahit Tsushima en quête de conquête totale. Jin Sakai doit mettre de côté les traditions samouraïs et forger un nouveau chemin, celui du Fantôme, alors qu\'il mène une guerre non conventionnelle pour la liberté du Japon. Chaque combat est un test de courage et d\'ingéniosité.', 150, '2024-07-03 12:58:33', NULL, NULL),
(23, 'Final Fantasy VII Remake', 'PlayStation 4', 'RPG', 16, 59.99, 0.00, 'Une réimagination spectaculaire d\'un des jeux les plus visionnaires de tous les temps. Final Fantasy VII Remake reconstruit et étend le RPG légendaire pour aujourd\'hui. Expérimentez un monde entièrement réalisé et des personnages inoubliables. Chaque moment est une aventure visuellement époustouflante.', 120, '2024-07-03 12:58:33', NULL, NULL),
(24, 'Sekiro: Shadows Die Twice', 'PC', 'Action', 18, 39.99, 0.00, 'Dans Sekiro: Shadows Die Twice, vous êtes le \"loup à un bras\", un guerrier déshonoré et mutilé sauvé de justesse de la mort. Entreprenez un voyage de vengeance et de rédemption dans un monde sombre et torturé. Chaque combat est un défi exigeant stratégie et habileté.', 110, '2024-07-03 12:58:33', NULL, NULL),
(25, 'Mario Kart 8 Deluxe', 'Nintendo Switch', 'Course', 3, 59.99, 0.00, 'Prenez la route avec la version définitive de Mario Kart 8 et jouez n\'importe où, n\'importe quand ! Faites la course contre vos amis ou combattez-les dans un mode bataille révisé sur des circuits de bataille nouveaux et classiques. Chaque course est une explosion de plaisir.', 300, '2024-07-03 12:58:33', NULL, NULL),
(26, 'Dark Souls III', 'PC', 'RPG', 16, 49.99, 0.00, 'Alors que les feux s\'éteignent et que le monde tombe en ruine, le développeur FROMSOFTWARE et le réalisateur Hidetaka Miyazaki continuent leur série acclamée par la critique et définissant le genre avec Dark Souls III. Embrassez les ténèbres et préparez-vous pour un voyage éprouvant.', 140, '2024-07-03 12:58:33', NULL, NULL),
(27, 'Persona 5 Royal', 'PlayStation 4', 'RPG', 16, 59.99, 0.00, 'Préparez-vous pour une nouvelle expérience RPG dans Persona 5 Royal, basé dans l\'univers de la série primée, Persona ! Enfilez le masque de Joker et rejoignez les Phantom Thieves of Hearts pour briser les chaînes de la société moderne. Chaque mission est une aventure fascinante et psychologique.', 130, '2024-07-03 12:58:33', NULL, NULL),
(28, 'Far Cry 6', 'Xbox One', 'FPS', 18, 59.99, 0.00, 'Bienvenue à Yara, un paradis tropical figé dans le temps. Far Cry 6 plonge les joueurs dans le monde palpitant d\'une révolution guerrière moderne. Combattez contre un dictateur et son régime pour libérer l\'île. Chaque bataille est une lutte pour la liberté.', 149, '2024-07-03 12:58:33', NULL, NULL),
(29, 'Les Sims 4', 'PC', 'Simulation', 12, 39.99, 14.99, 'Profitez du pouvoir de créer et de contrôler des personnes dans un monde virtuel où il n\'y a pas de règles dans Les Sims 4. Construisez des maisons, poursuivez des carrières, formez des relations et réalisez les rêves de vos Sims. Chaque décision façonne leur destin.', 197, '2024-07-03 12:58:33', NULL, NULL),
(30, 'NBA 2K23', 'PlayStation 5', 'Sports', 3, 59.99, 47.99, 'NBA 2K23 est le dernier titre de la série NBA 2K, mondialement renommée et best-seller, offrant une expérience de jeu de sport inégalée. Jouez avec vos équipes et stars NBA et WNBA préférées. Chaque match est une représentation réaliste du basketball.', 179, '2024-07-03 12:58:33', NULL, NULL),
(31, 'Death Stranding', 'PC', 'Aventure', 18, 39.99, 24.99, 'Du légendaire créateur de jeux Hideo Kojima vient une expérience totalement nouvelle et défiant les genres. Sam Bridges doit affronter un monde totalement transformé par le Death Stranding. En portant les fragments déconnectés du futur entre ses mains, il entreprend un voyage pour reconnecter le monde brisé. Chaque pas est une aventure unique.', 89, '2024-07-03 12:58:33', NULL, NULL),
(32, 'Borderlands 3', 'PlayStation 4', 'FPS', 18, 49.99, 34.99, 'Le jeu de tir-looter original revient, avec des milliards d\'armes et une aventure pleine de chaos ! Défoncez de nouveaux mondes et ennemis en tant que l\'un des quatre nouveaux chasseurs de l\'Arche, chacun avec des arbres de compétences profonds, des capacités et des personnalisations. Chaque bataille est une explosion de chaos.', 110, '2024-07-03 12:58:33', NULL, NULL),
(33, 'Monster Hunter: World', 'Xbox One', 'RPG', 16, 29.99, 19.99, 'Combattez d\'énormes monstres dans des lieux épiques dans Monster Hunter: World. En tant que chasseur, vous entreprendrez des quêtes pour traquer des monstres dans divers habitats. Abattez ces monstres et recevez des matériaux que vous pouvez utiliser pour créer des armes et des armures plus fortes afin de chasser des monstres encore plus dangereux. Chaque chasse est une épreuve de compétences et de stratégie.', 100, '2024-07-03 12:58:33', NULL, NULL);


-- Structure de la table `orders`

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `order_date` date NOT NULL,
  `agency_withdrawal` varchar(255) DEFAULT NULL,
  `date_withdrawal` date DEFAULT NULL,
  `status` enum('VALIDÉ','LIVRÉ') NOT NULL DEFAULT 'VALIDÉ',
  `total_price` decimal(10,2) NOT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`details`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Déchargement des données de la table `orders`

INSERT INTO `orders` (`id`, `user_id`, `order_number`, `order_date`, `agency_withdrawal`, `date_withdrawal`, `status`, `total_price`, `details`) VALUES
(28, 15, 'order_668568c32a3ef', '2024-07-03', 'toulouse', '2024-07-03', 'LIVRÉ', 179.96, '{\"items\":[{\"productId\":2,\"name\":\"Red Dead Redemption 2\",\"plateforme\":\"PlayStation 4\",\"genre\":\"Action\",\"price\":\"49.99\",\"quantity\":2},{\"productId\":4,\"name\":\"Minecraft\",\"plateforme\":\"Xbox One\",\"genre\":\"Sandbox\",\"price\":\"19.99\",\"quantity\":1},{\"productId\":5,\"name\":\"Animal Crossing: New Horizons\",\"plateforme\":\"Nintendo Switch\",\"genre\":\"Simulation\",\"price\":\"59.99\",\"quantity\":1}]}'),
(29, 15, 'order_668568d46cb4e', '2024-06-12', 'bordeaux', '2024-07-09', 'LIVRÉ', 149.97, '{\"items\":[{\"productId\":12,\"name\":\"FIFA 23\",\"plateforme\":\"PlayStation 4\",\"genre\":\"Sport\",\"price\":\"59.99\",\"quantity\":1},{\"productId\":11,\"name\":\"DOOM Eternal\",\"plateforme\":\"PC\",\"genre\":\"FPS\",\"price\":\"29.99\",\"quantity\":1},{\"productId\":15,\"name\":\"Assassin\'s Creed Valhalla\",\"plateforme\":\"PlayStation 5\",\"genre\":\"Action\",\"price\":\"59.99\",\"quantity\":1}]}'),
(30, 15, 'order_668568eb5367c', '2024-07-01', 'lille', '2024-07-04', 'LIVRÉ', 177.94, '{\"items\":[{\"productId\":28,\"name\":\"Far Cry 6\",\"plateforme\":\"Xbox One\",\"genre\":\"FPS\",\"price\":\"59.99\",\"quantity\":1},{\"productId\":31,\"name\":\"Death Stranding\",\"plateforme\":\"PC\",\"genre\":\"Aventure\",\"price\":\"24.99\",\"quantity\":1},{\"productId\":30,\"name\":\"NBA 2K23\",\"plateforme\":\"PlayStation 5\",\"genre\":\"Sports\",\"price\":\"47.99\",\"quantity\":1},{\"productId\":29,\"name\":\"Les Sims 4\",\"plateforme\":\"PC\",\"genre\":\"Simulation\",\"price\":\"14.99\",\"quantity\":3}]}');

-- Structure de la table `users`

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `code_postal` varchar(10) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('utilisateur','employee','admin') NOT NULL DEFAULT 'utilisateur',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Déchargement des données de la table `users`

INSERT INTO `users` (`id`, `nom`, `prenom`, `telephone`, `adresse`, `code_postal`, `ville`, `email`, `password`, `status`, `created_at`) VALUES
(1, 'aa', 'aa', 'aa', 'aa', 'aa', 'aa', 'a@a.com', '$2y$10$0Ks19sSl08Bqp76Jjplke.5AuGH9RPj/jl1oV/1AAXhnEKMQKhIxS', 'utilisateur', '2024-07-01 13:44:11'),
(15, 'azerty', 'aa', 'aa', 'aa', 'aa', 'aa', 'aa@aa.com', '$2y$10$s24sNxT5.HRo5rMlO.kZw.FUP9Su7A1KYEjE.FeHvgBDi4PBspayq', 'utilisateur', '2024-07-01 13:55:57'),
(18, 'geroix', 'sebastien', '0473718087', '43 rue des jarrouses', '63570', 'Brassac les mines', 'beleth63@gmail.com', '$2y$10$TrgBb6GNPry5MssO1pIJUu0rkkTFeKZRLqyObY/NyBo7qGl.cwXfW', 'admin', '2024-07-01 14:17:36');

-- Index pour les tables déchargées

-- Index pour la table `cart`

ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_product` (`product_id`);

-- Index pour la table `jeux`

ALTER TABLE `jeux`
  ADD PRIMARY KEY (`id`);

-- Index pour la table `orders`

ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

-- Index pour la table `users`

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

-- AUTO_INCREMENT pour les tables déchargées

-- AUTO_INCREMENT pour la table `cart`

ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

-- AUTO_INCREMENT pour la table `jeux`

ALTER TABLE `jeux`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

-- AUTO_INCREMENT pour la table `orders`

ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

-- AUTO_INCREMENT pour la table `users`

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

-- Contraintes pour les tables déchargées

-- Contraintes pour la table `cart`

ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `jeux` (`id`) ON DELETE CASCADE;

-- Contraintes pour la table `orders`

ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;