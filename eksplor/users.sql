CREATE DATABASE login_db;

USE login_db;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(100) NOT NULL
);

INSERT INTO users (username, password) VALUES ('admin', '12345');
