-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/08/2025 às 21:43
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

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

CREATE DATABASE IF NOT EXISTS `sa_padaria_mokele_revisao`;
USE `sa_padaria_mokele_revisao`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cargos`
--

CREATE TABLE `cargos` (
  `id_cargo` int(11) NOT NULL AUTO_INCREMENT,
  `nome_cargo` varchar(50) NOT NULL,
  PRIMARY KEY (`id_cargo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `cargos` (`id_cargo`, `nome_cargo`) VALUES
(1, 'Administrador');

-- --------------------------------------------------------

CREATE TABLE `telefone` (
  `id_telefone` int(11) NOT NULL AUTO_INCREMENT,
  `ddd` varchar(2) NOT NULL,
  `numero` varchar(20) NOT NULL,
  PRIMARY KEY (`id_telefone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE `fornecedores` (
  `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT,
  `nome_fornecedor` varchar(255) NOT NULL,
  `cnpj` varchar(18) NOT NULL,
  `descricao` text DEFAULT NULL,
  `id_telefone` int(11) NOT NULL,
  PRIMARY KEY (`id_fornecedor`),
  KEY `id_telefone` (`id_telefone`),
  FOREIGN KEY (`id_telefone`) REFERENCES `telefone` (`id_telefone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE `itens` (
  `id_item` int(11) NOT NULL AUTO_INCREMENT,
  `nome_item` varchar(255) NOT NULL,
  `quant_min` int(11) NOT NULL,
  `quant` int(11) NOT NULL,
  `categoria` enum('produto','insumo') NOT NULL,
  `validade` date NOT NULL,
  `id_fornecedor` int(11) DEFAULT NULL,
  `val_unitario` decimal(6,2) NOT NULL,
  `unidade_medida` varchar(50) NOT NULL,
  PRIMARY KEY (`id_item`),
  KEY `id_fornecedor` (`id_fornecedor`),
  FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `itens` VALUES
(1, 'Ayaya', 1, 1, 'insumo', '2071-11-28', NULL, 9999.99, 'Kg');

-- --------------------------------------------------------

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome_usuario` varchar(255) NOT NULL,
  `CPF` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `id_cargo` int(11) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `cpf_unico` (`CPF`),
  UNIQUE KEY `email_unico` (`email`),
  KEY `id_cargo` (`id_cargo`),
  FOREIGN KEY (`id_cargo`) REFERENCES `cargos` (`id_cargo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuarios` VALUES
(4, 'yan', '12345678908', 'yan@gmail.com', '$2y$10$j3oq2J5dqD.KmZj3KQbBcOYsvg.HjcsRrFfmQaCLY2yAXTVlVrcTq', 1);

-- --------------------------------------------------------

CREATE TABLE `comandas` (
    id_comanda INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NULL,
    valor_total DECIMAL(7,2) DEFAULT 0,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
        ON DELETE SET NULL
) ENGINE=InnoDB;

-- --------------------------------------------------------

CREATE TABLE `comanda_itens` (
    id_comanda INT NOT NULL,
    id_item INT NOT NULL,
    quantidade INT NOT NULL,
    PRIMARY KEY (id_comanda, id_item),
    FOREIGN KEY (id_comanda) REFERENCES comandas(id_comanda)
        ON DELETE CASCADE,
    FOREIGN KEY (id_item) REFERENCES itens(id_item)
        ON DELETE RESTRICT
) ENGINE=InnoDB;

-- --------------------------------------------------------

CREATE TABLE `vendas` (
    id_venda INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_comanda INT NULL,
    valor_total DECIMAL(7,2) NOT NULL,
    data_hora DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
        ON DELETE RESTRICT,
    FOREIGN KEY (id_comanda) REFERENCES comandas(id_comanda)
        ON DELETE SET NULL
) ENGINE=InnoDB;

-- --------------------------------------------------------

CREATE TABLE `vendas_itens` (
    id_venda_item INT AUTO_INCREMENT PRIMARY KEY,
    id_venda INT NOT NULL,
    id_item INT NOT NULL,
    quantidade INT NOT NULL,
    valor_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_venda) REFERENCES vendas(id_venda)
        ON DELETE CASCADE,
    FOREIGN KEY (id_item) REFERENCES itens(id_item)
        ON DELETE RESTRICT
) ENGINE=InnoDB;

-- --------------------------------------------------------

CREATE TABLE `metodos_pag` (
    id_metodo INT AUTO_INCREMENT PRIMARY KEY,
    id_venda INT NOT NULL,
    metodo VARCHAR(50) NOT NULL,
    valor_pago DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_venda) REFERENCES vendas(id_venda)
        ON DELETE CASCADE
) ENGINE=InnoDB;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
