-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 179.188.16.165
-- Generation Time: 23-Maio-2022 às 19:20
-- Versão do servidor: 5.7.32-35-log
-- PHP Version: 5.6.40-0+deb8u12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sitebase2022`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_address`
--

CREATE TABLE `phpwcms_address` (
  `address_id` int(11) NOT NULL,
  `address_key` varchar(255) COLLATE latin1_bin DEFAULT '',
  `address_email` text COLLATE latin1_bin,
  `address_name` text COLLATE latin1_bin,
  `address_verified` int(1) DEFAULT '0',
  `address_tstamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `address_subscription` blob,
  `address_iddetail` int(11) DEFAULT '0',
  `address_url1` varchar(255) COLLATE latin1_bin DEFAULT '',
  `address_url2` varchar(255) COLLATE latin1_bin DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_ads_campaign`
--

CREATE TABLE `phpwcms_ads_campaign` (
  `adcampaign_id` int(11) NOT NULL,
  `adcampaign_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `adcampaign_changed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `adcampaign_status` int(1) NOT NULL DEFAULT '0',
  `adcampaign_title` varchar(255) COLLATE latin1_bin NOT NULL DEFAULT '',
  `adcampaign_comment` text COLLATE latin1_bin NOT NULL,
  `adcampaign_datestart` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `adcampaign_dateend` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `adcampaign_maxview` int(11) NOT NULL DEFAULT '0',
  `adcampaign_maxclick` int(11) NOT NULL DEFAULT '0',
  `adcampaign_maxviewuser` int(11) NOT NULL DEFAULT '0',
  `adcampaign_curview` int(11) NOT NULL DEFAULT '0',
  `adcampaign_curclick` int(11) NOT NULL DEFAULT '0',
  `adcampaign_curviewuser` int(11) NOT NULL DEFAULT '0',
  `adcampaign_type` int(11) NOT NULL DEFAULT '0',
  `adcampaign_place` int(11) NOT NULL DEFAULT '0',
  `adcampaign_data` mediumtext COLLATE latin1_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_ads_formats`
--

CREATE TABLE `phpwcms_ads_formats` (
  `adformat_id` int(11) NOT NULL,
  `adformat_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `adformat_changed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `adformat_status` int(1) NOT NULL DEFAULT '0',
  `adformat_title` varchar(25) COLLATE latin1_bin NOT NULL DEFAULT '',
  `adformat_width` int(5) NOT NULL DEFAULT '0',
  `adformat_height` int(5) NOT NULL DEFAULT '0',
  `adformat_comment` text COLLATE latin1_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Extraindo dados da tabela `phpwcms_ads_formats`
--

INSERT INTO `phpwcms_ads_formats` (`adformat_id`, `adformat_created`, `adformat_changed`, `adformat_status`, `adformat_title`, `adformat_width`, `adformat_height`, `adformat_comment`) VALUES
(1, '2007-03-19 22:30:42', '2007-03-19 22:30:42', 1, 'Leaderboard', 728, 90, ''),
(2, '2007-03-19 22:30:42', '2007-03-19 22:30:42', 1, 'Banner', 468, 60, ''),
(3, '2007-03-19 22:30:42', '2007-03-19 22:30:42', 1, 'Small Square', 200, 200, ''),
(4, '2007-03-19 22:30:42', '2007-03-19 22:30:42', 1, 'Square', 250, 250, ''),
(5, '2007-03-19 22:30:42', '2007-03-19 22:30:42', 1, 'Medium Rectangle', 300, 250, ''),
(6, '2007-03-19 22:30:42', '2007-03-19 22:30:42', 1, 'Large Rectangle', 336, 280, ''),
(7, '2007-03-19 22:30:42', '2007-03-19 22:30:42', 1, 'Skyscraper', 120, 600, ''),
(8, '2007-03-19 22:30:42', '2007-03-19 22:30:42', 1, 'Wide Skyscraper', 160, 600, ''),
(10, '2007-03-19 22:30:42', '2007-03-19 22:30:42', 1, 'Half Banner', 234, 60, ''),
(11, '2007-03-19 22:30:42', '2007-03-19 22:30:42', 1, 'Square Button', 125, 125, ''),
(12, '2007-03-19 22:30:42', '2007-03-19 22:30:42', 1, 'Small Rectangle', 180, 150, ''),
(13, '2007-03-19 22:30:42', '2007-03-19 22:30:42', 1, 'Vertical Banner', 120, 240, ''),
(14, '2007-03-19 22:30:42', '2007-03-19 22:30:42', 1, 'Mini Square', 120, 120, ''),
(15, '2007-03-19 22:30:42', '2007-03-19 22:30:42', 1, 'Medium Scyscraper', 120, 450, ''),
(16, '2007-03-19 22:30:42', '2007-03-19 22:30:42', 1, 'Micro Bar', 88, 31, ''),
(17, '2007-03-19 22:30:42', '2007-03-19 22:30:42', 1, 'Vertical Rectangle', 240, 400, ''),
(18, '2007-03-19 22:30:42', '2007-03-19 22:30:42', 1, 'Vertical Button', 120, 90, ''),
(19, '2007-03-19 22:30:42', '2007-03-19 22:30:42', 1, 'Half Mini Square', 120, 60, ''),
(20, '2007-03-19 22:30:42', '2007-03-19 22:30:42', 1, 'Half Page Ad', 300, 600, ''),
(21, '2007-03-19 22:30:42', '2007-03-19 22:30:42', 1, 'Universal Flash Layer', 400, 400, ''),
(22, '2007-03-19 22:30:42', '2007-03-19 22:30:42', 1, 'PopUp', 250, 300, ''),
(23, '2007-03-19 22:30:42', '2007-03-19 22:30:42', 1, 'Target Button', 120, 150, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_ads_place`
--

CREATE TABLE `phpwcms_ads_place` (
  `adplace_id` int(11) NOT NULL,
  `adplace_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `adplace_changed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `adplace_status` int(1) NOT NULL DEFAULT '0',
  `adplace_title` varchar(255) COLLATE latin1_bin NOT NULL DEFAULT '',
  `adplace_format` int(11) NOT NULL DEFAULT '0',
  `adplace_width` int(11) NOT NULL DEFAULT '0',
  `adplace_height` int(11) NOT NULL DEFAULT '0',
  `adplace_prefix` varchar(255) COLLATE latin1_bin NOT NULL DEFAULT '',
  `adplace_suffix` varchar(255) COLLATE latin1_bin NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_ads_tracking`
--

CREATE TABLE `phpwcms_ads_tracking` (
  `adtracking_id` int(11) NOT NULL,
  `adtracking_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `adtracking_campaignid` int(11) NOT NULL DEFAULT '0',
  `adtracking_ip` varchar(30) COLLATE latin1_bin NOT NULL DEFAULT '',
  `adtracking_cookieid` varchar(50) COLLATE latin1_bin NOT NULL DEFAULT '',
  `adtracking_countclick` int(11) NOT NULL DEFAULT '0',
  `adtracking_countview` int(11) NOT NULL DEFAULT '0',
  `adtracking_useragent` varchar(255) COLLATE latin1_bin NOT NULL DEFAULT '',
  `adtracking_ref` text COLLATE latin1_bin NOT NULL,
  `adtracking_catid` int(11) NOT NULL DEFAULT '0',
  `adtracking_articleid` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_article`
--

CREATE TABLE `phpwcms_article` (
  `article_id` int(11) NOT NULL,
  `article_cid` int(11) DEFAULT '0',
  `article_tid` int(11) DEFAULT '0',
  `article_uid` int(11) DEFAULT '0',
  `article_tstamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `article_username` varchar(255) COLLATE latin1_bin DEFAULT '',
  `article_title` text COLLATE latin1_bin,
  `article_alias` varchar(255) COLLATE latin1_bin DEFAULT '',
  `article_keyword` text COLLATE latin1_bin,
  `article_public` int(1) DEFAULT '1',
  `article_deleted` int(1) DEFAULT '0',
  `article_begin` datetime DEFAULT '0000-00-00 00:00:00',
  `article_end` datetime DEFAULT '0000-00-00 00:00:00',
  `article_aktiv` int(1) DEFAULT '0',
  `article_subtitle` text COLLATE latin1_bin,
  `article_summary` mediumtext COLLATE latin1_bin,
  `article_redirect` text COLLATE latin1_bin,
  `article_sort` int(11) DEFAULT '0',
  `article_notitle` int(1) DEFAULT '0',
  `article_hidesummary` int(1) DEFAULT '0',
  `article_image` blob,
  `article_created` varchar(14) COLLATE latin1_bin DEFAULT '',
  `article_cache` varchar(10) COLLATE latin1_bin DEFAULT '0',
  `article_nosearch` char(1) COLLATE latin1_bin DEFAULT '0',
  `article_nositemap` int(1) DEFAULT '0',
  `article_aliasid` int(11) DEFAULT '0',
  `article_headerdata` int(1) DEFAULT '0',
  `article_morelink` int(1) DEFAULT '1',
  `article_noteaser` int(1) UNSIGNED DEFAULT '0',
  `article_pagetitle` varchar(255) COLLATE latin1_bin DEFAULT '',
  `article_paginate` int(1) DEFAULT '0',
  `article_serialized` blob,
  `article_priorize` int(5) DEFAULT '0',
  `article_norss` int(1) DEFAULT '1',
  `article_archive_status` int(1) DEFAULT '1',
  `article_menutitle` varchar(255) COLLATE latin1_bin DEFAULT '',
  `article_description` varchar(255) COLLATE latin1_bin DEFAULT '',
  `article_lang` varchar(255) COLLATE latin1_bin DEFAULT '',
  `article_lang_type` varchar(255) COLLATE latin1_bin DEFAULT '',
  `article_lang_id` int(11) UNSIGNED DEFAULT '0',
  `article_opengraph` int(1) UNSIGNED DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Extraindo dados da tabela `phpwcms_article`
--

INSERT INTO `phpwcms_article` (`article_id`, `article_cid`, `article_tid`, `article_uid`, `article_tstamp`, `article_username`, `article_title`, `article_alias`, `article_keyword`, `article_public`, `article_deleted`, `article_begin`, `article_end`, `article_aktiv`, `article_subtitle`, `article_summary`, `article_redirect`, `article_sort`, `article_notitle`, `article_hidesummary`, `article_image`, `article_created`, `article_cache`, `article_nosearch`, `article_nositemap`, `article_aliasid`, `article_headerdata`, `article_morelink`, `article_noteaser`, `article_pagetitle`, `article_paginate`, `article_serialized`, `article_priorize`, `article_norss`, `article_archive_status`, `article_menutitle`, `article_description`, `article_lang`, `article_lang_type`, `article_lang_id`, `article_opengraph`) VALUES
(1, 0, 0, 1, '2022-05-23 22:15:06', 'Administrador', 'Página Inicial', 'pagina-inicial', '', 1, 0, '2018-09-01 00:00:00', '2028-09-24 17:10:15', 1, '', '', '', 10, 1, 0, 0x613a31383a7b733a383a22746d706c6c697374223b733a373a2264656661756c74223b733a383a22746d706c66756c6c223b733a373a2264656661756c74223b733a343a226e616d65223b733a303a22223b733a323a226964223b693a303b733a353a227769647468223b693a3230303b733a363a22686569676874223b693a3230303b733a373a2263617074696f6e223b733a303a22223b733a343a227a6f6f6d223b693a303b733a383a226c69676874626f78223b693a303b733a31353a226c6973745f75736573756d6d617279223b693a303b733a393a226c6973745f6e616d65223b733a303a22223b733a373a226c6973745f6964223b693a303b733a31303a226c6973745f7769647468223b693a3130303b733a31313a226c6973745f686569676874223b693a3130303b733a31323a226c6973745f63617074696f6e223b733a303a22223b733a393a226c6973745f7a6f6f6d223b693a303b733a31333a226c6973745f6c69676874626f78223b693a303b733a31333a226c6973745f6d6178776f726473223b693a303b7d, '1538068215', '', '', 1, 0, 0, 1, 0, '', 0, '', 0, 1, 1, '', '', '', '', 0, 0),
(2, 2, 0, 1, '2022-03-31 20:44:13', 'Administrador', 'Empresa', 'empresa-1', '', 1, 0, '2018-09-01 00:00:00', '2028-09-24 17:10:47', 1, '', '', '', 10, 0, 0, 0x613a31383a7b733a383a22746d706c6c697374223b733a373a2264656661756c74223b733a383a22746d706c66756c6c223b733a373a2264656661756c74223b733a343a226e616d65223b733a303a22223b733a323a226964223b693a303b733a353a227769647468223b693a3230303b733a363a22686569676874223b693a3230303b733a373a2263617074696f6e223b733a303a22223b733a343a227a6f6f6d223b693a303b733a383a226c69676874626f78223b693a303b733a31353a226c6973745f75736573756d6d617279223b693a303b733a393a226c6973745f6e616d65223b733a303a22223b733a373a226c6973745f6964223b693a303b733a31303a226c6973745f7769647468223b693a3130303b733a31313a226c6973745f686569676874223b693a3130303b733a31323a226c6973745f63617074696f6e223b733a303a22223b733a393a226c6973745f7a6f6f6d223b693a303b733a31333a226c6973745f6c69676874626f78223b693a303b733a31333a226c6973745f6d6178776f726473223b693a303b7d, '1538068247', '', '', 1, 0, 0, 1, 0, '', 0, '', 0, 1, 1, '', '', '', '', 0, 0),
(3, 3, 0, 1, '2021-01-01 23:09:19', 'Administrador', 'Serviço 1', 'servicos-1', '', 1, 0, '2018-09-01 00:00:00', '2028-09-24 17:11:07', 1, 'Serviço Empresarial', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', '', 10, 0, 0, 0x613a32303a7b733a383a22746d706c6c697374223b733a373a2264656661756c74223b733a383a22746d706c66756c6c223b733a32313a227365727669636f2d636f6d706c65746f2e68746d6c223b733a343a226e616d65223b733a31333a227365727669636f2d312e6a7067223b733a323a226964223b733a313a2237223b733a353a227769647468223b693a3230303b733a363a22686569676874223b693a3230303b733a373a2263617074696f6e223b733a303a22223b733a343a227a6f6f6d223b693a303b733a383a226c69676874626f78223b693a303b733a343a2268617368223b733a33323a226237316439303630616462626639396365373339346164333961373865373164223b733a333a22657874223b733a333a226a7067223b733a31353a226c6973745f75736573756d6d617279223b693a313b733a393a226c6973745f6e616d65223b733a303a22223b733a373a226c6973745f6964223b693a303b733a31303a226c6973745f7769647468223b693a3130303b733a31313a226c6973745f686569676874223b693a3130303b733a31323a226c6973745f63617074696f6e223b733a303a22223b733a393a226c6973745f7a6f6f6d223b693a303b733a31333a226c6973745f6c69676874626f78223b693a303b733a31333a226c6973745f6d6178776f726473223b693a303b7d, '1538068267', '', '', 1, 0, 0, 1, 0, '', 0, '', 0, 1, 1, '', '', '', '', 0, 0),
(4, 4, 0, 1, '2022-05-08 22:05:32', 'Administrador', 'Produtos', 'produtos-1', '', 1, 0, '2018-09-01 00:00:00', '2028-09-24 17:11:33', 1, '', '', '', 10, 0, 0, 0x613a31383a7b733a383a22746d706c6c697374223b733a373a2264656661756c74223b733a383a22746d706c66756c6c223b733a373a2264656661756c74223b733a343a226e616d65223b733a303a22223b733a323a226964223b693a303b733a353a227769647468223b693a3230303b733a363a22686569676874223b693a3230303b733a373a2263617074696f6e223b733a303a22223b733a343a227a6f6f6d223b693a303b733a383a226c69676874626f78223b693a303b733a31353a226c6973745f75736573756d6d617279223b693a303b733a393a226c6973745f6e616d65223b733a303a22223b733a373a226c6973745f6964223b693a303b733a31303a226c6973745f7769647468223b693a3130303b733a31313a226c6973745f686569676874223b693a3130303b733a31323a226c6973745f63617074696f6e223b733a303a22223b733a393a226c6973745f7a6f6f6d223b693a303b733a31333a226c6973745f6c69676874626f78223b693a303b733a31333a226c6973745f6d6178776f726473223b693a303b7d, '1538068293', '', '', 1, 0, 0, 1, 0, '', 0, '', 0, 1, 1, '', '', '', '', 0, 0),
(5, 5, 0, 1, '2020-09-29 04:43:11', 'Administrador', 'Contato', 'contato-1', '', 1, 0, '2018-09-01 00:00:00', '2028-09-24 17:11:48', 1, '', '', '', 10, 0, 0, 0x613a31383a7b733a383a22746d706c6c697374223b733a373a2264656661756c74223b733a383a22746d706c66756c6c223b733a373a2264656661756c74223b733a343a226e616d65223b733a303a22223b733a323a226964223b693a303b733a353a227769647468223b693a3230303b733a363a22686569676874223b693a3230303b733a373a2263617074696f6e223b733a303a22223b733a343a227a6f6f6d223b693a303b733a383a226c69676874626f78223b693a303b733a31353a226c6973745f75736573756d6d617279223b693a303b733a393a226c6973745f6e616d65223b733a303a22223b733a373a226c6973745f6964223b693a303b733a31303a226c6973745f7769647468223b693a3130303b733a31313a226c6973745f686569676874223b693a3130303b733a31323a226c6973745f63617074696f6e223b733a303a22223b733a393a226c6973745f7a6f6f6d223b693a303b733a31333a226c6973745f6c69676874626f78223b693a303b733a31333a226c6973745f6d6178776f726473223b693a303b7d, '1538068308', '', '', 1, 0, 0, 1, 0, '', 0, '', 0, 1, 1, '', '', '', '', 0, 0),
(6, 6, 0, 1, '2018-10-17 07:08:03', 'Administrador', 'Noticia 1', 'noticia-1', '', 1, 0, '2018-10-16 00:00:00', '2028-10-14 04:00:38', 1, '', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<br />\r\n<br />\r\nLorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.&nbsp;<br />\r\n<br />\r\nLorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<br />\r\n<br />\r\nLorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.&nbsp;', '', 30, 0, 0, 0x613a32303a7b733a383a22746d706c6c697374223b733a373a2264656661756c74223b733a383a22746d706c66756c6c223b733a32323a226e6f7469636961732d636f6d706c6574612e68746d6c223b733a343a226e616d65223b733a31343a226e6f7469636961732d312e6a7067223b733a323a226964223b733a323a223132223b733a353a227769647468223b693a3230303b733a363a22686569676874223b693a3230303b733a373a2263617074696f6e223b733a303a22223b733a343a227a6f6f6d223b693a303b733a383a226c69676874626f78223b693a303b733a343a2268617368223b733a33323a223430346638666434326432363130646162303337313837363038393439383438223b733a333a22657874223b733a333a226a7067223b733a31353a226c6973745f75736573756d6d617279223b693a313b733a393a226c6973745f6e616d65223b733a303a22223b733a373a226c6973745f6964223b693a303b733a31303a226c6973745f7769647468223b693a3130303b733a31313a226c6973745f686569676874223b693a3130303b733a31323a226c6973745f63617074696f6e223b733a303a22223b733a393a226c6973745f7a6f6f6d223b693a303b733a31333a226c6973745f6c69676874626f78223b693a303b733a31333a226c6973745f6d6178776f726473223b693a34303b7d, '1539748838', '', '', 1, 0, 0, 1, 0, '', 0, '', 0, 1, 1, '', '', '', '', 0, 0),
(7, 6, 0, 1, '2018-10-17 07:07:42', 'Administrador', 'Noticia 2', 'noticia-2', '', 1, 0, '2018-10-16 00:00:00', '2028-10-14 04:03:02', 1, '', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<br />\r\n<br />\r\nLorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.&nbsp;<br />\r\n<br />\r\nLorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<br />\r\n<br />\r\nLorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.&nbsp;', '', 20, 0, 0, 0x613a32303a7b733a383a22746d706c6c697374223b733a373a2264656661756c74223b733a383a22746d706c66756c6c223b733a32323a226e6f7469636961732d636f6d706c6574612e68746d6c223b733a343a226e616d65223b733a31343a226e6f7469636961732d322e6a7067223b733a323a226964223b733a323a223133223b733a353a227769647468223b693a3230303b733a363a22686569676874223b693a3230303b733a373a2263617074696f6e223b733a303a22223b733a343a227a6f6f6d223b693a303b733a383a226c69676874626f78223b693a303b733a343a2268617368223b733a33323a223237663330323037646361633138333937613933316437613130643836386366223b733a333a22657874223b733a333a226a7067223b733a31353a226c6973745f75736573756d6d617279223b693a313b733a393a226c6973745f6e616d65223b733a303a22223b733a373a226c6973745f6964223b693a303b733a31303a226c6973745f7769647468223b693a3130303b733a31313a226c6973745f686569676874223b693a3130303b733a31323a226c6973745f63617074696f6e223b733a303a22223b733a393a226c6973745f7a6f6f6d223b693a303b733a31333a226c6973745f6c69676874626f78223b693a303b733a31333a226c6973745f6d6178776f726473223b693a34303b7d, '1539748982', '', '', 1, 0, 0, 1, 0, '', 0, '', 0, 1, 1, '', '', '', '', 0, 0),
(8, 6, 0, 1, '2018-10-17 07:09:12', 'Administrador', 'Noticia 3', 'noticia-3', '', 1, 0, '2018-10-16 00:00:00', '2028-10-14 04:08:58', 1, '', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<br />\r\n<br />\r\nLorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.&nbsp;<br />\r\n<br />\r\nLorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<br />\r\n<br />\r\nLorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.&nbsp;', '', 10, 0, 0, 0x613a32303a7b733a383a22746d706c6c697374223b733a373a2264656661756c74223b733a383a22746d706c66756c6c223b733a32323a226e6f7469636961732d636f6d706c6574612e68746d6c223b733a343a226e616d65223b733a31343a226e6f7469636961732d332e6a7067223b733a323a226964223b733a323a223134223b733a353a227769647468223b693a3230303b733a363a22686569676874223b693a3230303b733a373a2263617074696f6e223b733a303a22223b733a343a227a6f6f6d223b693a303b733a383a226c69676874626f78223b693a303b733a343a2268617368223b733a33323a223265663434353230323266386532663231306632653363356235333964636335223b733a333a22657874223b733a333a226a7067223b733a31353a226c6973745f75736573756d6d617279223b693a313b733a393a226c6973745f6e616d65223b733a303a22223b733a373a226c6973745f6964223b693a303b733a31303a226c6973745f7769647468223b693a3130303b733a31313a226c6973745f686569676874223b693a3130303b733a31323a226c6973745f63617074696f6e223b733a303a22223b733a393a226c6973745f7a6f6f6d223b693a303b733a31333a226c6973745f6c69676874626f78223b693a303b733a31333a226c6973745f6d6178776f726473223b693a34303b7d, '1539749338', '', '', 1, 0, 0, 1, 0, '', 0, '', 0, 1, 1, '', '', '', '', 0, 0),
(9, 7, 0, 1, '2019-02-14 17:21:09', 'Administrador', 'Busca', 'busca-1', '', 1, 0, '2019-02-13 00:00:00', '2029-02-11 15:03:21', 1, '', '', '', 10, 0, 0, 0x613a31383a7b733a383a22746d706c6c697374223b733a373a2264656661756c74223b733a383a22746d706c66756c6c223b733a373a2264656661756c74223b733a343a226e616d65223b733a303a22223b733a323a226964223b693a303b733a353a227769647468223b693a3230303b733a363a22686569676874223b693a3230303b733a373a2263617074696f6e223b733a303a22223b733a343a227a6f6f6d223b693a303b733a383a226c69676874626f78223b693a303b733a31353a226c6973745f75736573756d6d617279223b693a303b733a393a226c6973745f6e616d65223b733a303a22223b733a373a226c6973745f6964223b693a303b733a31303a226c6973745f7769647468223b693a3130303b733a31313a226c6973745f686569676874223b693a3130303b733a31323a226c6973745f63617074696f6e223b733a303a22223b733a393a226c6973745f7a6f6f6d223b693a303b733a31333a226c6973745f6c69676874626f78223b693a303b733a31333a226c6973745f6d6178776f726473223b693a303b7d, '1550156601', '', '', 1, 0, 0, 1, 0, '', 0, '', 0, 1, 1, '', '', '', '', 0, 0),
(10, 3, 0, 1, '2021-01-01 23:09:55', 'Administrador', 'Serviço 2', 'servico-2', '', 1, 0, '2018-09-01 00:00:00', '2028-09-24 17:11:07', 1, 'Serviço Empresarial', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', '', 20, 0, 0, 0x613a32303a7b733a383a22746d706c6c697374223b733a373a2264656661756c74223b733a383a22746d706c66756c6c223b733a32313a227365727669636f2d636f6d706c65746f2e68746d6c223b733a343a226e616d65223b733a31333a227365727669636f2d322e6a7067223b733a323a226964223b733a313a2239223b733a353a227769647468223b693a3230303b733a363a22686569676874223b693a3230303b733a373a2263617074696f6e223b733a303a22223b733a343a227a6f6f6d223b693a303b733a383a226c69676874626f78223b693a303b733a343a2268617368223b733a33323a223133616136313331316663376638633834383338383761343733656436303231223b733a333a22657874223b733a333a226a7067223b733a31353a226c6973745f75736573756d6d617279223b693a313b733a393a226c6973745f6e616d65223b733a303a22223b733a373a226c6973745f6964223b693a303b733a31303a226c6973745f7769647468223b693a3130303b733a31313a226c6973745f686569676874223b693a3130303b733a31323a226c6973745f63617074696f6e223b733a303a22223b733a393a226c6973745f7a6f6f6d223b693a303b733a31333a226c6973745f6c69676874626f78223b693a303b733a31333a226c6973745f6d6178776f726473223b693a303b7d, '1609531776', '', '', 1, 0, 0, 1, 0, '', 0, '', 0, 1, 1, '', '', '', '', 0, 0),
(11, 3, 0, 1, '2021-01-01 23:23:27', 'Administrador', 'Serviço 3', 'servico-3', '', 1, 0, '2018-09-01 00:00:00', '2028-09-24 17:11:07', 1, 'Serviço Empresarial', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', '', 30, 0, 0, 0x613a32303a7b733a383a22746d706c6c697374223b733a373a2264656661756c74223b733a383a22746d706c66756c6c223b733a32313a227365727669636f2d636f6d706c65746f2e68746d6c223b733a343a226e616d65223b733a31333a227365727669636f2d332e6a7067223b733a323a226964223b733a313a2238223b733a353a227769647468223b693a3230303b733a363a22686569676874223b693a3230303b733a373a2263617074696f6e223b733a303a22223b733a343a227a6f6f6d223b693a303b733a383a226c69676874626f78223b693a303b733a343a2268617368223b733a33323a223731623336386264613832666436666466653737613131313461316564653365223b733a333a22657874223b733a333a226a7067223b733a31353a226c6973745f75736573756d6d617279223b693a313b733a393a226c6973745f6e616d65223b733a303a22223b733a373a226c6973745f6964223b693a303b733a31303a226c6973745f7769647468223b693a3130303b733a31313a226c6973745f686569676874223b693a3130303b733a31323a226c6973745f63617074696f6e223b733a303a22223b733a393a226c6973745f7a6f6f6d223b693a303b733a31333a226c6973745f6c69676874626f78223b693a303b733a31333a226c6973745f6d6178776f726473223b693a303b7d, '1609532595', '', '', 1, 0, 0, 1, 0, '', 0, '', 0, 1, 1, '', '', '', '', 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_articlecat`
--

CREATE TABLE `phpwcms_articlecat` (
  `acat_id` int(11) NOT NULL,
  `acat_name` text COLLATE latin1_bin,
  `acat_menu` tinyint(1) DEFAULT '0',
  `acat_info` text COLLATE latin1_bin,
  `acat_public` int(1) DEFAULT '1',
  `acat_tstamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `acat_aktiv` int(1) DEFAULT '0',
  `acat_uid` int(11) DEFAULT '0',
  `acat_trash` int(1) DEFAULT '0',
  `acat_struct` int(11) DEFAULT '0',
  `acat_sort` int(11) DEFAULT '0',
  `acat_alias` varchar(255) COLLATE latin1_bin DEFAULT '',
  `acat_hidden` int(1) DEFAULT '0',
  `acat_template` int(11) DEFAULT '0',
  `acat_ssl` int(1) DEFAULT '0',
  `acat_regonly` int(1) DEFAULT '0',
  `acat_topcount` int(11) DEFAULT '0',
  `acat_redirect` text COLLATE latin1_bin,
  `acat_order` int(2) DEFAULT '0',
  `acat_cache` varchar(10) COLLATE latin1_bin DEFAULT '',
  `acat_nosearch` char(1) COLLATE latin1_bin DEFAULT '',
  `acat_nositemap` int(1) DEFAULT '0',
  `acat_permit` text COLLATE latin1_bin,
  `acat_maxlist` int(11) DEFAULT '0',
  `acat_cntpart` varchar(255) COLLATE latin1_bin DEFAULT '',
  `acat_pagetitle` varchar(255) COLLATE latin1_bin DEFAULT '',
  `acat_paginate` int(1) DEFAULT '0',
  `acat_overwrite` varchar(255) COLLATE latin1_bin DEFAULT '',
  `acat_archive` int(1) DEFAULT '0',
  `acat_class` varchar(255) COLLATE latin1_bin DEFAULT '',
  `acat_keywords` varchar(255) COLLATE latin1_bin DEFAULT '',
  `acat_cpdefault` int(10) UNSIGNED DEFAULT '0',
  `acat_lang` varchar(255) COLLATE latin1_bin DEFAULT '',
  `acat_lang_type` varchar(255) COLLATE latin1_bin DEFAULT '',
  `acat_lang_id` int(11) UNSIGNED DEFAULT '0',
  `acat_disable301` int(1) UNSIGNED DEFAULT '0',
  `acat_opengraph` int(1) UNSIGNED DEFAULT '1',
  `acat_img_width` varchar(255) COLLATE latin1_bin DEFAULT NULL,
  `acat_img_height` varchar(255) COLLATE latin1_bin DEFAULT NULL,
  `acat_img_crop` varchar(255) COLLATE latin1_bin DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Extraindo dados da tabela `phpwcms_articlecat`
--

INSERT INTO `phpwcms_articlecat` (`acat_id`, `acat_name`, `acat_menu`, `acat_info`, `acat_public`, `acat_tstamp`, `acat_aktiv`, `acat_uid`, `acat_trash`, `acat_struct`, `acat_sort`, `acat_alias`, `acat_hidden`, `acat_template`, `acat_ssl`, `acat_regonly`, `acat_topcount`, `acat_redirect`, `acat_order`, `acat_cache`, `acat_nosearch`, `acat_nositemap`, `acat_permit`, `acat_maxlist`, `acat_cntpart`, `acat_pagetitle`, `acat_paginate`, `acat_overwrite`, `acat_archive`, `acat_class`, `acat_keywords`, `acat_cpdefault`, `acat_lang`, `acat_lang_type`, `acat_lang_id`, `acat_disable301`, `acat_opengraph`, `acat_img_width`, `acat_img_height`, `acat_img_crop`) VALUES
(1, 'Home', 1, '', 1, '2020-01-11 00:41:04', 1, 1, 0, 0, 1, 'home', 0, 1, 0, 0, -1, 'index.php', 0, '0', '', 1, '', 0, '14,1,6,29,32,8,23', '', 0, '', 0, '', '', 0, '', '', 0, 0, 1, NULL, NULL, NULL),
(2, 'Empresa', 1, '', 1, '2021-06-17 22:50:04', 1, 1, 0, 0, 2, 'empresa', 0, 2, 0, 0, -1, '', 0, '', '', 1, '', 0, '14,1,6,29,32,8,23,5,31,7', '', 0, '', 0, '', '', 0, '', '', 0, 0, 1, NULL, NULL, NULL),
(3, 'Serviços', 1, '', 1, '2021-06-17 22:50:04', 1, 1, 0, 0, 3, 'servicos', 0, 2, 0, 0, 100, '', 0, '', '', 1, '', 100, '14,1,6,29,32,8,23,5,31,7', '', 1, '', 0, '', '', 0, '', '', 0, 0, 1, '350', '350', '0'),
(4, 'Produtos', 1, '', 1, '2021-07-20 00:35:52', 1, 1, 0, 0, 4, 'produtos', 0, 2, 0, 0, -1, '', 0, '', '', 1, '', 0, '14,1,6,29,32,8,23,31,5,7', '', 0, '', 0, '', '', 0, '', '', 0, 0, 1, NULL, NULL, NULL),
(5, 'Contato', 1, '', 1, '2021-07-20 00:35:52', 1, 1, 0, 0, 5, 'contato', 0, 3, 0, 0, -1, '', 0, '', '', 1, '', 0, '14,1,6,29,32,8,23', '', 0, '', 0, '', '', 0, '', '', 0, 0, 1, NULL, NULL, NULL),
(6, 'Noticias', 0, '', 1, '2022-05-20 23:44:45', 1, 1, 0, 0, 300, 'noticias', 1, 2, 0, 0, 12, '', 0, '', '', 1, '', 12, '', '', 1, '', 0, '', '', 0, '', '', 0, 0, 0, '500', '500', '0'),
(7, 'Busca', 0, '', 1, '2022-05-20 23:44:45', 1, 1, 0, 0, 301, 'busca', 1, 2, 0, 0, -1, '', 0, '', '', 1, '', 0, '', '', 0, '', 0, '', '', 0, '', '', 0, 0, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_articlecontent`
--

CREATE TABLE `phpwcms_articlecontent` (
  `acontent_id` int(11) NOT NULL,
  `acontent_aid` int(11) DEFAULT '0',
  `acontent_uid` int(11) DEFAULT '0',
  `acontent_created` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `acontent_tstamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `acontent_title` text COLLATE latin1_bin,
  `acontent_text` mediumtext COLLATE latin1_bin,
  `acontent_type` int(10) DEFAULT '0',
  `acontent_sorting` int(11) DEFAULT '0',
  `acontent_image` text COLLATE latin1_bin,
  `acontent_files` text COLLATE latin1_bin,
  `acontent_visible` int(1) DEFAULT '0',
  `acontent_subtitle` text COLLATE latin1_bin,
  `acontent_before` varchar(10) COLLATE latin1_bin DEFAULT '',
  `acontent_after` varchar(10) COLLATE latin1_bin DEFAULT '',
  `acontent_top` int(1) DEFAULT '0',
  `acontent_redirect` text COLLATE latin1_bin,
  `acontent_html` mediumtext COLLATE latin1_bin,
  `acontent_trash` int(1) DEFAULT '0',
  `acontent_alink` text COLLATE latin1_bin,
  `acontent_media` mediumtext COLLATE latin1_bin,
  `acontent_form` mediumtext COLLATE latin1_bin,
  `acontent_newsletter` mediumtext COLLATE latin1_bin,
  `acontent_block` varchar(200) COLLATE latin1_bin DEFAULT 'CONTENT',
  `acontent_anchor` int(1) DEFAULT '0',
  `acontent_template` varchar(255) COLLATE latin1_bin DEFAULT '',
  `acontent_spacer` int(1) DEFAULT '0',
  `acontent_tid` int(11) DEFAULT '0',
  `acontent_livedate` datetime DEFAULT '0000-00-00 00:00:00',
  `acontent_killdate` datetime DEFAULT '0000-00-00 00:00:00',
  `acontent_module` varchar(255) COLLATE latin1_bin DEFAULT '',
  `acontent_comment` text COLLATE latin1_bin,
  `acontent_paginate_page` int(5) DEFAULT '0',
  `acontent_paginate_title` varchar(255) COLLATE latin1_bin DEFAULT '',
  `acontent_category` varchar(255) COLLATE latin1_bin DEFAULT NULL,
  `acontent_granted` int(11) DEFAULT '0',
  `acontent_tab` varchar(255) COLLATE latin1_bin DEFAULT '',
  `acontent_lang` varchar(255) COLLATE latin1_bin DEFAULT '',
  `acontent_all_link` varchar(255) COLLATE latin1_bin DEFAULT NULL,
  `acontent_escurecer` tinyint(1) DEFAULT NULL,
  `campos_extra` varchar(255) COLLATE latin1_bin DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Extraindo dados da tabela `phpwcms_articlecontent`
--

INSERT INTO `phpwcms_articlecontent` (`acontent_id`, `acontent_aid`, `acontent_uid`, `acontent_created`, `acontent_tstamp`, `acontent_title`, `acontent_text`, `acontent_type`, `acontent_sorting`, `acontent_image`, `acontent_files`, `acontent_visible`, `acontent_subtitle`, `acontent_before`, `acontent_after`, `acontent_top`, `acontent_redirect`, `acontent_html`, `acontent_trash`, `acontent_alink`, `acontent_media`, `acontent_form`, `acontent_newsletter`, `acontent_block`, `acontent_anchor`, `acontent_template`, `acontent_spacer`, `acontent_tid`, `acontent_livedate`, `acontent_killdate`, `acontent_module`, `acontent_comment`, `acontent_paginate_page`, `acontent_paginate_title`, `acontent_category`, `acontent_granted`, `acontent_tab`, `acontent_lang`, `acontent_all_link`, `acontent_escurecer`, `campos_extra`) VALUES
(1, 1, 1, '2018-09-27 21:44:02', '2019-09-19 18:18:47', '', NULL, 16, 10, NULL, NULL, 1, '', '', '', 0, NULL, '', 0, NULL, NULL, 'a:24:{s:3:\"pos\";i:0;s:5:\"width\";i:1920;s:6:\"height\";i:1080;s:10:\"width_zoom\";i:800;s:11:\"height_zoom\";i:800;s:3:\"col\";i:1;s:5:\"space\";i:0;s:4:\"zoom\";i:0;s:8:\"lightbox\";i:0;s:9:\"nocaption\";i:0;s:6:\"center\";i:0;s:4:\"crop\";i:0;s:9:\"crop_zoom\";i:0;s:3:\"fx1\";i:0;s:3:\"fx2\";i:0;s:3:\"fx3\";i:0;s:14:\"addclassemulti\";i:0;s:5:\"tempo\";i:10;s:11:\"numeromulti\";i:0;s:11:\"classemulti\";N;s:9:\"addclasse\";i:0;s:12:\"numeroclasse\";i:0;s:16:\"addclasse_classe\";N;s:6:\"images\";a:2:{i:0;a:15:{s:8:\"thumb_id\";i:3;s:7:\"zoom_id\";s:0:\"\";s:10:\"thumb_name\";s:12:\"banner-1.jpg\";s:9:\"zoom_name\";s:0:\"\";s:4:\"sort\";i:0;s:7:\"caption\";s:16:\"Slogan do Banner\";s:8:\"freetext\";s:19:\"Subtitulo do banner\";s:3:\"url\";s:1:\"#\";s:4:\"tipo\";s:1:\"1\";s:6:\"pagina\";s:1:\"1\";s:5:\"botao\";s:10:\"Saiba Mais\";s:10:\"thumb_hash\";s:32:\"6aa0ec42d0d9667ea6e2c1fa73224f25\";s:9:\"thumb_ext\";s:3:\"jpg\";s:9:\"zoom_hash\";s:0:\"\";s:8:\"zoom_ext\";s:0:\"\";}i:1;a:15:{s:8:\"thumb_id\";i:4;s:7:\"zoom_id\";s:0:\"\";s:10:\"thumb_name\";s:12:\"banner-2.jpg\";s:9:\"zoom_name\";s:0:\"\";s:4:\"sort\";i:1;s:7:\"caption\";s:16:\"Slogan do Banner\";s:8:\"freetext\";s:19:\"Subtitulo do banner\";s:3:\"url\";s:1:\"#\";s:4:\"tipo\";s:1:\"1\";s:6:\"pagina\";s:1:\"1\";s:5:\"botao\";s:10:\"Saiba Mais\";s:10:\"thumb_hash\";s:32:\"e3bde1cff80deb90432a91a9dc4ea4da\";s:9:\"thumb_ext\";s:3:\"jpg\";s:9:\"zoom_hash\";s:0:\"\";s:8:\"zoom_ext\";s:0:\"\";}}}', NULL, 'BANNER', 0, 'banner.html', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 0, '', NULL, 0, '', '', NULL, NULL, NULL),
(2, 1, 1, '2018-09-27 22:06:42', '2022-03-31 19:22:18', 'Quem Somos', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.', 1, 20, '5:img-empresa.jpg:23a2264e686e3de095c62b3e4b598995:jpg:500:500::0:0', NULL, 1, 'Conheça a nossa história', '', '', 0, NULL, NULL, 0, NULL, NULL, 'a:4:{s:15:\"cimage_lightbox\";i:0;s:16:\"cimage_nocaption\";i:0;s:11:\"cimage_crop\";i:1;s:8:\"corfundo\";s:0:\"\";}', NULL, 'CONTENT', 0, 'quem-somos.html', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 0, '', NULL, 0, '', '', 'a:4:{s:5:\"botao\";s:0:\"\";s:4:\"tipo\";s:1:\"2\";s:4:\"link\";s:0:\"\";s:3:\"pag\";s:1:\"2\";}', 0, NULL),
(3, 1, 1, '2018-10-17 04:52:11', '2022-05-23 22:15:06', 'Nossos Serviços', NULL, 31, 30, NULL, NULL, 1, 'Subtitulo de Serviços', '', '', 0, NULL, '', 0, NULL, NULL, 'a:23:{s:3:\"pos\";i:0;s:5:\"width\";i:700;s:6:\"height\";i:700;s:10:\"width_zoom\";i:800;s:11:\"height_zoom\";i:800;s:3:\"col\";i:1;s:5:\"space\";i:0;s:4:\"zoom\";i:0;s:8:\"lightbox\";i:0;s:9:\"nocaption\";i:0;s:6:\"center\";i:0;s:4:\"crop\";i:0;s:9:\"crop_zoom\";i:0;s:3:\"fx1\";i:0;s:3:\"fx2\";i:0;s:3:\"fx3\";i:0;s:14:\"addclassemulti\";i:0;s:11:\"numeromulti\";i:0;s:11:\"classemulti\";N;s:9:\"addclasse\";i:0;s:12:\"numeroclasse\";i:0;s:16:\"addclasse_classe\";N;s:6:\"images\";a:3:{i:0;a:15:{s:8:\"thumb_id\";i:7;s:7:\"zoom_id\";s:0:\"\";s:10:\"thumb_name\";s:13:\"servico-1.jpg\";s:9:\"zoom_name\";s:0:\"\";s:4:\"sort\";i:0;s:7:\"caption\";s:9:\"Serviço 1\";s:8:\"freetext\";s:144:\"Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.\";s:3:\"url\";s:1:\"#\";s:4:\"tipo\";s:1:\"1\";s:6:\"pagina\";s:1:\"1\";s:5:\"botao\";s:0:\"\";s:10:\"thumb_hash\";s:32:\"b71d9060adbbf99ce7394ad39a78e71d\";s:9:\"thumb_ext\";s:3:\"jpg\";s:9:\"zoom_hash\";s:0:\"\";s:8:\"zoom_ext\";s:0:\"\";}i:1;a:15:{s:8:\"thumb_id\";i:9;s:7:\"zoom_id\";s:0:\"\";s:10:\"thumb_name\";s:13:\"servico-2.jpg\";s:9:\"zoom_name\";s:0:\"\";s:4:\"sort\";i:1;s:7:\"caption\";s:9:\"Serviço 2\";s:8:\"freetext\";s:144:\"Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.\";s:3:\"url\";s:1:\"#\";s:4:\"tipo\";s:1:\"1\";s:6:\"pagina\";s:1:\"1\";s:5:\"botao\";s:0:\"\";s:10:\"thumb_hash\";s:32:\"13aa61311fc7f8c8483887a473ed6021\";s:9:\"thumb_ext\";s:3:\"jpg\";s:9:\"zoom_hash\";s:0:\"\";s:8:\"zoom_ext\";s:0:\"\";}i:2;a:15:{s:8:\"thumb_id\";i:8;s:7:\"zoom_id\";s:0:\"\";s:10:\"thumb_name\";s:13:\"servico-3.jpg\";s:9:\"zoom_name\";s:0:\"\";s:4:\"sort\";i:2;s:7:\"caption\";s:9:\"Serviço 3\";s:8:\"freetext\";s:144:\"Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.\";s:3:\"url\";s:1:\"#\";s:4:\"tipo\";s:1:\"1\";s:6:\"pagina\";s:1:\"1\";s:5:\"botao\";s:0:\"\";s:10:\"thumb_hash\";s:32:\"71b368bda82fd6fdfe77a1114a1ede3e\";s:9:\"thumb_ext\";s:3:\"jpg\";s:9:\"zoom_hash\";s:0:\"\";s:8:\"zoom_ext\";s:0:\"\";}}}', NULL, 'CONTENT', 0, '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 0, '', NULL, 0, '', '', 'a:5:{s:5:\"botao\";s:0:\"\";s:4:\"tipo\";s:1:\"1\";s:4:\"link\";s:1:\"#\";s:3:\"pag\";s:1:\"1\";s:14:\"cimage_colunas\";s:0:\"\";}', NULL, 'a:1:{s:12:\"campo_clonar\";s:0:\"\";}'),
(12, 1, 1, '2021-01-01 02:53:13', '2021-01-01 08:40:04', 'Newsletter', NULL, 12, 90, NULL, NULL, 1, 'Fique por dentro das nossas Novidades', '', '', 0, NULL, NULL, 0, NULL, NULL, NULL, 'a:14:{s:4:\"text\";s:0:\"\";s:11:\"label_email\";s:0:\"\";s:10:\"label_name\";s:0:\"\";s:19:\"label_subscriptions\";s:0:\"\";s:17:\"all_subscriptions\";s:0:\"\";s:11:\"button_text\";s:0:\"\";s:12:\"success_text\";s:67:\"Obrigado, seu e-mail foi cadastrado com sucesso em nossos sistemas.\";s:8:\"reg_text\";s:341:\"[SUBJECT]Nome da Empresa [/SUBJECT]\r\n\r\nOlá {NEWSLETTER_NAME}, você se inscreveu em nosso site para receber novidades por e-mail.\r\nSeu e-mail: {NEWSLETTER_EMAIL}\r\n\r\nPara confirmar o seu cadastro clique no link abaixo.\r\n{NEWSLETTER_VERIFY}\r\n\r\nPara apagar seu cadastro a partir de nossa base de dados clique no link abaixo:\r\n{NEWSLETTER_DELETE}\";s:11:\"logoff_text\";s:0:\"\";s:11:\"change_text\";s:0:\"\";s:4:\"url1\";s:0:\"\";s:4:\"url2\";s:0:\"\";s:12:\"subscription\";a:0:{}s:3:\"pos\";i:0;}', 'CONTENT', 0, '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 0, '', NULL, 0, '', '', NULL, NULL, NULL),
(4, 5, 1, '2018-10-17 05:40:05', '2021-03-01 23:04:28', '', NULL, 23, 10, NULL, NULL, 1, '', '', '', 0, NULL, NULL, 0, NULL, NULL, 'a:42:{s:7:\"subject\";s:25:\"Nome da Empresa - Contato\";s:7:\"startup\";s:0:\"\";s:12:\"startup_html\";i:0;s:5:\"class\";s:0:\"\";s:11:\"error_class\";s:0:\"\";s:10:\"label_wrap\";s:1:\"|\";s:13:\"cform_reqmark\";s:1:\"*\";s:23:\"cform_function_validate\";s:0:\"\";s:2:\"cc\";s:0:\"\";s:10:\"targettype\";s:5:\"email\";s:6:\"target\";s:20:\"contato@email.com.br\";s:13:\"subjectselect\";s:0:\"\";s:10:\"sendertype\";s:16:\"emailfield_email\";s:6:\"sender\";s:0:\"\";s:14:\"sendernametype\";s:6:\"custom\";s:10:\"sendername\";s:0:\"\";s:11:\"verifyemail\";s:0:\"\";s:8:\"labelpos\";i:2;s:8:\"sendcopy\";i:0;s:6:\"copyto\";s:4:\"nome\";s:16:\"formtracking_off\";i:0;s:11:\"checktofrom\";i:0;s:18:\"onsuccess_redirect\";i:2;s:16:\"onerror_redirect\";i:2;s:9:\"onsuccess\";s:147:\"<div class=\"obrigado\">\r\n<h4>Obrigado {nome},</h4>\r\n\r\n<b>Recebemos seu Contato com SUCESSO!</b>\r\n\r\nAssim que possível entraremos em Contato.\r\n</div>\";s:7:\"onerror\";s:172:\"<font color=\"#ff0000\"><b>\r\nExistem campos que não foram preenchidos corretamente.</b><br/><br/>Por favor preencha e envie novamente o formulário. Obrigado.<br/><br/></font>\";s:15:\"template_format\";i:1;s:8:\"template\";s:1341:\"<strong style=\"font-size:25px\">CONTATO</strong><br />\r\n<strong style=\"font-size:16px\">Nome da Empresa</strong><br />\r\n&nbsp;\r\n<table border=\"0\" cellpadding=\"8\" cellspacing=\"1\" style=\" font-family:Verdana, Geneva, sans-serif\" width=\"752\">\r\n	<tbody><!-- <tr bgcolor=\"#d5d5d5\">\r\n			<td align=\"right\" colspan=\"2\">\r\n			<table border=\"0\" cellpadding=\"8\" cellspacing=\"0\" style=\"font-family:Verdana, Geneva, sans-serif; font-size:15px; color:#000;\" width=\"100%\">\r\n				<tbody>\r\n					<tr>\r\n						<td><strong style=\"font-size:20px\">CONTATO</strong><br />\r\n						<strong>Nome da Empresa</strong></td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>-->\r\n		<tr>\r\n			<td align=\"right\" bgcolor=\"#F4F4F4\" width=\"25%\"><strong>Nome:</strong></td>\r\n			<td bgcolor=\"#fafafa\" width=\"75%\">{nome}</td>\r\n		</tr>\r\n		<tr>\r\n			<td align=\"right\" bgcolor=\"#F4F4F4\" width=\"25%\"><strong>Email:</strong></td>\r\n			<td bgcolor=\"#fafafa\" width=\"75%\">{email}</td>\r\n		</tr>\r\n		<tr>\r\n			<td align=\"right\" bgcolor=\"#F4F4F4\" width=\"25%\"><strong>Telefone:</strong></td>\r\n			<td bgcolor=\"#fafafa\" width=\"75%\">{telefone}</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td bgcolor=\"#f4f4f4\" colspan=\"2\"><strong>Informa&ccedil;&otilde;es:</strong></td>\r\n		</tr>\r\n		<tr>\r\n			<td bgcolor=\"#fafafa\" colspan=\"2\">{info}</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\";s:20:\"template_format_copy\";i:0;s:13:\"template_copy\";s:0:\"\";s:11:\"function_to\";s:0:\"\";s:11:\"function_cc\";s:0:\"\";s:14:\"template_equal\";i:1;s:10:\"customform\";s:67:\"<p>{nome}</p>\r\n<p>{email}</p>\r\n<p>{telefone}</p>\r\n\r\n\r\n<p>{info}</p>\";s:6:\"savedb\";i:1;s:11:\"saveprofile\";i:0;s:10:\"anchor_off\";i:0;s:3:\"ssl\";i:0;s:6:\"fields\";a:4:{i:1;a:12:{s:4:\"type\";s:4:\"text\";s:4:\"name\";s:4:\"nome\";s:5:\"label\";s:0:\"\";s:8:\"required\";i:1;s:5:\"value\";s:0:\"\";s:5:\"error\";s:0:\"\";s:5:\"style\";s:0:\"\";s:5:\"class\";s:0:\"\";s:11:\"placeholder\";s:4:\"Nome\";s:7:\"profile\";s:0:\"\";s:4:\"size\";s:0:\"\";s:3:\"max\";s:0:\"\";}i:2;a:12:{s:4:\"type\";s:5:\"email\";s:4:\"name\";s:5:\"email\";s:5:\"label\";s:0:\"\";s:8:\"required\";i:1;s:5:\"value\";s:0:\"\";s:5:\"error\";s:0:\"\";s:5:\"style\";s:0:\"\";s:5:\"class\";s:0:\"\";s:11:\"placeholder\";s:6:\"E-mail\";s:7:\"profile\";s:0:\"\";s:4:\"size\";s:0:\"\";s:3:\"max\";s:0:\"\";}i:3;a:12:{s:4:\"type\";s:4:\"text\";s:4:\"name\";s:8:\"telefone\";s:5:\"label\";s:0:\"\";s:8:\"required\";i:1;s:5:\"value\";s:0:\"\";s:5:\"error\";s:0:\"\";s:5:\"style\";s:0:\"\";s:5:\"class\";s:0:\"\";s:11:\"placeholder\";s:14:\"(DDD) Telefone\";s:7:\"profile\";s:0:\"\";s:4:\"size\";s:0:\"\";s:3:\"max\";s:0:\"\";}i:4;a:12:{s:4:\"type\";s:8:\"textarea\";s:4:\"name\";s:4:\"info\";s:5:\"label\";s:0:\"\";s:8:\"required\";i:0;s:5:\"value\";s:0:\"\";s:5:\"error\";s:0:\"\";s:5:\"style\";s:0:\"\";s:5:\"class\";s:0:\"\";s:11:\"placeholder\";s:18:\"Deixa sua Mensagem\";s:7:\"profile\";s:0:\"\";s:4:\"size\";s:0:\"\";s:3:\"max\";i:3;}}s:6:\"google\";i:0;s:14:\"google_sitekey\";s:0:\"\";s:16:\"google_secretkey\";s:0:\"\";}', NULL, 'CONTENT', 0, '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 0, '', NULL, 0, '', '', NULL, NULL, NULL),
(5, 2, 1, '2018-10-17 06:23:24', '2022-03-31 20:43:14', '', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<br />\r\n<br />\r\n<span class=\"big\">Titulo</span><br />\r\nLorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<br />\r\n&nbsp;\r\n<ul>\r\n	<li>Lorem ipsum dolor sit amet,</li>\r\n	<li>Lorem ipsum dolor sit amet,&nbsp;consectetuer adipiscing elit</li>\r\n	<li>Lorem ipsum dolor sit</li>\r\n</ul>\r\n<br />\r\n<span class=\"small\">Subtitulo</span><br />\r\nLorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', 1, 10, '5:img-empresa.jpg:23a2264e686e3de095c62b3e4b598995:jpg:500:500::7:0', NULL, 1, '', '', '', 0, NULL, NULL, 0, NULL, NULL, 'a:4:{s:15:\"cimage_lightbox\";i:0;s:16:\"cimage_nocaption\";i:0;s:11:\"cimage_crop\";i:0;s:8:\"corfundo\";s:0:\"\";}', NULL, 'CONTENT', 0, '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 0, '', NULL, 0, '', '', 'a:4:{s:5:\"botao\";s:0:\"\";s:4:\"tipo\";s:1:\"1\";s:4:\"link\";s:0:\"\";s:3:\"pag\";s:1:\"1\";}', 1, NULL),
(16, 4, 1, '2021-01-01 20:13:28', '2021-01-01 20:13:37', '', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<br />\r\n<br />\r\nLorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<br />\r\n&nbsp;\r\n<ul>\r\n	<li>Lorem ipsum dolor sit amet,</li>\r\n	<li>Lorem ipsum dolor sit amet,&nbsp;consectetuer adipiscing elit</li>\r\n	<li>Lorem ipsum dolor sit</li>\r\n</ul>', 1, 0, '5:img-empresa.jpg:23a2264e686e3de095c62b3e4b598995:jpg:500:500::6:0', '', 1, '', '', '', 0, '', '', 0, '', '', 'a:3:{s:15:\"cimage_lightbox\";i:0;s:16:\"cimage_nocaption\";i:0;s:11:\"cimage_crop\";i:0;}', '', 'CONTENT', 0, '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 0, '', '', 0, '', '', 'a:4:{s:5:\"botao\";s:0:\"\";s:4:\"tipo\";s:1:\"1\";s:4:\"link\";s:0:\"\";s:3:\"pag\";s:1:\"1\";}', NULL, NULL),
(6, 1, 1, '2018-10-17 07:05:57', '2022-03-27 18:13:46', 'Notícias', NULL, 8, 80, NULL, NULL, 1, '', '', '', 0, NULL, NULL, 0, '', NULL, 'a:26:{s:14:\"alink_template\";s:19:\"lista-noticias.html\";s:17:\"alink_allowedtags\";s:58:\"<b><i><u><br><div><a><table><td><tr><img><font><s><strong>\";s:8:\"alink_id\";a:0:{}s:11:\"alink_level\";a:1:{i:0;s:1:\"6\";}s:10:\"alink_type\";i:1;s:15:\"alink_wordlimit\";s:0:\"\";s:17:\"alink_hidesummary\";i:0;s:13:\"alink_columns\";i:0;s:19:\"alink_categoryalias\";i:0;s:9:\"alink_max\";i:3;s:11:\"alink_width\";i:600;s:12:\"alink_height\";i:600;s:10:\"alink_zoom\";i:0;s:12:\"alink_unique\";i:0;s:10:\"alink_crop\";i:0;s:10:\"alink_prio\";i:0;s:14:\"addclassemulti\";i:0;s:11:\"numeromulti\";i:0;s:11:\"classemulti\";N;s:9:\"addclasse\";i:0;s:12:\"numeroclasse\";i:0;s:16:\"addclasse_classe\";N;s:11:\"alink_andor\";s:2:\"OR\";s:14:\"alink_category\";a:0:{}s:14:\"alink_paginate\";i:0;s:11:\"alink_itens\";s:0:\"\";}', NULL, 'CONTENT', 0, '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 0, '', NULL, 0, '', '', 'a:4:{s:5:\"botao\";s:13:\"Mais Notícias\";s:4:\"tipo\";s:1:\"1\";s:4:\"link\";s:14:\"index.php?id=6\";s:3:\"pag\";s:1:\"1\";}', NULL, NULL),
(7, 9, 1, '2019-02-14 17:04:06', '2019-02-14 17:21:09', '', NULL, 13, 10, NULL, NULL, 1, '', '', '', 0, NULL, NULL, 0, NULL, NULL, 'a:36:{s:15:\"result_per_page\";s:0:\"\";s:9:\"wordlimit\";s:0:\"\";s:6:\"newwin\";i:0;s:16:\"highlight_result\";i:0;s:11:\"label_input\";s:0:\"\";s:11:\"style_input\";s:0:\"\";s:12:\"label_button\";s:6:\"Buscar\";s:12:\"style_button\";s:0:\"\";s:12:\"label_result\";s:0:\"\";s:12:\"style_result\";s:0:\"\";s:5:\"align\";i:0;s:10:\"text_intro\";s:0:\"\";s:11:\"text_result\";s:0:\"\";s:13:\"text_noresult\";s:27:\"Nenhum Resultado Encontrado\";s:8:\"template\";s:0:\"\";s:9:\"text_html\";i:0;s:11:\"label_pages\";s:0:\"\";s:7:\"minchar\";i:3;s:8:\"start_at\";a:0:{}s:11:\"show_always\";i:1;s:8:\"show_top\";i:1;s:11:\"show_bottom\";i:1;s:9:\"show_next\";i:1;s:9:\"show_prev\";i:1;s:6:\"module\";a:0:{}s:11:\"search_news\";i:0;s:9:\"news_lang\";a:0:{}s:13:\"news_category\";a:0:{}s:10:\"news_andor\";s:2:\"OR\";s:8:\"news_url\";s:0:\"\";s:12:\"no_filenames\";i:0;s:11:\"no_username\";i:0;s:10:\"no_caption\";i:0;s:10:\"no_keyword\";i:0;s:12:\"hide_summary\";i:0;s:4:\"type\";s:2:\"OR\";}', NULL, 'CONTENT', 0, '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 0, '', NULL, 0, '', '', NULL, NULL, NULL),
(8, 1, 1, '2019-09-18 05:05:03', '2019-09-18 05:47:23', '', NULL, 16, 50, NULL, NULL, 1, '', '', '', 0, NULL, '', 9, NULL, NULL, 'a:24:{s:3:\"pos\";i:0;s:5:\"width\";i:200;s:6:\"height\";i:175;s:10:\"width_zoom\";i:800;s:11:\"height_zoom\";i:800;s:3:\"col\";i:1;s:5:\"space\";i:0;s:4:\"zoom\";i:0;s:8:\"lightbox\";i:0;s:9:\"nocaption\";i:0;s:6:\"center\";i:0;s:4:\"crop\";i:0;s:9:\"crop_zoom\";i:0;s:3:\"fx1\";i:0;s:3:\"fx2\";i:0;s:3:\"fx3\";i:0;s:14:\"addclassemulti\";i:0;s:5:\"tempo\";i:0;s:11:\"numeromulti\";i:0;s:11:\"classemulti\";N;s:9:\"addclasse\";i:0;s:12:\"numeroclasse\";i:0;s:16:\"addclasse_classe\";N;s:6:\"images\";a:0:{}}', NULL, 'CONTENT', 0, '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 0, '', NULL, 0, '', '', NULL, NULL, NULL),
(9, 1, 1, '2019-09-18 05:05:47', '2019-09-18 05:47:26', '', NULL, 16, 50, NULL, NULL, 1, '', '', '', 0, NULL, '', 9, NULL, NULL, 'a:24:{s:3:\"pos\";i:0;s:5:\"width\";i:200;s:6:\"height\";i:175;s:10:\"width_zoom\";i:800;s:11:\"height_zoom\";i:800;s:3:\"col\";i:1;s:5:\"space\";i:0;s:4:\"zoom\";i:0;s:8:\"lightbox\";i:0;s:9:\"nocaption\";i:0;s:6:\"center\";i:0;s:4:\"crop\";i:0;s:9:\"crop_zoom\";i:0;s:3:\"fx1\";i:0;s:3:\"fx2\";i:0;s:3:\"fx3\";i:0;s:14:\"addclassemulti\";i:0;s:5:\"tempo\";i:0;s:11:\"numeromulti\";i:0;s:11:\"classemulti\";N;s:9:\"addclasse\";i:0;s:12:\"numeroclasse\";i:0;s:16:\"addclasse_classe\";N;s:6:\"images\";a:0:{}}', NULL, 'CONTENT', 0, '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 0, '', NULL, 0, '', '', NULL, NULL, NULL),
(10, 1, 1, '2019-09-18 05:24:00', '2019-09-18 05:47:29', '', NULL, 16, 50, NULL, NULL, 0, '', '', '', 0, NULL, '', 9, NULL, NULL, 'a:24:{s:3:\"pos\";i:0;s:5:\"width\";i:1920;s:6:\"height\";i:1080;s:10:\"width_zoom\";i:800;s:11:\"height_zoom\";i:800;s:3:\"col\";i:1;s:5:\"space\";i:0;s:4:\"zoom\";i:0;s:8:\"lightbox\";i:0;s:9:\"nocaption\";i:0;s:6:\"center\";i:0;s:4:\"crop\";i:0;s:9:\"crop_zoom\";i:0;s:3:\"fx1\";i:0;s:3:\"fx2\";i:0;s:3:\"fx3\";i:0;s:14:\"addclassemulti\";i:0;s:5:\"tempo\";i:10;s:11:\"numeromulti\";i:0;s:11:\"classemulti\";N;s:9:\"addclasse\";i:0;s:12:\"numeroclasse\";i:0;s:16:\"addclasse_classe\";N;s:6:\"images\";a:2:{i:0;a:15:{s:8:\"thumb_id\";i:3;s:7:\"zoom_id\";s:0:\"\";s:10:\"thumb_name\";s:12:\"banner-1.jpg\";s:9:\"zoom_name\";s:0:\"\";s:4:\"sort\";i:0;s:7:\"caption\";s:16:\"Slogan do Banner\";s:8:\"freetext\";s:19:\"Subtitulo do banner\";s:3:\"url\";s:1:\"#\";s:4:\"tipo\";s:1:\"1\";s:6:\"pagina\";s:1:\"1\";s:5:\"botao\";s:10:\"Saiba Mais\";s:10:\"thumb_hash\";s:32:\"6aa0ec42d0d9667ea6e2c1fa73224f25\";s:9:\"thumb_ext\";s:3:\"jpg\";s:9:\"zoom_hash\";s:0:\"\";s:8:\"zoom_ext\";s:0:\"\";}i:1;a:15:{s:8:\"thumb_id\";i:4;s:7:\"zoom_id\";s:0:\"\";s:10:\"thumb_name\";s:12:\"banner-2.jpg\";s:9:\"zoom_name\";s:0:\"\";s:4:\"sort\";i:1;s:7:\"caption\";s:16:\"Slogan do Banner\";s:8:\"freetext\";s:26:\"&#8203;Subtitulo do banner\";s:3:\"url\";s:1:\"#\";s:4:\"tipo\";s:1:\"1\";s:6:\"pagina\";s:1:\"1\";s:5:\"botao\";s:10:\"Saiba Mais\";s:10:\"thumb_hash\";s:32:\"e3bde1cff80deb90432a91a9dc4ea4da\";s:9:\"thumb_ext\";s:3:\"jpg\";s:9:\"zoom_hash\";s:0:\"\";s:8:\"zoom_ext\";s:0:\"\";}}}', NULL, 'BANNER', 0, 'banner.html', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 0, '', NULL, 0, '', '', NULL, NULL, NULL),
(11, 1, 1, '2021-01-01 01:55:13', '2021-01-01 02:47:31', 'Slogan Principal', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', 1, 40, '15:fundo-slogan.jpg:f5bb5d420c811d2d470bbbd26a567516:jpg:1920:1080::0:0', NULL, 1, 'Subtitulo', '', '', 0, NULL, NULL, 0, NULL, NULL, 'a:3:{s:15:\"cimage_lightbox\";i:0;s:16:\"cimage_nocaption\";i:0;s:11:\"cimage_crop\";i:0;}', NULL, 'CONTENT', 0, 'imagem-fundo.html', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 0, '', NULL, 0, '', '', 'a:4:{s:5:\"botao\";s:0:\"\";s:4:\"tipo\";s:1:\"1\";s:4:\"link\";s:1:\"#\";s:3:\"pag\";s:1:\"1\";}', NULL, NULL),
(13, 2, 1, '2021-01-01 19:54:27', '2021-01-01 20:01:16', 'Titulo do Texto', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', 1, 20, '5:img-empresa.jpg:23a2264e686e3de095c62b3e4b598995:jpg:200:200::0:0', NULL, 1, 'Subtitulo', '', '', 0, NULL, NULL, 0, NULL, NULL, 'a:3:{s:15:\"cimage_lightbox\";i:0;s:16:\"cimage_nocaption\";i:0;s:11:\"cimage_crop\";i:0;}', NULL, 'CONTENT', 0, 'modelo2.html', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 0, '', NULL, 0, '', '', 'a:4:{s:5:\"botao\";s:0:\"\";s:4:\"tipo\";s:1:\"1\";s:4:\"link\";s:0:\"\";s:3:\"pag\";s:1:\"1\";}', NULL, NULL),
(14, 2, 1, '2021-01-01 20:01:44', '2021-01-01 20:03:52', 'Titulo do Texto', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', 1, 35, '', '', 1, 'Subtitulo', '', '', 0, '', '', 0, '', '', 'a:3:{s:15:\"cimage_lightbox\";i:0;s:16:\"cimage_nocaption\";i:0;s:11:\"cimage_crop\";i:0;}', '', 'CONTENT', 0, 'modelo3.html', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 0, '', '', 0, '', '', 'a:4:{s:5:\"botao\";s:0:\"\";s:4:\"tipo\";s:1:\"1\";s:4:\"link\";s:0:\"\";s:3:\"pag\";s:1:\"1\";}', NULL, NULL),
(15, 2, 1, '2021-01-01 20:03:45', '2021-01-01 20:05:36', 'Titulo do Texto', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', 1, 45, '15:fundo-slogan.jpg:f5bb5d420c811d2d470bbbd26a567516:jpg:800:200::0:0', '', 1, 'Subtitulo', '', '', 0, '', '', 0, '', '', 'a:3:{s:15:\"cimage_lightbox\";i:0;s:16:\"cimage_nocaption\";i:0;s:11:\"cimage_crop\";i:1;}', '', 'CONTENT', 0, 'modelo4.html', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 0, '', '', 0, '', '', 'a:4:{s:5:\"botao\";s:0:\"\";s:4:\"tipo\";s:1:\"1\";s:4:\"link\";s:0:\"\";s:3:\"pag\";s:1:\"1\";}', NULL, NULL),
(17, 4, 1, '2021-01-01 20:20:47', '2021-01-01 20:37:40', 'Titulo do Texto', 'Titulo  Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Titulo  Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', 32, 20, NULL, NULL, 1, 'Subtitulo', '', '', 0, NULL, '<dl>\n	<dt>Titulo</dt>\n	<dd>\n	</dd>\n	<dt>Titulo</dt>\n	<dd>\n		<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>\n	</dd>\n</dl>', 0, NULL, NULL, 'a:3:{i:0;a:3:{s:8:\"tabtitle\";s:6:\"Titulo\";s:11:\"tabheadline\";s:0:\"\";s:7:\"tabtext\";s:296:\"<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>\";}i:1;a:3:{s:8:\"tabtitle\";s:6:\"Titulo\";s:11:\"tabheadline\";s:0:\"\";s:7:\"tabtext\";s:296:\"<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>\";}s:13:\"tabwysiwygoff\";i:0;}', NULL, 'CONTENT', 0, '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 0, '', NULL, 0, '', '', NULL, NULL, NULL),
(18, 4, 1, '2021-01-01 20:43:29', '2022-05-08 22:05:32', 'Galeria de Fotos', '', 29, 30, NULL, NULL, 1, '', '', '', 0, NULL, NULL, 0, NULL, NULL, 'a:19:{s:6:\"images\";a:5:{i:0;a:7:{i:0;s:1:\"7\";i:1;s:13:\"servico-1.jpg\";i:2;s:32:\"b71d9060adbbf99ce7394ad39a78e71d\";i:3;s:3:\"jpg\";i:4;i:350;i:5;i:250;i:6;s:0:\"\";}i:1;a:7:{i:0;s:1:\"9\";i:1;s:13:\"servico-2.jpg\";i:2;s:32:\"13aa61311fc7f8c8483887a473ed6021\";i:3;s:3:\"jpg\";i:4;i:350;i:5;i:250;i:6;s:0:\"\";}i:2;a:7:{i:0;s:1:\"8\";i:1;s:13:\"servico-3.jpg\";i:2;s:32:\"71b368bda82fd6fdfe77a1114a1ede3e\";i:3;s:3:\"jpg\";i:4;i:350;i:5;i:250;i:6;s:0:\"\";}i:3;a:7:{i:0;s:2:\"10\";i:1;s:13:\"servico-4.jpg\";i:2;s:32:\"a285ce650a80f8e357e7d0440d9c0895\";i:3;s:3:\"jpg\";i:4;i:350;i:5;i:250;i:6;s:0:\"\";}i:4;a:7:{i:0;s:1:\"7\";i:1;s:13:\"servico-1.jpg\";i:2;s:32:\"b71d9060adbbf99ce7394ad39a78e71d\";i:3;s:3:\"jpg\";i:4;i:350;i:5;i:250;i:6;s:0:\"\";}}s:5:\"width\";i:350;s:6:\"height\";i:250;s:3:\"pos\";i:0;s:3:\"col\";i:2;s:4:\"zoom\";i:1;s:4:\"crop\";i:1;s:5:\"space\";i:3;s:8:\"lightbox\";i:1;s:9:\"nocaption\";i:0;s:5:\"limit\";i:0;s:6:\"random\";i:0;s:14:\"addclassemulti\";i:0;s:11:\"numeromulti\";i:0;s:11:\"classemulti\";N;s:9:\"addclasse\";i:0;s:12:\"numeroclasse\";i:0;s:16:\"addclasse_classe\";N;s:12:\"center_image\";i:0;}', NULL, 'CONTENT', 0, '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 0, '', NULL, 0, '', '', 'a:1:{s:14:\"cimage_colunas\";s:0:\"\";}', NULL, NULL),
(19, 3, 1, '2021-01-01 23:00:35', '2021-01-01 23:09:19', '', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<br />\r\n<br />\r\n<span class=\"big\">Titulo</span><br />\r\nLorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<br />\r\n&nbsp;\r\n<ul>\r\n	<li>Lorem ipsum dolor sit amet,</li>\r\n	<li>Lorem ipsum dolor sit amet,&nbsp;consectetuer adipiscing elit</li>\r\n	<li>Lorem ipsum dolor sit</li>\r\n</ul>\r\n<br />\r\n<span class=\"small\">Subtitulo</span><br />\r\nLorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', 1, 0, '7:servico-1.jpg:b71d9060adbbf99ce7394ad39a78e71d:jpg:500:500::7:0', '', 1, '', '', '', 0, '', '', 0, '', '', 'a:3:{s:15:\"cimage_lightbox\";i:0;s:16:\"cimage_nocaption\";i:0;s:11:\"cimage_crop\";i:0;}', '', 'CONTENT', 0, '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 0, '', '', 0, '', '', 'a:4:{s:5:\"botao\";s:0:\"\";s:4:\"tipo\";s:1:\"1\";s:4:\"link\";s:0:\"\";s:3:\"pag\";s:1:\"1\";}', NULL, NULL),
(20, 10, 1, '2021-01-01 23:00:35', '2021-01-01 23:09:19', '', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<br />\r\n<br />\r\n<span class=\"big\">Titulo</span><br />\r\nLorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<br />\r\n&nbsp;\r\n<ul>\r\n	<li>Lorem ipsum dolor sit amet,</li>\r\n	<li>Lorem ipsum dolor sit amet,&nbsp;consectetuer adipiscing elit</li>\r\n	<li>Lorem ipsum dolor sit</li>\r\n</ul>\r\n<br />\r\n<span class=\"small\">Subtitulo</span><br />\r\nLorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', 1, 0, '7:servico-1.jpg:b71d9060adbbf99ce7394ad39a78e71d:jpg:500:500::7:0', '', 1, '', '', '', 0, '', '', 0, '', '', 'a:3:{s:15:\"cimage_lightbox\";i:0;s:16:\"cimage_nocaption\";i:0;s:11:\"cimage_crop\";i:0;}', '', 'CONTENT', 0, '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 0, '', '', 0, '', '', 'a:4:{s:5:\"botao\";s:0:\"\";s:4:\"tipo\";s:1:\"1\";s:4:\"link\";s:0:\"\";s:3:\"pag\";s:1:\"1\";}', NULL, NULL),
(21, 11, 1, '2021-01-01 23:00:35', '2021-01-01 23:09:19', '', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<br />\r\n<br />\r\n<span class=\"big\">Titulo</span><br />\r\nLorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<br />\r\n&nbsp;\r\n<ul>\r\n	<li>Lorem ipsum dolor sit amet,</li>\r\n	<li>Lorem ipsum dolor sit amet,&nbsp;consectetuer adipiscing elit</li>\r\n	<li>Lorem ipsum dolor sit</li>\r\n</ul>\r\n<br />\r\n<span class=\"small\">Subtitulo</span><br />\r\nLorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', 1, 0, '7:servico-1.jpg:b71d9060adbbf99ce7394ad39a78e71d:jpg:500:500::7:0', '', 1, '', '', '', 0, '', '', 0, '', '', 'a:3:{s:15:\"cimage_lightbox\";i:0;s:16:\"cimage_nocaption\";i:0;s:11:\"cimage_crop\";i:0;}', '', 'CONTENT', 0, '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 0, '', '', 0, '', '', 'a:4:{s:5:\"botao\";s:0:\"\";s:4:\"tipo\";s:1:\"1\";s:4:\"link\";s:0:\"\";s:3:\"pag\";s:1:\"1\";}', NULL, NULL),
(22, 0, 0, '0000-00-00 00:00:00', '2022-03-31 19:15:51', NULL, NULL, 0, 0, NULL, NULL, 0, NULL, '', '', 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'CONTENT', 0, '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', NULL, 0, '', NULL, 0, '', '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_cache`
--

CREATE TABLE `phpwcms_cache` (
  `cache_id` int(11) NOT NULL,
  `cache_hash` varchar(50) COLLATE latin1_bin DEFAULT '',
  `cache_uri` text COLLATE latin1_bin,
  `cache_cid` int(11) DEFAULT '0',
  `cache_aid` int(11) DEFAULT '0',
  `cache_timeout` varchar(20) COLLATE latin1_bin DEFAULT '0',
  `cache_isprint` int(1) DEFAULT '0',
  `cache_changed` int(14) DEFAULT NULL,
  `cache_use` int(1) DEFAULT '0',
  `cache_searchable` int(1) DEFAULT '0',
  `cache_page` longtext COLLATE latin1_bin,
  `cache_stripped` longtext COLLATE latin1_bin
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_calendar`
--

CREATE TABLE `phpwcms_calendar` (
  `calendar_id` int(11) NOT NULL,
  `calendar_created` datetime DEFAULT '0000-00-00 00:00:00',
  `calendar_changed` datetime DEFAULT '0000-00-00 00:00:00',
  `calendar_status` int(1) DEFAULT '0',
  `calendar_start` datetime DEFAULT '0000-00-00 00:00:00',
  `calendar_end` datetime DEFAULT '0000-00-00 00:00:00',
  `calendar_allday` int(1) DEFAULT '0',
  `calendar_range` int(1) DEFAULT '0',
  `calendar_range_start` date DEFAULT '0000-00-00',
  `calendar_range_end` date DEFAULT '0000-00-00',
  `calendar_title` varchar(255) COLLATE latin1_bin DEFAULT '',
  `calendar_where` varchar(255) COLLATE latin1_bin DEFAULT '',
  `calendar_teaser` text COLLATE latin1_bin,
  `calendar_text` mediumtext COLLATE latin1_bin,
  `calendar_tag` varchar(255) COLLATE latin1_bin DEFAULT '',
  `calendar_object` longtext COLLATE latin1_bin,
  `calendar_refid` int(11) DEFAULT '0',
  `calendar_lang` varchar(255) COLLATE latin1_bin DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_categories`
--

CREATE TABLE `phpwcms_categories` (
  `cat_id` int(10) UNSIGNED NOT NULL,
  `cat_type` varchar(255) COLLATE latin1_bin DEFAULT '',
  `cat_pid` int(11) DEFAULT '0',
  `cat_status` int(1) DEFAULT '0',
  `cat_createdate` datetime DEFAULT '0000-00-00 00:00:00',
  `cat_changedate` datetime DEFAULT '0000-00-00 00:00:00',
  `cat_name` varchar(255) COLLATE latin1_bin DEFAULT '',
  `cat_info` text COLLATE latin1_bin,
  `cat_sort` int(11) DEFAULT '0',
  `cat_opengraph` int(1) UNSIGNED DEFAULT '1',
  `cat_pasta` varchar(255) COLLATE latin1_bin NOT NULL,
  `cat_title` varchar(255) COLLATE latin1_bin NOT NULL,
  `cat_description` text COLLATE latin1_bin NOT NULL,
  `cat_alias` varchar(255) COLLATE latin1_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_chat`
--

CREATE TABLE `phpwcms_chat` (
  `chat_id` int(11) NOT NULL,
  `chat_uid` int(11) NOT NULL DEFAULT '0',
  `chat_name` varchar(30) COLLATE latin1_bin NOT NULL DEFAULT '',
  `chat_tstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `chat_text` varchar(255) COLLATE latin1_bin NOT NULL DEFAULT '',
  `chat_cat` int(5) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_content`
--

CREATE TABLE `phpwcms_content` (
  `cnt_id` int(11) NOT NULL,
  `cnt_pid` int(11) DEFAULT '0',
  `cnt_created` int(11) DEFAULT '0',
  `cnt_changed` int(11) DEFAULT '0',
  `cnt_status` int(1) DEFAULT '0',
  `cnt_type` varchar(255) COLLATE latin1_bin DEFAULT NULL,
  `cnt_module` varchar(255) COLLATE latin1_bin DEFAULT NULL,
  `cnt_group` int(11) DEFAULT '0',
  `cnt_owner` int(11) DEFAULT '0',
  `cnt_livedate` datetime DEFAULT '0000-00-00 00:00:00',
  `cnt_killdate` datetime DEFAULT '0000-00-00 00:00:00',
  `cnt_archive_status` int(11) DEFAULT '0',
  `cnt_sort` int(11) DEFAULT '0',
  `cnt_prio` int(11) DEFAULT '0',
  `cnt_alias` varchar(255) COLLATE latin1_bin DEFAULT NULL,
  `cnt_name` varchar(255) COLLATE latin1_bin DEFAULT '',
  `cnt_title` varchar(255) COLLATE latin1_bin DEFAULT '',
  `cnt_subtitle` varchar(255) COLLATE latin1_bin DEFAULT '',
  `cnt_editor` varchar(255) COLLATE latin1_bin DEFAULT NULL,
  `cnt_place` varchar(255) COLLATE latin1_bin DEFAULT NULL,
  `cnt_teasertext` text COLLATE latin1_bin,
  `cnt_text` text COLLATE latin1_bin,
  `cnt_lang` varchar(10) COLLATE latin1_bin DEFAULT '',
  `cnt_object` text COLLATE latin1_bin,
  `cnt_opengraph` int(1) UNSIGNED DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_country`
--

CREATE TABLE `phpwcms_country` (
  `country_id` int(4) NOT NULL,
  `country_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `country_iso` char(2) COLLATE latin1_bin NOT NULL DEFAULT '',
  `country_iso3` char(3) COLLATE latin1_bin NOT NULL DEFAULT '',
  `country_isonum` int(11) NOT NULL DEFAULT '0',
  `country_continent_code` char(2) COLLATE latin1_bin NOT NULL DEFAULT '',
  `country_name` varchar(255) COLLATE latin1_bin NOT NULL DEFAULT '',
  `country_name_de` varchar(255) COLLATE latin1_bin NOT NULL DEFAULT '',
  `country_continent` varchar(255) COLLATE latin1_bin NOT NULL DEFAULT '',
  `country_continent_de` varchar(255) COLLATE latin1_bin NOT NULL DEFAULT '',
  `country_region` varchar(255) COLLATE latin1_bin NOT NULL DEFAULT '',
  `country_region_de` varchar(255) COLLATE latin1_bin NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Extraindo dados da tabela `phpwcms_country`
--

INSERT INTO `phpwcms_country` (`country_id`, `country_updated`, `country_iso`, `country_iso3`, `country_isonum`, `country_continent_code`, `country_name`, `country_name_de`, `country_continent`, `country_continent_de`, `country_region`, `country_region_de`) VALUES
(1, '0000-00-00 00:00:00', 'AF', 'AFG', 4, 'AS', 'Afghanistan, Islamic Republic of', 'Afghanistan', 'Asia', 'Asien', '', ''),
(2, '0000-00-00 00:00:00', 'AL', 'ALB', 8, 'EU', 'Albania, Republic of', 'Albanien', 'Europe', 'Europa', '', ''),
(3, '0000-00-00 00:00:00', 'DZ', 'DZA', 12, 'AF', 'Algeria, People\'s Democratic Republic of', 'Algerien', 'Africa', 'Afrika', '', ''),
(4, '0000-00-00 00:00:00', 'AS', 'ASM', 16, 'OC', 'American Samoa', 'Amerikanisch Samoa', 'Oceania', 'Ozeanien', '', ''),
(5, '0000-00-00 00:00:00', 'AD', 'AND', 20, 'EU', 'Andorra, Principality of', 'Andorra', 'Europe', 'Europa', '', ''),
(6, '0000-00-00 00:00:00', 'AO', 'AGO', 24, 'AF', 'Angola, Republic of', 'Angola', 'Africa', 'Afrika', '', ''),
(7, '0000-00-00 00:00:00', 'AI', 'AIA', 660, 'NA', 'Anguilla', 'Anguilla', 'North America', 'Nordamerika', '', ''),
(8, '0000-00-00 00:00:00', 'AQ', 'ATA', 10, 'AN', 'Antarctica (the territory South of 60 deg S)', 'Antarktis', 'Antarctica', 'Antarktis', '', ''),
(9, '0000-00-00 00:00:00', 'AG', 'ATG', 28, 'NA', 'Antigua and Barbuda', 'Antigua und Barbuda', 'North America', 'Nordamerika', '', ''),
(10, '0000-00-00 00:00:00', 'AR', 'ARG', 32, 'SA', 'Argentina, Argentine Republic', 'Argentinien', 'South America', 'Südamerika', '', ''),
(11, '0000-00-00 00:00:00', 'AM', 'ARM', 51, 'AS', 'Armenia, Republic of', 'Armenien', 'Asia', 'Asien', '', ''),
(12, '0000-00-00 00:00:00', 'AW', 'ABW', 533, 'NA', 'Aruba', 'Aruba', 'North America', 'Nordamerika', '', ''),
(13, '0000-00-00 00:00:00', 'AU', 'AUS', 36, 'OC', 'Australia, Commonwealth of', 'Australien', 'Oceania', 'Ozeanien', '', ''),
(14, '0000-00-00 00:00:00', 'AT', 'AUT', 40, 'EU', 'Austria, Republic of', 'Österreich', 'Europe', 'Europa', '', ''),
(15, '0000-00-00 00:00:00', 'AZ', 'AZE', 31, 'AS', 'Azerbaijan, Republic of', 'Aserbaidschan', 'Asia', 'Asien', '', ''),
(16, '0000-00-00 00:00:00', 'BS', 'BHS', 44, 'NA', 'Bahamas, Commonwealth of the', 'Bahamas', 'North America', 'Nordamerika', '', ''),
(17, '0000-00-00 00:00:00', 'BH', 'BHR', 48, 'AS', 'Bahrain, Kingdom of', 'Bahrain', 'Asia', 'Asien', '', ''),
(18, '0000-00-00 00:00:00', 'BD', 'BGD', 50, 'AS', 'Bangladesh, People\'s Republic of', 'Bangladesch', 'Asia', 'Asien', '', ''),
(19, '0000-00-00 00:00:00', 'BB', 'BRB', 52, 'NA', 'Barbados', 'Barbados', 'North America', 'Nordamerika', '', ''),
(20, '0000-00-00 00:00:00', 'BY', 'BLR', 112, 'EU', 'Belarus, Republic of', 'Belarus', 'Europe', 'Europa', '', ''),
(21, '0000-00-00 00:00:00', 'BE', 'BEL', 56, 'EU', 'Belgium, Kingdom of', 'Belgien', 'Europe', 'Europa', '', ''),
(22, '0000-00-00 00:00:00', 'BZ', 'BLZ', 84, 'NA', 'Belize', 'Belize', 'North America', 'Nordamerika', '', ''),
(23, '0000-00-00 00:00:00', 'BJ', 'BEN', 204, 'AF', 'Benin, Republic of', 'Benin', 'Africa', 'Afrika', '', ''),
(24, '0000-00-00 00:00:00', 'BM', 'BMU', 60, 'NA', 'Bermuda', 'Bermuda', 'North America', 'Nordamerika', '', ''),
(25, '0000-00-00 00:00:00', 'BT', 'BTN', 64, 'AS', 'Bhutan, Kingdom of', 'Bhutan', 'Asia', 'Asien', '', ''),
(26, '0000-00-00 00:00:00', 'BO', 'BOL', 68, 'SA', 'Bolivia, Republic of', 'Bolivien', 'South America', 'Südamerika', '', ''),
(27, '0000-00-00 00:00:00', 'BA', 'BIH', 70, 'EU', 'Bosnia and Herzegovina', 'Bosnien und Herzegowina', 'Europe', 'Europa', '', ''),
(28, '0000-00-00 00:00:00', 'BW', 'BWA', 72, 'AF', 'Botswana, Republic of', 'Botsuana', 'Africa', 'Afrika', '', ''),
(29, '0000-00-00 00:00:00', 'BV', 'BVT', 74, 'AN', 'Bouvet Island (Bouvetoya)', 'Bouvet-Insel', 'Antarctica', 'Antarktis', '', ''),
(30, '0000-00-00 00:00:00', 'BR', 'BRA', 76, 'SA', 'Brazil, Federative Republic of', 'Brasilien', 'South America', 'Südamerika', '', ''),
(31, '0000-00-00 00:00:00', 'IO', 'IOT', 86, 'AS', 'British Indian Ocean Territory (Chagos Archipelago)', 'Britisches Territorium Im Indischen Ozean', 'Asia', 'Asien', '', ''),
(32, '0000-00-00 00:00:00', 'BN', 'BRN', 96, 'AS', 'Brunei Darussalam', 'Brunei Darussalam', 'Asia', 'Asien', '', ''),
(33, '0000-00-00 00:00:00', 'BG', 'BGR', 100, 'EU', 'Bulgaria, Republic of', 'Bulgarien', 'Europe', 'Europa', '', ''),
(34, '0000-00-00 00:00:00', 'BF', 'BFA', 854, 'AF', 'Burkina Faso', 'Burkina Faso', 'Africa', 'Afrika', '', ''),
(35, '0000-00-00 00:00:00', 'BI', 'BDI', 108, 'AF', 'Burundi, Republic of', 'Burundi', 'Africa', 'Afrika', '', ''),
(36, '0000-00-00 00:00:00', 'KH', 'KHM', 116, 'AS', 'Cambodia, Kingdom of', 'Kambodscha', 'Asia', 'Asien', '', ''),
(37, '0000-00-00 00:00:00', 'CM', 'CMR', 120, 'AF', 'Cameroon, Republic of', 'Kamerun', 'Africa', 'Afrika', '', ''),
(38, '0000-00-00 00:00:00', 'CA', 'CAN', 124, 'NA', 'Canada', 'Kanada', 'North America', 'Nordamerika', '', ''),
(39, '0000-00-00 00:00:00', 'CV', 'CPV', 132, 'AF', 'Cape Verde, Republic of', 'Kap Verde', 'Africa', 'Afrika', '', ''),
(40, '0000-00-00 00:00:00', 'KY', 'CYM', 136, 'NA', 'Cayman Islands', 'Kaimaninseln', 'North America', 'Nordamerika', '', ''),
(41, '0000-00-00 00:00:00', 'CF', 'CAF', 140, 'AF', 'Central African Republic', 'Zentralafrikanische Republik', 'Africa', 'Afrika', '', ''),
(42, '0000-00-00 00:00:00', 'TD', 'TCD', 148, 'AF', 'Chad, Republic of', 'Tschad', 'Africa', 'Afrika', '', ''),
(43, '0000-00-00 00:00:00', 'CL', 'CHL', 152, 'SA', 'Chile, Republic of', 'Chile', 'South America', 'Südamerika', '', ''),
(44, '0000-00-00 00:00:00', 'CN', 'CHN', 156, 'AS', 'China, People\'s Republic of', 'China', 'Asia', 'Asien', '', ''),
(45, '0000-00-00 00:00:00', 'CX', 'CXR', 162, 'AS', 'Christmas Island', 'Weihnachtsinsel', 'Asia', 'Asien', '', ''),
(46, '0000-00-00 00:00:00', 'CC', 'CCK', 166, 'AS', 'Cocos (Keeling) Islands', 'Kokosinseln (Keelingsinseln)', 'Asia', 'Asien', '', ''),
(47, '0000-00-00 00:00:00', 'CO', 'COL', 170, 'SA', 'Colombia, Republic of', 'Kolumbien', 'South America', 'Südamerika', '', ''),
(48, '0000-00-00 00:00:00', 'KM', 'COM', 174, 'AF', 'Comoros, Union of the', 'Komoren', 'Africa', 'Afrika', '', ''),
(49, '0000-00-00 00:00:00', 'CG', 'COG', 178, 'AF', 'Congo, Republic of the', 'Kongo', 'Africa', 'Afrika', '', ''),
(50, '0000-00-00 00:00:00', 'CD', 'COD', 180, 'AF', 'Congo, Democratic Republic of the', 'Kongo, Demokratische Republik', 'Africa', 'Afrika', '', ''),
(51, '0000-00-00 00:00:00', 'CK', 'COK', 184, 'OC', 'Cook Islands', 'Cook-Inseln', 'Oceania', 'Ozeanien', '', ''),
(52, '0000-00-00 00:00:00', 'CR', 'CRI', 188, 'NA', 'Costa Rica, Republic of', 'Costa Rica', 'North America', 'Nordamerika', '', ''),
(53, '0000-00-00 00:00:00', 'CI', 'CIV', 384, 'AF', 'Cote d\'Ivoire, Republic of', 'Côte D\'Ivoire', 'Africa', 'Afrika', '', ''),
(54, '0000-00-00 00:00:00', 'HR', 'HRV', 191, 'EU', 'Croatia, Republic of', 'Kroatien', 'Europe', 'Europa', '', ''),
(55, '0000-00-00 00:00:00', 'CU', 'CUB', 192, 'NA', 'Cuba, Republic of', 'Kuba', 'North America', 'Nordamerika', '', ''),
(56, '0000-00-00 00:00:00', 'CY', 'CYP', 196, 'AS', 'Cyprus, Republic of', 'Zypern', 'Asia', 'Asien', '', ''),
(57, '0000-00-00 00:00:00', 'CZ', 'CZE', 203, 'EU', 'Czech Republic', 'Tschechische Republik', 'Europe', 'Europa', '', ''),
(58, '0000-00-00 00:00:00', 'DK', 'DNK', 208, 'EU', 'Denmark, Kingdom of', 'Dänemark', 'Europe', 'Europa', '', ''),
(59, '0000-00-00 00:00:00', 'DJ', 'DJI', 262, 'AF', 'Djibouti, Republic of', 'Dschibuti', 'Africa', 'Afrika', '', ''),
(60, '0000-00-00 00:00:00', 'DM', 'DMA', 212, 'NA', 'Dominica, Commonwealth of', 'Dominica', 'North America', 'Nordamerika', '', ''),
(61, '0000-00-00 00:00:00', 'DO', 'DOM', 214, 'NA', 'Dominican Republic', 'Dominikanische Republik', 'North America', 'Nordamerika', '', ''),
(63, '0000-00-00 00:00:00', 'EC', 'ECU', 218, 'SA', 'Ecuador, Republic of', 'Ecuador', 'South America', 'Südamerika', '', ''),
(64, '0000-00-00 00:00:00', 'EG', 'EGY', 818, 'AF', 'Egypt, Arab Republic of', 'Ägypten', 'Africa', 'Afrika', '', ''),
(65, '0000-00-00 00:00:00', 'SV', 'SLV', 222, 'NA', 'El Salvador, Republic of', 'El Salvador', 'North America', 'Nordamerika', '', ''),
(66, '0000-00-00 00:00:00', 'GQ', 'GNQ', 226, 'AF', 'Equatorial Guinea, Republic of', 'Äquatorialguinea', 'Africa', 'Afrika', '', ''),
(67, '0000-00-00 00:00:00', 'ER', 'ERI', 232, 'AF', 'Eritrea, State of', 'Eritrea', 'Africa', 'Afrika', '', ''),
(68, '0000-00-00 00:00:00', 'EE', 'EST', 233, 'EU', 'Estonia, Republic of', 'Estland', 'Europe', 'Europa', '', ''),
(69, '0000-00-00 00:00:00', 'ET', 'ETH', 231, 'AF', 'Ethiopia, Federal Democratic Republic of', 'Äthiopien', 'Africa', 'Afrika', '', ''),
(70, '0000-00-00 00:00:00', 'FK', 'FLK', 238, 'SA', 'Falkland Islands (Malvinas)', 'Falkland-Inseln (Malvinen)', 'South America', 'Südamerika', '', ''),
(71, '0000-00-00 00:00:00', 'FO', 'FRO', 234, 'EU', 'Faroe Islands', 'Färöer', 'Europe', 'Europa', '', ''),
(72, '0000-00-00 00:00:00', 'FJ', 'FJI', 242, 'OC', 'Fiji, Republic of the Fiji Islands', 'Fidschi', 'Oceania', 'Ozeanien', '', ''),
(73, '0000-00-00 00:00:00', 'FI', 'FIN', 246, 'EU', 'Finland, Republic of', 'Finnland', 'Europe', 'Europa', '', ''),
(74, '0000-00-00 00:00:00', 'FR', 'FRA', 250, 'EU', 'France, French Republic', 'Frankreich', 'Europe', 'Europa', '', ''),
(75, '0000-00-00 00:00:00', 'GF', 'GUF', 254, 'SA', 'French Guiana', 'Französisch Guayana', 'South America', 'Südamerika', '', ''),
(76, '0000-00-00 00:00:00', 'PF', 'PYF', 258, 'OC', 'French Polynesia', 'Französisch Polynesien', 'Oceania', 'Ozeanien', '', ''),
(77, '0000-00-00 00:00:00', 'TF', 'ATF', 260, 'AN', 'French Southern Territories', 'Französische Südgebiete', 'Antarctica', 'Antarktis', '', ''),
(78, '0000-00-00 00:00:00', 'GA', 'GAB', 266, 'AF', 'Gabon, Gabonese Republic', 'Gabun', 'Africa', 'Afrika', '', ''),
(79, '0000-00-00 00:00:00', 'GM', 'GMB', 270, 'AF', 'Gambia, Republic of the', 'Gambia', 'Africa', 'Afrika', '', ''),
(80, '0000-00-00 00:00:00', 'GE', 'GEO', 268, 'AS', 'Georgia', 'Georgien', 'Asia', 'Asien', '', ''),
(81, '0000-00-00 00:00:00', 'DE', 'DEU', 276, 'EU', 'Germany, Federal Republic of', 'Deutschland', 'Europe', 'Europa', '', ''),
(82, '0000-00-00 00:00:00', 'GH', 'GHA', 288, 'AF', 'Ghana, Republic of', 'Ghana', 'Africa', 'Afrika', '', ''),
(83, '0000-00-00 00:00:00', 'GI', 'GIB', 292, 'EU', 'Gibraltar', 'Gibraltar', 'Europe', 'Europa', '', ''),
(84, '0000-00-00 00:00:00', 'GR', 'GRC', 300, 'EU', 'Greece, Hellenic Republic', 'Griechenland', 'Europe', 'Europa', '', ''),
(85, '0000-00-00 00:00:00', 'GL', 'GRL', 304, 'NA', 'Greenland', 'Grönland', 'North America', 'Nordamerika', '', ''),
(86, '0000-00-00 00:00:00', 'GD', 'GRD', 308, 'NA', 'Grenada', 'Grenada', 'North America', 'Nordamerika', '', ''),
(87, '0000-00-00 00:00:00', 'GP', 'GLP', 312, 'NA', 'Guadeloupe', 'Guadeloupe', 'North America', 'Nordamerika', '', ''),
(88, '0000-00-00 00:00:00', 'GU', 'GUM', 316, 'OC', 'Guam', 'Guam', 'Oceania', 'Ozeanien', '', ''),
(89, '0000-00-00 00:00:00', 'GT', 'GTM', 320, 'NA', 'Guatemala, Republic of', 'Guatemala', 'North America', 'Nordamerika', '', ''),
(90, '0000-00-00 00:00:00', 'GN', 'GIN', 324, 'AF', 'Guinea, Republic of', 'Guinea', 'Africa', 'Afrika', '', ''),
(91, '0000-00-00 00:00:00', 'GW', 'GNB', 624, 'AF', 'Guinea-Bissau, Republic of', 'Guinea-Bissau', 'Africa', 'Afrika', '', ''),
(92, '0000-00-00 00:00:00', 'GY', 'GUY', 328, 'SA', 'Guyana, Co-operative Republic of', 'Guyana', 'South America', 'Südamerika', '', ''),
(93, '0000-00-00 00:00:00', 'HT', 'HTI', 332, 'NA', 'Haiti, Republic of', 'Haiti', 'North America', 'Nordamerika', '', ''),
(94, '0000-00-00 00:00:00', 'HM', 'HMD', 334, 'AN', 'Heard Island and McDonald Islands', 'Heard und McDonald', 'Antarctica', 'Antarktis', '', ''),
(95, '0000-00-00 00:00:00', 'VA', 'VAT', 336, 'EU', 'Holy See (Vatican City State)', 'Vatikanstadt, Staat (Heiliger Stuhl)', 'Europe', 'Europa', '', ''),
(96, '0000-00-00 00:00:00', 'HN', 'HND', 340, 'NA', 'Honduras, Republic of', 'Honduras', 'North America', 'Nordamerika', '', ''),
(97, '0000-00-00 00:00:00', 'HK', 'HKG', 344, 'AS', 'Hong Kong, Special Administrative Region of China', 'Hongkong', 'Asia', 'Asien', '', ''),
(98, '0000-00-00 00:00:00', 'HU', 'HUN', 348, 'EU', 'Hungary, Republic of', 'Ungarn', 'Europe', 'Europa', '', ''),
(99, '0000-00-00 00:00:00', 'IS', 'ISL', 352, 'EU', 'Iceland, Republic of', 'Island', 'Europe', 'Europa', '', ''),
(100, '0000-00-00 00:00:00', 'IN', 'IND', 356, 'AS', 'India, Republic of', 'Indien', 'Asia', 'Asien', '', ''),
(101, '0000-00-00 00:00:00', 'ID', 'IDN', 360, 'AS', 'Indonesia, Republic of', 'Indonesien', 'Asia', 'Asien', '', ''),
(102, '0000-00-00 00:00:00', 'IR', 'IRN', 364, 'AS', 'Iran, Islamic Republic of', 'Iran (Islamische Republik)', 'Asia', 'Asien', '', ''),
(103, '0000-00-00 00:00:00', 'IQ', 'IRQ', 368, 'AS', 'Iraq, Republic of', 'Irak', 'Asia', 'Asien', '', ''),
(104, '0000-00-00 00:00:00', 'IE', 'IRL', 372, 'EU', 'Ireland', 'Irland', 'Europe', 'Europa', '', ''),
(105, '0000-00-00 00:00:00', 'IL', 'ISR', 376, 'AS', 'Israel, State of', 'Israel', 'Asia', 'Asien', '', ''),
(106, '0000-00-00 00:00:00', 'IT', 'ITA', 380, 'EU', 'Italy, Italian Republic', 'Italien', 'Europe', 'Europa', '', ''),
(107, '0000-00-00 00:00:00', 'JM', 'JAM', 388, 'NA', 'Jamaica', 'Jamaika', 'North America', 'Nordamerika', '', ''),
(108, '0000-00-00 00:00:00', 'JP', 'JPN', 392, 'AS', 'Japan', 'Japan', 'Asia', 'Asien', '', ''),
(109, '0000-00-00 00:00:00', 'JO', 'JOR', 400, 'AS', 'Jordan, Hashemite Kingdom of', 'Jordanien', 'Asia', 'Asien', '', ''),
(110, '0000-00-00 00:00:00', 'KZ', 'KAZ', 398, 'AS', 'Kazakhstan, Republic of', 'Kasachstan', 'Asia', 'Asien', '', ''),
(111, '0000-00-00 00:00:00', 'KE', 'KEN', 404, 'AF', 'Kenya, Republic of', 'Kenia', 'Africa', 'Afrika', '', ''),
(112, '0000-00-00 00:00:00', 'KI', 'KIR', 296, 'OC', 'Kiribati, Republic of', 'Kiribati', 'Oceania', 'Ozeanien', '', ''),
(113, '0000-00-00 00:00:00', 'KP', 'PRK', 408, 'AS', 'Korea, Democratic People\'s Republic of', 'Korea, Demokratische Volksrepublik', 'Asia', 'Asien', '', ''),
(114, '0000-00-00 00:00:00', 'KR', 'KOR', 410, 'AS', 'Korea, Republic of', 'Korea, Republik', 'Asia', 'Asien', '', ''),
(115, '0000-00-00 00:00:00', 'KW', 'KWT', 414, 'AS', 'Kuwait, State of', 'Kuwait', 'Asia', 'Asien', '', ''),
(116, '0000-00-00 00:00:00', 'KG', 'KGZ', 417, 'AS', 'Kyrgyz Republic', 'Kirgisistan', 'Asia', 'Asien', '', ''),
(117, '0000-00-00 00:00:00', 'LA', 'LAO', 418, 'AS', 'Lao People\'s Democratic Republic', 'Laos, Demokratische Volksrepublik', 'Asia', 'Asien', '', ''),
(118, '0000-00-00 00:00:00', 'LV', 'LVA', 428, 'EU', 'Latvia, Republic of', 'Lettland', 'Europe', 'Europa', '', ''),
(119, '0000-00-00 00:00:00', 'LB', 'LBN', 422, 'AS', 'Lebanon, Lebanese Republic', 'Libanon', 'Asia', 'Asien', '', ''),
(120, '0000-00-00 00:00:00', 'LS', 'LSO', 426, 'AF', 'Lesotho, Kingdom of', 'Lesotho', 'Africa', 'Afrika', '', ''),
(121, '0000-00-00 00:00:00', 'LR', 'LBR', 430, 'AF', 'Liberia, Republic of', 'Liberia', 'Africa', 'Afrika', '', ''),
(122, '0000-00-00 00:00:00', 'LY', 'LBY', 434, 'AF', 'Libyan Arab Jamahiriya', 'Libysch-Arabische Dschamahirija', 'Africa', 'Afrika', '', ''),
(123, '0000-00-00 00:00:00', 'LI', 'LIE', 438, 'EU', 'Liechtenstein, Principality of', 'Liechtenstein', 'Europe', 'Europa', '', ''),
(124, '0000-00-00 00:00:00', 'LT', 'LTU', 440, 'EU', 'Lithuania, Republic of', 'Litauen', 'Europe', 'Europa', '', ''),
(125, '0000-00-00 00:00:00', 'LU', 'LUX', 442, 'EU', 'Luxembourg, Grand Duchy of', 'Luxembourg', 'Europe', 'Europa', '', ''),
(126, '0000-00-00 00:00:00', 'MO', 'MAC', 446, 'AS', 'Macao, Special Administrative Region of China', 'Macau', 'Asia', 'Asien', '', ''),
(127, '0000-00-00 00:00:00', 'MK', 'MKD', 807, 'EU', 'Macedonia, the former Yugoslav Republic of', 'Mazedonien, Ehemalige Jugoslawische Republik', 'Europe', 'Europa', '', ''),
(128, '0000-00-00 00:00:00', 'MG', 'MDG', 450, 'AF', 'Madagascar, Republic of', 'Madagaskar', 'Africa', 'Afrika', '', ''),
(129, '0000-00-00 00:00:00', 'MW', 'MWI', 454, 'AF', 'Malawi, Republic of', 'Malawi', 'Africa', 'Afrika', '', ''),
(130, '0000-00-00 00:00:00', 'MY', 'MYS', 458, 'AS', 'Malaysia', 'Malaysia', 'Asia', 'Asien', '', ''),
(131, '0000-00-00 00:00:00', 'MV', 'MDV', 462, 'AS', 'Maldives, Republic of', 'Malediven', 'Asia', 'Asien', '', ''),
(132, '0000-00-00 00:00:00', 'ML', 'MLI', 466, 'AF', 'Mali, Republic of', 'Mali', 'Africa', 'Afrika', '', ''),
(133, '0000-00-00 00:00:00', 'MT', 'MLT', 470, 'EU', 'Malta, Republic of', 'Malta', 'Europe', 'Europa', '', ''),
(134, '0000-00-00 00:00:00', 'MH', 'MHL', 584, 'OC', 'Marshall Islands, Republic of the', 'Marshallinseln', 'Oceania', 'Ozeanien', '', ''),
(135, '0000-00-00 00:00:00', 'MQ', 'MTQ', 474, 'NA', 'Martinique', 'Martinique', 'North America', 'Nordamerika', '', ''),
(136, '0000-00-00 00:00:00', 'MR', 'MRT', 478, 'AF', 'Mauritania, Islamic Republic of', 'Mauretanien', 'Africa', 'Afrika', '', ''),
(137, '0000-00-00 00:00:00', 'MU', 'MUS', 480, 'AF', 'Mauritius, Republic of', 'Mauritius', 'Africa', 'Afrika', '', ''),
(138, '0000-00-00 00:00:00', 'YT', 'MYT', 175, 'AF', 'Mayotte', 'Mayotte', 'Africa', 'Afrika', '', ''),
(139, '0000-00-00 00:00:00', 'MX', 'MEX', 484, 'NA', 'Mexico, United Mexican States', 'Mexiko', 'North America', 'Nordamerika', '', ''),
(140, '0000-00-00 00:00:00', 'FM', 'FSM', 583, 'OC', 'Micronesia, Federated States of', 'Mikronesien, Föderierte Staaten Von', 'Oceania', 'Ozeanien', '', ''),
(141, '0000-00-00 00:00:00', 'MD', 'MDA', 498, 'EU', 'Moldova, Republic of', 'Moldau, Republik', 'Europe', 'Europa', '', ''),
(142, '0000-00-00 00:00:00', 'MC', 'MCO', 492, 'EU', 'Monaco, Principality of', 'Monaco', 'Europe', 'Europa', '', ''),
(143, '0000-00-00 00:00:00', 'MN', 'MNG', 496, 'AS', 'Mongolia', 'Mongolei', 'Asia', 'Asien', '', ''),
(144, '0000-00-00 00:00:00', 'MS', 'MSR', 500, 'NA', 'Montserrat', 'Montserrat', 'North America', 'Nordamerika', '', ''),
(145, '0000-00-00 00:00:00', 'MA', 'MAR', 504, 'AF', 'Morocco, Kingdom of', 'Marokko', 'Africa', 'Afrika', '', ''),
(146, '0000-00-00 00:00:00', 'MZ', 'MOZ', 508, 'AF', 'Mozambique, Republic of', 'Mosambik', 'Africa', 'Afrika', '', ''),
(147, '0000-00-00 00:00:00', 'MM', 'MMR', 104, 'AS', 'Myanmar, Union of', 'Myanmar', 'Asia', 'Asien', '', ''),
(148, '0000-00-00 00:00:00', 'NA', 'NAM', 516, 'AF', 'Namibia, Republic of', 'Namibia', 'Africa', 'Afrika', '', ''),
(149, '0000-00-00 00:00:00', 'NR', 'NRU', 520, 'OC', 'Nauru, Republic of', 'Nauru', 'Oceania', 'Ozeanien', '', ''),
(150, '0000-00-00 00:00:00', 'NP', 'NPL', 524, 'AS', 'Nepal, State of', 'Nepal', 'Asia', 'Asien', '', ''),
(151, '0000-00-00 00:00:00', 'NL', 'NLD', 528, 'EU', 'Netherlands, Kingdom of the', 'Niederlande', 'Europe', 'Europa', '', ''),
(152, '0000-00-00 00:00:00', 'AN', 'ANT', 530, 'NA', 'Netherlands Antilles', 'Niederländische Antillen', 'North America', 'Nordamerika', '', ''),
(153, '0000-00-00 00:00:00', 'NC', 'NCL', 540, 'OC', 'New Caledonia', 'Neukaledonien', 'Oceania', 'Ozeanien', '', ''),
(154, '0000-00-00 00:00:00', 'NZ', 'NZL', 554, 'OC', 'New Zealand', 'Neuseeland', 'Oceania', 'Ozeanien', '', ''),
(155, '0000-00-00 00:00:00', 'NI', 'NIC', 558, 'NA', 'Nicaragua, Republic of', 'Nicaragua', 'North America', 'Nordamerika', '', ''),
(156, '0000-00-00 00:00:00', 'NE', 'NER', 562, 'AF', 'Niger, Republic of', 'Niger', 'Africa', 'Afrika', '', ''),
(157, '0000-00-00 00:00:00', 'NG', 'NGA', 566, 'AF', 'Nigeria, Federal Republic of', 'Nigeria', 'Africa', 'Afrika', '', ''),
(158, '0000-00-00 00:00:00', 'NU', 'NIU', 570, 'OC', 'Niue', 'Niue', 'Oceania', 'Ozeanien', '', ''),
(159, '0000-00-00 00:00:00', 'NF', 'NFK', 574, 'OC', 'Norfolk Island', 'Norfolk-Insel', 'Oceania', 'Ozeanien', '', ''),
(160, '0000-00-00 00:00:00', 'MP', 'MNP', 580, 'OC', 'Northern Mariana Islands, Commonwealth of the', 'Nördliche Marianen', 'Oceania', 'Ozeanien', '', ''),
(161, '0000-00-00 00:00:00', 'NO', 'NOR', 578, 'EU', 'Norway, Kingdom of', 'Norwegen', 'Europe', 'Europa', '', ''),
(162, '0000-00-00 00:00:00', 'OM', 'OMN', 512, 'AS', 'Oman, Sultanate of', 'Oman', 'Asia', 'Asien', '', ''),
(163, '0000-00-00 00:00:00', 'PK', 'PAK', 586, 'AS', 'Pakistan, Islamic Republic of', 'Pakistan', 'Asia', 'Asien', '', ''),
(164, '0000-00-00 00:00:00', 'PW', 'PLW', 585, 'OC', 'Palau, Republic of', 'Palau', 'Oceania', 'Ozeanien', '', ''),
(165, '0000-00-00 00:00:00', 'PS', 'PSE', 275, 'AS', 'Palestinian Territory, Occupied', 'Palästina', 'Asia', 'Asien', '', ''),
(166, '0000-00-00 00:00:00', 'PA', 'PAN', 591, 'NA', 'Panama, Republic of', 'Panama', 'North America', 'Nordamerika', '', ''),
(167, '0000-00-00 00:00:00', 'PG', 'PNG', 598, 'OC', 'Papua New Guinea, Independent State of', 'Papua-Neuguinea', 'Oceania', 'Ozeanien', '', ''),
(168, '0000-00-00 00:00:00', 'PY', 'PRY', 600, 'SA', 'Paraguay, Republic of', 'Paraguay', 'South America', 'Südamerika', '', ''),
(169, '0000-00-00 00:00:00', 'PE', 'PER', 604, 'SA', 'Peru, Republic of', 'Peru', 'South America', 'Südamerika', '', ''),
(170, '0000-00-00 00:00:00', 'PH', 'PHL', 608, 'AS', 'Philippines, Republic of the', 'Philippinen', 'Asia', 'Asien', '', ''),
(171, '0000-00-00 00:00:00', 'PN', 'PCN', 612, 'OC', 'Pitcairn Islands', 'Pitcairn', 'Oceania', 'Ozeanien', '', ''),
(172, '0000-00-00 00:00:00', 'PL', 'POL', 616, 'EU', 'Poland, Republic of', 'Polen', 'Europe', 'Europa', '', ''),
(173, '0000-00-00 00:00:00', 'PT', 'PRT', 620, 'EU', 'Portugal, Portuguese Republic', 'Portugal', 'Europe', 'Europa', '', ''),
(174, '0000-00-00 00:00:00', 'PR', 'PRI', 630, 'NA', 'Puerto Rico, Commonwealth of', 'Puerto Rico', 'North America', 'Nordamerika', '', ''),
(175, '0000-00-00 00:00:00', 'QA', 'QAT', 634, 'AS', 'Qatar, State of', 'Katar', 'Asia', 'Asien', '', ''),
(176, '0000-00-00 00:00:00', 'RE', 'REU', 638, 'AF', 'Reunion', 'Réunion', 'Africa', 'Afrika', '', ''),
(177, '0000-00-00 00:00:00', 'RO', 'ROU', 642, 'EU', 'Romania', 'Rumänien', 'Europe', 'Europa', '', ''),
(178, '0000-00-00 00:00:00', 'RU', 'RUS', 643, 'EU', 'Russian Federation', 'Russische Föderation', 'Europe', 'Europa', '', ''),
(179, '0000-00-00 00:00:00', 'RW', 'RWA', 646, 'AF', 'Rwanda, Republic of', 'Ruanda', 'Africa', 'Afrika', '', ''),
(180, '0000-00-00 00:00:00', 'SH', 'SHN', 654, 'AF', 'Saint Helena', 'St. Helena', 'Africa', 'Afrika', '', ''),
(181, '0000-00-00 00:00:00', 'KN', 'KNA', 659, 'NA', 'Saint Kitts and Nevis, Federation of', 'Saint Kitts und Nevis', 'North America', 'Nordamerika', '', ''),
(182, '0000-00-00 00:00:00', 'LC', 'LCA', 662, 'NA', 'Saint Lucia', 'Santa Lucia', 'North America', 'Nordamerika', '', ''),
(183, '0000-00-00 00:00:00', 'PM', 'SPM', 666, 'NA', 'Saint Pierre and Miquelon', 'Saint-Pierre und Miquelon', 'North America', 'Nordamerika', '', ''),
(184, '0000-00-00 00:00:00', 'VC', 'VCT', 670, 'NA', 'Saint Vincent and the Grenadines', 'Saint Vincent und die Grenadinen', 'North America', 'Nordamerika', '', ''),
(185, '0000-00-00 00:00:00', 'WS', 'WSM', 882, 'OC', 'Samoa, Independent State of', 'Samoa', 'Oceania', 'Ozeanien', '', ''),
(186, '0000-00-00 00:00:00', 'SM', 'SMR', 674, 'EU', 'San Marino, Republic of', 'San Marino', 'Europe', 'Europa', '', ''),
(187, '0000-00-00 00:00:00', 'ST', 'STP', 678, 'AF', 'Sao Tome and Principe, Democratic Republic of', 'São Tomé und Príncipe', 'Africa', 'Afrika', '', ''),
(188, '0000-00-00 00:00:00', 'SA', 'SAU', 682, 'AS', 'Saudi Arabia, Kingdom of', 'Saudi-Arabien', 'Asia', 'Asien', '', ''),
(189, '0000-00-00 00:00:00', 'SN', 'SEN', 686, 'AF', 'Senegal, Republic of', 'Senegal', 'Africa', 'Afrika', '', ''),
(190, '0000-00-00 00:00:00', 'SC', 'SYC', 690, 'AF', 'Seychelles, Republic of', 'Seychellen', 'Africa', 'Afrika', '', ''),
(191, '0000-00-00 00:00:00', 'SL', 'SLE', 694, 'AF', 'Sierra Leone, Republic of', 'Sierra Leone', 'Africa', 'Afrika', '', ''),
(192, '0000-00-00 00:00:00', 'SG', 'SGP', 702, 'AS', 'Singapore, Republic of', 'Singapur', 'Asia', 'Asien', '', ''),
(193, '0000-00-00 00:00:00', 'SK', 'SVK', 703, 'EU', 'Slovakia (Slovak Republic)', 'Slowakei (Slowakische Republik)', 'Europe', 'Europa', '', ''),
(194, '0000-00-00 00:00:00', 'SI', 'SVN', 705, 'EU', 'Slovenia, Republic of', 'Slowenien', 'Europe', 'Europa', '', ''),
(195, '0000-00-00 00:00:00', 'SB', 'SLB', 90, 'OC', 'Solomon Islands', 'Salomonen', 'Oceania', 'Ozeanien', '', ''),
(196, '0000-00-00 00:00:00', 'SO', 'SOM', 706, 'AF', 'Somalia, Somali Republic', 'Somalia', 'Africa', 'Afrika', '', ''),
(197, '0000-00-00 00:00:00', 'ZA', 'ZAF', 710, 'AF', 'South Africa, Republic of', 'Südafrika', 'Africa', 'Afrika', '', ''),
(198, '0000-00-00 00:00:00', 'GS', 'SGS', 239, 'AN', 'South Georgia and the South Sandwich Islands', 'Südgeorgien und Südliche Sandwichinseln', 'Antarctica', 'Antarktis', '', ''),
(199, '0000-00-00 00:00:00', 'ES', 'ESP', 724, 'EU', 'Spain, Kingdom of', 'Spanien', 'Europe', 'Europa', '', ''),
(200, '0000-00-00 00:00:00', 'LK', 'LKA', 144, 'AS', 'Sri Lanka, Democratic Socialist Republic of', 'Sri Lanka', 'Asia', 'Asien', '', ''),
(201, '0000-00-00 00:00:00', 'SD', 'SDN', 736, 'AF', 'Sudan, Republic of', 'Sudan', 'Africa', 'Afrika', '', ''),
(202, '0000-00-00 00:00:00', 'SR', 'SUR', 740, 'AF', 'Suriname, Republic of', 'Suriname', 'Africa', 'Afrika', '', ''),
(203, '0000-00-00 00:00:00', 'SJ', 'SJM', 744, 'EU', 'Svalbard & Jan Mayen Islands', 'Svalbard und Jan Mayen', 'Europe', 'Europa', '', ''),
(204, '0000-00-00 00:00:00', 'SZ', 'SWZ', 748, 'AF', 'Swaziland, Kingdom of', 'Swasiland', 'Africa', 'Afrika', '', ''),
(205, '0000-00-00 00:00:00', 'SE', 'SWE', 752, 'EU', 'Sweden, Kingdom of', 'Schweden', 'Europe', 'Europa', '', ''),
(206, '0000-00-00 00:00:00', 'CH', 'CHE', 756, 'EU', 'Switzerland, Swiss Confederation', 'Schweiz', 'Europe', 'Europa', '', ''),
(207, '0000-00-00 00:00:00', 'SY', 'SYR', 760, 'AS', 'Syrian Arab Republic', 'Syrien, Arabische Republik', 'Asia', 'Asien', '', ''),
(208, '0000-00-00 00:00:00', 'TW', 'TWN', 158, 'AS', 'Taiwan', 'Taiwan (China)', 'Asia', 'Asien', '', ''),
(209, '0000-00-00 00:00:00', 'TJ', 'TJK', 762, 'AS', 'Tajikistan, Republic of', 'Tadschikistan', 'Asia', 'Asien', '', ''),
(210, '0000-00-00 00:00:00', 'TZ', 'TZA', 834, 'AF', 'Tanzania, United Republic of', 'Tansania, Vereinigte Republik', 'Africa', 'Afrika', '', ''),
(211, '0000-00-00 00:00:00', 'TH', 'THA', 764, 'AS', 'Thailand, Kingdom of', 'Thailand', 'Asia', 'Asien', '', ''),
(212, '0000-00-00 00:00:00', 'TG', 'TGO', 768, 'AF', 'Togo, Togolese Republic', 'Togo', 'Africa', 'Afrika', '', ''),
(213, '0000-00-00 00:00:00', 'TK', 'TKL', 772, 'OC', 'Tokelau', 'Tokelau', 'Oceania', 'Ozeanien', '', ''),
(214, '0000-00-00 00:00:00', 'TO', 'TON', 776, 'OC', 'Tonga, Kingdom of', 'Tonga', 'Oceania', 'Ozeanien', '', ''),
(215, '0000-00-00 00:00:00', 'TT', 'TTO', 780, 'NA', 'Trinidad and Tobago, Republic of', 'Trinidad und Tobago', 'North America', 'Nordamerika', '', ''),
(216, '0000-00-00 00:00:00', 'TN', 'TUN', 788, 'AF', 'Tunisia, Tunisian Republic', 'Tunesien', 'Africa', 'Afrika', '', ''),
(217, '0000-00-00 00:00:00', 'TR', 'TUR', 792, 'AS', 'Turkey, Republic of', 'Türkei', 'Asia', 'Asien', '', ''),
(218, '0000-00-00 00:00:00', 'TM', 'TKM', 795, 'AS', 'Turkmenistan', 'Turkmenistan', 'Asia', 'Asien', '', ''),
(219, '0000-00-00 00:00:00', 'TC', 'TCA', 796, 'NA', 'Turks and Caicos Islands', 'Turks- und Caicosinseln', 'North America', 'Nordamerika', '', ''),
(220, '0000-00-00 00:00:00', 'TV', 'TUV', 798, 'OC', 'Tuvalu', 'Tuvalu', 'Oceania', 'Ozeanien', '', ''),
(221, '0000-00-00 00:00:00', 'UG', 'UGA', 800, 'AF', 'Uganda, Republic of', 'Uganda', 'Africa', 'Afrika', '', ''),
(222, '0000-00-00 00:00:00', 'UA', 'UKR', 804, 'EU', 'Ukraine', 'Ukraine', 'Europe', 'Europa', '', ''),
(223, '0000-00-00 00:00:00', 'AE', 'ARE', 784, 'AS', 'United Arab Emirates', 'Vereinigte Arabische Emirate', 'Asia', 'Asien', '', ''),
(224, '0000-00-00 00:00:00', 'GB', 'GBR', 826, 'EU', 'United Kingdom of Great Britain & Northern Ireland', 'United Kingdom', 'Europe', 'Europa', '', ''),
(225, '0000-00-00 00:00:00', 'US', 'USA', 840, 'NA', 'United States of America', 'Vereinigte Staaten', 'North America', 'Nordamerika', '', ''),
(226, '0000-00-00 00:00:00', 'UM', 'UMI', 581, 'OC', 'United States Minor Outlying Islands', 'Kleinere entlegene Inseln der Vereinigten Staaten', 'Oceania', 'Ozeanien', '', ''),
(227, '0000-00-00 00:00:00', 'UY', 'URY', 858, 'SA', 'Uruguay, Eastern Republic of', 'Uruguay', 'South America', 'Südamerika', '', ''),
(228, '0000-00-00 00:00:00', 'UZ', 'UZB', 860, 'AS', 'Uzbekistan, Republic of', 'Usbekistan', 'Asia', 'Asien', '', ''),
(229, '0000-00-00 00:00:00', 'VU', 'VUT', 548, 'OC', 'Vanuatu, Republic of', 'Vanuatu', 'Oceania', 'Ozeanien', '', ''),
(230, '0000-00-00 00:00:00', 'VE', 'VEN', 862, 'SA', 'Venezuela, Bolivarian Republic of', 'Venezuela', 'South America', 'Südamerika', '', ''),
(231, '0000-00-00 00:00:00', 'VN', 'VNM', 704, 'AS', 'Vietnam, Socialist Republic of', 'Vietnam', 'Asia', 'Asien', '', ''),
(232, '0000-00-00 00:00:00', 'VG', 'VGB', 92, 'NA', 'British Virgin Islands', 'Jungferninseln (Britische)', 'North America', 'Nordamerika', '', ''),
(233, '0000-00-00 00:00:00', 'VI', 'VIR', 850, 'NA', 'United States Virgin Islands', 'Jungferninseln (Amerikanische)', 'North America', 'Nordamerika', '', ''),
(234, '0000-00-00 00:00:00', 'WF', 'WLF', 876, 'OC', 'Wallis and Futuna', 'Wallis und Futuna', 'Oceania', 'Ozeanien', '', ''),
(235, '0000-00-00 00:00:00', 'EH', 'ESH', 732, 'AF', 'Western Sahara', 'Westsahara', 'Africa', 'Afrika', '', ''),
(236, '0000-00-00 00:00:00', 'YE', 'YEM', 887, 'AS', 'Yemen', 'Jemen', 'Asia', 'Asien', '', ''),
(237, '0000-00-00 00:00:00', 'YU', 'YUG', 891, 'EU', 'Yugoslavia', 'Jugoslawien', 'Europe', 'Europa', '', ''),
(238, '0000-00-00 00:00:00', 'ZM', 'ZMB', 894, 'AF', 'Zambia, Republic of', 'Sambia', 'Africa', 'Afrika', '', ''),
(239, '0000-00-00 00:00:00', 'ZW', 'ZWE', 716, 'AF', 'Zimbabwe, Republic of', 'Simbabwe', 'Africa', 'Afrika', '', ''),
(240, '0000-00-00 00:00:00', 'AX', 'ALA', 248, 'EU', 'Åland Islands', 'Åland Inseln', 'Europe', 'Europa', '', ''),
(241, '0000-00-00 00:00:00', 'GG', 'GGY', 831, 'EU', 'Guernsey, Bailiwick of', 'Guernsey, Vogtei', 'Europe', 'Europa', '', ''),
(242, '0000-00-00 00:00:00', 'IM', 'IMN', 833, 'EU', 'Isle of Man', 'Insel Man', 'Europe', 'Europa', '', ''),
(243, '0000-00-00 00:00:00', 'JE', 'JEY', 832, 'EU', 'Jersey, Bailiwick of', 'Jersey, Vogtei', 'Europe', 'Europa', '', ''),
(244, '0000-00-00 00:00:00', 'ME', 'MNE', 499, 'EU', 'Montenegro, Republic of', 'Montenegro', 'Europe', 'Europa', '', ''),
(245, '0000-00-00 00:00:00', 'BL', 'BLM', 652, 'NA', 'Saint Barthelemy', 'Sankt Bartholomäus', 'North America', 'Nordamerika', '', ''),
(246, '0000-00-00 00:00:00', 'MF', 'MAF', 663, 'NA', 'Saint Martin', 'Saint-Martin', 'North America', 'Nordamerika', '', ''),
(247, '0000-00-00 00:00:00', 'RS', 'SRB', 688, 'EU', 'Serbia, Republic of', 'Serbien', 'Europe', 'Europa', '', ''),
(248, '0000-00-00 00:00:00', 'TL', 'TLS', 626, 'AS', 'Timor-Leste, Democratic Republic of', 'Osttimor (Timor-Leste)', 'Asia', 'Asien', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_crossreference`
--

CREATE TABLE `phpwcms_crossreference` (
  `cref_id` int(11) NOT NULL,
  `cref_type` varchar(255) COLLATE latin1_bin NOT NULL DEFAULT '',
  `cref_module` varchar(255) COLLATE latin1_bin NOT NULL DEFAULT '',
  `cref_rid` int(11) NOT NULL DEFAULT '0',
  `cref_int` int(11) NOT NULL DEFAULT '0',
  `cref_str` varchar(255) COLLATE latin1_bin NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_dados`
--

CREATE TABLE `phpwcms_dados` (
  `dados_empresa` varchar(255) COLLATE latin1_bin NOT NULL DEFAULT '',
  `dados_fone` text COLLATE latin1_bin NOT NULL,
  `dados_fone_checkbox` text COLLATE latin1_bin NOT NULL,
  `dados_whatsapp` text COLLATE latin1_bin NOT NULL,
  `dados_msg_whatsapp` varchar(255) COLLATE latin1_bin NOT NULL,
  `dados_redes` text COLLATE latin1_bin NOT NULL,
  `dados_emails` text COLLATE latin1_bin NOT NULL,
  `dados_endereco` text COLLATE latin1_bin NOT NULL,
  `dados_rodape` text COLLATE latin1_bin NOT NULL,
  `dados_meta` text COLLATE latin1_bin NOT NULL,
  `dados_analytics` text COLLATE latin1_bin NOT NULL,
  `dados_webmaster` text COLLATE latin1_bin NOT NULL,
  `dados_classe_fone` int(1) NOT NULL,
  `dados_campo_adicional1` text COLLATE latin1_bin NOT NULL,
  `dados_campo_adicional2` text COLLATE latin1_bin NOT NULL,
  `dados_segundo_endereco` tinyint(1) NOT NULL,
  `dados_mapa1` tinyint(1) NOT NULL,
  `dados_mapa2` tinyint(1) NOT NULL,
  `dados_endereco2` text CHARACTER SET latin1 NOT NULL,
  `dados_campo_adicional3` text CHARACTER SET latin1 NOT NULL,
  `dados_campos_adicionais` text CHARACTER SET latin1 NOT NULL,
  `dados_recaptcha` text COLLATE latin1_bin NOT NULL,
  `dados_cookies` text COLLATE latin1_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Extraindo dados da tabela `phpwcms_dados`
--

INSERT INTO `phpwcms_dados` (`dados_empresa`, `dados_fone`, `dados_fone_checkbox`, `dados_whatsapp`, `dados_msg_whatsapp`, `dados_redes`, `dados_emails`, `dados_endereco`, `dados_rodape`, `dados_meta`, `dados_analytics`, `dados_webmaster`, `dados_classe_fone`, `dados_campo_adicional1`, `dados_campo_adicional2`, `dados_segundo_endereco`, `dados_mapa1`, `dados_mapa2`, `dados_endereco2`, `dados_campo_adicional3`, `dados_campos_adicionais`, `dados_recaptcha`, `dados_cookies`) VALUES
('Nome da Empresa', '(11) 5678-9012', 'check0', '1,(11) 98765-4321', 'Olá, deixe sua mensagem', 'check0,a1,a2,a3,a4,check5,a6,a7,a8,a9,#,,,,#,#,#,,,', 'check0,contato@email.com.br', 'Av Paulista,1000,Jardins,04651000,São Paulo,SP,Casa 1', '', '<link rel=\"apple-touch-icon\" sizes=\"180x180\" href=\"images/favicon/apple-touch-icon.png\">\n<link rel=\"icon\" type=\"image/png\" sizes=\"32x32\" href=\"images/favicon/favicon-32x32.png\">\n<link rel=\"icon\" type=\"image/png\" sizes=\"16x16\" href=\"images/favicon/favicon-16x16.png\">\n<link rel=\"manifest\" href=\"images/favicon/site.webmanifest\">\n<link rel=\"mask-icon\" href=\"images/favicon/safari-pinned-tab.svg\" color=\"#5bbad5\">\n<link rel=\"shortcut icon\" href=\"images/favicon/favicon.ico\">\n<meta name=\"msapplication-TileColor\" content=\"#da532c\">\n<meta name=\"msapplication-config\" content=\"images/favicon/browserconfig.xml\">\n<meta name=\"theme-color\" content=\"#ffffff\">', '', '', 0, '', '', 0, 0, 0, ',,,,,,', '', '', '{\"ativo\":\"2\",\"site\":\"\",\"secret\":\"\"}', 'a:3:{s:5:\"ativo\";s:1:\"2\";s:8:\"politica\";s:0:\"\";s:8:\"mensagem\";s:294:\"Utilizamos cookies e outras tecnologias semelhantes para melhorar sua experi&ecirc;ncia em nossos servi&ccedil;os e para fins publicit&aacute;rios, conforme disposto na nossa Pol&iacute;tica de Privacidade. Ao clicar em &quot;Aceitar&quot; voc&ecirc; concorda com estas condi&ccedil;&otilde;es.\";}');

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_file`
--

CREATE TABLE `phpwcms_file` (
  `f_id` int(11) NOT NULL,
  `f_pid` int(11) DEFAULT '0',
  `f_uid` int(11) DEFAULT '0',
  `f_kid` int(2) DEFAULT '0',
  `f_order` int(11) DEFAULT '0',
  `f_trash` int(1) DEFAULT '0',
  `f_aktiv` int(1) DEFAULT '0',
  `f_public` int(1) DEFAULT '0',
  `f_tstamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `f_name` varchar(255) COLLATE latin1_bin DEFAULT '',
  `f_cat` varchar(255) COLLATE latin1_bin DEFAULT NULL,
  `f_created` int(11) DEFAULT '0',
  `f_changed` int(11) DEFAULT '0',
  `f_size` int(15) UNSIGNED DEFAULT NULL,
  `f_type` varchar(200) COLLATE latin1_bin DEFAULT '',
  `f_ext` varchar(50) COLLATE latin1_bin DEFAULT '',
  `f_shortinfo` varchar(255) COLLATE latin1_bin DEFAULT '',
  `f_longinfo` text COLLATE latin1_bin,
  `f_keywords` varchar(255) COLLATE latin1_bin DEFAULT '',
  `f_hash` varchar(255) COLLATE latin1_bin DEFAULT '',
  `f_dlstart` int(11) DEFAULT '0',
  `f_dlfinal` int(11) DEFAULT '0',
  `f_refid` int(11) DEFAULT '0',
  `f_copyright` varchar(255) COLLATE latin1_bin DEFAULT NULL,
  `f_tags` varchar(255) COLLATE latin1_bin DEFAULT NULL,
  `f_granted` int(11) DEFAULT '0',
  `f_gallerystatus` int(1) DEFAULT '0',
  `f_vars` blob,
  `f_sort` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Extraindo dados da tabela `phpwcms_file`
--

INSERT INTO `phpwcms_file` (`f_id`, `f_pid`, `f_uid`, `f_kid`, `f_order`, `f_trash`, `f_aktiv`, `f_public`, `f_tstamp`, `f_name`, `f_cat`, `f_created`, `f_changed`, `f_size`, `f_type`, `f_ext`, `f_shortinfo`, `f_longinfo`, `f_keywords`, `f_hash`, `f_dlstart`, `f_dlfinal`, `f_refid`, `f_copyright`, `f_tags`, `f_granted`, `f_gallerystatus`, `f_vars`, `f_sort`) VALUES
(1, 0, 1, 0, 0, 0, 1, 1, '2018-09-27 20:04:15', 'Banners', '', 0, 0, 0, '', '', '', '', '', '', 0, 0, 0, '', '', 0, 0, '', 0),
(2, 0, 1, 0, 0, 0, 1, 1, '2018-09-27 20:04:15', 'img-site (imagens padrões do site)', '', 0, 0, 0, '', '', '', '', '', '', 0, 0, 0, '', '', 0, 0, '', 0),
(3, 1, 1, 1, 0, 0, 1, 1, '2021-01-01 09:01:07', 'banner-1.jpg', NULL, 1538073756, 1609480867, 255719, 'image/jpeg', 'jpg', '', '', '', '6aa0ec42d0d9667ea6e2c1fa73224f25', 0, 0, 0, '', '', 0, 0, 0x613a303a7b7d, 0),
(4, 1, 1, 1, 0, 0, 1, 1, '2021-01-01 09:01:07', 'banner-2.jpg', NULL, 1538073773, 1609480867, 181060, 'image/jpeg', 'jpg', '', '', '', 'e3bde1cff80deb90432a91a9dc4ea4da', 0, 0, 0, '', '', 0, 0, 0x613a303a7b7d, 0),
(5, 2, 1, 1, 0, 0, 1, 1, '2018-09-27 22:05:59', 'img-empresa.jpg', NULL, 1538075159, 0, 47242, 'image/jpeg', 'jpg', '', '', '', '23a2264e686e3de095c62b3e4b598995', 0, 0, 0, '', '', 0, 0, NULL, 0),
(6, 0, 1, 0, 0, 0, 1, 1, '2018-10-17 04:48:02', 'Serviços', NULL, 1539740882, 0, NULL, '', '', '', '', '', '', 0, 0, 0, NULL, NULL, 0, 0, NULL, 0),
(7, 6, 1, 1, 0, 0, 1, 1, '2018-10-17 04:50:17', 'servico-1.jpg', NULL, 1539741017, 0, 694817, 'image/jpeg', 'jpg', '', '', '', 'b71d9060adbbf99ce7394ad39a78e71d', 0, 0, 0, '', '', 0, 0, NULL, 0),
(8, 6, 1, 1, 0, 0, 1, 1, '2018-10-17 04:50:17', 'servico-3.jpg', NULL, 1539741017, 0, 390870, 'image/jpeg', 'jpg', '', '', '', '71b368bda82fd6fdfe77a1114a1ede3e', 0, 0, 0, '', '', 0, 0, NULL, 0),
(9, 6, 1, 1, 0, 0, 1, 1, '2018-10-17 04:50:17', 'servico-2.jpg', NULL, 1539741017, 0, 262786, 'image/jpeg', 'jpg', '', '', '', '13aa61311fc7f8c8483887a473ed6021', 0, 0, 0, '', '', 0, 0, NULL, 0),
(10, 6, 1, 1, 0, 0, 1, 1, '2018-10-17 04:50:17', 'servico-4.jpg', NULL, 1539741017, 0, 943601, 'image/jpeg', 'jpg', '', '', '', 'a285ce650a80f8e357e7d0440d9c0895', 0, 0, 0, '', '', 0, 0, NULL, 0),
(11, 0, 1, 0, 0, 0, 1, 1, '2018-10-17 06:55:33', 'Notícias', NULL, 1539748533, 0, NULL, '', '', '', '', '', '', 0, 0, 0, NULL, NULL, 0, 0, NULL, 0),
(12, 11, 1, 1, 0, 0, 1, 1, '2018-10-17 07:00:11', 'noticias-1.jpg', NULL, 1539748810, 0, 104669, 'image/jpeg', 'jpg', '', '', '', '404f8fd42d2610dab037187608949848', 0, 0, 0, '', '', 0, 0, NULL, 0),
(13, 11, 1, 1, 0, 0, 1, 1, '2018-10-17 07:00:11', 'noticias-2.jpg', NULL, 1539748811, 0, 373575, 'image/jpeg', 'jpg', '', '', '', '27f30207dcac18397a931d7a10d868cf', 0, 0, 0, '', '', 0, 0, NULL, 0),
(14, 11, 1, 1, 0, 0, 1, 1, '2018-10-17 07:00:16', 'noticias-3.jpg', NULL, 1539748816, 0, 1743541, 'image/jpeg', 'jpg', '', '', '', '2ef4452022f8e2f210f2e3c5b539dcc5', 0, 0, 0, '', '', 0, 0, NULL, 0),
(15, 2, 1, 1, 0, 0, 1, 1, '2021-01-01 02:11:57', 'fundo-slogan.jpg', NULL, 1609455259, 1609456317, 196952, 'image/jpeg', 'jpg', '', '', '', 'f5bb5d420c811d2d470bbbd26a567516', 0, 0, 0, '', '', 0, 0, NULL, 0),
(16, 2, 1, 1, 0, 5, 1, 1, '2021-01-01 02:11:57', 'fundo-slogan.jpg', NULL, 1609456317, 1609456317, 25723, 'image/jpeg', 'jpg', '', '', '', '9dcb5d4e22cb5b9bd3f56d10e6a9754b', 0, 0, 15, '', '', 0, 0, NULL, 0),
(17, 1, 1, 1, 0, 5, 1, 1, '2021-01-01 09:01:07', 'banner-1.jpg', NULL, 1609480867, 1609480867, 194937, 'image/jpeg', 'jpg', '', '', '', 'fe59456fc960d63c2d140eff2c5c3b39', 0, 0, 3, '', '', 0, 0, NULL, 0),
(18, 1, 1, 1, 0, 5, 1, 1, '2021-01-01 09:01:07', 'banner-2.jpg', NULL, 1609480867, 1609480867, 522484, 'image/jpeg', 'jpg', '', '', '', 'cb8e9ae7f594ef9ba39b36b3be57b2d4', 0, 0, 4, '', '', 0, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_filecat`
--

CREATE TABLE `phpwcms_filecat` (
  `fcat_id` int(11) NOT NULL,
  `fcat_name` varchar(255) COLLATE latin1_bin DEFAULT '',
  `fcat_aktiv` int(1) DEFAULT '0',
  `fcat_deleted` int(1) DEFAULT '0',
  `fcat_needed` int(1) DEFAULT '0',
  `fcat_sort` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_filekey`
--

CREATE TABLE `phpwcms_filekey` (
  `fkey_id` int(11) NOT NULL,
  `fkey_cid` int(11) DEFAULT '0',
  `fkey_name` varchar(255) COLLATE latin1_bin DEFAULT '',
  `fkey_aktiv` int(1) DEFAULT '0',
  `fkey_deleted` int(1) DEFAULT '0',
  `fkey_sort` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_formresult`
--

CREATE TABLE `phpwcms_formresult` (
  `formresult_id` int(11) NOT NULL,
  `formresult_pid` int(11) DEFAULT '0',
  `formresult_createdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `formresult_ip` varchar(50) COLLATE latin1_bin DEFAULT '',
  `formresult_content` mediumblob
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_formtracking`
--

CREATE TABLE `phpwcms_formtracking` (
  `formtracking_id` int(11) NOT NULL,
  `formtracking_hash` varchar(50) COLLATE latin1_bin DEFAULT '',
  `formtracking_ip` varchar(20) COLLATE latin1_bin DEFAULT '',
  `formtracking_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `formtracking_sentdate` varchar(20) COLLATE latin1_bin DEFAULT '',
  `formtracking_sent` int(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Extraindo dados da tabela `phpwcms_formtracking`
--

INSERT INTO `phpwcms_formtracking` (`formtracking_id`, `formtracking_hash`, `formtracking_ip`, `formtracking_created`, `formtracking_sentdate`, `formtracking_sent`) VALUES
(1, '31ca4fd0998f52298e0afebff303f969', '179.110.116.141', '2018-10-17 06:07:10', '', 0),
(2, '31ca4fd0998f52298e0afebff303f969', '179.110.116.141', '2018-10-17 06:07:27', '', 0),
(3, '31ca4fd0998f52298e0afebff303f969', '179.110.116.141', '2018-10-17 06:09:05', '', 0),
(4, '31ca4fd0998f52298e0afebff303f969', '179.110.116.141', '2018-10-17 06:09:48', '', 0),
(5, '31ca4fd0998f52298e0afebff303f969', '179.110.116.141', '2018-10-17 06:12:48', '', 0),
(6, '2386ee257b84fc684bab7d0801703a70', '179.110.116.141', '2018-10-17 07:02:23', '', 0),
(7, '6bbf3903b69b4fc50ad0eaef18d47a1f', '187.10.124.124', '2018-12-28 16:45:03', '', 0),
(8, '4687cd34a22242d84ffc4966edfef1e9', '187.74.9.205', '2019-02-14 17:04:41', '', 0),
(9, 'd770584aef537465f83960c310c187b0', '179.100.95.130', '2019-08-20 04:28:45', '', 0),
(10, 'c42e6eff09891f78348581c718db0b2f', '177.76.155.246', '2019-08-23 03:25:23', '', 0),
(11, '32a832b2a87d15c378cf516800d2ca05', '177.27.255.231', '2019-09-18 17:18:12', '', 0),
(12, 'f900d3fe8997618c6a53af113952eb6e', '177.118.133.16', '2020-01-10 23:56:03', '', 0),
(13, 'f900d3fe8997618c6a53af113952eb6e', '177.118.133.16', '2020-01-10 23:56:06', '', 0),
(14, 'a29b315e9c8cb4aef6410d892bd30391', '177.118.133.16', '2020-01-11 00:06:29', '', 0),
(15, 'a29b315e9c8cb4aef6410d892bd30391', '177.118.133.16', '2020-01-11 00:19:04', '', 0),
(16, 'a6c4a0cbeabaa1b632caa176b1ec7b63', '177.118.133.16', '2020-01-11 01:30:16', '', 0),
(17, 'a6c4a0cbeabaa1b632caa176b1ec7b63', '177.118.133.16', '2020-01-11 01:33:31', '', 0),
(18, 'a6c4a0cbeabaa1b632caa176b1ec7b63', '177.118.133.16', '2020-01-11 01:34:47', '', 0),
(19, 'a6c4a0cbeabaa1b632caa176b1ec7b63', '177.118.133.16', '2020-01-11 01:34:50', '', 0),
(20, 'a6c4a0cbeabaa1b632caa176b1ec7b63', '177.118.133.16', '2020-01-11 01:34:51', '', 0),
(21, 'a6c4a0cbeabaa1b632caa176b1ec7b63', '177.118.133.16', '2020-01-11 01:35:32', '', 0),
(22, 'a6c4a0cbeabaa1b632caa176b1ec7b63', '177.118.133.16', '2020-01-11 01:35:34', '', 0),
(23, 'a6c4a0cbeabaa1b632caa176b1ec7b63', '177.118.133.16', '2020-01-11 01:37:14', '', 0),
(24, 'a6c4a0cbeabaa1b632caa176b1ec7b63', '177.118.133.16', '2020-01-11 01:37:15', '', 0),
(25, 'a6c4a0cbeabaa1b632caa176b1ec7b63', '177.118.133.16', '2020-01-11 01:37:53', '', 0),
(26, 'a6c4a0cbeabaa1b632caa176b1ec7b63', '177.118.133.16', '2020-01-11 01:37:54', '', 0),
(27, 'a6c4a0cbeabaa1b632caa176b1ec7b63', '177.118.133.16', '2020-01-11 01:37:56', '', 0),
(28, 'a6c4a0cbeabaa1b632caa176b1ec7b63', '177.118.133.16', '2020-01-11 01:37:56', '', 0),
(29, '22b8835831bf601fdb2b347754c6f2ac', '200.153.217.168', '2020-07-15 21:23:01', '', 0),
(30, '22b8835831bf601fdb2b347754c6f2ac', '200.153.217.168', '2020-07-15 21:24:44', '', 0),
(31, '22b8835831bf601fdb2b347754c6f2ac', '200.153.217.168', '2020-07-15 21:25:21', '', 0),
(32, '22b8835831bf601fdb2b347754c6f2ac', '200.153.217.168', '2020-07-15 21:28:46', '', 0),
(33, '22b8835831bf601fdb2b347754c6f2ac', '200.153.217.168', '2020-07-15 21:28:53', '', 0),
(34, '22b8835831bf601fdb2b347754c6f2ac', '200.153.217.168', '2020-07-15 21:30:26', '', 0),
(35, '22b8835831bf601fdb2b347754c6f2ac', '200.153.217.168', '2020-07-15 21:30:31', '', 0),
(36, '22b8835831bf601fdb2b347754c6f2ac', '200.153.217.168', '2020-07-15 21:30:34', '', 0),
(37, '22b8835831bf601fdb2b347754c6f2ac', '200.153.217.168', '2020-07-15 21:45:26', '', 0),
(38, '22b8835831bf601fdb2b347754c6f2ac', '200.153.217.168', '2020-07-15 21:50:14', '', 0),
(39, '22b8835831bf601fdb2b347754c6f2ac', '200.153.217.168', '2020-07-15 21:50:54', '', 0),
(40, '22b8835831bf601fdb2b347754c6f2ac', '200.153.217.168', '2020-07-15 21:51:43', '', 0),
(41, '22b8835831bf601fdb2b347754c6f2ac', '200.153.217.168', '2020-07-15 21:53:10', '', 0),
(42, '22b8835831bf601fdb2b347754c6f2ac', '200.153.217.168', '2020-07-15 21:53:27', '', 0),
(43, '22b8835831bf601fdb2b347754c6f2ac', '200.153.217.168', '2020-07-15 21:53:47', '', 0),
(44, '22b8835831bf601fdb2b347754c6f2ac', '200.153.217.168', '2020-07-15 21:53:51', '', 0),
(45, '22b8835831bf601fdb2b347754c6f2ac', '200.153.217.168', '2020-07-15 21:54:01', '', 0),
(46, '22b8835831bf601fdb2b347754c6f2ac', '200.153.217.168', '2020-07-15 21:54:05', '', 0),
(47, '22b8835831bf601fdb2b347754c6f2ac', '200.153.217.168', '2020-07-15 21:54:24', '', 0),
(48, '22b8835831bf601fdb2b347754c6f2ac', '200.153.217.168', '2020-07-15 21:54:48', '', 0),
(49, '22b8835831bf601fdb2b347754c6f2ac', '200.153.217.168', '2020-07-15 21:55:39', '', 0),
(50, '22b8835831bf601fdb2b347754c6f2ac', '200.153.217.168', '2020-07-15 21:58:15', '', 0),
(51, '22b8835831bf601fdb2b347754c6f2ac', '200.153.217.168', '2020-07-15 21:59:44', '', 0),
(52, '4bf6b6309356de0ee15fbe2bc8540312', '200.153.217.168', '2020-07-15 22:00:15', '', 0),
(53, '4bf6b6309356de0ee15fbe2bc8540312', '200.153.217.168', '2020-07-15 22:02:29', '', 0),
(54, '4bf6b6309356de0ee15fbe2bc8540312', '200.153.217.168', '2020-07-15 22:03:16', '', 0),
(55, '4bf6b6309356de0ee15fbe2bc8540312', '200.153.217.168', '2020-07-15 22:06:06', '', 0),
(56, '4bf6b6309356de0ee15fbe2bc8540312', '200.153.217.168', '2020-07-15 22:06:12', '', 0),
(57, '4bf6b6309356de0ee15fbe2bc8540312', '200.153.217.168', '2020-07-15 22:06:19', '', 0),
(58, '4bf6b6309356de0ee15fbe2bc8540312', '200.153.217.168', '2020-07-15 22:07:01', '', 0),
(59, 'bf55d2729891ae7c0573b5a940c989da', '179.113.85.212', '2020-09-29 04:43:14', '', 0),
(60, 'bf55d2729891ae7c0573b5a940c989da', '179.113.85.212', '2020-09-29 04:43:16', '', 0),
(61, 'efd5096736838a1744d2506a5b2c376e', '201.69.177.177', '2021-01-01 23:23:56', '', 0),
(62, 'efd5096736838a1744d2506a5b2c376e', '201.69.177.177', '2021-01-01 23:24:36', '', 0),
(63, 'efd5096736838a1744d2506a5b2c376e', '201.69.177.177', '2021-01-01 23:24:37', '', 0),
(64, 'efd5096736838a1744d2506a5b2c376e', '201.69.177.177', '2021-01-01 23:24:38', '', 0),
(65, 'efd5096736838a1744d2506a5b2c376e', '201.69.177.177', '2021-01-01 23:25:10', '', 0),
(66, 'efd5096736838a1744d2506a5b2c376e', '201.69.177.177', '2021-01-01 23:25:19', '', 0),
(67, 'efd5096736838a1744d2506a5b2c376e', '201.69.177.177', '2021-01-01 23:25:20', '', 0),
(68, 'efd5096736838a1744d2506a5b2c376e', '201.69.177.177', '2021-01-01 23:25:40', '', 0),
(69, 'efd5096736838a1744d2506a5b2c376e', '201.69.177.177', '2021-01-01 23:25:41', '', 0),
(70, 'efd5096736838a1744d2506a5b2c376e', '201.69.177.177', '2021-01-01 23:25:50', '', 0),
(71, 'efd5096736838a1744d2506a5b2c376e', '201.69.177.177', '2021-01-01 23:25:51', '', 0),
(72, 'efd5096736838a1744d2506a5b2c376e', '201.69.177.177', '2021-01-01 23:26:53', '', 0),
(73, 'efd5096736838a1744d2506a5b2c376e', '201.69.177.177', '2021-01-01 23:30:36', '', 0),
(74, 'efd5096736838a1744d2506a5b2c376e', '201.69.177.177', '2021-01-01 23:30:37', '', 0),
(75, 'd9f35aa87786964c01db0329eff53275', '201.69.177.177', '2021-01-02 00:48:52', '', 0),
(76, 'd9f35aa87786964c01db0329eff53275', '201.69.177.177', '2021-01-02 00:51:09', '', 0),
(77, 'd9f35aa87786964c01db0329eff53275', '201.69.177.177', '2021-01-02 00:51:33', '', 0),
(78, 'd9f35aa87786964c01db0329eff53275', '201.69.177.177', '2021-01-02 00:51:47', '', 0),
(79, '13f40a9efb443e0a6f80820b3de65cfb', '201.0.39.105', '2021-02-04 02:10:31', '', 0),
(80, '878ba3f02b36fc269168127538c10ebc', '179.110.231.73', '2022-03-27 00:36:28', '', 0),
(81, '5482124856bc655edd2926bcc0b38e8a', '189.47.76.34', '2022-05-12 16:28:06', '', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_glossary`
--

CREATE TABLE `phpwcms_glossary` (
  `glossary_id` int(11) NOT NULL,
  `glossary_created` datetime DEFAULT '0000-00-00 00:00:00',
  `glossary_changed` datetime DEFAULT '0000-00-00 00:00:00',
  `glossary_title` text COLLATE latin1_bin,
  `glossary_tag` varchar(255) COLLATE latin1_bin DEFAULT '',
  `glossary_keyword` varchar(255) COLLATE latin1_bin DEFAULT '',
  `glossary_text` mediumtext COLLATE latin1_bin,
  `glossary_highlight` int(1) DEFAULT '0',
  `glossary_object` mediumtext COLLATE latin1_bin,
  `glossary_status` int(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_guestbook`
--

CREATE TABLE `phpwcms_guestbook` (
  `guestbook_id` int(11) NOT NULL,
  `guestbook_cid` int(11) DEFAULT '0',
  `guestbook_msg` text COLLATE latin1_bin,
  `guestbook_name` text COLLATE latin1_bin,
  `guestbook_email` text COLLATE latin1_bin,
  `guestbook_created` int(11) DEFAULT '0',
  `guestbook_trashed` int(1) DEFAULT '0',
  `guestbook_url` text COLLATE latin1_bin,
  `guestbook_show` int(1) DEFAULT '0',
  `guestbook_ip` varchar(20) COLLATE latin1_bin DEFAULT '',
  `guestbook_useragent` varchar(255) COLLATE latin1_bin DEFAULT '',
  `guestbook_image` varchar(255) COLLATE latin1_bin DEFAULT '',
  `guestbook_imagename` varchar(255) COLLATE latin1_bin DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_keyword`
--

CREATE TABLE `phpwcms_keyword` (
  `keyword_id` int(11) NOT NULL,
  `keyword_name` varchar(255) COLLATE latin1_bin DEFAULT '',
  `keyword_created` varchar(14) COLLATE latin1_bin DEFAULT '',
  `keyword_trash` int(1) DEFAULT '0',
  `keyword_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `keyword_description` text COLLATE latin1_bin,
  `keyword_link` varchar(255) COLLATE latin1_bin DEFAULT '',
  `keyword_sort` int(11) DEFAULT '0',
  `keyword_important` int(1) DEFAULT '0',
  `keyword_abbr` varchar(10) COLLATE latin1_bin DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_language`
--

CREATE TABLE `phpwcms_language` (
  `lang_id` varchar(255) COLLATE latin1_bin NOT NULL DEFAULT '',
  `lang_html` int(1) DEFAULT '1',
  `lang_type` int(1) DEFAULT '0',
  `EN` text COLLATE latin1_bin,
  `DE` text COLLATE latin1_bin,
  `BG` text COLLATE latin1_bin,
  `CA` text COLLATE latin1_bin,
  `CZ` text COLLATE latin1_bin,
  `DA` text COLLATE latin1_bin,
  `EE` text COLLATE latin1_bin,
  `ES` text COLLATE latin1_bin,
  `FI` text COLLATE latin1_bin,
  `FR` text COLLATE latin1_bin,
  `GR` text COLLATE latin1_bin,
  `HU` text COLLATE latin1_bin,
  `IT` text COLLATE latin1_bin,
  `LT` text COLLATE latin1_bin,
  `NL` text COLLATE latin1_bin,
  `NO` text COLLATE latin1_bin,
  `PL` text COLLATE latin1_bin,
  `PT` text COLLATE latin1_bin,
  `RO` text COLLATE latin1_bin,
  `SE` text COLLATE latin1_bin,
  `SK` text COLLATE latin1_bin,
  `VN` text COLLATE latin1_bin
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_log`
--

CREATE TABLE `phpwcms_log` (
  `log_id` int(11) NOT NULL,
  `log_created` datetime DEFAULT '0000-00-00 00:00:00',
  `log_type` varchar(50) COLLATE latin1_bin DEFAULT '',
  `log_ip` varchar(30) COLLATE latin1_bin DEFAULT '',
  `log_user_agent` varchar(255) COLLATE latin1_bin DEFAULT NULL,
  `log_user_id` int(11) DEFAULT '0',
  `log_user_name` varchar(255) COLLATE latin1_bin DEFAULT NULL,
  `log_referrer_id` int(11) DEFAULT '0',
  `log_referrer_url` text COLLATE latin1_bin,
  `log_data1` varchar(255) COLLATE latin1_bin DEFAULT '',
  `log_data2` varchar(255) COLLATE latin1_bin DEFAULT '',
  `log_data3` varchar(255) COLLATE latin1_bin DEFAULT '',
  `log_msg` text COLLATE latin1_bin
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_log_seo`
--

CREATE TABLE `phpwcms_log_seo` (
  `id` int(11) NOT NULL,
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `domain` varchar(255) COLLATE latin1_bin DEFAULT NULL,
  `query` varchar(255) COLLATE latin1_bin DEFAULT NULL,
  `pos` int(11) DEFAULT NULL,
  `referrer` text COLLATE latin1_bin,
  `hash` char(32) COLLATE latin1_bin DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_map`
--

CREATE TABLE `phpwcms_map` (
  `map_id` int(11) NOT NULL,
  `map_cid` int(11) DEFAULT '0',
  `map_x` int(5) DEFAULT '0',
  `map_y` int(5) DEFAULT '0',
  `map_title` text COLLATE latin1_bin,
  `map_zip` varchar(255) COLLATE latin1_bin DEFAULT '',
  `map_city` text COLLATE latin1_bin,
  `map_deleted` int(1) DEFAULT '0',
  `map_entry` text COLLATE latin1_bin,
  `map_vars` text COLLATE latin1_bin
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_message`
--

CREATE TABLE `phpwcms_message` (
  `msg_id` int(11) NOT NULL,
  `msg_pid` int(11) DEFAULT '0',
  `msg_uid` int(11) DEFAULT '0',
  `msg_tstamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `msg_subject` varchar(150) COLLATE latin1_bin DEFAULT '',
  `msg_text` blob,
  `msg_deleted` tinyint(1) DEFAULT '0',
  `msg_read` tinyint(1) DEFAULT '0',
  `msg_to` blob,
  `msg_from` int(11) DEFAULT '0',
  `msg_from_del` int(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_newsletter`
--

CREATE TABLE `phpwcms_newsletter` (
  `newsletter_id` int(11) NOT NULL,
  `newsletter_created` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `newsletter_lastsending` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `newsletter_subject` text COLLATE latin1_bin,
  `newsletter_changed` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `newsletter_vars` mediumblob,
  `newsletter_trashed` int(1) DEFAULT '0',
  `newsletter_active` int(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_newsletterqueue`
--

CREATE TABLE `phpwcms_newsletterqueue` (
  `queue_id` int(11) NOT NULL,
  `queue_created` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `queue_changed` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `queue_status` int(11) DEFAULT '0',
  `queue_pid` int(11) DEFAULT '0',
  `queue_rid` int(11) DEFAULT '0',
  `queue_errormsg` varchar(255) COLLATE latin1_bin DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_pagelayout`
--

CREATE TABLE `phpwcms_pagelayout` (
  `pagelayout_id` int(11) NOT NULL,
  `pagelayout_name` varchar(255) COLLATE latin1_bin DEFAULT '',
  `pagelayout_default` int(1) DEFAULT '0',
  `pagelayout_var` mediumblob,
  `pagelayout_trash` int(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Extraindo dados da tabela `phpwcms_pagelayout`
--

INSERT INTO `phpwcms_pagelayout` (`pagelayout_id`, `pagelayout_name`, `pagelayout_default`, `pagelayout_var`, `pagelayout_trash`) VALUES
(1, 'Site', 1, 0x613a36323a7b733a323a226964223b693a313b733a31313a226c61796f75745f6e616d65223b733a343a2253697465223b733a31343a226c61796f75745f64656661756c74223b693a313b733a31323a226c61796f75745f616c69676e223b693a303b733a31313a226c61796f75745f74797065223b693a333b733a31373a226c61796f75745f626f726465725f746f70223b733a303a22223b733a32303a226c61796f75745f626f726465725f626f74746f6d223b733a303a22223b733a31383a226c61796f75745f626f726465725f6c656674223b733a303a22223b733a31393a226c61796f75745f626f726465725f7269676874223b733a303a22223b733a31353a226c61796f75745f6e6f626f72646572223b693a313b733a31323a226c61796f75745f7469746c65223b733a31353a224e6f6d6520646120456d7072657361223b733a31383a226c61796f75745f7469746c655f6f72646572223b693a363b733a31393a226c61796f75745f7469746c655f737061636572223b733a333a22207c20223b733a31343a226c61796f75745f6267636f6c6f72223b623a303b733a31343a226c61796f75745f6267696d616765223b733a303a22223b733a31353a226c61796f75745f6a736f6e6c6f6164223b733a303a22223b733a31363a226c61796f75745f74657874636f6c6f72223b623a303b733a31363a226c61796f75745f6c696e6b636f6c6f72223b623a303b733a31333a226c61796f75745f76636f6c6f72223b623a303b733a31333a226c61796f75745f61636f6c6f72223b623a303b733a31363a226c61796f75745f616c6c5f7769647468223b733a303a22223b733a31383a226c61796f75745f616c6c5f6267636f6c6f72223b623a303b733a31383a226c61796f75745f616c6c5f6267696d616765223b733a303a22223b733a31363a226c61796f75745f616c6c5f636c617373223b733a303a22223b733a32303a226c61796f75745f636f6e74656e745f7769647468223b733a303a22223b733a32323a226c61796f75745f636f6e74656e745f6267636f6c6f72223b623a303b733a32323a226c61796f75745f636f6e74656e745f6267696d616765223b733a303a22223b733a32303a226c61796f75745f636f6e74656e745f636c617373223b733a303a22223b733a31373a226c61796f75745f6c6566745f7769647468223b733a303a22223b733a31393a226c61796f75745f6c6566745f6267636f6c6f72223b623a303b733a31393a226c61796f75745f6c6566745f6267696d616765223b733a303a22223b733a31373a226c61796f75745f6c6566745f636c617373223b733a303a22223b733a31383a226c61796f75745f72696768745f7769647468223b733a303a22223b733a32303a226c61796f75745f72696768745f6267636f6c6f72223b623a303b733a32303a226c61796f75745f72696768745f6267696d616765223b733a303a22223b733a31383a226c61796f75745f72696768745f636c617373223b733a303a22223b733a32323a226c61796f75745f6c65667473706163655f7769647468223b733a303a22223b733a32343a226c61796f75745f6c65667473706163655f6267636f6c6f72223b623a303b733a32343a226c61796f75745f6c65667473706163655f6267696d616765223b733a303a22223b733a32323a226c61796f75745f6c65667473706163655f636c617373223b733a303a22223b733a32333a226c61796f75745f726967687473706163655f7769647468223b733a303a22223b733a32353a226c61796f75745f726967687473706163655f6267636f6c6f72223b623a303b733a32353a226c61796f75745f726967687473706163655f6267696d616765223b733a303a22223b733a32333a226c61796f75745f726967687473706163655f636c617373223b733a303a22223b733a32303a226c61796f75745f6865616465725f686569676874223b733a303a22223b733a32313a226c61796f75745f6865616465725f6267636f6c6f72223b623a303b733a32313a226c61796f75745f6865616465725f6267696d616765223b733a303a22223b733a31393a226c61796f75745f6865616465725f636c617373223b733a303a22223b733a32323a226c61796f75745f746f7073706163655f686569676874223b733a303a22223b733a32333a226c61796f75745f746f7073706163655f6267636f6c6f72223b623a303b733a32333a226c61796f75745f746f7073706163655f6267696d616765223b733a303a22223b733a32313a226c61796f75745f746f7073706163655f636c617373223b733a303a22223b733a32353a226c61796f75745f626f74746f6d73706163655f686569676874223b733a303a22223b733a32363a226c61796f75745f626f74746f6d73706163655f6267636f6c6f72223b623a303b733a32363a226c61796f75745f626f74746f6d73706163655f6267696d616765223b733a303a22223b733a32343a226c61796f75745f626f74746f6d73706163655f636c617373223b733a303a22223b733a32303a226c61796f75745f666f6f7465725f686569676874223b733a303a22223b733a32313a226c61796f75745f666f6f7465725f6267636f6c6f72223b623a303b733a32313a226c61796f75745f666f6f7465725f6267696d616765223b733a303a22223b733a31393a226c61796f75745f666f6f7465725f636c617373223b733a303a22223b733a31333a226c61796f75745f72656e646572223b693a313b733a31393a226c61796f75745f637573746f6d626c6f636b73223b733a303a22223b7d, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_profession`
--

CREATE TABLE `phpwcms_profession` (
  `prof_id` int(4) NOT NULL,
  `prof_name` varchar(255) COLLATE latin1_bin DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Extraindo dados da tabela `phpwcms_profession`
--

INSERT INTO `phpwcms_profession` (`prof_id`, `prof_name`) VALUES
(1, 'academic'),
(2, 'accountant'),
(3, 'actor'),
(4, 'administrative services department manager'),
(5, 'administrator'),
(6, 'administrator, IT'),
(7, 'agricultural advisor'),
(8, 'air steward'),
(9, 'air-conditioning installer or mechanic'),
(10, 'aircraft service technician'),
(11, 'ambulance driver (non paramedic)'),
(12, 'animal carer (not in farms)'),
(13, 'animator'),
(14, 'arable farm manager, field crop or vegetable'),
(15, 'arable farmer, field crop or vegetable'),
(16, 'architect'),
(17, 'architect, landscape'),
(18, 'artist'),
(19, 'asbestos removal worker'),
(20, 'assembler'),
(21, 'assembly team leader'),
(22, 'assistant'),
(23, 'author'),
(24, 'baker'),
(25, 'bank clerk (back-office)'),
(26, 'beauty therapist'),
(27, 'beverage production process controller'),
(28, 'biologist'),
(29, 'blogger'),
(30, 'boring machine operator'),
(31, 'bricklayer'),
(32, 'builder'),
(33, 'butcher'),
(34, 'car mechanic'),
(35, 'career counsellor'),
(36, 'caretaker'),
(37, 'carpenter'),
(38, 'charge nurse'),
(39, 'check-out operator'),
(40, 'chef'),
(41, 'child-carer'),
(42, 'civil engineering technician'),
(43, 'civil servant'),
(44, 'cleaning supervisor'),
(45, 'clerk'),
(46, 'climatologist'),
(47, 'cloak room attendant'),
(48, 'cnc operator'),
(49, 'comic book writer'),
(50, 'community health worker'),
(51, 'company director'),
(52, 'computer programmer'),
(53, 'confectionery maker'),
(54, 'construction operative'),
(55, 'cook'),
(56, 'cooling or freezing installer or mechanic'),
(57, 'critic'),
(58, 'database designer'),
(59, 'decorator'),
(60, 'dental hygienist'),
(61, 'dental prosthesis technician'),
(62, 'dentist'),
(63, 'department store manager'),
(64, 'designer'),
(65, 'designer, graphic'),
(66, 'designer, industrial'),
(67, 'designer, interface'),
(68, 'designer, interior'),
(69, 'designer, screen'),
(70, 'designer, web'),
(71, 'dietician'),
(72, 'diplomat'),
(73, 'director'),
(74, 'display designer'),
(75, 'doctor'),
(76, 'domestic housekeeper'),
(77, 'economist'),
(78, 'editor'),
(79, 'education advisor'),
(80, 'electrical engineer'),
(81, 'electrical mechanic or fitter'),
(82, 'electrician'),
(83, 'engineer'),
(84, 'engineering maintenance supervisor'),
(85, 'estate agent'),
(86, 'executive'),
(87, 'executive secretary'),
(88, 'farmer'),
(89, 'felt roofer'),
(90, 'filing clerk'),
(91, 'film director'),
(92, 'financial clerk'),
(93, 'financial services manager'),
(94, 'fire fighter'),
(95, 'first line supervisor beverages workers'),
(96, 'first line supervisor of cleaning workers'),
(97, 'fisherman'),
(98, 'fishmonger'),
(99, 'flight attendant'),
(100, 'floral arranger'),
(101, 'food scientist'),
(102, 'garage supervisor'),
(103, 'garbage man'),
(104, 'gardener, all other'),
(105, 'general practitioner'),
(106, 'geographer'),
(107, 'geologist'),
(108, 'hairdresser'),
(109, 'head groundsman'),
(110, 'head teacher'),
(111, 'horse riding instructor'),
(112, 'hospital nurse'),
(113, 'hotel manager'),
(114, 'house painter'),
(115, 'hr manager'),
(116, 'it applications programmer'),
(117, 'it systems administrator'),
(118, 'jeweller'),
(119, 'journalist'),
(120, 'judge'),
(121, 'juggler'),
(122, 'kitchen assistant'),
(123, 'lathe setter-operator'),
(124, 'lawyer'),
(125, 'lecturer'),
(126, 'legal secretary'),
(127, 'lexicographer'),
(128, 'library assistant'),
(129, 'local police officer'),
(130, 'logistics manager'),
(131, 'machine tool operator'),
(132, 'magician'),
(133, 'makeup artist'),
(134, 'manager'),
(135, 'manager, all other health services'),
(136, 'marketing manager'),
(137, 'meat processing operator'),
(138, 'mechanical engineering technician'),
(139, 'medical laboratory technician'),
(140, 'medical radiography equipment operator'),
(141, 'metal moulder'),
(142, 'metal production process operator'),
(143, 'meteorologist'),
(144, 'midwifery professional'),
(145, 'miner'),
(146, 'mortgage clerk'),
(147, 'musical instrument maker'),
(148, 'musician'),
(149, 'non-commissioned officer armed forces'),
(150, 'nurse'),
(151, 'nursery school teacher'),
(152, 'nursing aid'),
(153, 'ophthalmic optician'),
(154, 'optician'),
(155, 'painter'),
(156, 'payroll clerk'),
(157, 'personal assistant'),
(158, 'personal carer in an institution for the elderly'),
(159, 'personal carer in an institution for the handicapped'),
(160, 'personal carer in private homes'),
(161, 'personnel clerk'),
(162, 'pest controller'),
(163, 'photographer'),
(164, 'physician assistant'),
(165, 'pilot'),
(166, 'pipe fitter'),
(167, 'plant maintenance mechanic'),
(168, 'plumber'),
(169, 'police inspector'),
(170, 'police officer'),
(171, 'policy advisor'),
(172, 'politician'),
(173, 'porter'),
(174, 'post secondary education teacher'),
(175, 'post sorting or distributing clerk'),
(176, 'power plant operator'),
(177, 'primary school head'),
(178, 'primary school teacher'),
(179, 'printer'),
(180, 'printing machine operator'),
(181, 'prison officer / warder'),
(182, 'product manager'),
(183, 'professional gambler'),
(184, 'project manager'),
(185, 'programmer'),
(186, 'psychologist'),
(187, 'puppeteer'),
(188, 'quality inspector, all other products'),
(189, 'receptionist'),
(190, 'restaurant cook'),
(191, 'road paviour'),
(192, 'roofer'),
(193, 'sailor'),
(194, 'sales assistant, all other'),
(195, 'sales or marketing manager'),
(196, 'sales representative'),
(197, 'sales support clerk'),
(198, 'salesperson'),
(199, 'scientist'),
(200, 'seaman (armed forces)'),
(201, 'secondary school manager'),
(202, 'secondary school teacher'),
(203, 'secretary'),
(204, 'security guard'),
(205, 'sheet metal worker'),
(206, 'ship mechanic'),
(207, 'shoe repairer, leather repairer'),
(208, 'shop assistant'),
(209, 'sign language Interpreter'),
(210, 'singer'),
(211, 'social media manager'),
(212, 'socialphotographer'),
(213, 'software analyst'),
(214, 'software developer'),
(215, 'software engineer'),
(216, 'soldier'),
(217, 'solicitor'),
(218, 'speech therapist'),
(219, 'steel fixer'),
(220, 'stockman'),
(221, 'structural engineer'),
(222, 'student'),
(223, 'surgeon'),
(224, 'surgical footwear maker'),
(225, 'swimming instructor'),
(226, 'system operator'),
(227, 'tailor'),
(228, 'tailor, seamstress'),
(229, 'tax inspector'),
(230, 'taxi driver'),
(231, 'teacher'),
(232, 'telephone operator'),
(233, 'telephonist'),
(234, 'theorist'),
(235, 'tile layer'),
(236, 'translator'),
(237, 'transport clerk'),
(238, 'travel agency clerk'),
(239, 'travel agent'),
(240, 'truck driver long distances'),
(241, 'trucker'),
(242, 'TV cameraman'),
(243, 'TV presenter'),
(244, 'university professor'),
(245, 'university researcher'),
(246, 'vet'),
(247, 'veterinary practitioner'),
(248, 'vocational education teacher'),
(249, 'waiter'),
(250, 'waiting staff'),
(251, 'web designer'),
(252, 'web developer'),
(253, 'webmaster'),
(254, 'welder, all other'),
(255, 'wood processing plant operator'),
(256, 'writer'),
(257, 'other'),
(258, 'n/a');

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_redirect`
--

CREATE TABLE `phpwcms_redirect` (
  `rid` int(11) UNSIGNED NOT NULL,
  `changed` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id` bigint(20) UNSIGNED DEFAULT '0',
  `aid` bigint(20) UNSIGNED DEFAULT '0',
  `alias` varchar(255) COLLATE latin1_bin DEFAULT '',
  `link` varchar(255) COLLATE latin1_bin DEFAULT '',
  `views` bigint(20) UNSIGNED DEFAULT '0',
  `active` int(1) UNSIGNED DEFAULT '0',
  `shortcut` int(1) UNSIGNED DEFAULT '0',
  `type` varchar(255) COLLATE latin1_bin DEFAULT '',
  `code` varchar(255) COLLATE latin1_bin DEFAULT '',
  `target` varchar(255) COLLATE latin1_bin DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_shop_boleto`
--

CREATE TABLE `phpwcms_shop_boleto` (
  `boleto_id` int(1) NOT NULL,
  `boleto_codigo` varchar(255) COLLATE latin1_bin DEFAULT NULL,
  `boleto_pedido` varchar(20) COLLATE latin1_bin DEFAULT NULL,
  `boleto_nome` text COLLATE latin1_bin,
  `boleto_cidade` text COLLATE latin1_bin,
  `boleto_estado` varchar(2) COLLATE latin1_bin DEFAULT NULL,
  `boleto_cep` varchar(255) COLLATE latin1_bin DEFAULT NULL,
  `boleto_info` text COLLATE latin1_bin,
  `boleto_valor` varchar(255) COLLATE latin1_bin DEFAULT NULL,
  `boleto_criacao` date DEFAULT NULL,
  `boleto_processamento` date DEFAULT NULL,
  `boleto_vencimento` date DEFAULT NULL,
  `boleto_email` varchar(255) COLLATE latin1_bin DEFAULT NULL,
  `boleto_status` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_shop_orders`
--

CREATE TABLE `phpwcms_shop_orders` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `order_number` varchar(20) COLLATE latin1_bin DEFAULT '',
  `order_date` datetime DEFAULT '0000-00-00 00:00:00',
  `order_name` varchar(255) COLLATE latin1_bin DEFAULT '',
  `order_firstname` varchar(255) COLLATE latin1_bin DEFAULT '',
  `order_email` varchar(255) COLLATE latin1_bin DEFAULT '',
  `order_net` float DEFAULT '0',
  `order_gross` float DEFAULT '0',
  `order_payment` varchar(255) COLLATE latin1_bin DEFAULT '',
  `order_data` mediumtext COLLATE latin1_bin,
  `order_status` varchar(100) COLLATE latin1_bin DEFAULT '',
  `order_user_id` int(11) DEFAULT '0',
  `order_pagseguro` varchar(255) COLLATE latin1_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_shop_products`
--

CREATE TABLE `phpwcms_shop_products` (
  `shopprod_id` int(10) UNSIGNED NOT NULL,
  `shopprod_createdate` datetime DEFAULT '0000-00-00 00:00:00',
  `shopprod_changedate` datetime DEFAULT '0000-00-00 00:00:00',
  `shopprod_status` int(1) UNSIGNED DEFAULT '0',
  `shopprod_uid` int(10) UNSIGNED DEFAULT '0',
  `shopprod_ordernumber` varchar(255) COLLATE latin1_bin DEFAULT '',
  `shopprod_model` varchar(255) COLLATE latin1_bin DEFAULT '',
  `shopprod_name1` varchar(255) COLLATE latin1_bin DEFAULT '',
  `shopprod_name2` varchar(255) COLLATE latin1_bin DEFAULT '',
  `shopprod_tag` varchar(255) COLLATE latin1_bin DEFAULT '',
  `shopprod_vat` float UNSIGNED DEFAULT '0',
  `shopprod_netgross` int(1) UNSIGNED DEFAULT '0',
  `shopprod_price` float DEFAULT '0',
  `shopprod_maxrebate` float DEFAULT '0',
  `shopprod_description0` text COLLATE latin1_bin,
  `shopprod_description1` text COLLATE latin1_bin,
  `shopprod_description2` text COLLATE latin1_bin,
  `shopprod_description3` text COLLATE latin1_bin,
  `shopprod_var` mediumtext COLLATE latin1_bin,
  `shopprod_category` varchar(255) COLLATE latin1_bin DEFAULT '',
  `shopprod_weight` float DEFAULT '0',
  `shopprod_color` varchar(255) COLLATE latin1_bin DEFAULT '',
  `shopprod_size` varchar(255) COLLATE latin1_bin DEFAULT '',
  `shopprod_listall` int(1) UNSIGNED DEFAULT '0',
  `shopprod_special_price` text COLLATE latin1_bin,
  `shopprod_track_view` int(11) DEFAULT '0',
  `shopprod_lang` varchar(255) COLLATE latin1_bin DEFAULT '',
  `shopprod_overwrite_meta` int(1) DEFAULT '1',
  `shopprod_opengraph` int(1) UNSIGNED DEFAULT '1',
  `shopprod_ordenacao` varchar(255) COLLATE latin1_bin DEFAULT NULL,
  `shopprod_seo_tit` varchar(255) COLLATE latin1_bin DEFAULT NULL,
  `shopprod_seo_desc` text COLLATE latin1_bin,
  `shopprod_parcelas` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_subscription`
--

CREATE TABLE `phpwcms_subscription` (
  `subscription_id` int(11) NOT NULL,
  `subscription_name` text COLLATE latin1_bin,
  `subscription_info` blob,
  `subscription_active` int(1) DEFAULT '0',
  `subscription_lang` varchar(100) COLLATE latin1_bin DEFAULT '',
  `subscription_tstamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_sysvalue`
--

CREATE TABLE `phpwcms_sysvalue` (
  `sysvalue_key` varchar(255) COLLATE latin1_bin NOT NULL DEFAULT '',
  `sysvalue_group` varchar(255) COLLATE latin1_bin DEFAULT '',
  `sysvalue_lastchange` int(11) DEFAULT '0',
  `sysvalue_status` int(1) DEFAULT '0',
  `sysvalue_vartype` varchar(255) COLLATE latin1_bin DEFAULT '',
  `sysvalue_value` mediumtext COLLATE latin1_bin
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Extraindo dados da tabela `phpwcms_sysvalue`
--

INSERT INTO `phpwcms_sysvalue` (`sysvalue_key`, `sysvalue_group`, `sysvalue_lastchange`, `sysvalue_status`, `sysvalue_vartype`, `sysvalue_value`) VALUES
('structure_array_vmode_all', 'frontend_render', 1653090304, 1, 'array', 'a:8:{i:0;a:30:{s:7:\"acat_id\";i:0;s:9:\"acat_name\";s:9:\"Principal\";s:9:\"acat_menu\";N;s:9:\"acat_info\";s:0:\"\";s:11:\"acat_struct\";i:0;s:9:\"acat_sort\";i:0;s:11:\"acat_hidden\";i:0;s:12:\"acat_regonly\";i:0;s:8:\"acat_ssl\";i:0;s:13:\"acat_template\";i:1;s:10:\"acat_alias\";s:5:\"index\";s:13:\"acat_topcount\";i:-1;s:12:\"acat_maxlist\";i:0;s:13:\"acat_redirect\";s:0:\"\";s:10:\"acat_order\";i:0;s:12:\"acat_timeout\";s:0:\"\";s:13:\"acat_nosearch\";s:0:\"\";s:14:\"acat_nositemap\";i:1;s:14:\"acat_img_width\";N;s:15:\"acat_img_height\";N;s:13:\"acat_img_crop\";N;s:11:\"acat_permit\";a:0:{}s:14:\"acat_pagetitle\";s:0:\"\";s:13:\"acat_paginate\";i:0;s:14:\"acat_overwrite\";s:0:\"\";s:12:\"acat_archive\";i:0;s:10:\"acat_class\";s:0:\"\";s:13:\"acat_keywords\";s:0:\"\";s:15:\"acat_disable301\";i:0;s:14:\"acat_opengraph\";i:1;}i:1;a:30:{s:7:\"acat_id\";s:1:\"1\";s:9:\"acat_name\";s:4:\"Home\";s:9:\"acat_menu\";s:1:\"1\";s:9:\"acat_info\";s:0:\"\";s:11:\"acat_struct\";s:1:\"0\";s:9:\"acat_sort\";s:1:\"1\";s:11:\"acat_hidden\";s:1:\"0\";s:12:\"acat_regonly\";s:1:\"0\";s:8:\"acat_ssl\";s:1:\"0\";s:13:\"acat_template\";s:1:\"1\";s:10:\"acat_alias\";s:4:\"home\";s:13:\"acat_topcount\";s:2:\"-1\";s:12:\"acat_maxlist\";s:1:\"0\";s:13:\"acat_redirect\";s:9:\"index.php\";s:10:\"acat_order\";s:1:\"0\";s:12:\"acat_timeout\";s:1:\"0\";s:13:\"acat_nosearch\";s:0:\"\";s:14:\"acat_nositemap\";s:1:\"1\";s:14:\"acat_img_width\";N;s:15:\"acat_img_height\";N;s:13:\"acat_img_crop\";N;s:11:\"acat_permit\";a:0:{}s:14:\"acat_pagetitle\";s:0:\"\";s:13:\"acat_paginate\";s:1:\"0\";s:14:\"acat_overwrite\";s:0:\"\";s:12:\"acat_archive\";s:1:\"0\";s:10:\"acat_class\";s:0:\"\";s:13:\"acat_keywords\";s:0:\"\";s:15:\"acat_disable301\";s:1:\"0\";s:14:\"acat_opengraph\";s:1:\"1\";}i:2;a:30:{s:7:\"acat_id\";s:1:\"2\";s:9:\"acat_name\";s:7:\"Empresa\";s:9:\"acat_menu\";s:1:\"1\";s:9:\"acat_info\";s:0:\"\";s:11:\"acat_struct\";s:1:\"0\";s:9:\"acat_sort\";s:1:\"2\";s:11:\"acat_hidden\";s:1:\"0\";s:12:\"acat_regonly\";s:1:\"0\";s:8:\"acat_ssl\";s:1:\"0\";s:13:\"acat_template\";s:1:\"2\";s:10:\"acat_alias\";s:7:\"empresa\";s:13:\"acat_topcount\";s:2:\"-1\";s:12:\"acat_maxlist\";s:1:\"0\";s:13:\"acat_redirect\";s:0:\"\";s:10:\"acat_order\";s:1:\"0\";s:12:\"acat_timeout\";s:0:\"\";s:13:\"acat_nosearch\";s:0:\"\";s:14:\"acat_nositemap\";s:1:\"1\";s:14:\"acat_img_width\";N;s:15:\"acat_img_height\";N;s:13:\"acat_img_crop\";N;s:11:\"acat_permit\";a:0:{}s:14:\"acat_pagetitle\";s:0:\"\";s:13:\"acat_paginate\";s:1:\"0\";s:14:\"acat_overwrite\";s:0:\"\";s:12:\"acat_archive\";s:1:\"0\";s:10:\"acat_class\";s:0:\"\";s:13:\"acat_keywords\";s:0:\"\";s:15:\"acat_disable301\";s:1:\"0\";s:14:\"acat_opengraph\";s:1:\"1\";}i:3;a:30:{s:7:\"acat_id\";s:1:\"3\";s:9:\"acat_name\";s:8:\"Serviços\";s:9:\"acat_menu\";s:1:\"1\";s:9:\"acat_info\";s:0:\"\";s:11:\"acat_struct\";s:1:\"0\";s:9:\"acat_sort\";s:1:\"3\";s:11:\"acat_hidden\";s:1:\"0\";s:12:\"acat_regonly\";s:1:\"0\";s:8:\"acat_ssl\";s:1:\"0\";s:13:\"acat_template\";s:1:\"2\";s:10:\"acat_alias\";s:8:\"servicos\";s:13:\"acat_topcount\";s:3:\"100\";s:12:\"acat_maxlist\";s:3:\"100\";s:13:\"acat_redirect\";s:0:\"\";s:10:\"acat_order\";s:1:\"0\";s:12:\"acat_timeout\";s:0:\"\";s:13:\"acat_nosearch\";s:0:\"\";s:14:\"acat_nositemap\";s:1:\"1\";s:14:\"acat_img_width\";s:3:\"350\";s:15:\"acat_img_height\";s:3:\"350\";s:13:\"acat_img_crop\";s:1:\"0\";s:11:\"acat_permit\";a:0:{}s:14:\"acat_pagetitle\";s:0:\"\";s:13:\"acat_paginate\";s:1:\"1\";s:14:\"acat_overwrite\";s:0:\"\";s:12:\"acat_archive\";s:1:\"0\";s:10:\"acat_class\";s:0:\"\";s:13:\"acat_keywords\";s:0:\"\";s:15:\"acat_disable301\";s:1:\"0\";s:14:\"acat_opengraph\";s:1:\"1\";}i:4;a:30:{s:7:\"acat_id\";s:1:\"4\";s:9:\"acat_name\";s:8:\"Produtos\";s:9:\"acat_menu\";s:1:\"1\";s:9:\"acat_info\";s:0:\"\";s:11:\"acat_struct\";s:1:\"0\";s:9:\"acat_sort\";s:1:\"4\";s:11:\"acat_hidden\";s:1:\"0\";s:12:\"acat_regonly\";s:1:\"0\";s:8:\"acat_ssl\";s:1:\"0\";s:13:\"acat_template\";s:1:\"2\";s:10:\"acat_alias\";s:8:\"produtos\";s:13:\"acat_topcount\";s:2:\"-1\";s:12:\"acat_maxlist\";s:1:\"0\";s:13:\"acat_redirect\";s:0:\"\";s:10:\"acat_order\";s:1:\"0\";s:12:\"acat_timeout\";s:0:\"\";s:13:\"acat_nosearch\";s:0:\"\";s:14:\"acat_nositemap\";s:1:\"1\";s:14:\"acat_img_width\";N;s:15:\"acat_img_height\";N;s:13:\"acat_img_crop\";N;s:11:\"acat_permit\";a:0:{}s:14:\"acat_pagetitle\";s:0:\"\";s:13:\"acat_paginate\";s:1:\"0\";s:14:\"acat_overwrite\";s:0:\"\";s:12:\"acat_archive\";s:1:\"0\";s:10:\"acat_class\";s:0:\"\";s:13:\"acat_keywords\";s:0:\"\";s:15:\"acat_disable301\";s:1:\"0\";s:14:\"acat_opengraph\";s:1:\"1\";}i:5;a:30:{s:7:\"acat_id\";s:1:\"5\";s:9:\"acat_name\";s:7:\"Contato\";s:9:\"acat_menu\";s:1:\"1\";s:9:\"acat_info\";s:0:\"\";s:11:\"acat_struct\";s:1:\"0\";s:9:\"acat_sort\";s:1:\"5\";s:11:\"acat_hidden\";s:1:\"0\";s:12:\"acat_regonly\";s:1:\"0\";s:8:\"acat_ssl\";s:1:\"0\";s:13:\"acat_template\";s:1:\"3\";s:10:\"acat_alias\";s:7:\"contato\";s:13:\"acat_topcount\";s:2:\"-1\";s:12:\"acat_maxlist\";s:1:\"0\";s:13:\"acat_redirect\";s:0:\"\";s:10:\"acat_order\";s:1:\"0\";s:12:\"acat_timeout\";s:0:\"\";s:13:\"acat_nosearch\";s:0:\"\";s:14:\"acat_nositemap\";s:1:\"1\";s:14:\"acat_img_width\";N;s:15:\"acat_img_height\";N;s:13:\"acat_img_crop\";N;s:11:\"acat_permit\";a:0:{}s:14:\"acat_pagetitle\";s:0:\"\";s:13:\"acat_paginate\";s:1:\"0\";s:14:\"acat_overwrite\";s:0:\"\";s:12:\"acat_archive\";s:1:\"0\";s:10:\"acat_class\";s:0:\"\";s:13:\"acat_keywords\";s:0:\"\";s:15:\"acat_disable301\";s:1:\"0\";s:14:\"acat_opengraph\";s:1:\"1\";}i:6;a:30:{s:7:\"acat_id\";s:1:\"6\";s:9:\"acat_name\";s:8:\"Noticias\";s:9:\"acat_menu\";s:1:\"0\";s:9:\"acat_info\";s:0:\"\";s:11:\"acat_struct\";s:1:\"0\";s:9:\"acat_sort\";s:3:\"300\";s:11:\"acat_hidden\";s:1:\"1\";s:12:\"acat_regonly\";s:1:\"0\";s:8:\"acat_ssl\";s:1:\"0\";s:13:\"acat_template\";s:1:\"2\";s:10:\"acat_alias\";s:8:\"noticias\";s:13:\"acat_topcount\";s:2:\"12\";s:12:\"acat_maxlist\";s:2:\"12\";s:13:\"acat_redirect\";s:0:\"\";s:10:\"acat_order\";s:1:\"0\";s:12:\"acat_timeout\";s:0:\"\";s:13:\"acat_nosearch\";s:0:\"\";s:14:\"acat_nositemap\";s:1:\"1\";s:14:\"acat_img_width\";s:3:\"500\";s:15:\"acat_img_height\";s:3:\"500\";s:13:\"acat_img_crop\";s:1:\"0\";s:11:\"acat_permit\";a:0:{}s:14:\"acat_pagetitle\";s:0:\"\";s:13:\"acat_paginate\";s:1:\"1\";s:14:\"acat_overwrite\";s:0:\"\";s:12:\"acat_archive\";s:1:\"0\";s:10:\"acat_class\";s:0:\"\";s:13:\"acat_keywords\";s:0:\"\";s:15:\"acat_disable301\";s:1:\"0\";s:14:\"acat_opengraph\";s:1:\"0\";}i:7;a:30:{s:7:\"acat_id\";s:1:\"7\";s:9:\"acat_name\";s:5:\"Busca\";s:9:\"acat_menu\";s:1:\"0\";s:9:\"acat_info\";s:0:\"\";s:11:\"acat_struct\";s:1:\"0\";s:9:\"acat_sort\";s:3:\"301\";s:11:\"acat_hidden\";s:1:\"1\";s:12:\"acat_regonly\";s:1:\"0\";s:8:\"acat_ssl\";s:1:\"0\";s:13:\"acat_template\";s:1:\"2\";s:10:\"acat_alias\";s:5:\"busca\";s:13:\"acat_topcount\";s:2:\"-1\";s:12:\"acat_maxlist\";s:1:\"0\";s:13:\"acat_redirect\";s:0:\"\";s:10:\"acat_order\";s:1:\"0\";s:12:\"acat_timeout\";s:0:\"\";s:13:\"acat_nosearch\";s:0:\"\";s:14:\"acat_nositemap\";s:1:\"1\";s:14:\"acat_img_width\";N;s:15:\"acat_img_height\";N;s:13:\"acat_img_crop\";N;s:11:\"acat_permit\";a:0:{}s:14:\"acat_pagetitle\";s:0:\"\";s:13:\"acat_paginate\";s:1:\"0\";s:14:\"acat_overwrite\";s:0:\"\";s:12:\"acat_archive\";s:1:\"0\";s:10:\"acat_class\";s:0:\"\";s:13:\"acat_keywords\";s:0:\"\";s:15:\"acat_disable301\";s:1:\"0\";s:14:\"acat_opengraph\";s:1:\"0\";}}'),
('structure_array_vmode_editor', 'frontend_render', 1653090273, 1, 'bool', '0'),
('structure_array_vmode_admin', 'frontend_render', 1653090273, 1, 'bool', '0'),
('shop_pref_currency', 'module_shop', 1550238041, 1, 'string', ''),
('shop_pref_unit_weight', 'module_shop', 1550238041, 1, 'string', 'kg'),
('shop_pref_vat', 'module_shop', 1550238041, 1, 'array', 'a:3:{i:0;s:4:\"0.00\";i:1;s:4:\"7.00\";i:2;s:5:\"19.00\";}'),
('shop_pref_email_to', 'module_shop', 1550238041, 1, 'string', ''),
('shop_pref_email_from', 'module_shop', 1550238041, 1, 'string', ''),
('shop_pref_email_paypal', 'module_shop', 1550238041, 1, 'string', ''),
('shop_pref_id_shop', 'module_shop', 1550238041, 1, 'int', '0'),
('shop_pref_id_cart', 'module_shop', 1550238041, 1, 'int', '0'),
('shop_pref_felang', 'module_shop', 1550238041, 1, 'int', '0'),
('shop_pref_shipping', 'module_shop', 1550238041, 1, 'array', 'a:5:{i:0;a:3:{s:6:\"weight\";s:2:\"50\";s:3:\"net\";i:0;s:3:\"vat\";i:0;}i:1;a:3:{s:6:\"weight\";s:0:\"\";s:3:\"net\";i:0;s:3:\"vat\";i:0;}i:2;a:3:{s:6:\"weight\";s:0:\"\";s:3:\"net\";i:0;s:3:\"vat\";i:0;}i:3;a:3:{s:6:\"weight\";s:0:\"\";s:3:\"net\";i:0;s:3:\"vat\";i:0;}i:4;a:3:{s:6:\"weight\";s:0:\"\";s:3:\"net\";i:0;s:3:\"vat\";i:0;}}'),
('shop_pref_payment', 'module_shop', 1550238041, 1, 'array', 'a:6:{s:6:\"paypal\";i:1;s:6:\"prepay\";i:1;s:3:\"pod\";i:1;s:6:\"onbill\";i:1;s:5:\"ccard\";i:1;s:14:\"accepted_ccard\";a:3:{i:0;s:15:\"americanexpress\";i:1;s:10:\"mastercard\";i:2;s:4:\"visa\";}}'),
('shop_pref_terms', 'module_shop', 1550238041, 1, 'string', ''),
('shop_pref_terms_format', 'module_shop', 1550238041, 1, 'int', '0'),
('shop_pref_discount', 'module_shop', 1550238041, 1, 'array', 'a:2:{s:8:\"discount\";i:0;s:7:\"percent\";i:0;}'),
('shop_pref_loworder', 'module_shop', 1550238041, 1, 'array', 'a:4:{s:8:\"loworder\";i:0;s:5:\"under\";i:0;s:6:\"charge\";i:0;s:3:\"vat\";i:0;}');

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_template`
--

CREATE TABLE `phpwcms_template` (
  `template_id` int(11) NOT NULL,
  `template_type` int(11) DEFAULT '1',
  `template_name` varchar(255) COLLATE latin1_bin DEFAULT '',
  `template_default` int(1) DEFAULT '0',
  `template_var` mediumblob,
  `template_trash` int(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Extraindo dados da tabela `phpwcms_template`
--

INSERT INTO `phpwcms_template` (`template_id`, `template_type`, `template_name`, `template_default`, `template_var`, `template_trash`) VALUES
(1, 1, 'Home', 0, 0x613a32303a7b733a343a226e616d65223b733a343a22486f6d65223b733a373a2264656661756c74223b693a303b733a363a226c61796f7574223b693a313b733a333a22637373223b613a313a7b693a303b733a31313a22657374696c6f732e637373223b7d733a383a2268746d6c68656164223b733a3635313a223c6c696e6b2072656c3d226170706c652d746f7563682d69636f6e222073697a65733d22313830783138302220687265663d22696d616765732f66617669636f6e2f6170706c652d746f7563682d69636f6e2e706e67223e0a3c6c696e6b2072656c3d2269636f6e2220747970653d22696d6167652f706e67222073697a65733d2233327833322220687265663d22696d616765732f66617669636f6e2f66617669636f6e2d33327833322e706e67223e0a3c6c696e6b2072656c3d2269636f6e2220747970653d22696d6167652f706e67222073697a65733d2231367831362220687265663d22696d616765732f66617669636f6e2f66617669636f6e2d31367831362e706e67223e0a3c6c696e6b2072656c3d226d616e69666573742220687265663d22696d616765732f66617669636f6e2f736974652e7765626d616e6966657374223e0a3c6c696e6b2072656c3d226d61736b2d69636f6e2220687265663d22696d616765732f66617669636f6e2f7361666172692d70696e6e65642d7461622e7376672220636f6c6f723d2223356262616435223e0a3c6c696e6b2072656c3d2273686f72746375742069636f6e2220687265663d22696d616765732f66617669636f6e2f66617669636f6e2e69636f223e0a3c6d657461206e616d653d226d736170706c69636174696f6e2d54696c65436f6c6f722220636f6e74656e743d2223646135333263223e0a3c6d657461206e616d653d226d736170706c69636174696f6e2d636f6e6669672220636f6e74656e743d22696d616765732f66617669636f6e2f62726f77736572636f6e6669672e786d6c223e0a3c6d657461206e616d653d227468656d652d636f6c6f722220636f6e74656e743d2223666666666666223e0a0a223b733a31323a2268746d6c686561645f657874223b733a303a22223b733a383a226a736f6e6c6f6164223b733a303a22223b733a31303a2268656164657274657874223b613a313a7b693a303b733a393a22746f706f2e68746d6c223b7d733a383a226d61696e74657874223b613a313a7b693a303b733a393a22686f6d652e68746d6c223b7d733a31303a22666f6f74657274657874223b613a333a7b693a303b733a31313a22726f646170652e68746d6c223b693a313b733a31373a22736372697074732d736974652e68746d6c223b693a323b733a31323a2265666569746f732e68746d6c223b7d733a383a226c65667474657874223b733a303a22223b733a393a22726967687474657874223b733a303a22223b733a393a226572726f7274657874223b733a34323a223c68313e343034206572726f7220706167653c2f68313e0d0a3c703e4e6f20636f6e74656e743c2f703e223b733a31303a2266656c6f67696e75726c223b733a303a22223b733a353a226a736c6962223b733a31313a226a71756572792d312e3131223b733a393a226a736c69626c6f6164223b693a313b733a31303a2266726f6e74656e646a73223b693a303b733a393a22676f6f676c65617069223b693a303b733a323a226964223b693a313b733a393a226f7665727772697465223b733a303a22223b7d, 0),
(2, 1, 'Interna', 1, 0x613a32303a7b733a343a226e616d65223b733a373a22496e7465726e61223b733a373a2264656661756c74223b693a313b733a363a226c61796f7574223b693a313b733a333a22637373223b613a313a7b693a303b733a31313a22657374696c6f732e637373223b7d733a383a2268746d6c68656164223b733a3635303a223c6c696e6b2072656c3d226170706c652d746f7563682d69636f6e222073697a65733d22313830783138302220687265663d22696d616765732f66617669636f6e2f6170706c652d746f7563682d69636f6e2e706e67223e0a3c6c696e6b2072656c3d2269636f6e2220747970653d22696d6167652f706e67222073697a65733d2233327833322220687265663d22696d616765732f66617669636f6e2f66617669636f6e2d33327833322e706e67223e0a3c6c696e6b2072656c3d2269636f6e2220747970653d22696d6167652f706e67222073697a65733d2231367831362220687265663d22696d616765732f66617669636f6e2f66617669636f6e2d31367831362e706e67223e0a3c6c696e6b2072656c3d226d616e69666573742220687265663d22696d616765732f66617669636f6e2f736974652e7765626d616e6966657374223e0a3c6c696e6b2072656c3d226d61736b2d69636f6e2220687265663d22696d616765732f66617669636f6e2f7361666172692d70696e6e65642d7461622e7376672220636f6c6f723d2223356262616435223e0a3c6c696e6b2072656c3d2273686f72746375742069636f6e2220687265663d22696d616765732f66617669636f6e2f66617669636f6e2e69636f223e0a3c6d657461206e616d653d226d736170706c69636174696f6e2d54696c65436f6c6f722220636f6e74656e743d2223646135333263223e0a3c6d657461206e616d653d226d736170706c69636174696f6e2d636f6e6669672220636f6e74656e743d22696d616765732f66617669636f6e2f62726f77736572636f6e6669672e786d6c223e0a3c6d657461206e616d653d227468656d652d636f6c6f722220636f6e74656e743d2223666666666666223e0a223b733a31323a2268746d6c686561645f657874223b733a303a22223b733a383a226a736f6e6c6f6164223b733a303a22223b733a31303a2268656164657274657874223b613a313a7b693a303b733a31373a22746f706f2d696e7465726e612e68746d6c223b7d733a383a226d61696e74657874223b613a313a7b693a303b733a31323a22696e7465726e612e68746d6c223b7d733a31303a22666f6f74657274657874223b613a323a7b693a303b733a31313a22726f646170652e68746d6c223b693a313b733a31373a22736372697074732d736974652e68746d6c223b7d733a383a226c65667474657874223b733a303a22223b733a393a22726967687474657874223b733a303a22223b733a393a226572726f7274657874223b733a34323a223c68313e343034206572726f7220706167653c2f68313e0d0a3c703e4e6f20636f6e74656e743c2f703e223b733a31303a2266656c6f67696e75726c223b733a303a22223b733a353a226a736c6962223b733a31313a226a71756572792d312e3131223b733a393a226a736c69626c6f6164223b693a313b733a31303a2266726f6e74656e646a73223b693a303b733a393a22676f6f676c65617069223b693a303b733a323a226964223b693a323b733a393a226f7665727772697465223b733a303a22223b7d, 0),
(3, 1, 'Contato', 0, 0x613a32303a7b733a343a226e616d65223b733a373a22436f6e7461746f223b733a373a2264656661756c74223b693a303b733a363a226c61796f7574223b693a313b733a333a22637373223b613a313a7b693a303b733a31313a22657374696c6f732e637373223b7d733a383a2268746d6c68656164223b733a3635303a223c6c696e6b2072656c3d226170706c652d746f7563682d69636f6e222073697a65733d22313830783138302220687265663d22696d616765732f66617669636f6e2f6170706c652d746f7563682d69636f6e2e706e67223e0a3c6c696e6b2072656c3d2269636f6e2220747970653d22696d6167652f706e67222073697a65733d2233327833322220687265663d22696d616765732f66617669636f6e2f66617669636f6e2d33327833322e706e67223e0a3c6c696e6b2072656c3d2269636f6e2220747970653d22696d6167652f706e67222073697a65733d2231367831362220687265663d22696d616765732f66617669636f6e2f66617669636f6e2d31367831362e706e67223e0a3c6c696e6b2072656c3d226d616e69666573742220687265663d22696d616765732f66617669636f6e2f736974652e7765626d616e6966657374223e0a3c6c696e6b2072656c3d226d61736b2d69636f6e2220687265663d22696d616765732f66617669636f6e2f7361666172692d70696e6e65642d7461622e7376672220636f6c6f723d2223356262616435223e0a3c6c696e6b2072656c3d2273686f72746375742069636f6e2220687265663d22696d616765732f66617669636f6e2f66617669636f6e2e69636f223e0a3c6d657461206e616d653d226d736170706c69636174696f6e2d54696c65436f6c6f722220636f6e74656e743d2223646135333263223e0a3c6d657461206e616d653d226d736170706c69636174696f6e2d636f6e6669672220636f6e74656e743d22696d616765732f66617669636f6e2f62726f77736572636f6e6669672e786d6c223e0a3c6d657461206e616d653d227468656d652d636f6c6f722220636f6e74656e743d2223666666666666223e0a223b733a31323a2268746d6c686561645f657874223b733a303a22223b733a383a226a736f6e6c6f6164223b733a303a22223b733a31303a2268656164657274657874223b613a313a7b693a303b733a31373a22746f706f2d696e7465726e612e68746d6c223b7d733a383a226d61696e74657874223b613a313a7b693a303b733a31323a22636f6e7461746f2e68746d6c223b7d733a31303a22666f6f74657274657874223b613a323a7b693a303b733a31313a22726f646170652e68746d6c223b693a313b733a31373a22736372697074732d736974652e68746d6c223b7d733a383a226c65667474657874223b733a303a22223b733a393a22726967687474657874223b733a303a22223b733a393a226572726f7274657874223b733a34323a223c68313e343034206572726f7220706167653c2f68313e0d0a3c703e4e6f20636f6e74656e743c2f703e223b733a31303a2266656c6f67696e75726c223b733a303a22223b733a353a226a736c6962223b733a31313a226a71756572792d312e3131223b733a393a226a736c69626c6f6164223b693a313b733a31303a2266726f6e74656e646a73223b693a303b733a393a22676f6f676c65617069223b693a303b733a323a226964223b693a333b733a393a226f7665727772697465223b733a303a22223b7d, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_user`
--

CREATE TABLE `phpwcms_user` (
  `usr_id` int(11) NOT NULL,
  `usr_login` varchar(30) COLLATE latin1_bin DEFAULT '',
  `usr_pass` varchar(255) COLLATE latin1_bin DEFAULT '',
  `usr_email` varchar(150) COLLATE latin1_bin DEFAULT '',
  `usr_tstamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usr_rechte` tinyint(4) DEFAULT '0',
  `usr_admin` tinyint(1) DEFAULT '0',
  `usr_avatar` varchar(50) COLLATE latin1_bin DEFAULT '',
  `usr_aktiv` int(1) DEFAULT '0',
  `usr_name` varchar(100) COLLATE latin1_bin DEFAULT '',
  `usr_var_structure` blob,
  `usr_var_publicfile` blob,
  `usr_var_privatefile` blob,
  `usr_lang` varchar(50) COLLATE latin1_bin DEFAULT '',
  `usr_wysiwyg` int(2) DEFAULT '0',
  `usr_fe` int(1) DEFAULT '0',
  `usr_vars` mediumtext COLLATE latin1_bin
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Extraindo dados da tabela `phpwcms_user`
--

INSERT INTO `phpwcms_user` (`usr_id`, `usr_login`, `usr_pass`, `usr_email`, `usr_tstamp`, `usr_rechte`, `usr_admin`, `usr_avatar`, `usr_aktiv`, `usr_name`, `usr_var_structure`, `usr_var_publicfile`, `usr_var_privatefile`, `usr_lang`, `usr_wysiwyg`, `usr_fe`, `usr_vars`) VALUES
(1, 'admin', 'bfb8f95dab100bfbae312e91671d133a', 'noreply@bluebirdagencia1.websiteseguro.com', '2022-03-27 00:31:51', 0, 1, '', 1, 'Webmaster', 0x613a31353a7b693a303b733a313a2231223b733a373a2261727469636c65223b613a303a7b7d693a353b733a313a2231223b693a343b733a313a2231223b693a373b733a313a2231223b693a383b733a313a2231223b693a393b733a313a2231223b693a31303b733a313a2231223b693a31313b733a313a2231223b693a31323b733a313a2231223b693a31373b733a313a2231223b693a31393b733a313a2231223b693a333b733a313a2231223b693a323b733a313a2231223b693a363b733a313a2231223b7d, '', 0x613a313a7b693a313b693a313b7d, 'pt', 2, 2, 'a:3:{s:8:\"template\";s:0:\"\";s:11:\"selected_cp\";a:0:{}s:10:\"allowed_cp\";a:0:{}}');

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_userdetail`
--

CREATE TABLE `phpwcms_userdetail` (
  `detail_id` int(11) NOT NULL,
  `detail_regkey` varchar(255) COLLATE latin1_bin DEFAULT NULL,
  `detail_pid` int(11) DEFAULT '0',
  `detail_formid` int(11) DEFAULT '0',
  `detail_tstamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `detail_title` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_salutation` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_firstname` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_lastname` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_company` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_street` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_add` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_city` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_zip` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_region` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_country` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_fon` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_fax` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_mobile` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_signature` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_prof` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_notes` blob,
  `detail_public` int(1) DEFAULT '1',
  `detail_aktiv` int(1) DEFAULT '1',
  `detail_newsletter` int(11) DEFAULT '0',
  `detail_website` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_userimage` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_gender` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_birthday` date DEFAULT '0000-00-00',
  `detail_varchar1` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_varchar2` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_varchar3` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_varchar4` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_varchar5` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_text1` text COLLATE latin1_bin,
  `detail_text2` text COLLATE latin1_bin,
  `detail_text3` text COLLATE latin1_bin,
  `detail_text4` text COLLATE latin1_bin,
  `detail_text5` text COLLATE latin1_bin,
  `detail_email` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_login` varchar(255) COLLATE latin1_bin DEFAULT '',
  `detail_password` varchar(255) COLLATE latin1_bin DEFAULT '',
  `userdetail_lastlogin` datetime DEFAULT '0000-00-00 00:00:00',
  `detail_int1` bigint(20) DEFAULT '0',
  `detail_int2` bigint(20) DEFAULT '0',
  `detail_int3` bigint(20) DEFAULT '0',
  `detail_int4` bigint(20) DEFAULT '0',
  `detail_int5` bigint(20) DEFAULT '0',
  `detail_float1` double DEFAULT '0',
  `detail_float2` double DEFAULT '0',
  `detail_float3` double DEFAULT '0',
  `detail_float4` double DEFAULT '0',
  `detail_float5` double DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_usergroup`
--

CREATE TABLE `phpwcms_usergroup` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(200) COLLATE latin1_bin DEFAULT '',
  `group_member` mediumtext COLLATE latin1_bin,
  `group_value` longblob,
  `group_timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `group_trash` int(1) DEFAULT '0',
  `group_active` int(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phpwcms_userlog`
--

CREATE TABLE `phpwcms_userlog` (
  `userlog_id` int(11) NOT NULL,
  `logged_user` varchar(30) COLLATE latin1_bin NOT NULL DEFAULT '',
  `logged_username` varchar(100) COLLATE latin1_bin NOT NULL DEFAULT '',
  `logged_start` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `logged_change` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `logged_in` int(1) NOT NULL DEFAULT '0',
  `logged_ip` varchar(24) COLLATE latin1_bin NOT NULL DEFAULT '',
  `logged_section` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Extraindo dados da tabela `phpwcms_userlog`
--

INSERT INTO `phpwcms_userlog` (`userlog_id`, `logged_user`, `logged_username`, `logged_start`, `logged_change`, `logged_in`, `logged_ip`, `logged_section`) VALUES
(1, 'admin', 'Administrador', 1538068178, 1648341474, 0, '179.110.41.56', 0),
(2, 'admin', 'Webmaster', 1648341657, 1653344106, 1, '179.110.231.73', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `phpwcms_address`
--
ALTER TABLE `phpwcms_address`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `phpwcms_ads_campaign`
--
ALTER TABLE `phpwcms_ads_campaign`
  ADD PRIMARY KEY (`adcampaign_id`),
  ADD KEY `adcampaign_status` (`adcampaign_status`,`adcampaign_datestart`,`adcampaign_dateend`,`adcampaign_type`,`adcampaign_place`),
  ADD KEY `adcampaign_maxview` (`adcampaign_maxview`,`adcampaign_maxclick`,`adcampaign_maxviewuser`),
  ADD KEY `adcampaign_curview` (`adcampaign_curview`,`adcampaign_curclick`,`adcampaign_curviewuser`);

--
-- Indexes for table `phpwcms_ads_formats`
--
ALTER TABLE `phpwcms_ads_formats`
  ADD PRIMARY KEY (`adformat_id`),
  ADD KEY `adformat_status` (`adformat_status`);

--
-- Indexes for table `phpwcms_ads_place`
--
ALTER TABLE `phpwcms_ads_place`
  ADD PRIMARY KEY (`adplace_id`),
  ADD KEY `adplace_status` (`adplace_status`);

--
-- Indexes for table `phpwcms_ads_tracking`
--
ALTER TABLE `phpwcms_ads_tracking`
  ADD PRIMARY KEY (`adtracking_id`),
  ADD KEY `adtracking_campaignid` (`adtracking_campaignid`,`adtracking_ip`,`adtracking_countclick`,`adtracking_countview`),
  ADD KEY `adtracking_cookieid` (`adtracking_cookieid`);

--
-- Indexes for table `phpwcms_article`
--
ALTER TABLE `phpwcms_article`
  ADD PRIMARY KEY (`article_id`),
  ADD KEY `article_aktiv` (`article_aktiv`),
  ADD KEY `article_public` (`article_public`),
  ADD KEY `article_deleted` (`article_deleted`),
  ADD KEY `article_nosearch` (`article_nosearch`),
  ADD KEY `article_begin` (`article_begin`),
  ADD KEY `article_end` (`article_end`),
  ADD KEY `article_cid` (`article_cid`),
  ADD KEY `article_tstamp` (`article_tstamp`),
  ADD KEY `article_priorize` (`article_priorize`),
  ADD KEY `article_sort` (`article_sort`),
  ADD KEY `article_alias` (`article_alias`),
  ADD KEY `article_archive_status` (`article_archive_status`),
  ADD KEY `article_lang` (`article_lang`),
  ADD KEY `article_lang_type` (`article_lang_type`),
  ADD KEY `article_lang_id` (`article_lang_id`),
  ADD KEY `article_noteaser` (`article_noteaser`),
  ADD KEY `article_opengraph` (`article_opengraph`);

--
-- Indexes for table `phpwcms_articlecat`
--
ALTER TABLE `phpwcms_articlecat`
  ADD PRIMARY KEY (`acat_id`),
  ADD KEY `acat_struct` (`acat_struct`),
  ADD KEY `acat_sort` (`acat_sort`),
  ADD KEY `acat_alias` (`acat_alias`),
  ADD KEY `acat_archive` (`acat_archive`),
  ADD KEY `acat_lang` (`acat_lang`),
  ADD KEY `acat_lang_type` (`acat_lang_type`),
  ADD KEY `acat_lang_id` (`acat_lang_id`),
  ADD KEY `acat_opengraph` (`acat_opengraph`);

--
-- Indexes for table `phpwcms_articlecontent`
--
ALTER TABLE `phpwcms_articlecontent`
  ADD PRIMARY KEY (`acontent_id`),
  ADD KEY `acontent_aid` (`acontent_aid`),
  ADD KEY `acontent_sorting` (`acontent_sorting`),
  ADD KEY `acontent_type` (`acontent_type`),
  ADD KEY `acontent_livedate` (`acontent_livedate`,`acontent_killdate`),
  ADD KEY `acontent_paginate` (`acontent_paginate_page`),
  ADD KEY `acontent_granted` (`acontent_granted`),
  ADD KEY `acontent_lang` (`acontent_lang`);

--
-- Indexes for table `phpwcms_cache`
--
ALTER TABLE `phpwcms_cache`
  ADD PRIMARY KEY (`cache_id`),
  ADD KEY `cache_hash` (`cache_hash`);
ALTER TABLE `phpwcms_cache` ADD FULLTEXT KEY `cache_stripped` (`cache_stripped`);

--
-- Indexes for table `phpwcms_calendar`
--
ALTER TABLE `phpwcms_calendar`
  ADD PRIMARY KEY (`calendar_id`),
  ADD KEY `calendar_status` (`calendar_status`),
  ADD KEY `calendar_start` (`calendar_start`),
  ADD KEY `calendar_end` (`calendar_end`),
  ADD KEY `calendar_tag` (`calendar_tag`),
  ADD KEY `calendar_refid` (`calendar_refid`),
  ADD KEY `calendar_range` (`calendar_range`),
  ADD KEY `calendar_lang` (`calendar_lang`);

--
-- Indexes for table `phpwcms_categories`
--
ALTER TABLE `phpwcms_categories`
  ADD PRIMARY KEY (`cat_id`),
  ADD KEY `cat_type` (`cat_type`,`cat_status`),
  ADD KEY `cat_pid` (`cat_pid`),
  ADD KEY `cat_sort` (`cat_sort`),
  ADD KEY `cat_opengraph` (`cat_opengraph`);

--
-- Indexes for table `phpwcms_chat`
--
ALTER TABLE `phpwcms_chat`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `phpwcms_content`
--
ALTER TABLE `phpwcms_content`
  ADD PRIMARY KEY (`cnt_id`),
  ADD KEY `cnt_livedate` (`cnt_livedate`),
  ADD KEY `cnt_killdate` (`cnt_killdate`),
  ADD KEY `cnt_module` (`cnt_module`),
  ADD KEY `cnt_type` (`cnt_type`),
  ADD KEY `cnt_group` (`cnt_group`),
  ADD KEY `cnt_owner` (`cnt_owner`),
  ADD KEY `cnt_alias` (`cnt_alias`),
  ADD KEY `cnt_pid` (`cnt_pid`),
  ADD KEY `cnt_sort` (`cnt_sort`),
  ADD KEY `cnt_prio` (`cnt_prio`),
  ADD KEY `cnt_opengraph` (`cnt_opengraph`);

--
-- Indexes for table `phpwcms_country`
--
ALTER TABLE `phpwcms_country`
  ADD PRIMARY KEY (`country_id`),
  ADD UNIQUE KEY `country_iso` (`country_iso`),
  ADD UNIQUE KEY `country_name` (`country_name`);

--
-- Indexes for table `phpwcms_crossreference`
--
ALTER TABLE `phpwcms_crossreference`
  ADD PRIMARY KEY (`cref_id`),
  ADD KEY `cref_type` (`cref_type`),
  ADD KEY `cref_rid` (`cref_rid`),
  ADD KEY `cref_int` (`cref_int`),
  ADD KEY `cref_str` (`cref_str`),
  ADD KEY `cref_module` (`cref_module`);

--
-- Indexes for table `phpwcms_dados`
--
ALTER TABLE `phpwcms_dados`
  ADD PRIMARY KEY (`dados_empresa`);

--
-- Indexes for table `phpwcms_file`
--
ALTER TABLE `phpwcms_file`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `f_granted` (`f_granted`),
  ADD KEY `f_sort` (`f_sort`);
ALTER TABLE `phpwcms_file` ADD FULLTEXT KEY `f_name` (`f_name`);
ALTER TABLE `phpwcms_file` ADD FULLTEXT KEY `f_shortinfo` (`f_shortinfo`);

--
-- Indexes for table `phpwcms_filecat`
--
ALTER TABLE `phpwcms_filecat`
  ADD PRIMARY KEY (`fcat_id`);

--
-- Indexes for table `phpwcms_filekey`
--
ALTER TABLE `phpwcms_filekey`
  ADD PRIMARY KEY (`fkey_id`);

--
-- Indexes for table `phpwcms_formresult`
--
ALTER TABLE `phpwcms_formresult`
  ADD PRIMARY KEY (`formresult_id`),
  ADD KEY `formresult_pid` (`formresult_pid`);

--
-- Indexes for table `phpwcms_formtracking`
--
ALTER TABLE `phpwcms_formtracking`
  ADD PRIMARY KEY (`formtracking_id`);

--
-- Indexes for table `phpwcms_glossary`
--
ALTER TABLE `phpwcms_glossary`
  ADD PRIMARY KEY (`glossary_id`),
  ADD KEY `glossary_status` (`glossary_status`),
  ADD KEY `glossary_tag` (`glossary_tag`),
  ADD KEY `glossary_keyword` (`glossary_keyword`),
  ADD KEY `glossary_highlight` (`glossary_highlight`);

--
-- Indexes for table `phpwcms_guestbook`
--
ALTER TABLE `phpwcms_guestbook`
  ADD PRIMARY KEY (`guestbook_id`);

--
-- Indexes for table `phpwcms_keyword`
--
ALTER TABLE `phpwcms_keyword`
  ADD PRIMARY KEY (`keyword_id`),
  ADD KEY `keyword_abbr` (`keyword_abbr`);

--
-- Indexes for table `phpwcms_language`
--
ALTER TABLE `phpwcms_language`
  ADD PRIMARY KEY (`lang_id`);

--
-- Indexes for table `phpwcms_log`
--
ALTER TABLE `phpwcms_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `log_referrer_id` (`log_referrer_id`),
  ADD KEY `log_type` (`log_type`);

--
-- Indexes for table `phpwcms_log_seo`
--
ALTER TABLE `phpwcms_log_seo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hash` (`hash`);

--
-- Indexes for table `phpwcms_map`
--
ALTER TABLE `phpwcms_map`
  ADD PRIMARY KEY (`map_id`);

--
-- Indexes for table `phpwcms_message`
--
ALTER TABLE `phpwcms_message`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `phpwcms_newsletter`
--
ALTER TABLE `phpwcms_newsletter`
  ADD PRIMARY KEY (`newsletter_id`);

--
-- Indexes for table `phpwcms_newsletterqueue`
--
ALTER TABLE `phpwcms_newsletterqueue`
  ADD PRIMARY KEY (`queue_id`),
  ADD KEY `nlqueue` (`queue_pid`,`queue_status`);

--
-- Indexes for table `phpwcms_pagelayout`
--
ALTER TABLE `phpwcms_pagelayout`
  ADD PRIMARY KEY (`pagelayout_id`);

--
-- Indexes for table `phpwcms_profession`
--
ALTER TABLE `phpwcms_profession`
  ADD PRIMARY KEY (`prof_id`);

--
-- Indexes for table `phpwcms_redirect`
--
ALTER TABLE `phpwcms_redirect`
  ADD PRIMARY KEY (`rid`),
  ADD KEY `id` (`id`,`aid`,`alias`),
  ADD KEY `active` (`active`),
  ADD KEY `link` (`link`);

--
-- Indexes for table `phpwcms_shop_boleto`
--
ALTER TABLE `phpwcms_shop_boleto`
  ADD PRIMARY KEY (`boleto_id`);

--
-- Indexes for table `phpwcms_shop_orders`
--
ALTER TABLE `phpwcms_shop_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `order_number` (`order_number`,`order_status`);

--
-- Indexes for table `phpwcms_shop_products`
--
ALTER TABLE `phpwcms_shop_products`
  ADD PRIMARY KEY (`shopprod_id`),
  ADD KEY `shopprod_status` (`shopprod_status`),
  ADD KEY `category` (`shopprod_category`),
  ADD KEY `tag` (`shopprod_tag`),
  ADD KEY `all` (`shopprod_listall`),
  ADD KEY `shopprod_track_view` (`shopprod_track_view`),
  ADD KEY `shopprod_lang` (`shopprod_lang`),
  ADD KEY `shopprod_opengraph` (`shopprod_opengraph`);

--
-- Indexes for table `phpwcms_subscription`
--
ALTER TABLE `phpwcms_subscription`
  ADD PRIMARY KEY (`subscription_id`);

--
-- Indexes for table `phpwcms_sysvalue`
--
ALTER TABLE `phpwcms_sysvalue`
  ADD PRIMARY KEY (`sysvalue_key`),
  ADD KEY `sysvalue_group` (`sysvalue_group`),
  ADD KEY `sysvalue_status` (`sysvalue_status`);

--
-- Indexes for table `phpwcms_template`
--
ALTER TABLE `phpwcms_template`
  ADD PRIMARY KEY (`template_id`);

--
-- Indexes for table `phpwcms_user`
--
ALTER TABLE `phpwcms_user`
  ADD PRIMARY KEY (`usr_id`);

--
-- Indexes for table `phpwcms_userdetail`
--
ALTER TABLE `phpwcms_userdetail`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `detail_pid` (`detail_pid`),
  ADD KEY `detail_formid` (`detail_formid`),
  ADD KEY `detail_password` (`detail_password`),
  ADD KEY `detail_aktiv` (`detail_aktiv`),
  ADD KEY `detail_regkey` (`detail_regkey`);

--
-- Indexes for table `phpwcms_usergroup`
--
ALTER TABLE `phpwcms_usergroup`
  ADD PRIMARY KEY (`group_id`),
  ADD KEY `group_member` (`group_member`(255));

--
-- Indexes for table `phpwcms_userlog`
--
ALTER TABLE `phpwcms_userlog`
  ADD PRIMARY KEY (`userlog_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `phpwcms_address`
--
ALTER TABLE `phpwcms_address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_ads_campaign`
--
ALTER TABLE `phpwcms_ads_campaign`
  MODIFY `adcampaign_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_ads_formats`
--
ALTER TABLE `phpwcms_ads_formats`
  MODIFY `adformat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `phpwcms_ads_place`
--
ALTER TABLE `phpwcms_ads_place`
  MODIFY `adplace_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_ads_tracking`
--
ALTER TABLE `phpwcms_ads_tracking`
  MODIFY `adtracking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_article`
--
ALTER TABLE `phpwcms_article`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `phpwcms_articlecat`
--
ALTER TABLE `phpwcms_articlecat`
  MODIFY `acat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `phpwcms_articlecontent`
--
ALTER TABLE `phpwcms_articlecontent`
  MODIFY `acontent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `phpwcms_cache`
--
ALTER TABLE `phpwcms_cache`
  MODIFY `cache_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_calendar`
--
ALTER TABLE `phpwcms_calendar`
  MODIFY `calendar_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_categories`
--
ALTER TABLE `phpwcms_categories`
  MODIFY `cat_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_chat`
--
ALTER TABLE `phpwcms_chat`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_content`
--
ALTER TABLE `phpwcms_content`
  MODIFY `cnt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_country`
--
ALTER TABLE `phpwcms_country`
  MODIFY `country_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;

--
-- AUTO_INCREMENT for table `phpwcms_crossreference`
--
ALTER TABLE `phpwcms_crossreference`
  MODIFY `cref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_file`
--
ALTER TABLE `phpwcms_file`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `phpwcms_filecat`
--
ALTER TABLE `phpwcms_filecat`
  MODIFY `fcat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_filekey`
--
ALTER TABLE `phpwcms_filekey`
  MODIFY `fkey_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_formresult`
--
ALTER TABLE `phpwcms_formresult`
  MODIFY `formresult_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_formtracking`
--
ALTER TABLE `phpwcms_formtracking`
  MODIFY `formtracking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `phpwcms_glossary`
--
ALTER TABLE `phpwcms_glossary`
  MODIFY `glossary_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_guestbook`
--
ALTER TABLE `phpwcms_guestbook`
  MODIFY `guestbook_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_keyword`
--
ALTER TABLE `phpwcms_keyword`
  MODIFY `keyword_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_log`
--
ALTER TABLE `phpwcms_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_log_seo`
--
ALTER TABLE `phpwcms_log_seo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_map`
--
ALTER TABLE `phpwcms_map`
  MODIFY `map_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_message`
--
ALTER TABLE `phpwcms_message`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_newsletter`
--
ALTER TABLE `phpwcms_newsletter`
  MODIFY `newsletter_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_newsletterqueue`
--
ALTER TABLE `phpwcms_newsletterqueue`
  MODIFY `queue_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_pagelayout`
--
ALTER TABLE `phpwcms_pagelayout`
  MODIFY `pagelayout_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `phpwcms_profession`
--
ALTER TABLE `phpwcms_profession`
  MODIFY `prof_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=259;

--
-- AUTO_INCREMENT for table `phpwcms_redirect`
--
ALTER TABLE `phpwcms_redirect`
  MODIFY `rid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_shop_boleto`
--
ALTER TABLE `phpwcms_shop_boleto`
  MODIFY `boleto_id` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_shop_orders`
--
ALTER TABLE `phpwcms_shop_orders`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_shop_products`
--
ALTER TABLE `phpwcms_shop_products`
  MODIFY `shopprod_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_subscription`
--
ALTER TABLE `phpwcms_subscription`
  MODIFY `subscription_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_template`
--
ALTER TABLE `phpwcms_template`
  MODIFY `template_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `phpwcms_user`
--
ALTER TABLE `phpwcms_user`
  MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `phpwcms_userdetail`
--
ALTER TABLE `phpwcms_userdetail`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_usergroup`
--
ALTER TABLE `phpwcms_usergroup`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpwcms_userlog`
--
ALTER TABLE `phpwcms_userlog`
  MODIFY `userlog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
