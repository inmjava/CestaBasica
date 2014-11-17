-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tempo de Geração: 
-- Versão do Servidor: 5.5.27
-- Versão do PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `catedral_apucarana`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `tb_seg_usuario`
--

INSERT INTO `tb_seg_usuario` (`id`, `cd_paroquia`, `login`, `senha`, `nome`) VALUES
(1, 1, 'ivan', '0cc175b9c0f1b6a831c399e269772661', 'Ivan Nicoli');

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
