-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 179.188.16.25
-- Tempo de Geração: 11/11/2015 às 16:32:56
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
(12, 'Santuário São José'),
(11, 'Paróquia São Francisco Xavier'),
(10, 'Paróquia São Benedito'),
(9, 'Paróquia Nossa Senhora do Perpétuo Socorro'),
(8, 'Paróquia Nossa Senhora de Fátima'),
(7, 'Paróquia Nossa Senhora Aparecida'),
(6, 'Paróquia Cristo Sacerdote'),
(5, 'Paróquia Cristo Rei'),
(4, 'Paróquia Cristo Profeta'),
(3, 'Paróquia Coração Eucarístico de Jesus'),
(2, 'Paróquia Imaculado Coração de Maria'),
(1, 'Catedral Nossa Senhora de Lourdes');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=89 ;

--
-- Extraindo dados da tabela `tb_seg_usuario`
--

INSERT INTO `tb_seg_usuario` (`id`, `cd_paroquia`, `login`, `senha`, `nome`) VALUES
(10, 10, 'saobenedito_apucarana', '670b5644a548cf40cd07963ac4c37e4e', 'Paróquia São Benedito'),
(9, 9, 'perpetuoapucarana', '996009f2374006606f4c0b0fda878af1', 'Paróquia Nossa Senhora do Perpétuo Socorro'),
(8, 8, 'nossasenhoradefatima', '53f95fc35cd5c904da333d9231d67026', 'Paróquia Nossa Senhora de Fátima'),
(7, 7, 'nsaparecidaapucarana', '1f3db82eb3cb07faf60e1b1fc03768df', 'Paróquia Nossa Senhora Aparecida'),
(6, 6, 'cristosacerdoteapucarana', '60c97bef031ec312b512c08565c1868e', 'Paróquia Cristo Sacerdote'),
(5, 5, 'paroquiacristorei', 'e5b888ba51c1e2319b104a583a2906a2', 'Paróquia Cristo Rei'),
(4, 4, 'cristoprofeta_apucarana', '2fa321697b50684a2f98ef21d0298991', 'Paróquia Cristo Profeta'),
(3, 3, 'coracaoeucaristicodejesus', '65f2a94c8c2d56d5b43a1a3d9d811102', 'Paróquia Coração Eucarístico de Jesus'),
(2, 2, 'coracaodemaria_apucarana', 'f5aa4bd09c07d8b2f65bad6c7cd3358f', 'Paróquia Imaculado Coração de Maria'),
(1, 1, 'catnsl_apucarana', '6f2688a5fce7d48c8d19762b88c32c3b', 'Catedral Nossa Senhora de Lourdes'),
(11, 11, 'parsfxavier_apucarana', '0a7c93e6c36f4d639a05adb387947066', 'Paróquia São Francisco Xavier'),
(12, 12, 'santuário', '01588f3853f3a4683c9e134bd6f83fee', 'Santuário São José'),
(88, 1, 'ivan', '0cc175b9c0f1b6a831c399e269772661', 'Ivan Nicoli');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Extraindo dados da tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`id`, `cd_paroquia`, `nome`, `rg`, `cpf`, `telefone`, `data_nasc`, `endereco`, `cert_nasc`, `nome_mae`, `nome_pai`, `data_cadastro`) VALUES
(11, 4, 'Angelina Nascimento De Moraes', NULL, NULL, '(43) 3423-0144', '1925-07-19 00:00:00', 'Rua Domingos Alexandre, 30', NULL, 'Angelina Nascimento', 'Joao Nascimento', '2015-11-04 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
