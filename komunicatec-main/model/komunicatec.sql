-- Criação da base de dados, se não já existir
CREATE DATABASE IF NOT EXISTS komunicatec;
USE komunicatec;

-- Declaração das tabelas
-- Usuário
CREATE TABLE usuario (
	id_usuario				INT PRIMARY KEY AUTO_INCREMENT,
	nome					VARCHAR(50) NOT NULL,
	sobrenome				VARCHAR(100) NOT NULL,
	email					VARCHAR(150) UNIQUE NOT NULL,
	senha					VARCHAR(255) NOT NULL,
	telefone				VARCHAR(15),
	visibilidade_telefone	TINYINT NOT NULL,
	foto_de_perfil			VARCHAR(200)
);

-- Aceites
CREATE TABLE aceite_opcional (
	id_aceite_opcional	INT PRIMARY KEY AUTO_INCREMENT,
	aceite_newsletter	TINYINT NOT NULL,
	data_do_aceite		DATETIME NOT NULL,
	id_usuario_fk		INT NOT NULL,
	FOREIGN KEY (id_usuario_fk) REFERENCES usuario(id_usuario)
);

CREATE TABLE aceite_obrigatorio (
	id_aceite_obrigatorio			INT PRIMARY KEY AUTO_INCREMENT,
	aceite_termo_de_uso				TINYINT NOT NULL,
	data_do_aceite					DATETIME NOT NULL,
	aceite_politica_de_privacidade	TINYINT NOT NULL,
	id_usuario_fk					INT NOT NULL,
	FOREIGN KEY (id_usuario_fk) REFERENCES usuario(id_usuario)
);

-- Perfis
CREATE TABLE perfil_discente_egresso (
	id_ra			INT PRIMARY KEY AUTO_INCREMENT,
	curso			VARCHAR(70) NOT NULL,
	semestre		ENUM('1', '2', '3', '4', '5', '6') NOT NULL,
	situacao		ENUM('discente', 'egresso') NOT NULL,
	turno			ENUM('manhã', 'noite') NOT NULL,
	descricao		VARCHAR(500),
	id_usuario_fk	INT NOT NULL,
	FOREIGN KEY (id_usuario_fk) REFERENCES usuario(id_usuario)
);
-- ENUM() apenas permite strings fixas, espqcificados entre parênteses

CREATE TABLE perfil_administrador_comunicador (
	id_cpf			INT PRIMARY KEY AUTO_INCREMENT,
	cargo			ENUM('professor', '', 'diretor') NOT NULL,
	nivel_de_acesso	ENUM('administrador', 'comunicador') NOT NULL,
	status			ENUM('ativo', 'suspenso') NOT NULL,
	id_usuario_fk	INT NOT NULL,
	FOREIGN KEY (id_usuario_fk) REFERENCES usuario(id_usuario)
);

-- Categorias de publicações (1:n)
CREATE TABLE categoria (
	id_categoria	INT PRIMARY KEY AUTO_INCREMENT,
	nome_categoria	VARCHAR(45) UNIQUE NOT NULL
);

-- Publicações
CREATE TABLE publicacao (
	id_publicacao				INT PRIMARY KEY AUTO_INCREMENT,
	titulo						VARCHAR(150) NOT NULL,
	descricao					VARCHAR(1000) NOT NULL,
	data_de_publicacao			DATETIME NOT NULL,
	data_de_ultima_modificacao	DATETIME,
	log_ultima_modificacao		VARCHAR(100),
	data_de_expiracao			DATE,
	id_categoria_fk				INT NOT NULL,
	FOREIGN KEY (id_categoria_fk) REFERENCES categoria(id_categoria),
	id_cpf_fk					INT NOT NULL,
	FOREIGN KEY (id_cpf_fk) REFERENCES perfil_administrador_comunicador(id_cpf)
);

-- Mídias de publicações (1:n)
CREATE TABLE link_publicacao (
	id_link_publicacao	INT PRIMARY KEY AUTO_INCREMENT,
	endereco_link		VARCHAR(500) NOT NULL,
	id_publicacao_fk	INT NOT NULL,
	FOREIGN KEY (id_publicacao_fk) REFERENCES publicacao(id_publicacao)
);

CREATE TABLE imagem_publicacao (
	id_imagem_publicacao	INT PRIMARY KEY AUTO_INCREMENT,
	endereco_imagem			VARCHAR(500),
	id_publicacao_fk		INT NOT NULL,
	FOREIGN KEY (id_publicacao_fk) REFERENCES publicacao(id_publicacao)
);