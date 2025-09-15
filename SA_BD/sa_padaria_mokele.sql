-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15/09/2025 às 19:42
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
(1, 'Administrador'),
(2, 'Atendente'),
(3, 'Controlador de Estoque');

-- --------------------------------------------------------

--
-- Estrutura para tabela `comandas`
--

CREATE TABLE `comandas` (
  `id_comanda` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `aberta` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `comandas`
--

INSERT INTO `comandas` (`id_comanda`, `id_usuario`, `aberta`) VALUES
(1, NULL, 1),
(2, NULL, 1),
(3, NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `comanda_itens`
--

CREATE TABLE `comanda_itens` (
  `id_comanda_itens` int(11) NOT NULL,
  `id_comanda` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `quantidade` decimal(10,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `comanda_itens`
--

INSERT INTO `comanda_itens` (`id_comanda_itens`, `id_comanda`, `id_item`, `quantidade`) VALUES
(1, 1, 1, 1.000),
(2, 2, 12, 12.000),
(3, 3, 32, 18999.000);

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedores`
--

CREATE TABLE `fornecedores` (
  `id_fornecedor` int(11) NOT NULL,
  `nome_fornecedor` varchar(255) NOT NULL,
  `cnpj` varchar(18) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `fornecedores`
--

INSERT INTO `fornecedores` (`id_fornecedor`, `nome_fornecedor`, `cnpj`, `descricao`) VALUES
(1, 'Farinha Brasil Ltda', '12.345.678/0001-90', 'Fornecedor de farinha de trigo'),
(2, 'Laticínios Silva', '98.765.432/0001-12', 'Fornecimento de leite e derivados'),
(3, 'Açúcar Doce S/A', '23.456.789/0001-45', 'Açúcar refinado e cristal'),
(4, 'Fermento Express', '34.567.890/0001-67', 'Fermentos biológicos e químicos'),
(5, 'Óleo e Gorduras Ltda', '45.678.901/0001-23', 'Óleo vegetal e manteiga'),
(6, 'Chocolate & Cia', '56.789.012/0001-34', 'Chocolate para confeitaria'),
(7, 'Embalagens Plus', '67.890.123/0001-56', 'Embalagens para pães e doces'),
(8, 'Frutas Naturais', '78.901.234/0001-78', 'Frutas frescas e secas'),
(9, 'Mel do Campo 2', '76.522.265/0001-11', 'Mel e produtos apícolas'),
(10, 'Conservas e Temperos', '90.123.456/0001-90', 'Conservas, sal e temperos');

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens`
--

CREATE TABLE `itens` (
  `id_item` int(11) NOT NULL,
  `nome_item` varchar(255) NOT NULL,
  `quant_min` decimal(10,2) NOT NULL,
  `quant` decimal(10,2) NOT NULL,
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
(1, 'Farinha de trigo', 20.00, 99.00, 'insumo', '2026-05-01', 1, 4.50, 'Kg'),
(2, 'Açúcar refinado', 15.00, 80.00, 'insumo', '2026-07-20', 3, 3.20, 'Kg'),
(3, 'Fermento biológico', 10.00, 50.00, 'insumo', '2025-11-15', 4, 2.80, 'Kg'),
(4, 'Leite integral', 30.00, 200.00, 'insumo', '2025-09-10', 2, 3.90, 'L'),
(5, 'Óleo vegetal', 10.00, 60.00, 'insumo', '2026-02-28', 5, 7.10, 'L'),
(6, 'Manteiga', 8.00, 40.00, 'insumo', '2025-12-15', 5, 15.00, 'Kg'),
(7, 'Chocolate meio amargo', 5.00, 30.00, 'insumo', '2026-04-05', 6, 25.00, 'Kg'),
(8, 'Embalagem para pão', 50.00, 300.00, 'insumo', '2027-01-01', 7, 0.20, 'UN'),
(9, 'Mel natural', 7.00, 20.00, 'insumo', '2026-06-10', 9, 18.50, 'Kg'),
(10, 'Sal refinado', 10.00, 70.00, 'insumo', '2027-03-20', 10, 1.50, 'Kg'),
(11, 'Pão francês', 40.00, 150.00, 'produto', '2025-09-04', NULL, 0.50, 'UN'),
(12, 'Pão integral', 30.00, 120.00, 'produto', '2025-09-05', NULL, 0.70, 'UN'),
(13, 'Bolo de chocolate', 10.00, 25.00, 'produto', '2025-09-06', NULL, 15.00, 'UN'),
(14, 'Croissant', 20.00, 40.00, 'produto', '2025-09-05', NULL, 3.50, 'UN'),
(15, 'Rosca doce', 15.00, 30.00, 'produto', '2025-09-07', NULL, 8.00, 'UN'),
(16, 'Cookies de aveia', 20.00, 50.00, 'produto', '2025-09-10', NULL, 1.20, 'UN'),
(17, 'Pão de queijo', 30.00, 100.00, 'produto', '2025-09-04', NULL, 0.80, 'UN'),
(18, 'Torta de maçã', 10.00, 20.00, 'produto', '2025-09-08', NULL, 20.00, 'UN'),
(19, 'Muffin de blueberry', 15.00, 35.00, 'produto', '2025-09-06', NULL, 5.50, 'UN'),
(20, 'Pão de mel', 20.00, 45.00, 'produto', '2025-09-09', NULL, 4.00, 'UN'),
(21, 'Farinha integral', 15.00, 70.00, 'insumo', '2026-08-01', 1, 5.00, 'Kg'),
(22, 'Açúcar mascavo', 10.00, 40.00, 'insumo', '2026-10-15', 3, 4.00, 'Kg'),
(23, 'Fermento químico', 8.00, 25.00, 'insumo', '2026-01-20', 4, 3.50, 'Kg'),
(24, 'Leite condensado', 10.00, 30.00, 'insumo', '2025-12-30', 2, 6.00, 'Kg'),
(25, 'Óleo de coco', 5.00, 20.00, 'insumo', '2026-04-25', 5, 18.00, 'L'),
(26, 'Margarina', 10.00, 40.00, 'insumo', '2026-02-10', 5, 9.00, 'Kg'),
(27, 'Chocolate ao leite', 10.00, 25.00, 'insumo', '2026-03-15', 6, 22.00, 'Kg'),
(28, 'Saco para embalar', 100.00, 500.00, 'insumo', '2027-05-01', 7, 0.10, 'UN'),
(29, 'Frutas secas', 7.00, 35.00, 'insumo', '2026-07-10', 8, 40.00, 'Kg'),
(30, 'Melado', 5.00, 15.00, 'insumo', '2026-09-30', 9, 10.00, 'Kg'),
(31, 'Pão australiano', 25.00, 80.00, 'produto', '2025-09-04', NULL, 1.00, 'UN'),
(32, 'Baguete', 30.00, 90.00, 'produto', '2025-09-04', NULL, 1.50, 'UN'),
(33, 'Bolo de cenoura', 10.00, 22.00, 'produto', '2025-09-06', NULL, 13.00, 'UN'),
(34, 'Donuts', 25.00, 55.00, 'produto', '2025-09-05', NULL, 2.00, 'UN'),
(35, 'Empada de frango', 20.00, 40.00, 'produto', '2025-09-05', NULL, 6.00, 'UN'),
(36, 'Biscoito amanteigado', 20.00, 60.00, 'produto', '2025-09-07', NULL, 1.10, 'UN'),
(37, 'Pão de cebola', 30.00, 70.00, 'produto', '2025-09-04', NULL, 0.90, 'UN'),
(38, 'Torta de limão', 10.00, 18.00, 'produto', '2025-09-08', NULL, 19.00, 'UN'),
(39, 'Muffin de chocolate', 15.00, 40.00, 'produto', '2025-09-06', NULL, 5.80, 'UN'),
(40, 'Pão doce', 20.00, 60.00, 'produto', '2025-09-09', NULL, 3.00, 'UN'),
(41, 'Farinha de milho', 20.00, 55.00, 'insumo', '2026-07-01', 1, 3.50, 'Kg'),
(42, 'Açúcar cristal', 15.00, 45.00, 'insumo', '2026-09-01', 3, 3.30, 'Kg'),
(43, 'Fermento natural', 8.00, 22.00, 'insumo', '2025-12-01', 4, 5.50, 'Kg'),
(44, 'Leite em pó', 10.00, 30.00, 'insumo', '2026-05-01', 2, 12.00, 'Kg'),
(45, 'Óleo de soja', 10.00, 60.00, 'insumo', '2026-03-15', 5, 6.50, 'L'),
(46, 'Gordura vegetal', 8.00, 25.00, 'insumo', '2026-01-10', 5, 8.00, 'Kg'),
(47, 'Chocolate branco', 10.00, 20.00, 'insumo', '2026-06-15', 6, 24.00, 'Kg'),
(48, 'Sacos para doces', 80.00, 450.00, 'insumo', '2027-04-01', 7, 0.15, 'UN'),
(49, 'Frutas frescas', 15.00, 30.00, 'insumo', '2025-10-01', 8, 10.00, 'Kg'),
(50, 'Tempero para pães', 5.00, 15.00, 'insumo', '2027-01-01', 10, 7.00, 'Kg');

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

--
-- Despejando dados para a tabela `metodos_pag`
--

INSERT INTO `metodos_pag` (`id_metodo`, `id_venda`, `metodo`, `valor_pago`) VALUES
(1, 1, 'Dinheiro', 5.40),
(2, 2, 'Dinheiro', 10.00),
(3, 3, 'Dinheiro', 6.00),
(4, 4, 'Dinheiro', 20.00),
(5, 5, 'Dinheiro', 19.50),
(6, 6, 'Dinheiro', 10.30),
(7, 7, 'Dinheiro', 7.50),
(8, 8, 'Dinheiro', 11.00),
(9, 9, 'Dinheiro', 14.00),
(10, 10, 'Dinheiro', 1.70),
(11, 11, 'dinheiro', 5.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `telefone`
--

CREATE TABLE `telefone` (
  `id_telefone` int(11) NOT NULL,
  `ddd` varchar(2) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `id_fornecedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `telefone`
--

INSERT INTO `telefone` (`id_telefone`, `ddd`, `numero`, `id_fornecedor`) VALUES
(1, '11', '98765-4321', 1),
(2, '21', '3456-7890', 2),
(3, '31', '91234-5678', 3),
(4, '41', '2345-6789', 4),
(5, '51', '99876-5432', 5),
(6, '61', '4567-8901', 6),
(7, '71', '9876-5432', 7),
(8, '81', '12345-6789', 8),
(9, '91', '8765-4321', 9),
(10, '19', '56789-0123', 10);

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
  `id_cargo` int(11) NOT NULL,
  `senha_temporaria` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome_usuario`, `CPF`, `email`, `senha`, `id_cargo`, `senha_temporaria`) VALUES
(6, 'Helena Lópes', '12345678900', 'helena.legau@helena.legau', '$2y$10$gwKWzAbjKe3ei1sz0S5ok.EbG67N7piQccORTmcZULTtizfQXOreS', 2, 0),
(9, 'Yan Carlos', '12345678911', 'yan@yan.carlos', '$2y$10$A5whywY4whG3BQNd1tD/sOZaPG91JtdAp87P39i89AhJxUAcGok6.', 3, 0),
(10, 'Micael Junco', '12345678922', 'micael@jef.j', '$2y$10$XVPGnOixpNVyjvr.fkcQ2eZDDx/gezVGSFiiAu7wsPd6mk/4MnZXe', 1, 0),
(12, 'Lucas', '09876543211', 'lucas.m@gmail.com', '$2y$10$Y6/j.uKQ8CO1Sy/TchNEfecLiQD7cXJGEb1JOmyvzt2omDiA3Q1Au', 2, 0),
(14, 'Luis Freitas', '08007707900', 'freitasluis@gmail.com', '$2y$10$EKnuo7iWAQi3mSYchZgsLOHZQPVnF4o8dfU0ahlIKRvqTeCXT6KzC', 1, 0);

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

--
-- Despejando dados para a tabela `vendas`
--

INSERT INTO `vendas` (`id_venda`, `id_usuario`, `id_comanda`, `valor_total`, `data_hora`) VALUES
(1, 6, NULL, 5.40, '2025-09-04 09:15:00'),
(2, 12, NULL, 10.00, '2025-09-04 10:05:00'),
(3, 6, NULL, 8.10, '2025-09-04 11:20:00'),
(4, 12, NULL, 20.00, '2025-09-04 12:00:00'),
(5, 6, NULL, 14.50, '2025-09-04 13:30:00'),
(6, 12, NULL, 6.60, '2025-09-04 14:45:00'),
(7, 6, NULL, 9.60, '2025-09-04 15:50:00'),
(8, 12, NULL, 7.20, '2025-09-04 16:10:00'),
(9, 6, NULL, 11.50, '2025-09-04 17:25:00'),
(10, 12, NULL, 4.80, '2025-09-04 18:00:00'),
(11, 10, NULL, 4.50, '2025-09-12 16:09:06');

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas_itens`
--

CREATE TABLE `vendas_itens` (
  `id_venda_item` int(11) NOT NULL,
  `id_venda` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `quantidade` decimal(10,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `vendas_itens`
--

INSERT INTO `vendas_itens` (`id_venda_item`, `id_venda`, `id_item`, `quantidade`) VALUES
(1, 1, 11, 4.000),
(2, 1, 16, 3.000),
(3, 2, 12, 5.000),
(4, 2, 20, 1.000),
(5, 3, 17, 6.000),
(6, 3, 8, 6.000),
(7, 4, 18, 1.000),
(8, 5, 13, 1.000),
(9, 5, 10, 3.000),
(10, 6, 14, 2.000),
(11, 6, 36, 3.000),
(12, 7, 19, 1.000),
(13, 7, 31, 2.000),
(14, 8, 15, 1.000),
(15, 8, 32, 2.000),
(16, 9, 21, 2.000),
(17, 9, 22, 1.000),
(18, 10, 40, 2.000),
(19, 10, 11, 1.000),
(20, 10, 16, 1.000),
(21, 11, 48, 0.000),
(22, 11, 1, 1.000);

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
  ADD PRIMARY KEY (`id_comanda_itens`),
  ADD KEY `id_comanda` (`id_comanda`),
  ADD KEY `id_item` (`id_item`);

--
-- Índices de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD PRIMARY KEY (`id_fornecedor`);

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
  ADD PRIMARY KEY (`id_telefone`),
  ADD KEY `fk_fornecedor` (`id_fornecedor`);

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
  MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `comandas`
--
ALTER TABLE `comandas`
  MODIFY `id_comanda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `comanda_itens`
--
ALTER TABLE `comanda_itens`
  MODIFY `id_comanda_itens` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  MODIFY `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `itens`
--
ALTER TABLE `itens`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de tabela `metodos_pag`
--
ALTER TABLE `metodos_pag`
  MODIFY `id_metodo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `telefone`
--
ALTER TABLE `telefone`
  MODIFY `id_telefone` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id_venda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `vendas_itens`
--
ALTER TABLE `vendas_itens`
  MODIFY `id_venda_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
-- Restrições para tabelas `telefone`
--
ALTER TABLE `telefone`
  ADD CONSTRAINT `fk_fornecedor` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`);

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
