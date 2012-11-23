-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Ven 23 Novembre 2012 à 21:59
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
('2490a102ec4a6b5e424b3679432e520f', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/536.11 (KHTML, like Gecko) Ubuntu/12.04 Chromium/20.0.1132.47 Chrome/20.0.11', 1353703563, 'a:4:{s:8:"user_obj";s:188:"O:4:"User":7:{s:2:"id";i:12;s:4:"name";s:5:"McFly";s:7:"vorname";s:6:"Johnny";s:5:"email";s:16:"mcfly@unistra.fr";s:3:"sex";s:1:"1";s:8:"password";s:4:"papa";s:4:"date";s:10:"2012-11-23";}";s:12:"is_connected";i:1;s:9:"notif_err";N;s:8:"notif_ok";s:0:"";}');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id_user`, `name_user`, `vorname_user`, `email_user`, `sex_user`, `password_user`, `date_user`) VALUES
(12, 'McFly', 'Johnny', 'mcfly@unistra.fr', 1, 'papa', '2012-11-23');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Contenu de la table `user_avatar`
--

INSERT INTO `user_avatar` (`id_avatar`, `id_user`, `url_avatar`, `date_avatar`) VALUES
(31, 12, 'johnny-halliday_22.jpg', '2012-11-23 18:57:47'),
(32, 12, 'johnnyhallyday.jpg', '2012-11-23 18:57:47'),
(33, 12, 'johnny_hallyday.jpg', '2012-11-23 18:57:47');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

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
