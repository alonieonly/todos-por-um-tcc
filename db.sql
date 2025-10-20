-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.32-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para todos_por_um
CREATE DATABASE IF NOT EXISTS `todos_por_um` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `todos_por_um`;

-- Copiando estrutura para tabela todos_por_um.administradores
CREATE TABLE IF NOT EXISTS `administradores` (
  `id_administrador` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `cpf` char(11) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `cargo` varchar(100) NOT NULL,
  `id_campanha` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_administrador`),
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_admin_campanha` (`id_campanha`),
  CONSTRAINT `fk_admin_campanha` FOREIGN KEY (`id_campanha`) REFERENCES `campanha` (`id_campanha`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela todos_por_um.administradores: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela todos_por_um.campanha
CREATE TABLE IF NOT EXISTS `campanha` (
  `id_campanha` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(150) NOT NULL,
  `nome` text DEFAULT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date DEFAULT NULL,
  `id_administrador` int(11) NOT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_campanha`),
  KEY `id_administrador` (`id_administrador`),
  KEY `id_paciente` (`id_paciente`),
  CONSTRAINT `campanha_ibfk_1` FOREIGN KEY (`id_administrador`) REFERENCES `administradores` (`id_administrador`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `campanha_ibfk_2` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela todos_por_um.campanha: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela todos_por_um.doacoes
CREATE TABLE IF NOT EXISTS `doacoes` (
  `id_doacoes` int(11) NOT NULL AUTO_INCREMENT,
  `id_doador` int(11) NOT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `id_campanha` int(11) DEFAULT NULL,
  `data_doacao` datetime NOT NULL DEFAULT current_timestamp(),
  `tipo_doacao` enum('valor','roupa','serviço','Outros') NOT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `status` enum('Concluída','Pendente','Cancelada') DEFAULT 'Pendente',
  `observacoes` text DEFAULT NULL,
  PRIMARY KEY (`id_doacoes`),
  KEY `id_doador` (`id_doador`),
  KEY `id_paciente` (`id_paciente`),
  KEY `id_campanha` (`id_campanha`),
  CONSTRAINT `doacoes_ibfk_1` FOREIGN KEY (`id_doador`) REFERENCES `doador` (`id_doador`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `doacoes_ibfk_2` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `doacoes_ibfk_3` FOREIGN KEY (`id_campanha`) REFERENCES `campanha` (`id_campanha`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela todos_por_um.doacoes: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela todos_por_um.doador
CREATE TABLE IF NOT EXISTS `doador` (
  `id_doador` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `senha` varchar(255) NOT NULL,
  `endereco` varchar(150) DEFAULT NULL,
  `data_nascimento` date NOT NULL,
  `cpf` char(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `avatar` varchar(45) DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_doador`),
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela todos_por_um.doador: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela todos_por_um.eventos
CREATE TABLE IF NOT EXISTS `eventos` (
  `id_evento` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `endereco` varchar(500) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `data_evento` date NOT NULL,
  `hora_evento` time DEFAULT NULL,
  `valor_inscricao` decimal(10,2) DEFAULT 0.00,
  `imagem_url` varchar(500) DEFAULT NULL,
  `status` enum('ativo','cancelado','concluido','adiado') DEFAULT 'ativo',
  `participantes_inscritos` int(11) DEFAULT 0,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_atualizacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_evento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela todos_por_um.eventos: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela todos_por_um.evento_inscricoes
CREATE TABLE IF NOT EXISTS `evento_inscricoes` (
  `id_inscricao` int(11) NOT NULL AUTO_INCREMENT,
  `id_evento` int(11) NOT NULL,
  `id_doador` int(11) NOT NULL,
  `data_inscricao` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('confirmada','pendente','cancelada') DEFAULT 'pendente',
  `valor_pago` decimal(10,2) DEFAULT 0.00,
  `forma_pagamento` enum('cartao','pix','dinheiro','outro') DEFAULT 'outro',
  `comprovante_url` varchar(500) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  PRIMARY KEY (`id_inscricao`),
  UNIQUE KEY `unique_inscricao` (`id_evento`,`id_doador`),
  KEY `id_doador` (`id_doador`),
  CONSTRAINT `evento_inscricoes_ibfk_1` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id_evento`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `evento_inscricoes_ibfk_2` FOREIGN KEY (`id_doador`) REFERENCES `doador` (`id_doador`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela todos_por_um.evento_inscricoes: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela todos_por_um.ong
CREATE TABLE IF NOT EXISTS `ong` (
  `id_ong` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `foto_perfil` varchar(45) DEFAULT NULL,
  `cnpj` varchar(18) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `endereco` varchar(200) DEFAULT NULL,
  `area_atuacao` enum('Saúde','Educação','Assistência Social','Outros') DEFAULT 'Outros',
  `descricao` text DEFAULT NULL,
  `data_cadastro` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_ong`),
  UNIQUE KEY `cnpj` (`cnpj`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela todos_por_um.ong: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela todos_por_um.paciente
CREATE TABLE IF NOT EXISTS `paciente` (
  `id_paciente` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `foto_perfil` varchar(45) DEFAULT NULL,
  `cpf` char(11) NOT NULL,
  `tipo_doenca` varchar(100) NOT NULL,
  `data_nascimento` date NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `id_administrador` int(11) DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_paciente`),
  UNIQUE KEY `cpf` (`cpf`),
  KEY `id_administrador` (`id_administrador`),
  CONSTRAINT `paciente_ibfk_1` FOREIGN KEY (`id_administrador`) REFERENCES `administradores` (`id_administrador`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela todos_por_um.paciente: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela todos_por_um.vaquinha
CREATE TABLE IF NOT EXISTS `vaquinha` (
  `id_vaquinha` int(11) NOT NULL AUTO_INCREMENT,
  `nome_vaquinha` varchar(255) NOT NULL,
  `meta` decimal(15,2) NOT NULL,
  `valor_arrecadado` decimal(15,2) DEFAULT 0.00,
  `causa` text DEFAULT NULL,
  `id_paciente` int(11) NOT NULL,
  `status` enum('ativa','concluida','cancelada') DEFAULT 'ativa',
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_atualizacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_vaquinha`),
  KEY `id_paciente` (`id_paciente`),
  CONSTRAINT `vaquinha_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela todos_por_um.vaquinha: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela todos_por_um.vaquinha_doacoes
CREATE TABLE IF NOT EXISTS `vaquinha_doacoes` (
  `id_doacao` int(11) NOT NULL AUTO_INCREMENT,
  `id_vaquinha` int(11) NOT NULL,
  `id_doador` int(11) NOT NULL,
  `valor_doacao` decimal(10,2) NOT NULL,
  `data_doacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `mensagem` text DEFAULT NULL,
  `anonima` enum('sim','nao') DEFAULT 'nao',
  `status` enum('confirmada','pendente','cancelada') DEFAULT 'pendente',
  PRIMARY KEY (`id_doacao`),
  KEY `id_vaquinha` (`id_vaquinha`),
  KEY `id_doador` (`id_doador`),
  CONSTRAINT `vaquinha_doacoes_ibfk_1` FOREIGN KEY (`id_vaquinha`) REFERENCES `vaquinha` (`id_vaquinha`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `vaquinha_doacoes_ibfk_2` FOREIGN KEY (`id_doador`) REFERENCES `doador` (`id_doador`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela todos_por_um.vaquinha_doacoes: ~0 rows (aproximadamente)

-- Copiando estrutura para view todos_por_um.vw_doacoes_completas
-- Criando tabela temporária para evitar erros de dependência de VIEW
CREATE TABLE `vw_doacoes_completas` (
	`id_doacao` INT(11) NOT NULL,
	`nome_doador` VARCHAR(1) NULL COLLATE 'utf8mb4_general_ci',
	`nome_paciente` VARCHAR(1) NULL COLLATE 'utf8mb4_general_ci',
	`campanha` TEXT NULL COLLATE 'utf8mb4_general_ci',
	`data_doacao` DATETIME NOT NULL,
	`tipo_doacao` ENUM('valor','roupa','serviço','Outros') NOT NULL COLLATE 'utf8mb4_general_ci',
	`valor` DECIMAL(10,2) NULL,
	`status` ENUM('Concluída','Pendente','Cancelada') NULL COLLATE 'utf8mb4_general_ci',
	`observacoes` TEXT NULL COLLATE 'utf8mb4_general_ci'
) ENGINE=MyISAM;

-- Copiando estrutura para view todos_por_um.vw_vaquinhas_completas
-- Criando tabela temporária para evitar erros de dependência de VIEW
CREATE TABLE `vw_vaquinhas_completas` (
	`id_vaquinha` INT(11) NOT NULL,
	`nome_vaquinha` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_general_ci',
	`meta` DECIMAL(15,2) NOT NULL,
	`valor_arrecadado` DECIMAL(15,2) NULL,
	`causa` TEXT NULL COLLATE 'utf8mb4_general_ci',
	`status_vaquinha` ENUM('ativa','concluida','cancelada') NULL COLLATE 'utf8mb4_general_ci',
	`data_criacao` TIMESTAMP NOT NULL,
	`id_paciente` INT(11) NOT NULL,
	`nome_paciente` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_general_ci',
	`tipo_doenca` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_general_ci',
	`nascimento_paciente` DATE NOT NULL,
	`foto_paciente` VARCHAR(1) NULL COLLATE 'utf8mb4_general_ci',
	`progresso_percentual` DECIMAL(21,2) NULL,
	`faltam_para_meta` DECIMAL(16,2) NULL,
	`total_doadores` BIGINT(21) NULL,
	`doacoes_confirmadas` BIGINT(21) NULL
) ENGINE=MyISAM;

-- Removendo tabela temporária e criando a estrutura VIEW final
DROP TABLE IF EXISTS `vw_doacoes_completas`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vw_doacoes_completas` AS SELECT 
    d.id_doacoes AS id_doacao,
    dr.nome AS nome_doador,
    p.nome AS nome_paciente,
    c.nome AS campanha,
    d.data_doacao,
    d.tipo_doacao,
	d.valor,
    d.status,
    d.observacoes
FROM doacoes d
LEFT JOIN doador dr ON d.id_doador = dr.id_doador
LEFT JOIN paciente p ON d.id_paciente = p.id_paciente
LEFT JOIN campanha c ON d.id_campanha = c.id_campanha ;

-- Removendo tabela temporária e criando a estrutura VIEW final
DROP TABLE IF EXISTS `vw_vaquinhas_completas`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vw_vaquinhas_completas` AS SELECT 
    v.id_vaquinha,
    v.nome_vaquinha,
    v.meta,
    v.valor_arrecadado,
    v.causa,
    v.status as status_vaquinha,
    v.data_criacao,
    p.id_paciente,
    p.nome as nome_paciente,
    p.tipo_doenca,
    p.data_nascimento as nascimento_paciente,
    p.foto_perfil as foto_paciente,
    -- Removido: Colunas foto1, foto2, etc., não existem na tabela paciente
    ROUND((v.valor_arrecadado / v.meta) * 100, 2) as progresso_percentual,
    (v.meta - v.valor_arrecadado) as faltam_para_meta,
    (SELECT COUNT(*) FROM vaquinha_doacoes vd WHERE vd.id_vaquinha = v.id_vaquinha) as total_doadores,
    (SELECT COUNT(*) FROM vaquinha_doacoes vd WHERE vd.id_vaquinha = v.id_vaquinha AND vd.status = 'confirmada') as doacoes_confirmadas
FROM vaquinha v
JOIN paciente p ON v.id_paciente = p.id_paciente ;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
