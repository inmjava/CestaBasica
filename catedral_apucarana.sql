-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2.2
-- http://www.phpmyadmin.net
--
-- Servidor: mysql01.cesta2.hospedagemdesites.ws
-- Tempo de Geração: 08/10/2015 às 16:50:49
-- Versão do Servidor: 5.6.21
-- Versão do PHP: 5.3.3-7+squeeze27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `cesta2`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_entrega`
--

CREATE TABLE IF NOT EXISTS `tb_entrega` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cd_usuario` int(10) unsigned NOT NULL,
  `cd_seg_usuario` int(10) unsigned NOT NULL,
  `data_entrega` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tb_entrega_FKIndex1` (`cd_seg_usuario`),
  KEY `tb_entrega_FKIndex2` (`cd_usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_paroquia`
--

CREATE TABLE IF NOT EXISTS `tb_paroquia` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Extraindo dados da tabela `tb_paroquia`
--

INSERT INTO `tb_paroquia` (`id`, `nome`) VALUES
(1, 'Bom Jesus'),
(2, 'Catedral Nossa Senhora de Lourdes'),
(3, 'Comunidade Imaculado Coração de Maria'),
(4, 'Coração Eucarístico de Jesus'),
(5, 'Cristo Profeta'),
(6, 'Cristo Rei'),
(7, 'Cristo Sacerdote'),
(8, 'Espírito Santo'),
(9, 'Imaculada Conceição'),
(10, 'Maria da Unidade'),
(11, 'Nossa Senhora Aparecida'),
(12, 'Nossa Senhora Auxiliadora'),
(13, 'Nossa Senhora da Gloria'),
(14, 'Nossa Senhora das Dores'),
(15, 'Nossa Senhora das Graças'),
(16, 'Nossa Senhora de Fátima'),
(17, 'Nossa Senhora de Guadalupe'),
(18, 'Nossa Senhora de Lourdes'),
(19, 'Nossa Senhora de Perpétuo Socorro'),
(20, 'Nossa Senhora do Perpétuo Socorro'),
(21, 'Nossa Senhora do Rocio'),
(22, 'Nossa Senhora do Rosário'),
(24, 'Sagrado Coração de Jesus'),
(25, 'Santa Inês'),
(26, 'Santa Luzia'),
(27, 'Santa Rita de Cássia'),
(28, 'Santa Terezinha'),
(29, 'Santíssima Mãe de Deus'),
(30, 'Santíssima Trindade'),
(31, 'Santo Antonio'),
(32, 'Santo Antônio de Pádua'),
(33, 'Santo Inácio de Loyola'),
(34, 'Santuário Nossa Senhora Aparecida (Padres Palotinos)'),
(35, 'Santuário São José'),
(36, 'São Benedito'),
(37, 'São Francisco'),
(38, 'São Francisco de Assis'),
(39, 'São Francisco Xavier'),
(40, 'São Franciso de Assis'),
(41, 'São João Batista'),
(42, 'São José'),
(43, 'São Judas Tadeu'),
(44, 'São Paulo Apóstolo'),
(45, 'São Pedro'),
(46, 'São Sebastião'),
(47, 'São Vicente Pallotti');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_seg_usuario`
--

CREATE TABLE IF NOT EXISTS `tb_seg_usuario` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cd_paroquia` int(10) unsigned NOT NULL,
  `login` varchar(40) DEFAULT NULL,
  `senha` varchar(50) DEFAULT NULL,
  `nome` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tb_seg_usuario_FKIndex1` (`cd_paroquia`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=88 ;

--
-- Extraindo dados da tabela `tb_seg_usuario`
--

INSERT INTO `tb_seg_usuario` (`id`, `cd_paroquia`, `login`, `senha`, `nome`) VALUES
(76, 1, 'catnsl_apucarana', '6f2688a5fce7d48c8d19762b88c32c3b', 'Catedral Nossa Senhora De Lourdes'),
(77, 2, 'coracaodemaria_apucarana', 'f5aa4bd09c07d8b2f65bad6c7cd3358f', 'Paróquia Imaculado Coração De Maria'),
(78, 3, 'coracaoeucaristicodejesus', '65f2a94c8c2d56d5b43a1a3d9d811102', 'Paróquia Coração Eucarístico De Jesus'),
(79, 4, 'cristoprofeta_apucarana', '2fa321697b50684a2f98ef21d0298991', 'Paróquia Cristo Profeta'),
(80, 5, 'paroquiacristorei', 'e5b888ba51c1e2319b104a583a2906a2', 'Paróquia Cristo Rei'),
(81, 6, 'cristosacerdoteapucarana', '60c97bef031ec312b512c08565c1868e', 'Paróquia Cristo Sacerdote'),
(82, 7, 'nsaparecidaapucarana', '1f3db82eb3cb07faf60e1b1fc03768df', 'Paróquia Nossa Senhora Aparecida'),
(83, 8, 'nossasenhoradefatima', '53f95fc35cd5c904da333d9231d67026', 'Paróquia Nossa Senhora De Fátima'),
(84, 9, 'perpetuoapucarana', '996009f2374006606f4c0b0fda878af1', 'Paróquia Nossa Senhora Do Perpétuo Socorro'),
(85, 10, 'saobenedito_apucarana', '670b5644a548cf40cd07963ac4c37e4e', 'Paróquia São Benedito'),
(86, 11, 'parsfxavier_apucarana', '0a7c93e6c36f4d639a05adb387947066', 'Paróquia São Francisco Xavier'),
(87, 12, 'santuario', '01588f3853f3a4683c9e134bd6f83fee', 'Santuário São José');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuario`
--

CREATE TABLE IF NOT EXISTS `tb_usuario` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cd_paroquia` int(10) unsigned NOT NULL,
  `nome` varchar(200) DEFAULT NULL,
  `rg` varchar(14) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `telefone` varchar(14) DEFAULT NULL,
  `data_nasc` datetime DEFAULT NULL,
  `endereco` varchar(200) DEFAULT NULL,
  `cert_nasc` varchar(200) DEFAULT NULL,
  `nome_mae` varchar(200) DEFAULT NULL,
  `nome_pai` varchar(200) DEFAULT NULL,
  `data_cadastro` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tb_usuario_FKIndex1` (`cd_paroquia`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
