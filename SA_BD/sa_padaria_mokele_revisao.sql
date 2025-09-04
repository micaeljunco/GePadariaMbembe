-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03/09/2025 às 18:47
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
-- Banco de dados: `sa_padaria_mokele_revisao`
--

CREATE DATABASE `sa_padaria_mokele`;
USE `sa_padaria_mokele`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cargos`
--

CREATE TABLE `cargos` (
  `id_cargo` int(11) NOT NULL,
  `nome_cargo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `valor_total` decimal(7,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `comanda_itens`
--

CREATE TABLE `comanda_itens` (
  `id_comanda` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `itens`
--

INSERT INTO `itens` (`id_item`, `nome_item`, `quant_min`, `quant`, `categoria`, `validade`, `id_fornecedor`, `val_unitario`, `unidade_medida`) VALUES
(1, 'Ayaya', 1, 1, 'insumo', '2071-11-28', NULL, 9999.99, 'Kg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `metodos_pag`
--

CREATE TABLE `metodos_pag` (
  `id_metodo` int(11) NOT NULL,
  `id_venda` int(11) NOT NULL,
  `metodo` varchar(50) NOT NULL,
  `valor_pago` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `telefone`
--

CREATE TABLE `telefone` (
  `id_telefone` int(11) NOT NULL,
  `ddd` varchar(2) NOT NULL,
  `numero` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome_usuario`, `CPF`, `email`, `senha`, `id_cargo`) VALUES
(5, 'Admin', '12345678901', 'admin@gmail.com', '$2y$10$4tMwZPXOVJqiq40jk.FoUOaClcrqPTC/iPBSf8hw7V3oTGhtVOeDW', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas`
--

CREATE TABLE `vendas` (
  `id_venda` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_comanda` int(11) DEFAULT NULL,
  `valor_total` decimal(7,2) NOT NULL,
  `data_hora` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas_itens`
--

CREATE TABLE `vendas_itens` (
  `id_venda_item` int(11) NOT NULL,
  `id_venda` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD PRIMARY KEY (`id_comanda`,`id_item`),
  ADD KEY `id_item` (`id_item`);

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
-- Índices de tabela `metodos_pag`
--
ALTER TABLE `metodos_pag`
  ADD PRIMARY KEY (`id_metodo`),
  ADD KEY `id_venda` (`id_venda`);

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
  ADD UNIQUE KEY `cpf_unico` (`CPF`),
  ADD UNIQUE KEY `email_unico` (`email`),
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
  ADD PRIMARY KEY (`id_venda_item`),
  ADD KEY `id_venda` (`id_venda`),
  ADD KEY `id_item` (`id_item`);

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
-- AUTO_INCREMENT de tabela `metodos_pag`
--
ALTER TABLE `metodos_pag`
  MODIFY `id_metodo` int(11) NOT NULL AUTO_INCREMENT;

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

--
-- AUTO_INCREMENT de tabela `vendas_itens`
--
ALTER TABLE `vendas_itens`
  MODIFY `id_venda_item` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `comandas`
--
ALTER TABLE `comandas`
  ADD CONSTRAINT `comandas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL;

--
-- Restrições para tabelas `comanda_itens`
--
ALTER TABLE `comanda_itens`
  ADD CONSTRAINT `comanda_itens_ibfk_1` FOREIGN KEY (`id_comanda`) REFERENCES `comandas` (`id_comanda`) ON DELETE CASCADE,
  ADD CONSTRAINT `comanda_itens_ibfk_2` FOREIGN KEY (`id_item`) REFERENCES `itens` (`id_item`);

--
-- Restrições para tabelas `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD CONSTRAINT `fornecedores_ibfk_1` FOREIGN KEY (`id_telefone`) REFERENCES `telefone` (`id_telefone`);

--
-- Restrições para tabelas `itens`
--
ALTER TABLE `itens`
  ADD CONSTRAINT `itens_ibfk_1` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`);

--
-- Restrições para tabelas `metodos_pag`
--
ALTER TABLE `metodos_pag`
  ADD CONSTRAINT `metodos_pag_ibfk_1` FOREIGN KEY (`id_venda`) REFERENCES `vendas` (`id_venda`) ON DELETE CASCADE;

--
-- Restrições para tabelas `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_cargo`) REFERENCES `cargos` (`id_cargo`);

--
-- Restrições para tabelas `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `vendas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `vendas_ibfk_2` FOREIGN KEY (`id_comanda`) REFERENCES `comandas` (`id_comanda`) ON DELETE SET NULL;

--
-- Restrições para tabelas `vendas_itens`
--
ALTER TABLE `vendas_itens`
  ADD CONSTRAINT `vendas_itens_ibfk_1` FOREIGN KEY (`id_venda`) REFERENCES `vendas` (`id_venda`) ON DELETE CASCADE,
  ADD CONSTRAINT `vendas_itens_ibfk_2` FOREIGN KEY (`id_item`) REFERENCES `itens` (`id_item`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
