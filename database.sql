CREATE DATABASE IF NOT EXISTS `sistema_gerenciamento`;
USE `sistema_gerenciamento`;

DROP TABLE IF EXISTS `item_venda`;
DROP TABLE IF EXISTS `entrada_produtos`;
DROP TABLE IF EXISTS `venda`;
DROP TABLE IF EXISTS `produtos`;
DROP TABLE IF EXISTS `cliente`;
DROP TABLE IF EXISTS `funcionario`;
DROP TABLE IF EXISTS `log`;

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

CREATE TABLE `log` (
  `id_log` int NOT NULL AUTO_INCREMENT,
  `tabela` varchar(80) NOT NULL,
  `operacao` varchar(80) NOT NULL,
  `data` datetime NOT NULL,
  `id_registro` varchar(32) NOT NULL,
  PRIMARY KEY (`id_log`)
);

DELIMITER //
CREATE TRIGGER `funcionario_insert_trigger`
AFTER INSERT ON funcionario
FOR EACH ROW
BEGIN
  INSERT INTO `log` (`tabela`, `operacao`, `data`, `id_registro`)
  VALUES ('funcionario', 'insert', sysdate(), CONCAT(new.id_funcionario));
END
//

DELIMITER //
CREATE TRIGGER `funcionario_update_trigger`
BEFORE UPDATE ON funcionario
FOR EACH ROW
BEGIN
  INSERT INTO `log` (`tabela`, `operacao`, `data`, `id_registro`)
  VALUES ('funcionario', 'update', sysdate(), CONCAT(new.id_funcionario));
END
//

DELIMITER //
CREATE TRIGGER `cliente_insert_trigger`
AFTER INSERT ON cliente
FOR EACH ROW
BEGIN
  INSERT INTO `log` (`tabela`, `operacao`, `data`, `id_registro`)
  VALUES ('cliente', 'insert', sysdate(), CONCAT(new.id_cliente));
END
//

DELIMITER //
CREATE TRIGGER `cliente_update_trigger`
BEFORE UPDATE ON cliente
FOR EACH ROW
BEGIN
  INSERT INTO `log` (`tabela`, `operacao`, `data`, `id_registro`)
  VALUES ('cliente', 'update', sysdate(), CONCAT(new.id_cliente));
END
//

DELIMITER //
CREATE TRIGGER `produtos_insert_trigger`
AFTER INSERT ON produtos
FOR EACH ROW
BEGIN
  INSERT INTO `log` (`tabela`, `operacao`, `data`, `id_registro`)
  VALUES ('produtos', 'insert', sysdate(), CONCAT(new.id_produtos));
END
//

DELIMITER //
CREATE TRIGGER `produtos_update_trigger`
BEFORE UPDATE ON produtos
FOR EACH ROW
BEGIN
  INSERT INTO `log` (`tabela`, `operacao`, `data`, `id_registro`)
  VALUES ('produtos', 'update', sysdate(), CONCAT(new.id_produtos));
END
//

DELIMITER //
CREATE TRIGGER `venda_insert_trigger`
AFTER INSERT ON venda
FOR EACH ROW
BEGIN
  INSERT INTO `log` (`tabela`, `operacao`, `data`, `id_registro`)
  VALUES ('venda', 'insert', sysdate(), CONCAT(new.id_venda));
END
//

DELIMITER //
CREATE TRIGGER `venda_update_trigger`
BEFORE UPDATE ON venda
FOR EACH ROW
BEGIN
  INSERT INTO `log` (`tabela`, `operacao`, `data`, `id_registro`)
  VALUES ('venda', 'update', sysdate(), CONCAT(new.id_venda));
END
//

DELIMITER //
CREATE TRIGGER `entrada_insert_trigger`
AFTER INSERT ON entrada_produtos
FOR EACH ROW
BEGIN
  INSERT INTO `log` (`tabela`, `operacao`, `data`, `id_registro`)
  VALUES ('entrada_produtos', 'insert', sysdate(), CONCAT(new.id_entrada));
END
//

DELIMITER //
CREATE TRIGGER `entrada_update_trigger`
BEFORE UPDATE ON entrada_produtos
FOR EACH ROW
BEGIN
  INSERT INTO `log` (`tabela`, `operacao`, `data`, `id_registro`)
  VALUES ('entrada_produtos', 'update', sysdate(), CONCAT(new.id_entrada));
END
//

DELIMITER //
CREATE TRIGGER `item_venda_insert_trigger`
AFTER INSERT ON item_venda
FOR EACH ROW
BEGIN
  INSERT INTO `log` (`tabela`, `operacao`, `data`, `id_registro`)
  VALUES ('item_venda', 'insert', sysdate(), CONCAT(new.produtos_id_produtos, ',', new.venda_id_venda));
END
//

DELIMITER //
CREATE TRIGGER `item_venda_update_trigger`
BEFORE UPDATE ON item_venda
FOR EACH ROW
BEGIN
  INSERT INTO `log` (`tabela`, `operacao`, `data`, `id_registro`)
  VALUES ('item_venda', 'update', sysdate(), CONCAT(new.produtos_id_produtos, ',', new.venda_id_venda));
END
//

INSERT INTO `funcionario` (`nome_funcionario`, `usuario`, `senha`, `adm`)
VALUES ('Administrador', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1)
