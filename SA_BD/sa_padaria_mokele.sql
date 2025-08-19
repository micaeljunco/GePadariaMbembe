-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 16/08/2025 às 17:25
-- Versão do servidor: 9.1.0
-- Versão do PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sa_padaria_mokele`
--

CREATE DATABASE IF NOT EXISTS sa_padaria_mokele;
USE sa_padaria_mokele;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cargos`
--

DROP TABLE IF EXISTS `cargos`;
CREATE TABLE IF NOT EXISTS `cargos` (
  `id_cargo` int NOT NULL AUTO_INCREMENT,
  `nome_cargo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_cargo`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cargos`
--

INSERT INTO `cargos` (`id_cargo`, `nome_cargo`) VALUES
(1, 'Administrador');

-- --------------------------------------------------------

--
-- Estrutura para tabela `comandas`
--

DROP TABLE IF EXISTS `comandas`;
CREATE TABLE IF NOT EXISTS `comandas` (
  `id_comanda` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int DEFAULT NULL,
  `valor_total` decimal(7,2) DEFAULT NULL,
  PRIMARY KEY (`id_comanda`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `comanda_produto`
--

DROP TABLE IF EXISTS `comanda_produto`;
CREATE TABLE IF NOT EXISTS `comanda_produto` (
  `id_comanda` int NOT NULL,
  `id_produto` int NOT NULL,
  `quantidade` int NOT NULL,
  KEY `id_comanda` (`id_comanda`),
  KEY `id_produto` (`id_produto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedores`
--

DROP TABLE IF EXISTS `fornecedores`;
CREATE TABLE IF NOT EXISTS `fornecedores` (
  `id_fornecedor` int NOT NULL AUTO_INCREMENT,
  `nome_fornecedor` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `cnpj` varchar(18) COLLATE utf8mb4_general_ci,
  `descricao` text COLLATE utf8mb4_general_ci,
  `id_telefone` int DEFAULT NULL,
  PRIMARY KEY (`id_fornecedor`),
  KEY `id_telefone` (`id_telefone`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id_produto` int NOT NULL AUTO_INCREMENT,
  `nome_produto` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `quant_min` int NOT NULL,
  `quant` int NOT NULL,
  `validade` date NOT NULL,
  `id_fornecedor` int NOT NULL,
  `preco` decimal(6,2) NOT NULL,
  PRIMARY KEY (`id_produto`),
  KEY `id_fornecedor` (`id_fornecedor`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `telefone`
--

DROP TABLE IF EXISTS `telefone`;
CREATE TABLE IF NOT EXISTS `telefone` (
  `id_telefone` int NOT NULL AUTO_INCREMENT,
  `ddd` varchar(2) COLLATE utf8mb4_general_ci NOT NULL,
  `numero` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_telefone`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nome_usuario` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `id_cargo` int NOT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `id_cargo` (`id_cargo`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome_usuario`, `email`, `senha`, `id_cargo`) VALUES
(1, 'Yan Carlos de Oliveira', 'Yan@gmail.com', '$2y$10$hjSq05Cvs7s26gJNyfBDweuAa7fjDhyziCiLRhe80ni3Dqh8W6Ydy', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas`
--

DROP TABLE IF EXISTS `vendas`;
CREATE TABLE IF NOT EXISTS `vendas` (
  `id_venda` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_comanda` int DEFAULT NULL,
  `valor_total` decimal(7,2) NOT NULL,
  `data_venda` date NOT NULL,
  `metodo_pagamento` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_venda`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_comanda` (`id_comanda`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas_produtos`
--

DROP TABLE IF EXISTS `vendas_produtos`;
CREATE TABLE IF NOT EXISTS `vendas_produtos` (
  `id_venda` int NOT NULL,
  `id_produto` int NOT NULL,
  `quantidade` int NOT NULL,
  KEY `id_venda` (`id_venda`),
  KEY `id_produto` (`id_produto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
