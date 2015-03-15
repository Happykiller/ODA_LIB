--
-- Structure de la table `tab_livres`
--

CREATE TABLE IF NOT EXISTS `tab_livres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(250) NOT NULL,
  `date_parution` date NOT NULL,
  `apercu` varchar(255) NOT NULL,
  `resume` text NOT NULL,
  `fichier_ebook` varchar(250) NOT NULL,
  `donateur` varchar(250) NOT NULL,
  `date_entree_lib` date NOT NULL,
  `actif` int(2) NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_motif` datetime NOT NULL,
  PRIMARY KEY (`id`)
);

--
-- Structure de la table `tab_tags`
--

CREATE TABLE IF NOT EXISTS `tab_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_livre` int(11) NOT NULL,
  `tag` varchar(250) NOT NULL,
  `date_creation` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_livre` (`id_livre`,`tag`)
);

--
-- Structure de la table `tab_reservations`
--

CREATE TABLE IF NOT EXISTS `tab_reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_livre` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `date_saisie` datetime NOT NULL,
  `date_retrait` datetime NOT NULL,
  `date_retour` datetime NOT NULL,
  `date_annulation` datetime NOT NULL,
  PRIMARY KEY (`id`)
);