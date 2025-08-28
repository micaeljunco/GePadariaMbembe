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

-- --------------------------------------------------------

--
-- Estrutura para tabela `cargos`
--

CREATE TABLE `cargos` (
  `id_cargo` int(11) NOT NULL,
  `nome_cargo` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cargos`
--

INSERT INTO `cargos` (`id_cargo`, `nome_cargo`) VALUES
(1, 'Administrador');

-- --------------------------------------------------------

--
-- Estrutura para tabela `comandas`
--

CREATE TABLE `comandas` (
  `id_comanda` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `valor_total` decimal(7,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `comanda_itens`
--

CREATE TABLE `comanda_itens` (
  `id_comanda` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `comanda_produto`
--

CREATE TABLE `comanda_produto` (
  `id_comanda` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedores`
--

CREATE TABLE `fornecedores` (
  `id_fornecedor` int(11) NOT NULL,
  `nome_fornecedor` varchar(255) NOT NULL,
  `cnpj` varchar(18) NOT NULL,
  `descricao` text DEFAULT NULL,
  `id_telefone` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens`
--

CREATE TABLE `itens` (
  `id_item` int(11) NOT NULL,
  `nome_item` varchar(255) NOT NULL,
  `quant_min` int(11) NOT NULL,
  `quant` int(11) NOT NULL,
  `categoria` enum('produto','insumo') NOT NULL,
  `validade` date NOT NULL,
  `id_fornecedor` int(11) DEFAULT NULL,
  `val_unitario` decimal(6,2) NOT NULL,
  `unidade_medida` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `itens`
--

INSERT INTO `itens` (`id_item`, `nome_item`, `quant_min`, `quant`, `categoria`, `validade`, `id_fornecedor`, `val_unitario`, `unidade_medida`) VALUES
(1, 'Ayaya', 1, 1, 'insumo', '2071-11-28', 0, 9999.99, 'Kg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id_produto` int(11) NOT NULL,
  `nome_produto` varchar(255) NOT NULL,
  `quant_min` int(11) NOT NULL,
  `quant` int(11) NOT NULL,
  `validade` date NOT NULL,
  `id_fornecedor` int(11) NOT NULL,
  `preco` decimal(6,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `telefone`
--

CREATE TABLE `telefone` (
  `id_telefone` int(11) NOT NULL,
  `ddd` varchar(2) NOT NULL,
  `numero` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome_usuario` varchar(255) NOT NULL,
  `CPF` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `id_cargo` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome_usuario`, `CPF`, `email`, `senha`, `id_cargo`) VALUES
(4, 'yan', '12345678908', 'yan@gmail.com', '$2y$10$j3oq2J5dqD.KmZj3KQbBcOYsvg.HjcsRrFfmQaCLY2yAXTVlVrcTq', 1);

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `usuarios_inativos`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `usuarios_inativos` (
`id_usuario` int(11)
,`nome_usuario` varchar(255)
,`CPF` varchar(20)
,`email` varchar(100)
,`id_cargo` int(11)
);

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas`
--

CREATE TABLE `vendas` (
  `id_venda` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_comanda` int(11) DEFAULT NULL,
  `valor_total` decimal(7,2) NOT NULL,
  `data_venda` date NOT NULL,
  `metodo_pagamento` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas_itens`
--

CREATE TABLE `vendas_itens` (
  `id_venda` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas_produtos`
--

CREATE TABLE `vendas_produtos` (
  `id_venda` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para view `usuarios_inativos`
--
DROP TABLE IF EXISTS `usuarios_inativos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `usuarios_inativos`  AS SELECT `usuarios`.`id_usuario` AS `id_usuario`, `usuarios`.`nome_usuario` AS `nome_usuario`, `usuarios`.`CPF` AS `CPF`, `usuarios`.`email` AS `email`, `usuarios`.`id_cargo` AS `id_cargo` FROM `usuarios` ;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`id_cargo`);

--
-- Índices de tabela `comandas`
--
ALTER TABLE `comandas`
  ADD PRIMARY KEY (`id_comanda`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `comanda_itens`
--
ALTER TABLE `comanda_itens`
  ADD KEY `id_comanda` (`id_comanda`),
  ADD KEY `id_item` (`id_item`);

--
-- Índices de tabela `comanda_produto`
--
ALTER TABLE `comanda_produto`
  ADD KEY `id_comanda` (`id_comanda`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD PRIMARY KEY (`id_fornecedor`),
  ADD KEY `id_telefone` (`id_telefone`);

--
-- Índices de tabela `itens`
--
ALTER TABLE `itens`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `id_fornecedor` (`id_fornecedor`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id_produto`),
  ADD KEY `id_fornecedor` (`id_fornecedor`);

--
-- Índices de tabela `telefone`
--
ALTER TABLE `telefone`
  ADD PRIMARY KEY (`id_telefone`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `CPF` (`CPF`,`email`),
  ADD KEY `id_cargo` (`id_cargo`);

--
-- Índices de tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id_venda`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_comanda` (`id_comanda`);

--
-- Índices de tabela `vendas_itens`
--
ALTER TABLE `vendas_itens`
  ADD KEY `id_venda` (`id_venda`),
  ADD KEY `id_item` (`id_item`);

--
-- Índices de tabela `vendas_produtos`
--
ALTER TABLE `vendas_produtos`
  ADD KEY `id_venda` (`id_venda`),
  ADD KEY `id_produto` (`id_produto`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cargos`
--
ALTER TABLE `cargos`
  MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `comandas`
--
ALTER TABLE `comandas`
  MODIFY `id_comanda` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  MODIFY `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `itens`
--
ALTER TABLE `itens`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `telefone`
--
ALTER TABLE `telefone`
  MODIFY `id_telefone` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id_venda` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
