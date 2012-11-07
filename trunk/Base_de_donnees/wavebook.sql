-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Mer 07 Novembre 2012 à 17:59
-- Version du serveur: 5.5.24
-- Version de PHP: 5.3.10-1ubuntu3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `wavebook`
--

-- --------------------------------------------------------

--
-- Structure de la table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('322e22ff4b826393df88bb8acb0a4396', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/536.11 (KHTML, like Gecko) Ubuntu/12.04 Chromium/20.0.1132.47 Chrome/20.0.11', 1352307342, 'a:4:{s:9:"notif_err";N;s:8:"notif_ok";N;s:8:"user_obj";s:212:"O:4:"User":7:{s:2:"id";i:2;s:4:"name";s:8:"Hollande";s:7:"vorname";s:8:"Francois";s:5:"email";s:19:"president@gmail.com";s:3:"sex";s:1:"1";s:8:"password";s:20:"Le changement c''est ";s:4:"date";s:10:"2012-10-30";}";s:12:"is_connected";i:1;}');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name_user` varchar(20) NOT NULL,
  `vorname_user` varchar(20) NOT NULL,
  `email_user` varchar(150) NOT NULL,
  `sex_user` tinyint(1) NOT NULL,
  `password_user` varchar(20) NOT NULL,
  `date_user` date NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id_user`, `name_user`, `vorname_user`, `email_user`, `sex_user`, `password_user`, `date_user`) VALUES
(1, 'Bieber', 'Justin', 'bieber@gmail.com', 1, 'Je suis trop beau', '2012-10-23'),
(2, 'Hollande', 'Francois', 'president@gmail.com', 1, 'Le changement c''est ', '2012-10-30'),
(3, 'Fox', 'Megan', 'fox.megan@hotmail.com', 0, 'Sexyyyy', '2012-10-11'),
(8, 'Barack', 'Obama', 'barack@whitehouse.us', 1, 'president', '2012-11-07'),
(10, 'Papa', 'Noel', 'papa.2012@noel.com', 1, 'cadeaux', '2012-11-07');

-- --------------------------------------------------------

--
-- Structure de la table `user_avatar`
--

CREATE TABLE IF NOT EXISTS `user_avatar` (
  `id_avatar` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `url_avatar` varchar(300) NOT NULL,
  `date_avatar` datetime NOT NULL,
  PRIMARY KEY (`id_avatar`),
  KEY `fk_user_id_avatar` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `user_avatar`
--

INSERT INTO `user_avatar` (`id_avatar`, `id_user`, `url_avatar`, `date_avatar`) VALUES
(1, 1, 'justin-bieber-5555115516ds5gfd5s5fds.jpg', '2012-10-22 00:00:00'),
(2, 1, 'images-bieber-sdsdg565655s5.jpg', '2012-10-16 00:00:00'),
(3, 1, 'hqdefault-56955fdg5f6d5h56f5dsh56h5fd56h5.jpg', '2012-10-23 11:00:00'),
(4, 2, 'hollande-mdr-9556565665566554sqffdsqf6556f56ds.jpg', '2012-10-03 00:00:00'),
(5, 2, 'hollande-56545s4dg545sd5g4d5s46546.jpg', '2012-10-23 09:00:00'),
(6, 3, 'megan_fox300a-dsqgds9559dsfgh9f95qdhg59qfsd9.jpg', '2012-10-03 00:00:00'),
(7, 3, 'megan-fox724-sfsdgdshfsd565fd65h56fd.jpg', '2012-10-23 07:46:00'),
(13, 8, 'article_obama.jpg', '2012-11-07 16:49:39'),
(14, 10, 'Jonathan_G_Meath_portrays_Santa_Claus.jpg', '2012-11-07 16:54:46');

-- --------------------------------------------------------

--
-- Structure de la table `user_file`
--

CREATE TABLE IF NOT EXISTS `user_file` (
  `id_file` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `type_file` enum('video','image','music','doc') NOT NULL,
  `desc_file` varchar(300) NOT NULL,
  `keywords_file` varchar(200) NOT NULL,
  `date_file` datetime NOT NULL,
  `url_file` varchar(200) NOT NULL,
  PRIMARY KEY (`id_file`),
  KEY `fk_user_id_file` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `user_file`
--

INSERT INTO `user_file` (`id_file`, `id_user`, `type_file`, `desc_file`, `keywords_file`, `date_file`, `url_file`) VALUES
(1, 3, 'video', 'La nature, c''est tellement beau !', 'nature, eau, herbe', '2012-10-24 05:00:00', 'Nature.mp4'),
(2, 3, 'video', 'Les legos, c''est cooooooll :D', 'lego, construction', '2012-10-24 15:00:00', 'test.ogv'),
(3, 2, 'music', 'Je kiff cette zik !', 'gangnam style, youtube, hit, 2012', '2012-10-24 10:25:19', 'Gangnam_Style.ogg'),
(4, 2, 'image', 'Magnifique...', 'lumia, nokia, wp8, microsoft', '2012-10-24 20:15:00', 'nokia-lumia-920-820-hands-on-07-640x426.jpg');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `user_avatar`
--
ALTER TABLE `user_avatar`
  ADD CONSTRAINT `fk_user_id_avatar` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Contraintes pour la table `user_file`
--
ALTER TABLE `user_file`
  ADD CONSTRAINT `fk_user_id_file` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
