CREATE TABLE bebidas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(500),
    categoria VARCHAR(50),
    origem VARCHAR(50),
    sabor VARCHAR(800),
    opcoes VARCHAR(2) NOT NULL,
    descricao TEXT,
    imagem VARCHAR(255)
);