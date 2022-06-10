CREATE DATABASE IF NOT EXISTS `sistema_gerenciamento`;
USE `sistema_gerenciamento`;

DROP TABLE IF EXISTS `item_venda`;
DROP TABLE IF EXISTS `entrada_produtos`;
DROP TABLE IF EXISTS `venda`;
DROP TABLE IF EXISTS `produtos`;
DROP TABLE IF EXISTS `cliente`;
DROP TABLE IF EXISTS `funcionario`;

CREATE TABLE `funcionario` (
  `id_funcionario` int NOT NULL AUTO_INCREMENT,
  `nome_funcionario` varchar(45) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `senha` varchar(45) NOT NULL,
  `adm` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_funcionario`)
);

CREATE TABLE `cliente` (
  `id_cliente` int NOT NULL AUTO_INCREMENT,
  `nome_cliente` varchar(50) NOT NULL,
  `cpf_cliente` varchar(15) NOT NULL,
  `telefonecliente` varchar(15) NOT NULL,
  PRIMARY KEY (`id_cliente`)
);

CREATE TABLE `produtos` (
  `id_produtos` int NOT NULL AUTO_INCREMENT,
  `nome_produto` varchar(45) NOT NULL,
  `categoria_produto` varchar(45) NOT NULL,
  `preco_produto` double NOT NULL,
  PRIMARY KEY (`id_produtos`)
);

CREATE TABLE `venda` (
  `id_venda` int NOT NULL AUTO_INCREMENT,
  `id_funcionario` int,
  `id_cliente` int,
  `data_venda` datetime DEFAULT NULL,
  PRIMARY KEY (`id_venda`),
  FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE SET NULL,
  FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`) ON DELETE SET NULL
);

CREATE TABLE `entrada_produtos` (
  `id_entrada` int NOT NULL AUTO_INCREMENT,
  `valor_entrada` double NOT NULL,
  `id_produto` int NOT NULL,
  `quantidade_entrada` int NOT NULL,
  `data_entrada` datetime DEFAULT NULL,
  PRIMARY KEY (`id_entrada`),
  FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produtos`) ON DELETE CASCADE 
);

CREATE TABLE `item_venda` (
  `produtos_id_produtos` int NOT NULL,
  `venda_id_venda` int NOT NULL,
  `quantidade` int NOT NULL,
  `valor_venda` double DEFAULT NULL,
  PRIMARY KEY (`produtos_id_produtos`, `venda_id_venda`),
  FOREIGN KEY (`produtos_id_produtos`) REFERENCES `produtos` (`id_produtos`) ON DELETE CASCADE,
  FOREIGN KEY (`venda_id_venda`) REFERENCES `venda` (`id_venda`) ON DELETE CASCADE
);

INSERT INTO `funcionario` (`nome_funcionario`, `usuario`, `senha`, `adm`)
VALUES ('Administrador', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1)
