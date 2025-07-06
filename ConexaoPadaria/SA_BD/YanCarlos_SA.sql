-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: sa_padaria_mokele
-- ------------------------------------------------------
-- Server version	8.0.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comanda`
--

DROP TABLE IF EXISTS `comanda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comanda` (
  `ID_comanda` int NOT NULL,
  `ID_usuario` int NOT NULL,
  `valor_tot` decimal(7,2) DEFAULT NULL,
  PRIMARY KEY (`ID_comanda`),
  KEY `FK_ID_usuario_comanda` (`ID_usuario`),
  CONSTRAINT `FK_ID_usuario_comanda` FOREIGN KEY (`ID_usuario`) REFERENCES `usuario` (`ID_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comanda`
--

LOCK TABLES `comanda` WRITE;
/*!40000 ALTER TABLE `comanda` DISABLE KEYS */;
INSERT INTO `comanda` VALUES (1,7,80.47),(2,6,157.61),(3,12,179.98),(4,12,101.60),(5,8,31.17),(6,6,138.67),(7,11,143.89),(8,3,134.23),(9,5,184.62),(10,7,126.08),(11,10,100.97),(12,10,65.72),(13,3,94.73),(14,11,59.19),(15,3,106.21),(16,12,173.60),(17,4,62.69),(18,9,130.10),(19,12,53.04),(20,10,129.05),(21,7,30.93),(22,3,35.92),(23,5,199.15),(24,6,21.12),(25,5,48.27),(26,8,121.01),(27,3,27.92),(28,5,53.71),(29,8,40.17),(30,6,115.35),(31,5,142.45),(32,8,26.54),(33,12,127.25),(34,12,133.30),(35,11,176.40),(36,5,88.89),(37,11,151.31),(38,3,30.71),(39,10,86.79),(40,11,90.85),(41,9,152.51),(42,12,29.41),(43,12,110.82),(44,3,179.77),(45,11,139.97),(46,4,122.35),(47,10,199.14),(48,12,197.23),(49,3,28.28),(50,3,69.69),(51,5,169.21),(52,11,125.34),(53,10,107.20),(54,6,179.54),(55,6,125.44),(56,9,43.15),(57,5,70.45),(58,6,110.33),(59,6,180.82),(60,4,179.79);
/*!40000 ALTER TABLE `comanda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comanda_produto`
--

DROP TABLE IF EXISTS `comanda_produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comanda_produto` (
  `ID_comanda` int NOT NULL,
  `ID_produto` int NOT NULL,
  `quantidade` int NOT NULL,
  `valor_unitario` decimal(8,2) NOT NULL,
  PRIMARY KEY (`ID_comanda`,`ID_produto`),
  KEY `FK_produto_comanda` (`ID_produto`),
  CONSTRAINT `FK_comanda` FOREIGN KEY (`ID_comanda`) REFERENCES `comanda` (`ID_comanda`),
  CONSTRAINT `FK_produto_comanda` FOREIGN KEY (`ID_produto`) REFERENCES `produto` (`ID_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comanda_produto`
--

LOCK TABLES `comanda_produto` WRITE;
/*!40000 ALTER TABLE `comanda_produto` DISABLE KEYS */;
INSERT INTO `comanda_produto` VALUES (1,46,1,34.10),(2,43,2,18.01),(3,18,3,43.73),(4,48,3,16.23),(5,42,5,19.56),(6,16,5,16.91),(7,6,1,38.33),(8,50,3,23.81),(9,7,5,14.14),(10,6,4,22.30),(11,37,5,43.95),(12,42,3,8.74),(13,17,3,41.56),(14,16,4,4.89),(15,6,1,36.99),(16,49,4,32.39),(17,22,1,26.37),(18,32,2,45.58),(19,42,3,40.29),(20,45,4,4.91),(21,10,1,26.19),(22,56,5,49.50),(23,60,5,9.40),(24,23,5,15.04),(25,25,2,30.29),(26,1,4,6.13),(27,39,4,44.06),(28,16,1,36.98),(29,32,4,38.19),(30,9,1,13.93),(31,35,5,9.79),(32,31,1,30.24),(33,3,3,30.92),(34,6,3,41.15),(35,8,3,30.56),(36,38,3,5.36),(37,33,2,10.92),(38,49,5,34.07),(39,2,5,47.73),(40,28,3,43.98),(41,6,1,6.96),(42,35,2,47.61),(43,10,5,24.34),(44,55,5,29.15),(45,3,5,11.39),(46,57,4,37.51),(47,45,3,46.55),(48,53,2,28.23),(49,47,5,41.82),(50,15,1,48.10),(51,39,1,9.11),(52,22,4,27.92),(53,7,1,43.66),(54,31,4,28.66),(55,26,5,18.79),(56,47,2,35.15),(57,39,3,41.97),(58,21,1,7.61),(59,47,3,45.77),(60,14,3,46.74);
/*!40000 ALTER TABLE `comanda_produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `endereco_fornecedor`
--

DROP TABLE IF EXISTS `endereco_fornecedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `endereco_fornecedor` (
  `ID_endereco` int NOT NULL,
  `tipo` varchar(30) DEFAULT NULL,
  `logradouro` varchar(30) DEFAULT NULL,
  `bairro` varchar(40) DEFAULT NULL,
  `cidade` varchar(40) DEFAULT NULL,
  `estado` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`ID_endereco`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `endereco_fornecedor`
--

LOCK TABLES `endereco_fornecedor` WRITE;
/*!40000 ALTER TABLE `endereco_fornecedor` DISABLE KEYS */;
INSERT INTO `endereco_fornecedor` VALUES (1,'Comercial','Rua das Palmeiras','Centro','Rio de Janeiro','RJ'),(2,'Industrial','Av. Brasil','Zona Norte','São Paulo','SP'),(3,'Residencial','Rua das Acácias','Jardins','Belo Horizonte','MG'),(4,'Comercial','Rua 7 de Setembro','Comércio','Salvador','BA'),(5,'Comercial','Av. Independência','Centro','Porto Alegre','RS'),(6,'Comercial','Rua Floriano Peixoto','Centro','Curitiba','PR'),(7,'Industrial','Av. das Indústrias','Distrito Industrial','Manaus','AM'),(8,'Residencial','Rua São João','Vila Nova','Fortaleza','CE'),(9,'Comercial','Av. Paulista','Bela Vista','São Paulo','SP'),(10,'Comercial','Rua dos Andradas','Centro','Porto Alegre','RS'),(11,'Comercial','Av. Afonso Pena','Funcionários','Belo Horizonte','MG'),(12,'Comercial','Rua XV de Novembro','Centro','Curitiba','PR'),(13,'Residencial','Rua das Rosas','Jardim das Flores','Campinas','SP'),(14,'Industrial','Av. Perimetral','Distrito Norte','Belém','PA'),(15,'Comercial','Rua da Paz','Centro','Vitória','ES'),(16,'Residencial','Rua Ipê Amarelo','Jardim Primavera','Niterói','RJ'),(17,'Comercial','Av. Rio Branco','Centro','Rio de Janeiro','RJ'),(18,'Comercial','Rua João Pessoa','Centro','Joinville','SC'),(19,'Industrial','Av. Sete Lagoas','Industrial','Contagem','MG'),(20,'Residencial','Rua das Oliveiras','Monte Verde','Maceió','AL'),(21,'Comercial','Rua Dom Pedro II','Bairro Novo','São Luís','MA'),(22,'Industrial','Av. do Café','Distrito Café','Ribeirão Preto','SP'),(23,'Comercial','Rua Chile','Centro','Salvador','BA'),(24,'Residencial','Rua da Aurora','Boa Vista','Recife','PE'),(25,'Comercial','Av. Beira Mar','Praia de Iracema','Fortaleza','CE'),(26,'Residencial','Rua das Bromélias','Santa Rosa','Niterói','RJ'),(27,'Comercial','Rua Visconde de Inhaúma','Centro','Rio de Janeiro','RJ'),(28,'Comercial','Rua Carlos Gomes','Brotas','Salvador','BA'),(29,'Comercial','Rua Barão do Rio Branco','Centro','Blumenau','SC'),(30,'Residencial','Rua Pequiá','Vila Madalena','São Paulo','SP'),(31,'Industrial','Av. do Trabalho','Indústrias','Caxias do Sul','RS'),(32,'Comercial','Rua Marquês de Abrantes','Flamengo','Rio de Janeiro','RJ'),(33,'Comercial','Av. Getúlio Vargas','Centro','Uberlândia','MG'),(34,'Comercial','Rua Frei Caneca','República','São Paulo','SP'),(35,'Residencial','Rua Cedro','Tijuca','Rio de Janeiro','RJ'),(36,'Comercial','Av. Norte-Sul','Centro','Aracaju','SE'),(37,'Industrial','Rua das Máquinas','Polo Industrial','Diadema','SP'),(38,'Comercial','Av. Atlântica','Copacabana','Rio de Janeiro','RJ'),(39,'Residencial','Rua dos Pinhais','Santa Tereza','Belo Horizonte','MG'),(40,'Comercial','Rua Senador Pompeu','Centro','Fortaleza','CE'),(41,'Residencial','Rua Flor de Lótus','Jardim América','Goiânia','GO'),(42,'Comercial','Av. Presidente Vargas','Centro','Rio de Janeiro','RJ'),(43,'Comercial','Rua da Assembleia','Centro','Rio de Janeiro','RJ'),(44,'Comercial','Rua das Gaivotas','Praia Grande','Santos','SP'),(45,'Residencial','Rua Laranjeiras','São Francisco','Niterói','RJ'),(46,'Industrial','Rua Fundição','Zona Industrial','Contagem','MG'),(47,'Comercial','Av. Amazonas','Centro','Belo Horizonte','MG'),(48,'Residencial','Rua do Limoeiro','Centro','Recife','PE'),(49,'Comercial','Rua Bento Gonçalves','Centro','Canoas','RS'),(50,'Industrial','Rua da Produção','Indústrias','Joinville','SC'),(51,'Comercial','Rua das Acácias','Barra','Salvador','BA'),(52,'Comercial','Rua do Comércio','Centro','Cuiabá','MT'),(53,'Residencial','Rua Dália','Jardim das Acácias','São José','SC'),(54,'Comercial','Rua Santo Antônio','Centro','João Pessoa','PB'),(55,'Residencial','Rua das Figueiras','Jardim Paulista','São Paulo','SP'),(56,'Comercial','Rua Maranhão','Centro','Campo Grande','MS'),(57,'Comercial','Rua dos Coqueiros','Boa Viagem','Recife','PE'),(58,'Comercial','Rua das Águas','Centro','Foz do Iguaçu','PR'),(59,'Residencial','Rua Pitangueiras','Tambaú','João Pessoa','PB'),(60,'Industrial','Av. das Fábricas','Distrito Sul','Campinas','SP');
/*!40000 ALTER TABLE `endereco_fornecedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estoque`
--

DROP TABLE IF EXISTS `estoque`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estoque` (
  `ID_estoque` int NOT NULL,
  `ID_produto` int NOT NULL,
  `Quant_min` int NOT NULL,
  `Quant_max` int NOT NULL,
  `Tipo` tinyint NOT NULL,
  PRIMARY KEY (`ID_estoque`),
  KEY `FK_ID_produto` (`ID_produto`),
  CONSTRAINT `FK_ID_produto` FOREIGN KEY (`ID_produto`) REFERENCES `produto` (`ID_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estoque`
--

LOCK TABLES `estoque` WRITE;
/*!40000 ALTER TABLE `estoque` DISABLE KEYS */;
INSERT INTO `estoque` VALUES (1,1,10,100,1),(2,2,10,100,1),(3,3,10,100,1),(4,4,10,100,1),(5,5,10,100,1),(6,6,10,100,1),(7,7,10,100,1),(8,8,5,30,1),(9,9,10,100,1),(10,10,10,100,1),(11,11,10,100,1),(12,12,5,20,1),(13,13,10,100,1),(14,14,10,100,1),(15,15,10,100,1),(16,16,5,30,1),(17,17,10,100,1),(18,18,10,100,1),(19,19,10,100,1),(20,20,5,30,1),(21,21,10,100,1),(22,22,5,30,1),(23,23,10,100,1),(24,24,10,100,1),(25,25,10,100,1),(26,26,5,30,1),(27,27,10,100,1),(28,28,10,100,1),(29,29,5,30,1),(30,30,5,30,1),(31,31,10,100,1),(32,32,5,30,1),(33,33,10,100,1),(34,34,10,100,1),(35,35,10,100,1),(36,36,10,100,1),(37,37,5,20,1),(38,38,5,20,1),(39,39,10,100,1),(40,40,10,100,1),(41,41,10,100,1),(42,42,5,20,1),(43,43,10,100,1),(44,44,10,100,1),(45,45,10,100,1),(46,46,10,100,1),(47,47,10,100,1),(48,48,10,100,1),(49,49,10,100,1),(50,50,10,100,1),(51,51,10,100,1),(52,52,5,20,1),(53,53,10,100,1),(54,54,5,20,1),(55,55,10,100,1),(56,56,10,100,1),(57,57,10,100,1),(58,58,10,100,1),(59,59,5,30,1),(60,60,5,30,1),(61,61,20,200,2),(62,62,20,200,2),(63,63,20,200,2),(64,64,20,200,2),(65,65,20,200,2),(66,66,20,200,2),(67,67,20,200,2),(68,68,20,200,2),(69,69,20,200,2),(70,70,20,200,2),(71,71,20,200,2),(72,72,20,200,2),(73,73,20,200,2),(74,74,20,200,2),(75,75,20,200,2),(76,76,20,200,2),(77,77,20,200,2),(78,78,20,200,2),(79,79,20,200,2),(80,80,20,200,2),(81,81,20,200,2),(82,82,20,200,2),(83,83,20,200,2),(84,84,20,200,2),(85,85,20,200,2),(86,86,20,200,2),(87,87,20,200,2),(88,88,20,200,2),(89,89,20,200,2),(90,90,20,200,2);
/*!40000 ALTER TABLE `estoque` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fornecedor`
--

DROP TABLE IF EXISTS `fornecedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fornecedor` (
  `ID_fornecedor` int NOT NULL,
  `ID_endereco` int NOT NULL,
  `ID_telefone_fornecedor` int NOT NULL,
  `CNPJ` varchar(22) NOT NULL,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_fornecedor`),
  KEY `FK_ID_endereco` (`ID_endereco`),
  KEY `FK_ID_telefone_fornecedor` (`ID_telefone_fornecedor`),
  CONSTRAINT `FK_ID_endereco` FOREIGN KEY (`ID_endereco`) REFERENCES `endereco_fornecedor` (`ID_endereco`),
  CONSTRAINT `FK_ID_telefone_fornecedor` FOREIGN KEY (`ID_telefone_fornecedor`) REFERENCES `telefone_fornecedor` (`ID_telefone_fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fornecedor`
--

LOCK TABLES `fornecedor` WRITE;
/*!40000 ALTER TABLE `fornecedor` DISABLE KEYS */;
INSERT INTO `fornecedor` VALUES (1,1,1,'00.000.001/0001-01','Padaria Estrela'),(2,2,2,'00.000.002/0001-02','Açougue do Zé'),(3,3,3,'00.000.003/0001-03','Frutas Tropicais Ltda'),(4,4,4,'00.000.004/0001-04','Laticínios Aurora'),(5,5,5,'00.000.005/0001-05','Grãos do Cerrado'),(6,6,6,'00.000.006/0001-06','Doce Sabor SA'),(7,7,7,'00.000.007/0001-07','Distribuidora Pão & Mel'),(8,8,8,'00.000.008/0001-08','Cafés Aromáticos'),(9,9,9,'00.000.009/0001-09','Bebidas Brasil'),(10,10,10,'00.000.010/0001-10','Água Mineral Fonte Clara'),(11,11,11,'00.000.011/0001-11','Massa Fina Alimentos'),(12,12,12,'00.000.012/0001-12','Sabor do Campo'),(13,13,13,'00.000.013/0001-13','Verde Vida Hortifruti'),(14,14,14,'00.000.014/0001-14','Peixaria Oceano Azul'),(15,15,15,'00.000.015/0001-15','Alimentos Naturais Bela Terra'),(16,16,16,'00.000.016/0001-16','Doces e Compotas Finas'),(17,17,17,'00.000.017/0001-17','Pães e Cia'),(18,18,18,'00.000.018/0001-18','Congelados do Sul'),(19,19,19,'00.000.019/0001-19','Fazenda Boa Esperança'),(20,20,20,'00.000.020/0001-20','Cerealista Nova Era'),(21,21,21,'00.000.021/0001-21','Refrescos Tropicais'),(22,22,22,'00.000.022/0001-22','Empório do Pão'),(23,23,23,'00.000.023/0001-23','Temperos da Vovó'),(24,24,24,'00.000.024/0001-24','Alimentos Maré Cheia'),(25,25,25,'00.000.025/0001-25','Distribuidora Litoral'),(26,26,26,'00.000.026/0001-26','Super Café Brasil'),(27,27,27,'00.000.027/0001-27','Sucos da Fazenda'),(28,28,28,'00.000.028/0001-28','Carne Nobre'),(29,29,29,'00.000.029/0001-29','Queijos do Vale'),(30,30,30,'00.000.030/0001-30','Alimentos Premium'),(31,31,31,'00.000.031/0001-31','Armazém Bom Gosto'),(32,32,32,'00.000.032/0001-32','Distribuidora Fartura'),(33,33,33,'00.000.033/0001-33','Produtos do Interior'),(34,34,34,'00.000.034/0001-34','Companhia do Milho'),(35,35,35,'00.000.035/0001-35','Laticínios da Serra'),(36,36,36,'00.000.036/0001-36','Empório da Fazenda'),(37,37,37,'00.000.037/0001-37','Verduras Fresquinhas'),(38,38,38,'00.000.038/0001-38','Distribuidora Café Forte'),(39,39,39,'00.000.039/0001-39','Panificadora Sabor Real'),(40,40,40,'00.000.040/0001-40','Confeitaria Delícia'),(41,41,41,'00.000.041/0001-41','Produtos Coloniais LTDA'),(42,42,42,'00.000.042/0001-42','Biscoitos da Vovó'),(43,43,43,'00.000.043/0001-43','Alimentos da Roça'),(44,44,44,'00.000.044/0001-44','Cervejaria Artesanal Malte Puro'),(45,45,45,'00.000.045/0001-45','Produtos Dietéticos Vida Leve'),(46,46,46,'00.000.046/0001-46','Ervas e Especiarias Ltda'),(47,47,47,'00.000.047/0001-47','Farinhas e Cia'),(48,48,48,'00.000.048/0001-48','Café do Norte'),(49,49,49,'00.000.049/0001-49','Frutas Tropicais Ltda'),(50,50,50,'00.000.050/0001-50','Alimentos Nobres SA'),(51,51,51,'00.000.051/0001-51','Congelados de Minas'),(52,52,52,'00.000.052/0001-52','Produtos Naturais Raiz'),(53,53,53,'00.000.053/0001-53','Vinhos e Licores Premium'),(54,54,54,'00.000.054/0001-54','Fazenda São Jorge'),(55,55,55,'00.000.055/0001-55','Armazém da Esquina'),(56,56,56,'00.000.056/0001-56','Empório Gourmet Serra Azul'),(57,57,57,'00.000.057/0001-57','Distribuidora Mar e Terra'),(58,58,58,'00.000.058/0001-58','Mel e Cia'),(59,59,59,'00.000.059/0001-59','Café Sertanejo'),(60,60,60,'00.000.060/0001-60','Distribuidora Bom Sabor');
/*!40000 ALTER TABLE `fornecedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produto`
--

DROP TABLE IF EXISTS `produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produto` (
  `ID_produto` int NOT NULL,
  `ID_fornecedor` int NOT NULL,
  `medida` char(4) NOT NULL,
  `valor_unitario` decimal(7,2) DEFAULT NULL,
  `nome_produto` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`ID_produto`),
  KEY `FK_ID_fornecedor` (`ID_fornecedor`),
  CONSTRAINT `FK_ID_fornecedor` FOREIGN KEY (`ID_fornecedor`) REFERENCES `fornecedor` (`ID_fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produto`
--

LOCK TABLES `produto` WRITE;
/*!40000 ALTER TABLE `produto` DISABLE KEYS */;
INSERT INTO `produto` VALUES (1,1,'UN',12.50,'Pão Francês'),(2,2,'KG',8.90,'Farinha de Trigo'),(3,3,'LT',6.40,'Leite Integral'),(4,4,'UN',3.20,'Sonho Recheado'),(5,5,'CX',25.00,'Caixa de Bombom'),(6,6,'UN',45.75,'Bolo de Festa'),(7,7,'KG',18.30,'Queijo Minas'),(8,8,'UN',99.90,'Tábua de Frios'),(9,9,'LT',7.80,'Suco de Laranja'),(10,10,'UN',5.60,'Coxinha de Frango'),(11,1,'KG',14.50,'Presunto Fatiado'),(12,2,'CX',130.00,'Caixa de Doces Sortidos'),(13,3,'UN',16.70,'Torta de Limão'),(14,4,'LT',11.90,'Iogurte Natural'),(15,5,'KG',4.50,'Açúcar Refinado'),(16,6,'UN',10.00,'Croissant Simples'),(17,7,'LT',10.00,'Achocolatado'),(18,8,'UN',8.50,'Pão Doce'),(19,9,'KG',29.00,'Mortadela Defumada'),(20,10,'UN',7.90,'Empada de Frango'),(21,1,'CX',72.00,'Caixa de Pão de Queijo'),(22,2,'UN',6.00,'Mini Pizza'),(23,3,'KG',13.90,'Manteiga'),(24,4,'LT',14.20,'Café Coado'),(25,5,'UN',19.99,'Bolo de Cenoura com Cobertura'),(26,6,'UN',7.00,'Biscoito de Polvilho'),(27,7,'LT',6.90,'Vitamina de Banana'),(28,8,'KG',21.00,'Ricota Fresca'),(29,9,'CX',95.00,'Caixa de Torradas'),(30,10,'UN',8.50,'Folhado de Presunto e Queijo'),(31,1,'KG',9.90,'Frutas da Estação'),(32,2,'UN',5.50,'Pastel de Carne'),(33,3,'UN',12.90,'Torta de Frango'),(34,4,'CX',40.00,'Caixa de Mini Salgados'),(35,5,'LT',9.30,'Leite Desnatado'),(36,6,'UN',6.90,'Rosquinha de Coco'),(37,7,'UN',3.50,'Pão de Batata'),(38,8,'UN',4.50,'Pão Integral'),(39,9,'KG',8.80,'Banana Prata'),(40,10,'UN',11.50,'Pão Recheado'),(41,1,'LT',7.70,'Refrigerante Lata'),(42,2,'UN',3.90,'Pão de Leite'),(43,3,'UN',4.50,'Queijo Prato'),(44,4,'UN',6.00,'Mini Sonho'),(45,5,'UN',5.90,'Torta de Chocolate'),(46,6,'LT',6.00,'Leite com Chocolate'),(47,7,'KG',27.50,'Linguiça Artesanal'),(48,8,'UN',10.99,'Enroladinho de Salsicha'),(49,9,'UN',4.30,'Quiche de Alho-Poró'),(50,10,'UN',12.00,'Bolo de Milho'),(51,1,'KG',19.80,'Frango Assado'),(52,2,'UN',4.90,'Pão de Forma Caseiro'),(53,3,'UN',6.00,'Esfiha de Carne'),(54,4,'CX',110.00,'Kit de Doces Caseiros'),(55,5,'UN',13.90,'Torta de Morango'),(56,6,'UN',7.50,'Bolo de Laranja'),(57,7,'LT',8.40,'Suco Natural'),(58,8,'KG',22.70,'Requeijão Cremoso'),(59,9,'UN',6.00,'Biscoito Caseiro'),(60,10,'UN',9.50,'Tapioca Pronta'),(61,1,'KG',5.20,'Farinha de Trigo Especial'),(62,2,'KG',7.80,'Açúcar Cristal'),(63,3,'DZ',12.00,'Ovos Brancos'),(64,4,'LT',6.70,'Leite Integral'),(65,5,'KG',18.90,'Queijo Muçarela'),(66,6,'KG',15.00,'Presunto Cozido'),(67,7,'KG',21.50,'Manteiga sem Sal'),(68,8,'KG',9.30,'Margarina Industrial'),(69,9,'KG',13.70,'Chocolate em Pó 50%'),(70,10,'KG',6.90,'Fermento Biológico Seco'),(71,1,'LT',7.10,'Óleo de Soja'),(72,2,'KG',10.20,'Coco Ralado Seco'),(73,3,'KG',11.40,'Farinha de Milho'),(74,4,'KG',8.90,'Fubá Fino'),(75,5,'KG',14.80,'Leite em Pó Integral'),(76,6,'KG',20.50,'Requeijão Cremoso'),(77,7,'L',8.00,'Essência de Baunilha'),(78,8,'KG',27.00,'Chocolate Meio Amargo'),(79,9,'KG',5.60,'Açúcar Refinado'),(80,10,'KG',24.90,'Goiabada em Barra'),(81,1,'KG',9.90,'Amido de Milho'),(82,2,'KG',10.50,'Creme de Leite'),(83,3,'KG',13.30,'Leite Condensado'),(84,4,'KG',17.20,'Queijo Prato'),(85,5,'KG',19.90,'Calabresa Defumada'),(86,6,'KG',16.00,'Peito de Peru Fatiado'),(87,7,'KG',22.40,'Frutas Cristalizadas'),(88,8,'KG',6.70,'Sal Refinado'),(89,9,'L',9.80,'Água Mineral Galão'),(90,10,'KG',4.80,'Fermento Químico em Pó');
/*!40000 ALTER TABLE `produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telefone_fornecedor`
--

DROP TABLE IF EXISTS `telefone_fornecedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telefone_fornecedor` (
  `ID_telefone_fornecedor` int NOT NULL,
  `DDD` varchar(5) DEFAULT NULL,
  `numero` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`ID_telefone_fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telefone_fornecedor`
--

LOCK TABLES `telefone_fornecedor` WRITE;
/*!40000 ALTER TABLE `telefone_fornecedor` DISABLE KEYS */;
INSERT INTO `telefone_fornecedor` VALUES (1,'11','91234-5678'),(2,'21','99876-5432'),(3,'31','93456-7890'),(4,'41','97654-3210'),(5,'51','94567-8901'),(6,'61','92345-6789'),(7,'71','98765-4321'),(8,'81','95678-9012'),(9,'91','96543-2109'),(10,'85','95432-1098'),(11,'98','94321-0987'),(12,'96','93210-9876'),(13,'83','92109-8765'),(14,'84','91098-7654'),(15,'82','90987-6543'),(16,'92','89876-5432'),(17,'95','88765-4321'),(18,'86','87654-3210'),(19,'67','86543-2109'),(20,'62','85432-1098'),(21,'47','84321-0987'),(22,'48','83210-9876'),(23,'49','82109-8765'),(24,'53','81098-7654'),(25,'54','80987-6543'),(26,'55','79876-5432'),(27,'63','78765-4321'),(28,'64','77654-3210'),(29,'65','76543-2109'),(30,'66','75432-1098'),(31,'69','74321-0987'),(32,'93','73210-9876'),(33,'94','72109-8765'),(34,'97','71098-7654'),(35,'99','70987-6543'),(36,'11','69876-5432'),(37,'21','68765-4321'),(38,'31','67654-3210'),(39,'41','66543-2109'),(40,'51','65432-1098'),(41,'61','64321-0987'),(42,'71','63210-9876'),(43,'81','62109-8765'),(44,'91','61098-7654'),(45,'85','60987-6543'),(46,'98','59876-5432'),(47,'96','58765-4321'),(48,'83','57654-3210'),(49,'84','56543-2109'),(50,'82','55432-1098'),(51,'92','54321-0987'),(52,'95','53210-9876'),(53,'86','52109-8765'),(54,'67','51098-7654'),(55,'62','50987-6543'),(56,'47','49876-5432'),(57,'48','48765-4321'),(58,'49','47654-3210'),(59,'53','46543-2109'),(60,'54','45432-1098');
/*!40000 ALTER TABLE `telefone_fornecedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `ID_usuario` int NOT NULL,
  `ID_usuario_telefone` int NOT NULL,
  `email_usuario` varchar(100) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `nome_usuario` varchar(50) NOT NULL,
  `nivel` varchar(30) NOT NULL,
  `CPF` varchar(20) NOT NULL,
  PRIMARY KEY (`ID_usuario`),
  UNIQUE KEY `email_usuario` (`email_usuario`),
  UNIQUE KEY `CPF` (`CPF`),
  KEY `FK_ID_usuario_telefone` (`ID_usuario_telefone`),
  CONSTRAINT `FK_ID_usuario_telefone` FOREIGN KEY (`ID_usuario_telefone`) REFERENCES `usuario_telefone` (`ID_usuario_telefone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,1,'senhor.genival@exemplo.com','genival123','Senhor Genival','gerente','111.111.111-11'),(2,2,'usuario2@exemplo.com','Senha2Usuario','Amanda de Freitas Bragança Barroso','analista de vendas','222.222.222-02'),(3,3,'usuario3@exemplo.com','Senha3Usuario','Carlos Eduardo Lima','controlador de estoque','222.222.222-03'),(4,4,'usuario4@exemplo.com','Senha4Usuario','Fernanda Souza','funcionário comum','222.222.222-04'),(5,5,'usuario5@exemplo.com','Senha5Usuario','Juliana Pereira','analista de vendas','222.222.222-05'),(6,6,'usuario6@exemplo.com','Senha6Usuario','Roberto da Silva','controlador de estoque','222.222.222-06'),(7,7,'usuario7@exemplo.com','Senha7Usuario','Lucas Magalhães','funcionário comum','222.222.222-07'),(8,8,'usuario8@exemplo.com','Senha8Usuario','Mariana Costa','analista de vendas','222.222.222-08'),(9,9,'usuario9@exemplo.com','Senha9Usuario','Ricardo Martins','controlador de estoque','222.222.222-09'),(10,10,'usuario10@exemplo.com','Senha10Usuario','Beatriz Gonçalves','funcionário comum','222.222.222-10'),(11,11,'usuario11@exemplo.com','Senha11Usuario','Patrícia Almeida','analista de vendas','222.222.222-11'),(12,12,'usuario12@exemplo.com','Senha12Usuario','Fernando Rodrigues','controlador de estoque','222.222.222-12'),(13,13,'usuario13@exemplo.com','Senha13Usuario','Sabrina Carvalho','funcionário comum','222.222.222-13'),(14,14,'usuario14@exemplo.com','Senha14Usuario','Marcelo Pereira','analista de vendas','222.222.222-14'),(15,15,'usuario15@exemplo.com','Senha15Usuario','Yan Carlos de Oliveira','controlador de estoque','222.222.222-15'),(16,16,'usuario16@exemplo.com','Senha16Usuario','Flávia Teixeira','funcionário comum','222.222.222-16'),(17,17,'usuario17@exemplo.com','Senha17Usuario','Gustavo Mota','analista de vendas','222.222.222-17'),(18,18,'usuario18@exemplo.com','Senha18Usuario','Amanda Nunes','controlador de estoque','222.222.222-18'),(19,19,'usuario19@exemplo.com','Senha19Usuario','Leandro Barbosa','funcionário comum','222.222.222-19'),(20,20,'usuario20@exemplo.com','Senha20Usuario','Camila Dias','analista de vendas','222.222.222-20'),(21,21,'usuario21@exemplo.com','Senha21Usuario','Eduardo Pires','controlador de estoque','222.222.222-21'),(22,22,'usuario22@exemplo.com','Senha22Usuario','Carla Moreira','funcionário comum','222.222.222-22'),(23,23,'usuario23@exemplo.com','Senha23Usuario','Victor Castro','analista de vendas','222.222.222-23'),(24,24,'usuario24@exemplo.com','Senha24Usuario','Daniela Figueiredo','controlador de estoque','222.222.222-24'),(25,25,'usuario25@exemplo.com','Senha25Usuario','João Carvalho','funcionário comum','222.222.222-25'),(26,26,'usuario26@exemplo.com','Senha26Usuario','Mariana Lima','analista de vendas','222.222.222-26'),(27,27,'usuario27@exemplo.com','Senha27Usuario','Rogério Mendes','controlador de estoque','222.222.222-27'),(28,28,'usuario28@exemplo.com','Senha28Usuario','Micael Costa','funcionário comum','222.222.222-28'),(29,29,'usuario29@exemplo.com','Senha29Usuario','Julio Ferreira','analista de vendas','222.222.222-29'),(30,30,'usuario30@exemplo.com','Senha30Usuario','Larissa Rocha','controlador de estoque','222.222.222-30'),(31,31,'usuario31@exemplo.com','Senha31Usuario','Cláudia Souza','funcionário comum','222.222.222-31'),(32,32,'usuario32@exemplo.com','Senha32Usuario','Renato Vieira','analista de vendas','222.222.222-32'),(33,33,'usuario33@exemplo.com','Senha33Usuario','Tatiana Gomes','controlador de estoque','222.222.222-33'),(34,34,'usuario34@exemplo.com','Senha34Usuario','Diego Santos','funcionário comum','222.222.222-34'),(35,35,'usuario35@exemplo.com','Senha35Usuario','Carolina Martins','analista de vendas','222.222.222-35'),(36,36,'usuario36@exemplo.com','Senha36Usuario','Ricardo Pereira','controlador de estoque','222.222.222-36'),(37,37,'usuario37@exemplo.com','Senha37Usuario','Isabela Mendes','funcionário comum','222.222.222-37'),(38,38,'usuario38@exemplo.com','Senha38Usuario','Mirella Santos','analista de vendas','222.222.222-38'),(39,39,'usuario39@exemplo.com','Senha39Usuario','Felipe Oliveira','controlador de estoque','222.222.222-39'),(40,40,'usuario40@exemplo.com','Senha40Usuario','Vanessa Costa','funcionário comum','222.222.222-40'),(41,41,'usuario41@exemplo.com','Senha41Usuario','Roberta Nascimento','analista de vendas','222.222.222-41'),(42,42,'usuario42@exemplo.com','Senha42Usuario','Luis Gomes','controlador de estoque','222.222.222-42'),(43,43,'usuario43@exemplo.com','Senha43Usuario','André Luiz','funcionário comum','222.222.222-43'),(44,44,'usuario44@exemplo.com','Senha44Usuario','Priscila Ramos','analista de vendas','222.222.222-44'),(45,45,'usuario45@exemplo.com','Senha45Usuario','Tiago Cunha','controlador de estoque','222.222.222-45'),(46,46,'usuario46@exemplo.com','Senha46Usuario','Lorena Marques','funcionário comum','222.222.222-46'),(47,47,'usuario47@exemplo.com','Senha47Usuario','Igor Fonseca','analista de vendas','222.222.222-47'),(48,48,'usuario48@exemplo.com','Senha48Usuario','Sérgio Azevedo','controlador de estoque','222.222.222-48'),(49,49,'usuario49@exemplo.com','Senha49Usuario','Mariana Silveira','funcionário comum','222.222.222-49'),(50,50,'usuario50@exemplo.com','Senha50Usuario','Victor Rocha','analista de vendas','222.222.222-50'),(51,51,'usuario51@exemplo.com','Senha51Usuario','Carolina Dias','controlador de estoque','222.222.222-51'),(52,52,'usuario52@exemplo.com','Senha52Usuario','Pedro Albuquerque','funcionário comum','222.222.222-52'),(53,53,'usuario53@exemplo.com','Senha53Usuario','Nathália Cardoso','analista de vendas','222.222.222-53'),(54,54,'usuario54@exemplo.com','Senha54Usuario','Alexandre Rezende','controlador de estoque','222.222.222-54'),(55,55,'usuario55@exemplo.com','Senha55Usuario','Marcos Paulo Fernandes','funcionário comum','222.222.222-55'),(56,56,'usuario56@exemplo.com','Senha56Usuario','Suelen Teixeira','analista de vendas','222.222.222-56'),(57,57,'usuario57@exemplo.com','Senha57Usuario','Aline Costa','controlador de estoque','222.222.222-57'),(58,58,'usuario58@exemplo.com','Senha58Usuario','Rafael Barreto','funcionário comum','222.222.222-58'),(59,59,'usuario59@exemplo.com','Senha59Usuario','Isadora Cunha','analista de vendas','222.222.222-59'),(60,60,'usuario60@exemplo.com','Senha60Usuario','Bruno Figueiredo','controlador de estoque','222.222.222-60');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_telefone`
--

DROP TABLE IF EXISTS `usuario_telefone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario_telefone` (
  `ID_usuario_telefone` int NOT NULL,
  `DDD` varchar(5) DEFAULT NULL,
  `numero` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`ID_usuario_telefone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_telefone`
--

LOCK TABLES `usuario_telefone` WRITE;
/*!40000 ALTER TABLE `usuario_telefone` DISABLE KEYS */;
INSERT INTO `usuario_telefone` VALUES (1,'21','99900-0001'),(2,'11','98811-1234'),(3,'31','97722-2345'),(4,'41','96633-3456'),(5,'51','95544-4567'),(6,'61','94455-5678'),(7,'71','93366-6789'),(8,'81','92277-7890'),(9,'91','91188-8901'),(10,'85','90099-9012'),(11,'98','98910-0123'),(12,'96','97821-1234'),(13,'62','96732-2345'),(14,'27','95643-3456'),(15,'82','94554-4567'),(16,'95','93465-5678'),(17,'92','92376-6789'),(18,'86','91287-7890'),(19,'67','90198-8901'),(20,'79','89009-9012'),(21,'89','88910-0123'),(22,'63','87821-1234'),(23,'84','86732-2345'),(24,'83','85643-3456'),(25,'94','84554-4567'),(26,'93','83465-5678'),(27,'92','82376-6789'),(28,'91','81287-7890'),(29,'85','80198-8901'),(30,'88','79009-9012'),(31,'21','78910-0123'),(32,'11','77821-1234'),(33,'31','76732-2345'),(34,'41','75643-3456'),(35,'51','74554-4567'),(36,'61','73465-5678'),(37,'71','72376-6789'),(38,'81','71287-7890'),(39,'91','70198-8901'),(40,'85','79009-9012'),(41,'98','78910-0123'),(42,'96','77821-1234'),(43,'62','76732-2345'),(44,'27','75643-3456'),(45,'82','74554-4567'),(46,'95','73465-5678'),(47,'92','72376-6789'),(48,'86','71287-7890'),(49,'67','70198-8901'),(50,'79','79009-9012'),(51,'89','78910-0123'),(52,'63','77821-1234'),(53,'84','76732-2345'),(54,'83','75643-3456'),(55,'94','74554-4567'),(56,'93','73465-5678'),(57,'92','72376-6789'),(58,'91','71287-7890'),(59,'85','70198-8901'),(60,'88','79009-9012');
/*!40000 ALTER TABLE `usuario_telefone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venda_produto`
--

DROP TABLE IF EXISTS `venda_produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `venda_produto` (
  `ID_venda` int NOT NULL,
  `ID_produto` int NOT NULL,
  `quantidade` int NOT NULL,
  `valor_unitario` decimal(8,2) NOT NULL,
  PRIMARY KEY (`ID_venda`,`ID_produto`),
  KEY `FK_produto` (`ID_produto`),
  CONSTRAINT `FK_produto` FOREIGN KEY (`ID_produto`) REFERENCES `produto` (`ID_produto`),
  CONSTRAINT `FK_venda` FOREIGN KEY (`ID_venda`) REFERENCES `vendas` (`ID_venda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venda_produto`
--

LOCK TABLES `venda_produto` WRITE;
/*!40000 ALTER TABLE `venda_produto` DISABLE KEYS */;
INSERT INTO `venda_produto` VALUES (1,42,2,34.56),(2,19,5,22.63),(2,41,1,16.52),(2,42,1,41.65),(2,43,2,20.01),(3,8,2,21.42),(3,19,2,20.71),(3,60,2,14.76),(4,8,5,22.37),(4,23,3,35.77),(4,42,3,35.21),(4,56,5,30.43),(5,12,4,38.22),(5,17,2,26.48),(5,38,1,32.35),(6,13,3,5.60),(6,56,4,34.92),(7,21,4,13.25),(7,28,5,18.45),(7,30,5,45.96),(8,27,1,46.40),(8,31,4,39.45),(8,38,3,30.69),(8,47,3,39.11),(9,13,1,6.25),(9,25,2,32.75),(9,44,2,12.16),(10,39,2,39.76),(11,16,3,31.49),(11,41,3,37.09),(11,57,5,18.33),(12,6,1,38.28),(12,14,5,37.64),(12,31,2,17.52),(12,46,3,39.01),(13,12,1,35.66),(14,46,3,36.47),(14,50,2,37.25),(14,58,5,10.80),(14,59,1,18.96),(15,36,1,25.79),(16,23,1,32.84),(17,6,5,15.64),(17,38,5,3.68),(17,55,2,32.49),(18,10,1,47.72),(18,21,3,22.96),(19,12,1,11.42),(19,29,3,24.65),(19,30,5,10.00),(19,35,4,33.40),(20,59,1,15.02),(21,35,2,43.33),(21,55,4,27.56),(21,59,2,14.39),(22,4,5,24.71),(22,17,2,26.86),(22,35,1,5.83),(23,8,4,3.84),(23,28,4,39.97),(24,17,3,43.06),(24,22,2,23.40),(24,44,3,32.82),(25,12,4,32.64),(25,21,3,3.79),(25,45,5,2.06),(25,54,3,15.99),(26,19,4,9.98),(26,24,1,38.44),(26,47,3,43.00),(26,53,1,26.58),(27,20,2,6.37),(27,21,1,46.53),(28,16,5,44.90),(28,39,1,16.53),(29,11,2,5.70),(30,12,2,23.78),(31,14,2,33.32),(32,36,1,28.47),(33,11,3,47.68),(33,30,3,23.81),(33,48,4,44.94),(33,54,1,16.94),(34,39,3,8.23),(35,1,3,22.50),(35,36,1,36.48),(35,58,2,39.96),(36,11,5,44.95),(36,35,5,48.19),(37,15,5,26.42),(37,22,2,29.94),(37,30,1,17.93),(37,54,5,32.49),(38,43,2,7.96),(39,5,2,28.57),(39,49,5,47.39),(39,50,3,3.77),(40,19,4,17.30),(40,22,2,14.01),(40,39,3,32.28),(41,29,4,33.52),(42,13,1,23.57),(42,51,3,45.64),(42,59,5,38.79),(43,14,3,35.04),(43,26,3,44.11),(43,42,1,47.53),(44,11,1,24.65),(44,37,2,46.11),(45,32,5,40.30),(46,7,4,3.11),(46,19,5,47.13),(47,5,4,29.31),(47,52,3,36.70),(48,37,3,10.22),(49,13,5,7.44),(49,19,5,36.17),(49,25,4,23.55),(49,45,2,5.11),(50,1,4,38.47),(50,4,5,21.24),(50,47,2,13.89),(51,16,5,2.62),(52,11,1,38.24),(53,9,2,43.71),(54,43,3,11.52),(55,15,5,36.27),(55,41,3,39.99),(55,48,5,11.48),(55,52,4,38.70),(56,35,2,32.93),(56,49,5,30.01),(57,6,5,49.68),(57,10,3,14.06),(57,33,5,13.41),(57,52,4,27.10),(58,12,5,42.11),(58,31,5,10.70),(58,38,1,46.31),(58,54,1,36.28),(59,5,2,21.96),(59,15,5,47.10),(59,26,5,32.88),(59,35,5,19.98),(60,15,3,10.83),(60,31,4,10.62),(60,56,2,44.02);
/*!40000 ALTER TABLE `venda_produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendas`
--

DROP TABLE IF EXISTS `vendas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vendas` (
  `ID_venda` int NOT NULL,
  `ID_usuario` int NOT NULL,
  `valor_total` decimal(8,2) NOT NULL,
  `data_venda` datetime NOT NULL,
  `metodo_pagamento` varchar(30) NOT NULL,
  PRIMARY KEY (`ID_venda`),
  KEY `FK_ID_usuario` (`ID_usuario`),
  CONSTRAINT `FK_ID_usuario` FOREIGN KEY (`ID_usuario`) REFERENCES `usuario` (`ID_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendas`
--

LOCK TABLES `vendas` WRITE;
/*!40000 ALTER TABLE `vendas` DISABLE KEYS */;
INSERT INTO `vendas` VALUES (1,3,95.64,'2025-04-01 08:00:00','Cartão de Débito'),(2,10,64.59,'2025-04-01 08:30:00','Cartão de Crédito'),(3,4,10.75,'2025-04-01 09:00:00','Dinheiro'),(4,9,47.11,'2025-04-01 09:30:00','Dinheiro'),(5,7,35.01,'2025-04-01 10:00:00','Cartão de Crédito'),(6,6,83.48,'2025-04-01 10:30:00','Cartão de Débito'),(7,5,93.27,'2025-04-01 11:00:00','Pix'),(8,6,36.04,'2025-04-01 11:30:00','Dinheiro'),(9,10,82.51,'2025-04-01 12:00:00','Dinheiro'),(10,5,98.55,'2025-04-01 12:30:00','Cartão de Débito'),(11,8,95.19,'2025-04-01 13:00:00','Dinheiro'),(12,3,14.42,'2025-04-01 13:30:00','Pix'),(13,6,89.37,'2025-04-01 14:00:00','Cartão de Débito'),(14,4,38.15,'2025-04-01 14:30:00','Pix'),(15,8,63.41,'2025-04-01 15:00:00','Pix'),(16,11,85.12,'2025-04-01 15:30:00','Cartão de Crédito'),(17,11,36.40,'2025-04-01 16:00:00','Pix'),(18,8,34.41,'2025-04-01 16:30:00','Pix'),(19,3,90.49,'2025-04-01 17:00:00','Cartão de Crédito'),(20,3,77.60,'2025-04-01 17:30:00','Pix'),(21,9,62.28,'2025-04-01 18:00:00','Cartão de Crédito'),(22,5,38.61,'2025-04-01 18:30:00','Pix'),(23,4,40.17,'2025-04-01 19:00:00','Cartão de Crédito'),(24,3,58.97,'2025-04-01 19:30:00','Cartão de Crédito'),(25,9,58.81,'2025-04-01 20:00:00','Cartão de Crédito'),(26,6,80.30,'2025-04-01 20:30:00','Dinheiro'),(27,12,48.06,'2025-04-01 21:00:00','Cartão de Crédito'),(28,11,64.78,'2025-04-01 21:30:00','Cartão de Crédito'),(29,9,49.12,'2025-04-01 22:00:00','Dinheiro'),(30,9,28.69,'2025-04-01 22:30:00','Cartão de Débito'),(31,11,62.48,'2025-04-01 23:00:00','Cartão de Crédito'),(32,7,42.55,'2025-04-01 23:30:00','Dinheiro'),(33,6,22.39,'2025-04-02 00:00:00','Cartão de Crédito'),(34,3,66.59,'2025-04-02 00:30:00','Dinheiro'),(35,12,91.72,'2025-04-02 01:00:00','Dinheiro'),(36,7,94.68,'2025-04-02 01:30:00','Pix'),(37,3,73.15,'2025-04-02 02:00:00','Cartão de Crédito'),(38,7,42.79,'2025-04-02 02:30:00','Cartão de Débito'),(39,6,10.83,'2025-04-02 03:00:00','Cartão de Crédito'),(40,9,54.11,'2025-04-02 03:30:00','Cartão de Débito'),(41,4,39.60,'2025-04-02 04:00:00','Pix'),(42,12,57.32,'2025-04-02 04:30:00','Cartão de Crédito'),(43,10,68.48,'2025-04-02 05:00:00','Cartão de Débito'),(44,3,86.53,'2025-04-02 05:30:00','Cartão de Débito'),(45,9,63.94,'2025-04-02 06:00:00','Pix'),(46,5,50.21,'2025-04-02 06:30:00','Cartão de Crédito'),(47,6,92.57,'2025-04-02 07:00:00','Dinheiro'),(48,9,24.65,'2025-04-02 07:30:00','Pix'),(49,10,23.85,'2025-04-02 08:00:00','Cartão de Crédito'),(50,9,91.29,'2025-04-02 08:30:00','Pix'),(51,9,99.56,'2025-04-02 09:00:00','Cartão de Débito'),(52,9,25.49,'2025-04-02 09:30:00','Cartão de Crédito'),(53,11,87.16,'2025-04-02 10:00:00','Dinheiro'),(54,9,35.67,'2025-04-02 10:30:00','Cartão de Débito'),(55,5,64.94,'2025-04-02 11:00:00','Cartão de Débito'),(56,4,91.24,'2025-04-02 11:30:00','Dinheiro'),(57,10,14.07,'2025-04-02 12:00:00','Pix'),(58,11,55.25,'2025-04-02 12:30:00','Cartão de Débito'),(59,6,80.05,'2025-04-02 13:00:00','Dinheiro'),(60,10,92.64,'2025-04-02 13:30:00','Dinheiro');
/*!40000 ALTER TABLE `vendas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-25 16:49:29
