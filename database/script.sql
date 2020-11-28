CREATE DATABASE adega;

use adega;

CREATE TABLE usuarios (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    login VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    perfil ENUM('USUARIO', 'ADMIN') NOT NULL,
    UNIQUE (login)
);

CREATE TABLE categorias (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    UNIQUE (nome)
);

CREATE TABLE clientes (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    UNIQUE (email)
);

CREATE TABLE fornecedores (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    razao_social VARCHAR(50) NOT NULL,
    nome_fantasia VARCHAR(50) NOT NULL,
    cnpj VARCHAR(14) NOT NULL,
    email VARCHAR(50) NOT NULL,
    UNIQUE (cnpj)
);

CREATE TABLE produtos (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_fornecedor INT(5) UNSIGNED NOT NULL,    
    id_categoria INT(5) UNSIGNED NOT NULL,
    nome VARCHAR(50) NOT NULL,
    descricao VARCHAR(150) NULL DEFAULT,
    quantidade INT(5) NOT NULL,
    preco FLOAT(10, 2) NOT NULL,
    valor_total FLOAT(10, 2) NOT NULL,    
    data_entrada DATETIME NOT NULL,
    FOREIGN KEY (id_fornecedor) REFERENCES fornecedores(id) ON DELETE CASCADE,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id) ON DELETE CASCADE
);

CREATE TABLE pedidos (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT(5) UNSIGNED NOT NULL,
    id_produto INT(5) UNSIGNED NOT NULL,
    id_usuario INT(5) UNSIGNED NOT NULL,
    quantidade INT(5) NOT NULL,
    valor_total FLOAT(10, 2) NOT NULL,
    status ENUM('ABERTO', 'FECHADO') NOT NULL,
    data_pedido DATETIME NOT NULL,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id) ON DELETE CASCADE,
    FOREIGN KEY (id_produto) REFERENCES produtos(id) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);

INSERT INTO usuarios(nome, login, email, senha) VALUES ('Usuário de teste','usuario.teste','usuario.teste@gmail.com',md5('123456'))