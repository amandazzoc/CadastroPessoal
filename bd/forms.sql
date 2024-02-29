create database cadastro;
USE cadastro;
 CREATE TABLE usuarios (
 id INT not null AUTO_INCREMENT PRIMARY KEY, 
 nome VARCHAR(255) NOT NULL,
 cpf VARCHAR(255) NOT NULL,
 email VARCHAR(255) NOT NULL,
 telefone VARCHAR(255) NOT NULL,
 estado_civil VARCHAR(255) NOT NULL,
 endereco VARCHAR(255) NOT NULL,
 cep VARCHAR(255) NOT NULL,
 data_nascimento date NOT NULL,
 idade int NOT NULL);