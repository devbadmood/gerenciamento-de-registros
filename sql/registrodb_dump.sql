-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS registrodb CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE registrodb;

-- Tabela principal de registros
CREATE TABLE IF NOT EXISTS registros (
  id INT NOT NULL AUTO_INCREMENT,
  titulo VARCHAR(255) NOT NULL,
  conteudo LONGTEXT NOT NULL,
  status ENUM('Ativo','Inativo') DEFAULT 'Ativo',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dados de exemplo
INSERT INTO registros (titulo, conteudo, status) VALUES
('Primeiro Registro', 'Este é o conteúdo do primeiro registro.', 'Ativo'),
('Segundo Registro', 'Conteúdo do segundo registro com mais detalhes.', 'Inativo'),
('Registro de Teste', 'Texto de teste para verificação do sistema.', 'Ativo'),
('Registro Temporário', 'Este registro será excluído em breve.', 'Inativo'),
('Registro Importante', 'Informações relevantes sobre o projeto.', 'Ativo');
