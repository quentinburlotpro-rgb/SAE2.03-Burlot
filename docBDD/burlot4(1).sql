-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 07 mai 2026 à 11:00
-- Version du serveur : 10.11.14-MariaDB-0+deb12u2
-- Version de PHP : 8.3.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `burlot4`
--

-- --------------------------------------------------------

--
-- Structure de la table `SAE-Category`
--

CREATE TABLE `SAE-Category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `SAE-Category`
--

INSERT INTO `SAE-Category` (`id`, `name`) VALUES
(1, 'Action'),
(2, 'Comédie'),
(3, 'Drame'),
(4, 'Science-fiction'),
(5, 'Animation'),
(6, 'Thriller'),
(7, 'Horreur'),
(8, 'Aventure'),
(9, 'Fantaisie'),
(10, 'Documentaire');

-- --------------------------------------------------------

--
-- Structure de la table `SAE-Favorite`
--

CREATE TABLE `SAE-Favorite` (
  `id_profile` int(11) NOT NULL,
  `id_movie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `SAE-Favorite`
--

INSERT INTO `SAE-Favorite` (`id_profile`, `id_movie`) VALUES
(2, 43),
(5, 35),
(5, 38),
(5, 39),
(6, 35),
(6, 38),
(6, 39),
(6, 40),
(7, 39),
(7, 40),
(10, 39),
(18, 35),
(18, 37),
(18, 41),
(18, 42);

-- --------------------------------------------------------

--
-- Structure de la table `SAE-Movie`
--

CREATE TABLE `SAE-Movie` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `year` int(11) DEFAULT NULL,
  `length` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `director` varchar(255) DEFAULT NULL,
  `id_category` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `trailer` varchar(255) DEFAULT NULL,
  `min_age` int(11) DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `SAE-Movie`
--

INSERT INTO `SAE-Movie` (`id`, `name`, `year`, `length`, `description`, `director`, `id_category`, `image`, `trailer`, `min_age`, `featured`) VALUES
(7, 'Interstellar', 2014, 169, 'Un groupe d\'explorateurs voyage à travers un trou de ver pour sauver l\'humanité.', 'Christopher Nolan', 4, 'interstellar.jpg', 'https://www.youtube.com/embed/VaOijhK3CRU?si=76Ke4uw4LYjuLuQ6', 12, 1),
(12, 'La Liste de Schindler', 1993, 195, 'Un industriel allemand sauve des milliers de Juifs pendant l\'Holocauste.', 'Steven Spielberg', 3, 'schindler.webp', 'https://www.youtube.com/embed/ONWtyxzl-GE?si=xC3ASGGPy5Ib-aPn', 16, 0),
(17, 'Your Name', 2016, 107, 'Deux adolescents échangent leurs corps de manière mystérieuse.', 'Makoto Shinkai', 5, 'your_name.jpg', 'https://www.youtube.com/embed/AROOK45LXXg?si=aUQyGk2VMCb_ToUL', 10, 0),
(27, 'Le Bon, la Brute et le Truand', 1966, 161, 'Trois hommes se lancent à la recherche d\'un trésor caché.', 'Sergio Leone', 8, 'bon_brute_truand.jpg', 'https://www.youtube.com/embed/WA1hCZFOPqs?si=TwNZAoM4oj4KpGja', 12, 0),
(35, 'Mad Max: Fury Road', 2015, 120, 'Dans un monde post-apocalyptique, une femme se rebelle contre un tyran...', 'George Miller', 1, 'mad_max.jpg', 'https://www.youtube.com/embed/hEJnMQG9ev8', 12, 0),
(36, 'Intouchables', 2011, 112, 'À la suite d\'un accident de parapente, un riche aristocrate engage un jeune de banlieue...', 'Eric Toledano', 2, 'intouchables.jpg', 'https://www.youtube.com/embed/EsaX5kltRcA', 0, 0),
(37, 'Blade Runner 2049', 2017, 164, 'Un nouvel officier de police découvre un secret enterré depuis longtemps...', 'Denis Villeneuve', 4, 'blade_runner.webp', 'https://www.youtube.com/embed/gCcx85zbxz4', 12, 0),
(38, 'The Matrix', 1999, 136, 'Un programmeur informatique découvre que la réalité n\'est qu\'une simulation...', 'Lana Wachowski', 4, 'matrix.jpg', 'https://www.youtube.com/embed/vKQi3bBA1y8', 12, 0),
(39, 'Spider-Man: New Generation', 2018, 117, 'Miles Morales devient le nouveau Spider-Man et découvre le Spider-Verse...', 'Peter Ramsey', 5, 'spiderman.jpg', 'https://www.youtube.com/embed/eGDqpAM6Gyk', 0, 1),
(40, 'Princesse Mononoké', 1997, 134, 'Un jeune prince part à la recherche d\'un remède et se retrouve au cœur d\'une guerre...', 'Hayao Miyazaki', 5, 'mononoke.jpg', 'https://www.youtube.com/embed/4OiMOHRDs14', 10, 0),
(41, 'Seven', 1995, 127, 'Deux inspecteurs traquent un tueur en série qui utilise les sept péchés capitaux...', 'David Fincher', 6, 'seven.webp', 'https://www.youtube.com/embed/znmZoVkCjpI', 16, 0),
(42, 'Shutter Island', 2010, 138, 'En 1954, deux marshals enquêtent sur la disparition d\'une patiente sur une île...', 'Martin Scorsese', 6, 'shutter_island.jpg', 'https://www.youtube.com/embed/5iaYLCiq5RM', 12, 0),
(43, 'Conjuring: Les dossiers Warren', 2013, 112, 'Des enquêteurs paranormaux aident une famille terrorisée par une présence sombre...', 'James Wan', 7, 'conjuring.jpg', 'https://www.youtube.com/embed/McOmzgX09wo', 12, 0),
(44, 'Le Seigneur des Anneaux : La Communauté de l\'anneau', 2001, 178, 'Un jeune Hobbit hérite d\'un anneau magique et doit entreprendre un voyage périlleux...', 'Peter Jackson', 9, 'lotr.webp', 'https://www.youtube.com/embed/vvx7m22GGtA', 10, 0),
(47, 'Inception', 2010, 148, 'Un voleur qui s\'approprie des secrets d\'entreprise à travers l\'utilisation de la technologie de partage de rêves.', 'Christopher Nolan', 4, 'inception.jpg', 'https://www.youtube.com/embed/8hP9D6kZseM', 12, 1),
(48, 'Le Voyage de Chihiro', 2001, 125, 'Une jeune fille entre dans le monde des esprits après que ses parents ont été transformés en porcs.', 'Hayao Miyazaki', 5, 'chihiro.jpg', 'https://www.youtube.com/embed/ByXuk9QqQkk', 0, 0),
(49, 'The Dark Knight', 2008, 152, 'Batman doit accepter l\'un des plus grands défis psychologiques et physiques de sa lutte contre l\'injustice.', 'Christopher Nolan', 1, 'dark_knight.jpg', 'https://www.youtube.com/embed/EXeTwQWrcwY', 12, 1),
(50, 'Parasite', 2019, 132, 'Toute la famille de Ki-taek est au chômage et s\'intéresse particulièrement au train de vie de la richissime famille Park.', 'Bong Joon-ho', 6, 'parasite.jpg', 'https://www.youtube.com/embed/5xH0HfJH66M', 12, 0),
(51, 'Le Roi Lion', 1994, 88, 'Le jeune lion Simba doit succéder à son père Mufasa comme roi de la Terre des Lions.', 'Roger Allers', 5, 'roi_lion.jpg', 'https://www.youtube.com/embed/lFzVJEksoDY', 0, 0),
(52, 'Pulp Fiction', 1994, 154, 'Les vies de deux tueurs à gages, d\'un boxeur, d\'un gangster et de sa femme s\'entremêlent.', 'Quentin Tarantino', 6, 'pulp_fiction.jpg', 'https://www.youtube.com/embed/s7EdQ4FqbhY', 16, 0),
(53, 'Gladiator', 2000, 155, 'Un général romain est trahi et sa famille assassinée par le fils corrompu de l\'empereur.', 'Ridley Scott', 1, 'gladiator.jpg', 'https://www.youtube.com/embed/owK1at_Nny4', 12, 0),
(54, 'Le Parrain', 1972, 175, 'Le patriarche vieillissant d\'une dynastie du crime organisé transfère le contrôle de son empire à son fils.', 'Francis Ford Coppola', 3, 'godfather.jpg', 'https://www.youtube.com/embed/UaVTIH8MTV0', 16, 0),
(56, 'Alien, le huitième passager', 1979, 117, 'L\'équipage d\'un vaisseau spatial répond à un signal de détresse provenant d\'une planète inconnue.', 'Ridley Scott', 7, 'alien.jpg', 'https://www.youtube.com/embed/jQ5lPt9edzQ', 12, 0),
(57, 'Coco', 2017, 105, 'Miguel, qui rêve de devenir musicien, se retrouve accidentellement dans la Terre des Morts.', 'Lee Unkrich', 5, 'coco.jpg', 'https://www.youtube.com/embed/Rvr68u6k5sI', 0, 0),
(58, 'Joker', 2019, 122, 'À Gotham City, Arthur Fleck, un humoriste de stand-up raté, bascule dans la folie.', 'Todd Phillips', 3, 'joker.jpg', 'https://www.youtube.com/embed/zAGVQLHvwOY', 16, 0),
(59, 'Le Silence des Agneaux', 1991, 118, 'Une jeune stagiaire du FBI cherche l\'aide d\'un tueur cannibale emprisonné pour arrêter un autre tueur.', 'Jonathan Demme', 6, 'silence_lambs.jpg', 'https://www.youtube.com/embed/W6Mm8SbeRIw', 16, 0),
(60, 'Avatar', 2009, 162, 'Un marine paraplégique est envoyé sur la lune Pandora pour une mission unique.', 'James Cameron', 4, 'avatar.jpg', 'https://www.youtube.com/embed/5PSNL1qAk6Y', 10, 0),
(61, 'Toy Story', 1995, 81, 'Un cow-boy en peluche est menacé lorsqu\'un astronaute le remplace dans le cœur de son propriétaire.', 'John Lasseter', 5, 'toy_story.jpg', 'https://www.youtube.com/embed/v-PjgYDrg70', 0, 0),
(62, 'The Shining', 1980, 146, 'Un écrivain s\'installe dans un hôtel isolé avec sa famille pour l\'hiver, mais la folie le guette.', 'Stanley Kubrick', 7, 'shining.jpg', 'https://www.youtube.com/embed/S014qGZiSdI', 16, 0),
(63, 'Grand Budapest Hotel', 2014, 99, 'Les aventures de Gustave H, l\'homme aux clés d\'or d\'un célèbre hôtel européen.', 'Wes Anderson', 2, 'budapest_hotel.jpg', 'https://www.youtube.com/embed/1Fg5iWmQjwk', 10, 0),
(64, 'Harry Potter à l\'école des sorciers', 2001, 152, 'Un garçon découvre qu\'il est un sorcier et commence son éducation à Poudlard.', 'Chris Columbus', 9, 'harry_potter.jpg', 'https://www.youtube.com/embed/mNgwNXKafWw', 0, 0),
(65, 'Django Unchained', 2012, 165, 'Un esclave libéré fait équipe avec un chasseur de primes pour sauver sa femme.', 'Quentin Tarantino', 8, 'django.jpg', 'https://www.youtube.com/embed/0fUCuvNlOCg', 16, 0),
(66, 'Star Wars: Un Nouvel Espoir', 1977, 121, 'Luke Skywalker rejoint un chevalier Jedi et un pilote pour sauver la galaxie.', 'George Lucas', 4, 'star_wars.jpg', 'https://www.youtube.com/embed/7L8p7_SL75c', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `SAE-Profile`
--

CREATE TABLE `SAE-Profile` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `min_age` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `SAE-Profile`
--

INSERT INTO `SAE-Profile` (`id`, `name`, `avatar`, `min_age`) VALUES
(1, 'Eloi', '1', 7),
(2, 'Trottmann', '2', 12),
(5, 'Toufik', '3', 16),
(6, 'Alex', '4', 16),
(7, 'fredbisou', '5', 10),
(10, 'Jesus', '6', 12);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `SAE-Category`
--
ALTER TABLE `SAE-Category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `SAE-Favorite`
--
ALTER TABLE `SAE-Favorite`
  ADD PRIMARY KEY (`id_profile`,`id_movie`);

--
-- Index pour la table `SAE-Movie`
--
ALTER TABLE `SAE-Movie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_category` (`id_category`);

--
-- Index pour la table `SAE-Profile`
--
ALTER TABLE `SAE-Profile`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `SAE-Category`
--
ALTER TABLE `SAE-Category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `SAE-Movie`
--
ALTER TABLE `SAE-Movie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT pour la table `SAE-Profile`
--
ALTER TABLE `SAE-Profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
