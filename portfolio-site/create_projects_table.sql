-- SQL script to create the projects table

CREATE TABLE IF NOT EXISTS projects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  image VARCHAR(255),
  status VARCHAR(50),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  client_id INT,
  FOREIGN KEY (client_id) REFERENCES users(id) ON DELETE SET NULL
);
