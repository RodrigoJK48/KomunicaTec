-- Declaração do banco de dados (DDL)
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
	visibilidade_telefone	TINYINT NOT NULL DEFAULT 0,
	foto_perfil				VARCHAR(200)
);

-- Aceites
CREATE TABLE aceite_opcional (
	id_aceite_opcional	INT PRIMARY KEY AUTO_INCREMENT,
	aceite_newsletter	TINYINT NOT NULL,
	data_aceite			DATETIME NOT NULL,
	id_usuario_fk		INT NOT NULL,
	FOREIGN KEY (id_usuario_fk) REFERENCES usuario(id_usuario)
);

CREATE TABLE aceite_obrigatorio (
	id_aceite_obrigatorio			INT PRIMARY KEY AUTO_INCREMENT,
	aceite_termo_de_uso				TINYINT NOT NULL,
	data_aceite						DATETIME NOT NULL,
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
	id_cpf			CHAR(11) PRIMARY KEY,
	cargo			ENUM('professor', 'coordenador', 'diretor') NOT NULL,
	nivel_acesso	ENUM('administrador', 'comunicador') NOT NULL,
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
	data_publicacao				DATETIME NOT NULL,
	data_ultima_modificacao		DATETIME,
	log_ultima_modificacao		VARCHAR(100),
	data_expiracao				DATE,
	id_categoria_fk				INT NOT NULL,
	FOREIGN KEY (id_categoria_fk) REFERENCES categoria(id_categoria),
	id_cpf_fk					CHAR(11) NOT NULL,
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

-- Cadastro de dados (DML)
-- Usuário administrador inicial
INSERT INTO usuario (id_usuario, nome, sobrenome, email, senha) VALUES
(1, 'Silvia', 'Farani', 'silvia@fatec.sp.gov.br', '$2y$10$fbcg0icG01j3GWbYgneBZOKbEk5iLKK1cA8IDaPih7DDDc3v5cKQC');
INSERT INTO perfil_administrador_comunicador (id_cpf, cargo, nivel_acesso, status, id_usuario_fk) VALUES
('01234567890', 'coordenador', 'administrador', 'ativo', 1);

-- Usuário comunicador de exemplo
INSERT INTO usuario (id_usuario, nome, sobrenome, email, senha, telefone, visibilidade_telefone) VALUES
(2, 'Paulo', 'Jacobsen', 'paulo@fatec.sp.gov.br', '$2y$10$dfVkll2yLevpNlcGjhLH4OAOoPZtOMX7AKpWS/AUUAhaBgm20qy26', '(11) 98765-4321', 1);
INSERT INTO perfil_administrador_comunicador (id_cpf, cargo, nivel_acesso, status, id_usuario_fk) VALUES
('01234567891', 'professor', 'comunicador', 'ativo', 2);

-- Categorias padrão
INSERT INTO categoria (id_categoria, nome_categoria) VALUES
(1, 'Outro'), (2, 'Vaga'), (3, 'Curso'), (4, 'Evento');

-- Publicações de exemplo
INSERT INTO publicacao (id_publicacao, titulo, descricao, data_publicacao, data_expiracao, id_categoria_fk, id_cpf_fk)
VALUES (
	1,
	'Estágio em Análise de Dados',
	'Bom dia a todos! Um ex-aluno me posicionou sobre uma vaga de estágio em aberto para a empresa XPTO.
Interessados, por favor, clicar no link.',
'2025-11-01 13:44:41',
'2025-11-30',
2,
'01234567890'
),
(
	2,
	'Convite ao Simbaju DSM!',
'Boa tarde a todos!
Nos dias 4 e 5 de novembro ocorrerão as apresentações do Simbaju do DSM.
Estudantes do GT1 e G3E estão convidados.',
'2025-11-01 13:44:41',
'2025-11-04',
4,
'01234567890'
);