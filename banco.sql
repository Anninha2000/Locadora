
DROP DATABASE IF EXISTS locadora;
CREATE DATABASE locadora;
USE locadora;

CREATE TABLE filmes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    genero VARCHAR(50) NOT NULL,
    ano_lancamento INT NOT NULL,
    preco_aluguel DECIMAL(10, 2) NOT NULL,
    
    diretor VARCHAR(100),
    atores TEXT,                
    classificacao VARCHAR(50),  
    duracao INT,                
    sinopse TEXT,
    imagem VARCHAR(255) DEFAULT 'img/default.jpg',
    nota DECIMAL(3, 1) DEFAULT 5.0
);


CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);


INSERT INTO usuarios (nome, email, senha) VALUES 
('Admin Professor', 'admin@cineverse.com', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm');


INSERT INTO filmes (titulo, genero, ano_lancamento, preco_aluguel, diretor, atores, classificacao, duracao, sinopse, imagem, nota) VALUES (
    'Pulp Fiction', 'Ficção', 1994, 12.90, 'Quentin Tarantino', 'John Travolta, Uma Thurman, Samuel L. Jackson', '18 anos', 154, 
    'Os caminhos de vários criminosos se cruzam nestas três histórias de sangue, violência e humor negro.', 
    'img/Pulp-Fiction2.png', 5.0
);


INSERT INTO filmes (titulo, genero, ano_lancamento, preco_aluguel, diretor, atores, classificacao, duracao, sinopse, imagem, nota) VALUES (
    'De Volta para o Futuro III', 'Ficção', 1990, 11.50, 'Robert Zemeckis', 'Michael J. Fox, Christopher Lloyd', 'Livre', 118, 
    'Marty McFly viaja para o Velho Oeste de 1885 para resgatar o Doc Brown e evitar que ele altere a história.', 
    'img/De-volta-para-o-futuro-III.jpg', 4.8
);


INSERT INTO filmes (titulo, genero, ano_lancamento, preco_aluguel, diretor, atores, classificacao, duracao, sinopse, imagem, nota) VALUES (
    'Como Treinar o Seu Dragão', 'Animação', 2010, 9.90, 'Dean DeBlois', 'Jay Baruchel, Gerard Butler', 'Livre', 98, 
    'Soluço é um jovem viking que desafia a tradição ao fazer amizade com um dos dragões mais mortais.', 
    'img/treinar.jpg', 5.0
);


INSERT INTO filmes (titulo, genero, ano_lancamento, preco_aluguel, diretor, atores, classificacao, duracao, sinopse, imagem, nota) VALUES (
    'O Exorcista', 'Terror', 1973, 14.90, 'William Friedkin', 'Ellen Burstyn, Linda Blair', '18 anos', 122, 
    'Uma atriz percebe que sua filha de doze anos está tendo um comportamento assustador e recorre a padres para salvá-la.', 
    'img/exorcista.jpg', 4.9
);


INSERT INTO filmes (titulo, genero, ano_lancamento, preco_aluguel, diretor, atores, classificacao, duracao, sinopse, imagem, nota) VALUES (
    'Interestelar', 'Ficção', 2014, 15.90, 'Christopher Nolan', 'Matthew McConaughey, Anne Hathaway', '12 anos', 169, 
    'Um grupo de astronautas viaja através de um buraco de minhoca em busca de um novo lar para a humanidade.', 
    'img/interestelar1.jpg', 5.0
);


INSERT INTO filmes (titulo, genero, ano_lancamento, preco_aluguel, diretor, atores, classificacao, duracao, sinopse, imagem, nota) VALUES (
    'Matrix', 'Ficção', 1999, 12.50, 'Lana Wachowski', 'Keanu Reeves, Laurence Fishburne', '14 anos', 136, 
    'Um programador descobre que a realidade é uma simulação criada por máquinas e se une à rebelião.', 
    'img/matrix.jpg', 5.0
);


INSERT INTO filmes (titulo, genero, ano_lancamento, preco_aluguel, diretor, atores, classificacao, duracao, sinopse, imagem, nota) VALUES (
    'Toy Story', 'Animação', 1995, 8.90, 'John Lasseter', 'Tom Hanks, Tim Allen', 'Livre', 81, 
    'Woody, um boneco cowboy, sente-se ameaçado quando um novo brinquedo espacial, Buzz Lightyear, chega ao quarto.', 
    'img/toystory1.jpg', 4.7
);


INSERT INTO filmes (titulo, genero, ano_lancamento, preco_aluguel, diretor, atores, classificacao, duracao, sinopse, imagem, nota) VALUES (
    'Viva - A Vida é uma Festa', 'Animação', 2017, 10.90, 'Lee Unkrich', 'Anthony Gonzalez, Gael García Bernal', 'Livre', 105, 
    'Miguel sonha em ser músico e acaba entrando acidentalmente na Terra dos Mortos.', 
    'img/viva1.jpg', 5.0
);


INSERT INTO filmes (titulo, genero, ano_lancamento, preco_aluguel, diretor, atores, classificacao, duracao, sinopse, imagem, nota) VALUES (
    'WALL-E', 'Animação', 2008, 9.90, 'Andrew Stanton', 'Ben Burtt, Elissa Knight', 'Livre', 98, 
    'Um pequeno robô compactador de lixo embarca em uma jornada espacial que mudará o destino da humanidade.', 
    'img/Wall.jpg', 5.0
);


INSERT INTO filmes (titulo, genero, ano_lancamento, preco_aluguel, diretor, atores, classificacao, duracao, sinopse, imagem, nota) VALUES (
    'Halloween', 'Terror', 1978, 11.00, 'John Carpenter', 'Jamie Lee Curtis, Donald Pleasence', '18 anos', 91, 
    'Quinze anos depois de assassinar sua irmã, Michael Myers escapa de um hospital psiquiátrico.', 
    'img/wallowen.jpg', 4.5
);


SELECT * FROM filmes;
SELECT * FROM usuarios;