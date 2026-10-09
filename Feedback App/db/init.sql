CREATE DATABASE IF NOT EXISTS feedback CHARACTER SET utf8mb4;
USE feedback;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(128) NOT NULL,
    nickname VARCHAR(100) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS secret (
    id INT AUTO_INCREMENT PRIMARY KEY,
    flag VARCHAR(200) NOT NULL
);

INSERT INTO secret (flag) VALUES
('flag{sql_1nj3ci1on_3rr0r_b4s3d_byp4ss_228b7133b1416d7a3e4fd0a0c74e6c4b9d99213813415b80291d78ea43b00c8a591360ed3a79db81317f3cc07e541bd1a120f0043b934efc2467752d2f039f01}');

CREATE TABLE IF NOT EXISTS feedbacks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO users (username, password, nickname, role) VALUES
('admin', SHA2('admin', 512), 'Administrator', 'admin'),
('bob', SHA2('bob', 512), 'Bob', 'user'),
('mia', SHA2('mia', 512), 'Mia', 'user'),
('eve', SHA2('eve', 512), 'Eve', 'user'),
('john', SHA2('john', 512), 'John', 'user'),
('mark', SHA2('mark', 512), 'Mark', 'user'),
('eric', SHA2('eric', 512), 'Eric', 'user'),
('ryan', SHA2('ryan', 512), 'Ryan', 'user'),
('adam', SHA2('adam', 512), 'Adam', 'user'),
('luke', SHA2('luke', 512), 'Luke', 'user'),
('kate', SHA2('kate', 512), 'Kate', 'user'),
('anna', SHA2('anna', 512), 'Anna', 'user'),
('jane', SHA2('jane', 512), 'Jane', 'user'),
('rose', SHA2('rose', 512), 'Rose', 'user'),
('lily', SHA2('lily', 512), 'Lily', 'user'),
('alice', SHA2('alice', 512), 'Alice', 'user'),
('kelly', SHA2('kelly', 512), 'Kelly', 'user'),
('frank', SHA2('frank', 512), 'Frank', 'user'),
('david', SHA2('david', 512), 'David', 'user'),
('maxim', SHA2('maxim', 512), 'Maxim', 'user'),
('chloe', SHA2('chloe', 512), 'Chloe', 'user'),
('brian', SHA2('brian', 512), 'Brian', 'user'),
('kevin', SHA2('kevin', 512), 'Kevin', 'user'),
('dylan', SHA2('dylan', 512), 'Dylan', 'user'),
('oscar', SHA2('oscar', 512), 'Oscar', 'user'),
('grace', SHA2('grace', 512), 'Grace', 'user'),
('hazel', SHA2('hazel', 512), 'Hazel', 'user'),
('sarah', SHA2('sarah', 512), 'Sarah', 'user'),
('henry', SHA2('henry', 512), 'Henry', 'user'),
('simon', SHA2('simon', 512), 'Simon', 'user'),
('logan', SHA2('logan', 512), 'Logan', 'user'),
('mason', SHA2('mason', 512), 'Mason', 'user'),
('lucas', SHA2('lucas', 512), 'Lucas', 'user'),
('clark', SHA2('clark', 512), 'Clark', 'user'),
('naomi', SHA2('naomi', 512), 'Naomi', 'user'),
('elena', SHA2('elena', 512), 'Elena', 'user'),
('fiona', SHA2('fiona', 512), 'Fiona', 'user'),
('claire', SHA2('claire', 512), 'Claire', 'user'),
('stella', SHA2('stella', 512), 'Stella', 'user'),
('oliver', SHA2('oliver', 512), 'Oliver', 'user');

INSERT INTO feedbacks (user_id, title, content) VALUES
(2, 'Trai nghiem san pham', 'San pham dung kha on, giao dien de dung.'),
(3, 'Gop y giao dien', 'Nen them che do toi cho ung dung.'),
(4, 'Loi khi dang tai', 'Thinh thoang tai trang bi cham khi mang yeu.'),
(5, 'Khen ngoi ho tro', 'Doi ho tro phan hoi rat nhanh, cam on team.');
