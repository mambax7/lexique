-- --------------------------------------------------------

-- 
-- Structure de la table `lex_access`
-- 

CREATE TABLE `lex_access` (
  `idLexique` bigint(20) NOT NULL default '0',
  `idGroup` bigint(20) NOT NULL default '0',
  `isDefine` tinyint(1) NOT NULL default '1',
  `buttonAccess` int(11) NOT NULL default '195',
  `readButtonsTlb`  BIGINT NOT NULL DEFAULT '0',
  `readAccessList` bigint(20) NOT NULL default '0',
  `readPropertyList` bigint(20) NOT NULL default '0',
  `readButtonsList` BIGINT NOT NULL DEFAULT '0',
  `readAccessForm` bigint(20) NOT NULL default '0',
  `readPropertyForm` bigint(20) NOT NULL default '0',
  `readButtonsForm` BIGINT NOT NULL DEFAULT '0',
  `showOption` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`idLexique`,`idGroup`)
) TYPE=MyISAM;


-- 
-- Contenu de la table `lex_access`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `lex_caption`
-- 

CREATE TABLE `lex_caption` (
  `idCaption` bigint(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY  (`idCaption`)
) TYPE=MyISAM;

-- 
-- Contenu de la table `lex_caption`
-- 

INSERT INTO `lex_caption` (`idCaption`, `name`) VALUES 
(0, 'Default'),
(1, 'test'),
(2, 'Livres'),
(3, 'repertoire'),
(4, 'rrrrrrrrrrr'),
(5, 'Titre'),
(6, 'Titre');

-- --------------------------------------------------------

-- 
-- Structure de la table `lex_captionset`
-- 

CREATE TABLE `lex_captionset` (
  `idCaption` bigint(20) NOT NULL,
  `code` varchar(50) NOT NULL,
  `newText` varchar(200) NOT NULL,
  `state` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`idCaption`,`code`)
) TYPE=MyISAM;

-- 
-- Contenu de la table `lex_captionset`
-- 

INSERT INTO `lex_captionset` (`idCaption`, `code`, `newText`, `state`) VALUES 
(0, 'categories', 'CATEGORYS', 1),
(0, 'category', 'CATEGORY', 0),
(0, 'definition1', 'DEFINITION1', 1),
(0, 'definition2', 'DEFINITION2', 1),
(0, 'definition3', 'DEFINITION3', 1),
(0, 'definitions1', 'DEFS1', 0),
(0, 'definitions2', 'DEFS2', 0),
(0, 'definitions3', 'DEFS3', 0),
(0, 'lesDefinitions1', 'DEFINITIONS1', 0),
(0, 'lesDefinitions2', 'DEFINITIONS2', 0),
(0, 'lesDefinitions3', 'DEFINITIONS3', 0),
(0, 'lexique', 'LEXIQUE', 1),
(0, 'properties', 'PROPERTYS', 0),
(0, 'property', 'PROPERTY', 0),
(0, 'referentiel', 'REFERENCIEL_TITLE1', 1),
(0, 'seealso', 'SEEALSO2', 1),
(0, 'shortdef', 'SHORTDEF2', 1),
(0, 'terme', 'TERME2', 1),
(0, 'termesAndDefinitions', 'TERMEANDDEFINITIONS', 0),
(0, 'follow', 'Lire la suite...', 1),
(1, 'categories', 'AAA', 0),
(1, 'category', 'BBB', 0),
(1, 'definition1', 'CCC', 0),
(1, 'definition2', 'DDD', 0),
(1, 'definition3', 'EEE', 0),
(1, 'definitions1', 'FFF', 0),
(1, 'definitions2', 'GGG', 0),
(1, 'definitions3', 'HHH', 0),
(1, 'lesDefinitions1', 'III', 0),
(1, 'lesDefinitions2', 'JJJ', 0),
(1, 'lesDefinitions3', 'KKK', 0),
(1, 'lexique', 'LLL', 0),
(1, 'properties', 'MMM', 0),
(1, 'property', 'NNN', 0),
(1, 'referentiel', 'OOO', 0),
(1, 'seealso', 'PPP', 0),
(1, 'shortdef', 'QQQ', 0),
(1, 'terme', 'RRR', 0),
(1, 'termesAndDefinitions', 'SSS', 0),
(2, 'categories', '', 0),
(2, 'definition1', '', 0),
(2, 'definition2', '', 0),
(2, 'definition3', '', 0),
(2, 'lexique', 'Bibliothèque', 0),
(2, 'referentiel', '', 0),
(2, 'seealso', '', 0),
(2, 'shortdef', 'Auteur', 0),
(2, 'terme', 'Titre', 0),
(3, 'categories', 'Nationamités', 0),
(3, 'category', 'Nationamité', 0),
(3, 'definition1', '', 0),
(3, 'definition2', '', 0),
(3, 'definition3', '', 0),
(3, 'definitions1', '', 0),
(3, 'definitions2', '', 0),
(3, 'definitions3', '', 0),
(3, 'lesDefinitions1', '', 0),
(3, 'lesDefinitions2', '', 0),
(3, 'lesDefinitions3', '', 0),
(3, 'lexique', 'Répertoire', 0),
(3, 'properties', '', 0),
(3, 'property', '', 0),
(3, 'referentiel', 'Référentiel', 0),
(3, 'seealso', 'Consulter aussi', 0),
(3, 'shortdef', 'Discipline', 0),
(3, 'terme', 'Nom', 0),
(3, 'termesAndDefinitions', '', 0),
(4, 'categories', 'hhhhhhhhhhhh', 0),
(4, 'category', '', 0),
(4, 'definition1', '', 0),
(4, 'definition2', '', 0),
(4, 'definition3', '', 0),
(4, 'definitions1', '', 0),
(4, 'definitions2', '', 0),
(4, 'definitions3', '', 0),
(4, 'lesDefinitions1', '', 0),
(4, 'lesDefinitions2', '', 0),
(4, 'lesDefinitions3', '', 0),
(4, 'lexique', '', 0),
(4, 'properties', '', 0),
(4, 'property', '', 0),
(4, 'referentiel', 'hhhhhhhhhh', 0),
(4, 'seealso', '', 0),
(4, 'shortdef', '', 0),
(4, 'terme', '', 0),
(4, 'termesAndDefinitions', '', 0),
(5, 'categories', 'ghghghgh', 0),
(5, 'category', '', 0),
(5, 'definition1', '', 0),
(5, 'definition2', 'blabla', 0),
(5, 'definition3', '', 0),
(5, 'definitions1', '', 0),
(5, 'definitions2', '', 0),
(5, 'definitions3', '', 0),
(5, 'lesDefinitions1', '', 0),
(5, 'lesDefinitions2', '', 0),
(5, 'lesDefinitions3', '', 0),
(5, 'lexique', '', 0),
(5, 'properties', '', 0),
(5, 'property', '', 0),
(5, 'referentiel', '', 0),
(5, 'seealso', '', 0),
(5, 'shortdef', '', 0),
(5, 'terme', '', 0),
(5, 'termesAndDefinitions', '', 0),
(6, 'categories', 'zzz', 0),
(6, 'definition1', '', 0),
(6, 'definition2', '', 0),
(6, 'definition3', '', 0),
(6, 'lexique', '', 0),
(6, 'referentiel', '', 0),
(6, 'seealso', '', 0),
(6, 'shortdef', '', 0),
(6, 'terme', '', 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `lex_category`
-- 

CREATE TABLE `lex_category` (
  `idFamily` bigint(12) NOT NULL default '0',
  `idCategory` bigint(12) NOT NULL default '0',
  `idBin` bigint(18) NOT NULL,
  `name` varchar(50) NOT NULL default '',
  `state` int(1) NOT NULL default '0',
  `showOrder` int(3) NOT NULL default '0',
  PRIMARY KEY  (`idFamily`,`idCategory`),
  KEY `showorder` (`showOrder`)
) TYPE=MyISAM;

-- 
-- Contenu de la table `lex_category`
-- 

INSERT INTO `lex_category` (`idFamily`, `idCategory`, `idBin`, `name`, `state`, `showOrder`) VALUES 
(1, 6, 64, 'Educatifs', 1, 60),
(1, 7, 128, 'Equipement', 1, 70),
(1, 8, 256, 'Ecole', 1, 80),
(1, 9, 512, '', 1, 90),
(1, 10, 1024, '', 1, 100),
(1, 11, 2048, '', 1, 110),
(1, 12, 4096, '', 1, 120),
(1, 13, 8192, '', 1, 130),
(1, 14, 16384, '', 1, 140),
(1, 15, 32768, '', 1, 150),
(1, 16, 65536, '', 1, 160),
(1, 17, 131072, '', 1, 170),
(1, 18, 262144, '', 1, 180),
(1, 19, 524288, '', 1, 190),
(1, 20, 1048576, '', 1, 200),
(1, 21, 2097152, '', 1, 210),
(1, 22, 4194304, '', 1, 220),
(1, 23, 8388608, '', 1, 230),
(1, 24, 16777216, '', 1, 240),
(1, 25, 33554432, '', 1, 250),
(1, 26, 67108864, '', 1, 260),
(1, 27, 134217728, '', 1, 270),
(1, 28, 268435456, '', 1, 280),
(1, 29, 536870912, '', 1, 290),
(1, 30, 1073741824, '', 1, 300),
(3, 28, 268435456, '', 1, 280),
(3, 27, 134217728, '', 1, 270),
(3, 26, 67108864, '', 1, 260),
(3, 25, 33554432, '', 1, 250),
(3, 24, 16777216, '', 1, 240),
(3, 23, 8388608, '', 1, 230),
(3, 22, 4194304, '', 1, 220),
(3, 21, 2097152, '', 1, 210),
(3, 20, 1048576, '', 1, 200),
(3, 19, 524288, '', 1, 190),
(3, 18, 262144, '', 1, 180),
(3, 17, 131072, '', 1, 170),
(3, 16, 65536, '', 1, 160),
(3, 15, 32768, '', 1, 150),
(3, 14, 16384, '', 1, 140),
(3, 13, 8192, '', 1, 130),
(3, 12, 4096, '', 1, 120),
(3, 11, 2048, '', 1, 110),
(3, 10, 1024, '', 1, 100),
(3, 9, 512, '', 1, 90),
(3, 8, 256, '', 1, 80),
(3, 7, 128, '', 1, 70),
(3, 6, 64, '', 1, 60),
(3, 5, 32, '', 1, 50),
(3, 4, 16, '', 1, 40),
(3, 3, 8, 'Medecin', 1, 30),
(3, 2, 4, 'Reporter', 1, 20),
(3, 1, 2, 'Sportif', 1, 10),
(3, 0, 1, 'Ecrivain', 1, 0),
(2, 0, 1, 'Française', 1, 0),
(2, 1, 2, 'Anglaise', 1, 10),
(2, 2, 4, 'Japonaise', 1, 20),
(2, 3, 8, 'Chinoise', 1, 30),
(2, 4, 16, 'Allemande', 1, 40),
(2, 5, 32, 'Espagnole', 1, 50),
(2, 6, 64, 'Italienne', 1, 60),
(2, 7, 128, 'Russe', 1, 70),
(2, 8, 256, 'Americaine', 1, 80),
(2, 9, 512, 'Algerienne', 1, 90),
(2, 10, 1024, 'Israelite', 1, 100),
(2, 11, 2048, '', 1, 110),
(2, 12, 4096, '', 1, 120),
(2, 13, 8192, '', 1, 130),
(2, 14, 16384, '', 1, 140),
(2, 15, 32768, '', 1, 150),
(2, 16, 65536, '', 1, 160),
(2, 17, 131072, '', 1, 170),
(2, 18, 262144, '', 1, 180),
(2, 19, 524288, '', 1, 190),
(2, 20, 1048576, '', 1, 200),
(2, 21, 2097152, '', 1, 210),
(2, 22, 4194304, '', 1, 220),
(2, 23, 8388608, '', 1, 230),
(2, 24, 16777216, '', 1, 240),
(2, 25, 33554432, '', 1, 250),
(2, 26, 67108864, '', 1, 260),
(2, 27, 134217728, '', 1, 270),
(2, 28, 268435456, '', 1, 280),
(2, 29, 536870912, '', 1, 290),
(2, 30, 1073741824, '', 1, 300),
(2, 31, 2147483648, 'Umpaumpa', 1, 310),
(4, 0, 1, 'livre', 1, 0),
(4, 1, 2, 'Journal', 1, 10),
(4, 2, 4, 'Film', 1, 20),
(4, 3, 8, 'Cd ou DVD', 1, 30),
(4, 4, 16, 'Catalogue', 1, 40),
(4, 5, 32, '', 1, 50),
(4, 6, 64, '', 1, 60),
(4, 7, 128, '', 1, 70),
(4, 8, 256, '', 1, 80),
(4, 9, 512, '', 1, 90),
(4, 10, 1024, '', 1, 100),
(4, 11, 2048, '', 1, 110),
(4, 12, 4096, '', 1, 120),
(4, 13, 8192, '', 1, 130),
(4, 14, 16384, '', 1, 140),
(4, 15, 32768, '', 1, 150),
(4, 16, 65536, '', 1, 160),
(4, 17, 131072, '', 1, 170),
(4, 18, 262144, '', 1, 180),
(4, 19, 524288, '', 1, 190),
(4, 20, 1048576, '', 1, 200),
(4, 21, 2097152, '', 1, 210),
(4, 22, 4194304, '', 1, 220),
(4, 23, 8388608, '', 1, 230),
(4, 24, 16777216, '', 1, 240),
(4, 25, 33554432, '', 1, 250),
(4, 26, 67108864, '', 1, 260),
(4, 27, 134217728, '', 1, 270),
(4, 28, 268435456, '', 1, 280),
(4, 29, 536870912, '', 1, 290),
(4, 30, 1073741824, '', 1, 300),
(4, 31, 2147483648, '', 1, 310),
(3, 29, 536870912, '', 1, 290),
(3, 30, 1073741824, '', 1, 300),
(3, 31, 2147483648, '', 1, 310),
(1, 31, 2147483648, '', 1, 310),
(1, 0, 1, 'Technique', 1, 0),
(1, 1, 2, 'Bases', 1, 10),
(1, 2, 4, 'Kata', 1, 20),
(1, 3, 8, 'Etiquette', 1, 30),
(1, 4, 16, 'Histoire', 1, 40),
(1, 5, 32, 'Philosophie', 1, 50);

-- --------------------------------------------------------

-- 
-- Structure de la table `lex_family`
-- 

CREATE TABLE `lex_family` (
  `idFamily` bigint(12) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default 'Famille',
  `maxCount` int(2) NOT NULL default '8',
  PRIMARY KEY  (`idFamily`)
) TYPE=MyISAM;

-- 
-- Contenu de la table `lex_family`
-- 

INSERT INTO `lex_family` (`idFamily`, `name`, `maxCount`) VALUES 
(1, 'Discipline', 32),
(2, 'Nationalite', 32),
(3, 'Metier', 32),
(4, 'Media', 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `lex_lexique`
-- 

CREATE TABLE `lex_lexique` (
  `idLexique` bigint(12) unsigned NOT NULL auto_increment,
  `idFamily` bigint(12) unsigned NOT NULL default '0',
  `idSelecteur` bigint(12) NOT NULL,
  `idCaption` bigint(20) NOT NULL default '0',
  `idProperty` bigint(20) NOT NULL,
  `name` varchar(50) NOT NULL default '',
  `icone` varchar(30) NOT NULL default 'livre1.gif',
  `introtext` text NOT NULL,
  `actif` smallint(1) NOT NULL default '1',
  `ordre` smallint(1) NOT NULL default '0',
  `nbmsgbypage` int(11) NOT NULL default '10',
  `searchSeeAlsoMode` int(11) NOT NULL default '0',
  `detailShowShortDef` tinyint(4) NOT NULL default '1',
  `detailShowDefinition` tinyint(4) NOT NULL default '1',
  `detailShowInterligne` tinyint(4) NOT NULL default '0',
  `detailShowButtons` int(11) NOT NULL default '255',
  `detailShowProperty` tinyint(4) NOT NULL default '0',
  `seealsomode` tinyint(4) NOT NULL default '0',
  `synchroniseterme` tinyint(4) NOT NULL default '0',
  `detailShowSeeAlso` int(11) NOT NULL default '0',
  `detailSeeAlsoShowing` int(11) NOT NULL default '0',
  `intlinksicon` tinyint(4) NOT NULL default '1',
  `iconolink` int(11) NOT NULL default '6',
  `icolink` int(11) NOT NULL default '5',
  `icoref` tinyint(4) NOT NULL default '3',
  `icosize` tinyint(4) NOT NULL default '1',
  `intlinkspopup` tinyint(4) NOT NULL default '1',
  `intlinksheight` int(11) NOT NULL default '420',
  `intlinkswidth` int(11) NOT NULL default '350',
  `nbtermebypage` int(11) NOT NULL default '10',
  `detailSeeAlsoCache` tinyint(4) NOT NULL default '1',
  `detailGererVisit` tinyint(4) NOT NULL default '0',
  `showcategory` tinyint(4) NOT NULL default '1',
  `buttonPosition` tinyint(4) NOT NULL default '0',
  `intautosubmit` tinyint(4) NOT NULL default '1',
  `anonpost` tinyint(4) NOT NULL default '1',
  `sendmail2webmaster` tinyint(4) NOT NULL default '1',
  `mail4webmaster` varchar(50) NOT NULL default 'jjd@kiolo.com',
  `xoopsSearch` bigint(20) NOT NULL default '3',
  `dateCreation` datetime default NULL,
  `dateModification` datetime default NULL,
  `dateState` int(10) unsigned default '0',
  `noteMin` int(10) unsigned default '0',
  `noteMax` int(10) unsigned default '0',
  `noteImg` varchar(255) default NULL,
  `noteCount` int(10) unsigned default '0',
  `noteSum` int(10) unsigned default '0',
  `noteAverage` float default '0',
  `termeNoteMin` int(10) unsigned default '0',
  `termeNoteMax` int(10) unsigned default '0',
  `termeNoteImg` varchar(255) default NULL,
  `followPosition` tinyint DEFAULT '0' NOT NULL, 
  `editor`    tinyint(1) default '99',  
  `dooptions` tinyint(1) default '0',        
  `dohtml`    tinyint(1) default '1',  
  `dosmiley`  tinyint(1) default '1',  
  `doxcode`   tinyint(1) default '1',  
  `doimage`   tinyint(1) default '1',  
  `dobr`      tinyint(1) default '1', 
PRIMARY KEY  (`idLexique`),
  KEY `idCaption` (`idCaption`)
) TYPE=MyISAM;


-- --------------------------------------------------------

-- 
-- Structure de la table `lex_list`
-- 

CREATE TABLE `lex_list` (
  `idList` bigint(20) NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `items` longtext,
  `killable` int(10) unsigned default '0',
  `sorth` int(10) unsigned default '0',
  PRIMARY KEY  (`idList`)
) TYPE=MyISAM;

-- 
-- Contenu de la table `lex_list`
-- 

INSERT INTO `lex_list` (`idList`, `name`, `items`, `killable`, `sorth`) VALUES 
(1, 'zzzzzzzzzzz', '321;654;987;yyy', 1, 0),
(2, 'OuiNon', 'Oui;Non', 1, 0),
(3, 'zzzzzzzzzzzzz', 'zzzzzzz\r\nrrrr', 1, 0),
(4, 'OOOOOOOOOOO', ';aaa;eee;rrr;gggrrr;eee;eee', 1, 0),
(5, 'Régions', 'Ile de france\r\nNord Pas de Calais\r\nHaute Normandie\r\nChampagne\r\nAlsace\r\nBourgogne\r\nFranche-Comté\r\nPoitou-Charentes\r\nAuvergne\r\nRhones Alpes\r\nAquitaine\r\nMidi-Pyrénées\r\nLanguedoc-Rouissillon\r\nProvence\r\nPays de la Loire\r\nNouvelle Calédonie\r\nLorraine\r\nCôte d''Azur', 1, 0);


-- --------------------------------------------------------

-- 
-- Structure de la table `lex_property`
-- 

CREATE TABLE `lex_property` (
  `idProperty` bigint(20) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`idProperty`)
) TYPE=MyISAM;

-- 
-- Contenu de la table `lex_property`
-- 

INSERT INTO `lex_property` (`idProperty`, `name`) VALUES 
(1, 'articles'),
(0, ''),
(7, 'personnes'),
(28, 'zzzzzzzzzzzzz');

-- --------------------------------------------------------

-- 
-- Structure de la table `lex_propertyset`
-- 

CREATE TABLE `lex_propertyset` (
  `idPropertySet` bigint(20) NOT NULL auto_increment,
  `idProperty` bigint(20) NOT NULL default '0',
  `idList` bigint(20) NOT NULL,
  `name` varchar(50) NOT NULL default '',
  `dataType` tinyint(4) NOT NULL default '0',
  `rowSeparator` tinyint(4) NOT NULL default '0',
  `showOrder` int(4) NOT NULL default '99',
  `state` tinyint(4) NOT NULL default '1',
  `byteAccess` int(11) NOT NULL default '0',
  PRIMARY KEY  (`idPropertySet`),
  KEY `idProperty` (`idProperty`)
) TYPE=MyISAM;

-- 
-- Contenu de la table `lex_propertyset`
-- 

INSERT INTO `lex_propertyset` (`idPropertySet`, `idProperty`, `idList`, `name`, `dataType`, `rowSeparator`, `showOrder`, `state`, `byteAccess`) VALUES 
(5, 1, 0, 'Langue', 0, 0, 99, 1, 2),
(4, 1, 2, 'Disponibilité', 0, 0, 10, 1, 0),
(3, 1, 0, 'Note', 0, 0, 99, 1, 3),
(2, 1, 0, 'Editeur', 0, 0, 99, 1, 1),
(1, 1, 0, 'prix', 0, 0, 200, 1, 5),
(72, 1, 0, 'ISBN', 0, 0, 127, 1, 4),
(76, 7, 0, 'Période', 0, 0, 100, 1, 1),
(69, 7, 0, 'ttttttttttttttttttttt''rrr', 0, 0, 101, 1, 2),
(68, 7, 0, 'ae''rrrrrrrrrrrrrrrrrr', 0, 0, 99, 1, 0),
(78, 1, 0, 'Disponibilité', 1, 0, 210, 1, 6),
(79, 1, 0, 'prix', 0, 0, 220, 1, 7),
(80, 7, 0, 'aaa', 0, 0, 109, 1, 3),
(81, 7, 0, 'zzzz', 0, 2, 119, 1, 4),
(82, 7, 0, 'eee', 0, 0, 129, 1, 5),
(83, 7, 0, 'rrrr', 0, 2, 139, 1, 6),
(84, 7, 0, 'tttt', 0, 0, 149, 1, 7),
(85, 7, 0, 'yyyy', 0, 0, 159, 1, 8),
(86, 7, 0, 'uuuuu', 0, 0, 169, 1, 9),
(87, 7, 0, 'iiii', 0, 1, 179, 1, 10),
(88, 7, 0, 'complément d''ddddddddd', 0, 0, 189, 1, 11),
(89, 7, 0, 'zzzzz''zzzz''zzzzz', 0, 0, 199, 1, 12),
(90, 1, 0, 'site éditeur', 3, 0, 230, 1, 8),
(91, 28, 1, 'aaaaaaaaa', 0, 0, 0, 1, 0),
(92, 28, 2, 'zzzzzzz', 0, 0, 10, 1, 1),
(93, 28, 4, 'xxxxxxxxxxxxxx', 0, 0, 20, 1, 2),
(94, 1, 4, 'aaaaaaaaaarrrrr', 0, 0, 12, 1, 9),
(95, 1, 1, 'zzzzzzzzzzzzzzzz', 0, 0, 14, 1, 10),
(96, 1, 5, 'Regions', 0, 0, 240, 1, 11);

-- --------------------------------------------------------

-- 
-- Structure de la table `lex_propertyval`
-- 

CREATE TABLE `lex_propertyval` (
  `idProperty` bigint(20) NOT NULL,
  `idLexique` bigint(12) unsigned NOT NULL,
  `idPropertySet` bigint(20) NOT NULL default '0',
  `idTerme` bigint(12) unsigned NOT NULL,
  `value` varchar(255) NOT NULL default '',
  KEY `idPropertySet` (`idPropertySet`,`idTerme`)
) TYPE=MyISAM;

-- 
-- Contenu de la table `lex_propertyval`
-- 

INSERT INTO `lex_propertyval` (`idProperty`, `idLexique`, `idPropertySet`, `idTerme`, `value`) VALUES 
(0, 0, 72, 3, ''),
(0, 0, 2, 3, 'ggggggggggggg'),
(0, 0, 3, 3, 'ggggggggggg'),
(0, 0, 87, 1347, ''),
(0, 0, 1, 1354, '888'),
(0, 0, 78, 1340, ''),
(0, 0, 90, 1357, ''),
(0, 0, 79, 1357, '999'),
(0, 0, 5, 3, 'gggggggggggggg'),
(0, 0, 4, 3, 'ggggggggggg'),
(0, 0, 86, 1347, ''),
(0, 0, 78, 1357, 'ssssssssssss'),
(0, 0, 1, 1357, '888zzzzzzzzz'),
(0, 0, 72, 1354, ''),
(0, 0, 3, 1354, ''),
(0, 0, 5, 1354, ''),
(0, 0, 2, 1354, ''),
(0, 0, 95, 1354, '654'),
(0, 0, 68, 1360, ' uuuuuuuuuuuuuuuu'),
(0, 0, 76, 1360, ' '),
(0, 0, 69, 1360, ' '),
(0, 0, 94, 1354, 'aaa'),
(0, 0, 4, 1354, 'Non'),
(0, 0, 84, 1347, ''),
(0, 0, 85, 1347, 'jjjjjjjjj-hhhhhhhhhhhhhh-hhhhhhhhhhhhhhhhhhhh-hhhhhhhhhhhhhh-hhhhhhhhhhh'),
(0, 0, 83, 1347, ''),
(0, 0, 82, 1347, ''),
(0, 0, 81, 1347, 'wazertu000000000000000000'),
(0, 0, 80, 1347, 'zzzzzzzzzzzzzzzzzzz'),
(0, 0, 69, 1347, 'daîto ryu'),
(0, 0, 76, 1347, '1657 - 1695'),
(0, 0, 88, 1346, ''),
(0, 0, 87, 1346, ''),
(0, 0, 86, 1346, ''),
(0, 0, 85, 1346, ''),
(0, 0, 84, 1346, ''),
(0, 0, 83, 1346, 'oooooooooooooo'),
(0, 0, 82, 1346, ''),
(0, 0, 80, 1346, ''),
(0, 0, 81, 1346, ''),
(0, 0, 69, 1346, 'oooooooooooooooooooooo'),
(0, 0, 76, 1346, ''),
(0, 0, 68, 1346, ''),
(0, 0, 68, 1347, 'francaise'),
(0, 0, 1, 1340, ''),
(0, 0, 72, 1340, ''),
(0, 0, 3, 1340, ''),
(0, 0, 5, 1340, ''),
(0, 0, 2, 1340, ''),
(0, 0, 95, 1340, 'yyy'),
(0, 0, 94, 1340, 'eee'),
(0, 0, 4, 1340, 'Oui'),
(0, 0, 89, 1346, 'opppmmmmmmmmmmmmmmmmmmmmmm'),
(0, 0, 88, 1347, ''),
(0, 0, 89, 1347, ''),
(0, 0, 1, 3, 'hhhhhhhhhhhhhhhhhhhhhh'),
(0, 0, 78, 3, ''),
(0, 0, 79, 3, ''),
(0, 0, 72, 1357, ''),
(0, 0, 3, 1357, ''),
(0, 0, 5, 1357, ''),
(0, 0, 2, 1357, ''),
(0, 0, 4, 338, 'Non'),
(0, 0, 94, 338, 'gggrrr'),
(0, 0, 2, 338, ''),
(0, 0, 5, 338, ''),
(0, 0, 3, 338, ''),
(0, 0, 72, 338, ''),
(0, 0, 1, 338, ''),
(0, 0, 78, 338, ''),
(0, 0, 79, 338, ''),
(0, 0, 90, 338, ''),
(0, 0, 95, 1357, '654'),
(0, 0, 78, 1354, ''),
(0, 0, 79, 1354, '999'),
(0, 0, 90, 1354, ''),
(0, 0, 79, 1340, ''),
(0, 0, 90, 1340, ''),
(0, 0, 96, 1340, 'Franche-Comté'),
(0, 0, 94, 1357, ''),
(0, 0, 4, 1357, 'Oui'),
(0, 0, 96, 1357, 'Côte d');

-- --------------------------------------------------------

-- 
-- Structure de la table `lex_selecteur`
-- 

CREATE TABLE `lex_selecteur` (
  `idSelecteur` bigint(12) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default 'nom du selecteur',
  `alphabet` varchar(100) NOT NULL default 'ABCDEFGHIJKLMNOPQRSTUVWXZ',
  `other` varchar(5) NOT NULL default '#',
  `showAllLetters` tinyint(1) NOT NULL default '1',
  `frameDelimitor` int(2) NOT NULL default '0',
  `letterSeparator` varchar(8) NOT NULL default '#|#',
  `rows` int(1) NOT NULL default '1',
  PRIMARY KEY  (`idSelecteur`)
) TYPE=MyISAM;

-- 
-- Contenu de la table `lex_selecteur`
-- 

INSERT INTO `lex_selecteur` (`idSelecteur`, `name`, `alphabet`, `other`, `showAllLetters`, `frameDelimitor`, `letterSeparator`, `rows`) VALUES 
(1, 'Standart', 'ABCDEFGHIJKLMNOPQRSTUVWXZ', '#', 1, 0, '#|#', 1),
(6, 'Numérique', '0123456789', '#', 1, 2, '#|#', 1),
(5, 'Minimum', '', '#', 0, 2, '#|#', 1),
(4, 'Alpha numerique', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ_0123456789', '#', 1, 2, '#-#', 1),
(7, 'nom du selecteur', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', '#', 1, 0, '#|#', 1);

-- --------------------------------------------------------

-- 
-- Structure de la table `lex_temp`
-- 

CREATE TABLE `lex_temp` (
  `tbldata` varchar(80) NOT NULL default '',
  `coldata` varchar(80) NOT NULL default '',
  `colid` varchar(80) NOT NULL default '',
  `dataid` bigint(12) NOT NULL default '0',
  `datavalue` text NOT NULL,
  `datatype` int(11) NOT NULL default '0',
  `lastupdate` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`tbldata`,`dataid`,`coldata`)
) TYPE=MyISAM;



-- --------------------------------------------------------

-- 
-- Structure de la table `lex_terme`
-- 

CREATE TABLE `lex_terme` (
  `idTerme` bigint(12) unsigned NOT NULL auto_increment,
  `idLexique` bigint(12) unsigned NOT NULL,
  `idSeeAlso` bigint(20) NOT NULL default '0',
  `letter` char(1) NOT NULL default '',
  `name` varchar(50) NOT NULL default '',
  `shortDef` varchar(255) NOT NULL,
  `definition1` text NOT NULL,
  `definition2` text NOT NULL,
  `definition3` text NOT NULL,
  `seealso` varchar(255) NOT NULL default '',
  `seeAlsoList` varchar(255) NOT NULL,
  `seealsostatus` smallint(1) NOT NULL default '1',
  `state` char(1) NOT NULL default 'D',
  `comments` smallint(5) unsigned NOT NULL default '0',
  `categoryBin` bigint(32) NOT NULL default '0',
  `category` varchar(32) NOT NULL default '',
  `visit` bigint(12) NOT NULL default '0',
  `reference` tinyint(4) NOT NULL default '0',
  `templink` longtext NOT NULL,
  `tempCategory` longtext NOT NULL,
  `user` varchar(50) NOT NULL,
  `userTS` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `dateCreation` datetime default NULL,
  `dateModification` datetime default NULL,
  `dateState` int(10) unsigned default '0',
  `noteCount` int(8) unsigned default '0',
  `noteSum` int(8) unsigned default '0',
  `noteAverage` float default '0',
  `dooptions` tinyint(1) default '0',  
  `dohtml`    tinyint(1) default '1',  
  `dosmiley`  tinyint(1) default '1',  
  `doxcode`   tinyint(1) default '1',  
  `doimage`   tinyint(1) default '1',  
  `dobr`      tinyint(1) default '1', 
  PRIMARY KEY  (`idTerme`),
  KEY `letter` (`letter`),
  KEY `name` (`name`),
  KEY `category` (`categoryBin`),
  KEY `isSeeAlso` (`idSeeAlso`),
  FULLTEXT KEY `search` (`name`,`definition1`)
) TYPE=MyISAM;

