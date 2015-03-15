SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `@dbLog@`
--

--
-- Contenu de la table `@dbLog@`.`@prefixeDb@tab_menu_categorie`
--

INSERT INTO `@dbLog@`.`@prefixeDb@tab_menu_categorie` (`id`, `Description`) VALUES
(1, 'L''accueil'),
(2, 'Administration'),
(3, 'Gestion'),
(4, 'Rapports');

--
-- Contenu de la table `@dbLog@`.`@prefixeDb@tab_menu`
-- Réservé 1-20 API
--

INSERT INTO `@dbLog@`.`@prefixeDb@tab_menu` (`id`, `Description`, `Description_courte`, `id_categorie`, `Lien`) VALUES
(1, 'L''accueil', 'L''accueil', 1, 'page_home.html'),
(2, 'Contact', 'Contact', 1, 'page_contact.html'),
(3, 'FAQ', 'FAQ', 1, 'page_faq.html'),
(4, 'Statistiques', 'Statistiques', 2, 'page_stats.html');

--
-- Réserve un plage de tag pour le système
--
ALTER TABLE `@dbLog@`.`@prefixeDb@tab_menu` AUTO_INCREMENT = 100;

--
-- Contenu de la table `@dbLog@`.`@prefixeDb@tab_rangs`
--

INSERT INTO `@dbLog@`.`@prefixeDb@tab_rangs` (`id`, `labelle`, `indice`) VALUES
(1, 'Visiteur', 99),
(2, 'Dieu', 1),
(3, 'Superviseur', 10),
(4, 'Responsable', 20),
(5, 'Collaborateur', 30);

--
-- Contenu de la table `@dbLog@`.`@prefixeDb@tab_menu_rangs_droit`
--

INSERT INTO `@dbLog@`.`@prefixeDb@tab_menu_rangs_droit` (`id`, `id_rang`, `id_menu`) VALUES
(1, 1, ';1;2;3;4;'),
(2, 10, ';1;2;3;'),
(3, 20, ';1;2;3;'),
(4, 30, ';1;2;3;'),
(5, 99, ';1;2;3;');

--
-- Contenu de la table `@dbLog@`.`@prefixeDb@tab_parametres`
--

INSERT INTO `@dbLog@`.`@prefixeDb@tab_parametres` (`id`, `param_name`, `param_type`, `param_value`) VALUES
(1, 'nom_site', 'varchar', 'Lab Oda'),
(2, 'maintenance', 'int', '0');

--
-- Contenu de la table `@dbLog@`.`@prefixeDb@tab_utilisateurs`
--

INSERT INTO `@dbLog@`.`@prefixeDb@tab_utilisateurs` (`id`, `login`, `password`, `code_user`, `nom`, `prenom`, `profile`, `montrer_aide_ihm`, `mail`, `actif`) VALUES
(1, 'FRO', 'hunter', 'FRO', 'Rosito', 'Fabrice', 1, 0, 'fabrice.rosito@gmail.com', 1);

--
-- Contenu de la table `@dbLog@`.`@prefixeDb@tab_statistiques_site`
--

INSERT INTO `@dbLog@`.`@prefixeDb@tab_statistiques_site` (`id`, `date`, `code_user`, `page`, `action`) VALUES
(1, '2013-05-29 10:30:35', 'fro', 'index.html', 'letMeIn : ok');