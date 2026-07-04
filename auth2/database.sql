-- ================================================
--  Créer la base et la table users
-- ================================================

CREATE DATABASE IF NOT EXISTS portfolio_db
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE portfolio_db;

CREATE TABLE IF NOT EXISTS users (
  id_user    INT          NOT NULL AUTO_INCREMENT,
  nom        VARCHAR(100) NOT NULL,
  email      VARCHAR(150) NOT NULL UNIQUE,
  password   VARCHAR(255) NOT NULL,
  role       ENUM('admin','user') NOT NULL DEFAULT 'user',
  created_at TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_user)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Utilisateur admin de test  (mot de passe : Admin@123)
-- Regénérez le hash avec : password_hash('Admin@123', PASSWORD_BCRYPT)
INSERT INTO users (nom, email, password, role) VALUES
('Admin', 'admin@portfolio.com',
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
