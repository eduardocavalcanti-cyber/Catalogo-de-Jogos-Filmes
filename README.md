# CATÁLOGO — Livros & Jogos

Sistema acadêmico simples de **catálogo e reserva de livros/jogos** em PHP 8.3 + MySQL + PDO + MVC + POO.

Fluxo: criar conta → login → ver catálogo (GET) → detalhes → reservar (POST) → minhas reservas → cancelar.

## Tecnologias
PHP 8.3+, MySQL, PDO (prepared statements), Composer (PSR-4), HTML5, CSS3, Bootstrap 5, JS

## Estrutura (inspirada no FitCalc)
```
Catalogo/
├── Config/Conexao.php, config.php
├── Model/Usuario.php, Item.php, Reserva.php
├── Controller/UsuarioController.php, ItemController.php, ReservaController.php
├── View/ (inicio, catalogo, detalhes, login, cadastro, reservas, perfil, dashboard, novo-item) + partials/layout.php
├── public/css/style.css
├── storage/uploads/
├── index.php (roteador único ?p=)
├── database.sql
├── .env (.env.example)
└── composer.json
```

## Instalação
```bash
composer install
cp .env.example .env   # ajuste DB_*
mysql -u root -p < database.sql
php -S localhost:8000
# abrir http://localhost:8000
```
XAMPP: copie `Catalogo/` para `htdocs/catalogo`, importe `database.sql` no phpMyAdmin, acesse `http://localhost/catalogo/`.

## Banco
- `users(id,nome,email,senha,created_at)` — senha com `password_hash`
- `items(id,titulo,tipo,descricao,autor,ano,categoria,imagem,quantidade,created_at)`
- `reservas(id,user_id,item_id,data_reserva,data_devolucao,status,created_at)` — devolução = +7 dias

Seed com 10 itens (livros e jogos) já incluso.

## Funcionalidades
- Cadastro/login/logout com hash, validação e CSRF
- Catálogo com busca por título, filtro tipo (livro/jogo) e disponibilidade — **GET → Controller → Model → PDO → MySQL → View**
- Detalhes com disponibilidade calculada (`quantidade - reservas ativas`)
- Reserva com POST, verifica login, disponibilidade, duplicidade, transaction + `FOR UPDATE`
- Minhas Reservas (só do usuário logado) + cancelamento (libera disponibilidade)
- Perfil (editar nome/email/senha)
- Cadastro de item (POST + upload JPG/PNG/WEBP 2MB) — requisito POST
- Responsivo, badges 🟢/🟡/🔴, proteção XSS (`e()`), SQL Injection (prepared), CSRF, rotas protegidas

## Segurança
PDO prepared statements, `password_hash`/`verify`, `htmlspecialchars`, CSRF token, `FOR UPDATE` na reserva, validação back-end de disponibilidade/duplicidade e ownership no cancelamento.

## Banco de Dados
CREATE DATABASE IF NOT EXISTS catalogo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE catalogo;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(150) NOT NULL,
  tipo ENUM('livro','jogo') NOT NULL,
  descricao TEXT NOT NULL,
  autor VARCHAR(120) NOT NULL,
  ano INT NOT NULL,
  categoria VARCHAR(80) NOT NULL,
  imagem VARCHAR(255) DEFAULT NULL,
  quantidade INT NOT NULL DEFAULT 1,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS reservas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  item_id INT NOT NULL,
  data_reserva DATETIME DEFAULT CURRENT_TIMESTAMP,
  data_devolucao DATE NOT NULL,
  status ENUM('ativa','cancelada','concluida') NOT NULL DEFAULT 'ativa',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE,
  INDEX idx_user (user_id),
  INDEX idx_item (item_id)
) ENGINE=InnoDB;

INSERT INTO items (titulo,tipo,descricao,autor,ano,categoria,imagem,quantidade) VALUES
('O Hobbit','livro','Bilbo Bolseiro embarca em uma aventura inesperada com anões para recuperar um tesouro guardado por um dragão.','J.R.R. Tolkien',1937,'Fantasia',NULL,3),
('Dom Casmurro','livro','Clássico de Machado de Assis sobre ciúme, memória e a dúvida eterna sobre Capitu.','Machado de Assis',1899,'Romance',NULL,2),
('Harry Potter e a Pedra Filosofal','livro','O início da jornada de Harry em Hogwarts, onde descobre ser um bruxo.','J.K. Rowling',1997,'Fantasia',NULL,4),
('1984','livro','Distopia de George Orwell sobre vigilância e totalitarismo.','George Orwell',1949,'Ficção',NULL,2),
('Minecraft','jogo','Construa, explore e sobreviva em um mundo infinito de blocos.','Mojang Studios',2011,'Sandbox',NULL,5),
('GTA V','jogo','Mundo aberto repleto de ação nas ruas de Los Santos.','Rockstar Games',2013,'Ação',NULL,2),
('The Witcher 3','jogo','Geralt de Rívia em uma épica caçada em um mundo de fantasia sombria.','CD Projekt RED',2015,'RPG',NULL,3),
('The Legend of Zelda: Breath of the Wild','jogo','Aventura em mundo aberto no reino de Hyrule.','Nintendo',2017,'Aventura',NULL,1),
('Clean Code','livro','Guia essencial para escrever código limpo e sustentável.','Robert C. Martin',2008,'Tecnologia',NULL,3),
('Elden Ring','jogo','RPG de ação em mundo aberto criado por FromSoftware.','FromSoftware',2022,'RPG',NULL,0);
