CREATE DATABASE library_db;
USE library_db;

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(50)
);

INSERT INTO admins (username, password) VALUES ('admin', 'admin123');

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_name VARCHAR(100),
    category VARCHAR(50),
    author VARCHAR(100),
    quantity INT,
    available INT
);
