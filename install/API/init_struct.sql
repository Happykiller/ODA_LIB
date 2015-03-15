SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `@dbLog@`
--

DELIMITER ;

-- --------------------------------------------------------

--
-- Création de la database
--
create database `@dbLog@` CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Création de l'utilisateur
--
grant all privileges on `@dbLog@`.* to "@dbLog@"@"@dbDomaine@" identified by "@dbPass@";

-- --------------------------------------------------------

--
-- Structure de la table `@dbLog@`.`@prefixeDb@tab_contact`
--

CREATE TABLE IF NOT EXISTS `@dbLog@`.`@prefixeDb@tab_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_enreg` datetime NOT NULL,
  `reponse` varchar(250) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Structure de la table `@dbLog@`.`@prefixeDb@tab_log`
--

CREATE TABLE IF NOT EXISTS `@dbLog@`.`@prefixeDb@tab_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateTime` datetime NOT NULL,
  `type` int(4) NOT NULL,
  `commentaires` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Structure de la table `@dbLog@`.`@prefixeDb@tab_menu`
--

CREATE TABLE IF NOT EXISTS `@dbLog@`.`@prefixeDb@tab_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(250) NOT NULL,
  `Description_courte` varchar(50) NOT NULL,
  `id_categorie` int(5) NOT NULL,
  `Lien` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Structure de la table `@dbLog@`.`@prefixeDb@tab_menu_categorie`
--

CREATE TABLE IF NOT EXISTS `@dbLog@`.`@prefixeDb@tab_menu_categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(50) NOT NULL,
  `ouvert` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Structure de la table `@dbLog@`.`@prefixeDb@tab_menu_rangs_droit`
--

CREATE TABLE IF NOT EXISTS `@dbLog@`.`@prefixeDb@tab_menu_rangs_droit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rang` int(5) NOT NULL,
  `id_menu` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Structure de la table `@dbLog@`.`@prefixeDb@tab_parametres`
--

CREATE TABLE IF NOT EXISTS `@dbLog@`.`@prefixeDb@tab_parametres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `param_name` varchar(50) NOT NULL,
  `param_type` varchar(100) NOT NULL,
  `param_value` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Structure de la table `@dbLog@`.`@prefixeDb@tab_rangs`
--

CREATE TABLE IF NOT EXISTS `@dbLog@`.`@prefixeDb@tab_rangs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `labelle` varchar(250) NOT NULL,
  `indice` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Structure de la table `@dbLog@`.`@prefixeDb@tab_statistiques_site`
--

CREATE TABLE IF NOT EXISTS `@dbLog@`.`@prefixeDb@tab_statistiques_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `code_user` varchar(50) NOT NULL,
  `page` varchar(250) NOT NULL,
  `action` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Structure de la table `@dbLog@`.`@prefixeDb@tab_utilisateurs`
--

CREATE TABLE IF NOT EXISTS `@dbLog@`.`@prefixeDb@tab_utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `code_user` varchar(10) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `profile` int(4) NOT NULL,
  `description` varchar(250) NOT NULL,
  `montrer_aide_ihm` int(2) NOT NULL DEFAULT '1',
  `mail` varchar(100) NOT NULL,
  `actif` int(2) NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modif` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Structure de la table `@dbLog@`.`@prefixeDb@tab_service_mail_dest`
--

CREATE TABLE `@dbLog@`.`@prefixeDb@tab_service_mail` (
  id int(11) NOT NULL AUTO_INCREMENT,
  libelle varchar(100) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `@dbLog@`.`@prefixeDb@tab_service_mail_dest`
--

CREATE TABLE `@dbLog@`.`@prefixeDb@tab_service_mail_dest` (
  id int(11) NOT NULL,
  id_type_mail int(11) NOT NULL,
  code_user varchar(50) NOT NULL,
  nivo varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Relations
--

ALTER TABLE  @dbLog@.`@prefixeDb@tab_menu` ADD INDEX (  `id_categorie` ) ;
ALTER TABLE  @dbLog@.`@prefixeDb@tab_menu_rangs_droit` ADD INDEX (  `id_rang` ) ;
ALTER TABLE  @dbLog@.`@prefixeDb@tab_service_mail_dest` ADD INDEX (  `id_type_mail` ) ;
ALTER TABLE  @dbLog@.`@prefixeDb@tab_utilisateurs` ADD UNIQUE  `code_user` (  `code_user` );
ALTER TABLE  @dbLog@.`@prefixeDb@tab_service_mail_dest` ADD INDEX (  `code_user` ) ;
ALTER TABLE  @dbLog@.`@prefixeDb@tab_statistiques_site` ADD INDEX (  `code_user` ) ;
ALTER TABLE  @dbLog@.`@prefixeDb@tab_rangs` ADD UNIQUE  `indice` (  `indice` );
ALTER TABLE  @dbLog@.`@prefixeDb@tab_utilisateurs` ADD INDEX (  `profile` ) ;

ALTER TABLE  @dbLog@.`@prefixeDb@tab_menu` ADD FOREIGN KEY (  `id_categorie` ) REFERENCES  @dbLog@.`@prefixeDb@tab_menu_categorie` (
`id`
) ON DELETE NO ACTION ON UPDATE NO ACTION ;

ALTER TABLE  @dbLog@.`@prefixeDb@tab_menu_rangs_droit` ADD FOREIGN KEY (  `id_rang` ) REFERENCES  @dbLog@.`@prefixeDb@tab_rangs` (
`indice`
) ON DELETE NO ACTION ON UPDATE NO ACTION ;

ALTER TABLE  @dbLog@.`@prefixeDb@tab_service_mail_dest` ADD FOREIGN KEY (  `id_type_mail` ) REFERENCES  @dbLog@.`@prefixeDb@tab_service_mail` (
`id`
) ON DELETE NO ACTION ON UPDATE NO ACTION ;

ALTER TABLE  @dbLog@.`@prefixeDb@tab_service_mail_dest` ADD FOREIGN KEY (  `code_user` ) REFERENCES  @dbLog@.`@prefixeDb@tab_utilisateurs` (
`code_user`
) ON DELETE NO ACTION ON UPDATE NO ACTION ;

ALTER TABLE  @dbLog@.`@prefixeDb@tab_statistiques_site` ADD FOREIGN KEY (  `code_user` ) REFERENCES  @dbLog@.`@prefixeDb@tab_utilisateurs` (
`code_user`
) ON DELETE NO ACTION ON UPDATE NO ACTION ;

ALTER TABLE  @dbLog@.`@prefixeDb@tab_utilisateurs` ADD FOREIGN KEY (  `profile` ) REFERENCES  @dbLog@.`@prefixeDb@tab_rangs` (
`indice`
) ON DELETE NO ACTION ON UPDATE NO ACTION ;