CREATE SCHEMA `todos_por_um`;
USE `todos_por_um`;

CREATE TABLE administradores (
    id_administrador INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf CHAR(11) UNIQUE NOT NULL,
    telefone VARCHAR(20),
    cargo VARCHAR(100) NOT NULL,
    id_campanha INT NOT NULL,
    email VARCHAR(100),
    FOREIGN KEY (id_campanha) REFERENCES campanha(id_campanha)
        ON DELETE SET NULL ON UPDATE CASCADE,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE doador (
    id_doador INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20),
    senha VARCHAR(255) NOT NULL,
    endereco VARCHAR(150),
    data_nascimento DATE NOT NULL,
    cpf CHAR(11) UNIQUE NOT NULL,
    email VARCHAR(100),
    avatar VARCHAR(45),
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE paciente (
    id_paciente INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    foto_perfil VARCHAR(45),
    cpf CHAR(11) UNIQUE NOT NULL,
    tipo_doenca VARCHAR(100) NOT NULL,
    data_nascimento DATE NOT NULL,
    id_administrador INT NOT NULL,
    telefone VARCHAR(20),
    id_doacoes INT NOT NULL,
    FOREIGN KEY (id_administrador) REFERENCES administradores(id_administrador)
		ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (id_doacoes) REFERENCES doacoes(id_doacoes)
		ON DELETE CASCADE ON UPDATE CASCADE,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE campanha (
    id_campanha INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(150) NOT NULL,
    nome TEXT,
    data_inicio DATE NOT NULL,
    data_fim DATE,
    id_administrador INT NOT NULL,
    id_doacoes INT NOT NULL,
    id_paciente INT NULL,
    FOREIGN KEY (id_administrador) REFERENCES administradores(id_administrador)
		ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (id_doacoes) REFERENCES doacoes(id_doacoes)
		ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_paciente) REFERENCES doacoes(id_paciente)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE ONG (
    id_ong INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    foto_perfil VARCHAR(45),
    cnpj VARCHAR(18) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telefone VARCHAR(20),
    endereco VARCHAR(200),
    area_atuacao ENUM('Saúde', 'Educação', 'Assistência Social', 'Outros') DEFAULT 'Outros',
    descricao TEXT,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE doacoes (
    id_doacoes INT AUTO_INCREMENT PRIMARY KEY,
    id_doador INT NOT NULL,
    id_paciente INT NULL,
    id_campanha INT NULL,
    data_doacao DATE NOT NULL,
    tipo_doacao ENUM('valor', 'roupa', 'serviço', 'Outros') NOT NULL,
    valor DECIMAL(5),
    status ENUM('Concluída', 'Pendente', 'Cancelada') DEFAULT 'Pendente',
    observacoes TEXT,
    FOREIGN KEY (id_doador) REFERENCES doador(id_doador)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_paciente) REFERENCES paciente(id_paciente)
        ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (id_campanha) REFERENCES campanha(id_campanha)
        ON DELETE SET NULL ON UPDATE CASCADE,
	FOREIGN KEY (id_administrador) REFERENCES administradores(id_administrador)
        ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE eventos (
    id_evento INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    endereco VARCHAR(500) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    estado VARCHAR(50) NOT NULL,
    cep VARCHAR(10),
    data_evento DATE NOT NULL,
    hora_evento TIME,
    valor_inscricao DECIMAL(10,2) DEFAULT 0.00,
    imagem_url VARCHAR(500),
    status ENUM('ativo', 'cancelado', 'concluido', 'adiado') DEFAULT 'ativo',
    participantes_inscritos INT DEFAULT 0,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE evento_inscricoes (
    id_inscricao INT AUTO_INCREMENT PRIMARY KEY,
    id_evento INT NOT NULL,
    id_doador INT NOT NULL,
    data_inscricao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('confirmada', 'pendente', 'cancelada') DEFAULT 'pendente',
    valor_pago DECIMAL(10,2) DEFAULT 0.00,
    forma_pagamento ENUM('cartao', 'pix', 'dinheiro', 'outro') DEFAULT 'outro',
    comprovante_url VARCHAR(500),
    observacoes TEXT,
    
    FOREIGN KEY (id_evento) REFERENCES eventos(id_evento)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_doador) REFERENCES doador(id_doador)
        ON DELETE CASCADE ON UPDATE CASCADE,
    
    UNIQUE KEY unique_inscricao (id_evento, id_doador)
);

CREATE TABLE vaquinha (
    id_vaquinha INT AUTO_INCREMENT PRIMARY KEY,
    nome_vaquinha VARCHAR(255) NOT NULL,
    meta DECIMAL(15,2) NOT NULL,
    valor_arrecadado DECIMAL(15,2) DEFAULT 0.00,
    causa TEXT,
    id_paciente INT NOT NULL,
    status ENUM('ativa', 'concluida', 'cancelada') DEFAULT 'ativa',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (id_paciente) REFERENCES paciente(id_paciente)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE vaquinha_doacoes (
    id_doacao INT AUTO_INCREMENT PRIMARY KEY,
    id_vaquinha INT NOT NULL,
    id_doador INT NOT NULL,
    valor_doacao DECIMAL(10,2) NOT NULL,
    data_doacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    mensagem TEXT,
    anonima ENUM('sim', 'nao') DEFAULT 'nao',
    status ENUM('confirmada', 'pendente', 'cancelada') DEFAULT 'pendente',
    
    FOREIGN KEY (id_vaquinha) REFERENCES vaquinha(id_vaquinha)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_doador) REFERENCES doador(id_doador)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE VIEW vw_doacoes_completas AS
SELECT 
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
LEFT JOIN campanha c ON d.id_campanha = c.id_campanha;

CREATE VIEW vw_vaquinhas_completas AS
SELECT 
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
    p.foto1 as foto1,
    p.foto2 as foto2,
    p.foto3 as foto3,
    p.foto4 as foto4,
    
    ROUND((v.valor_arrecadado / v.meta) * 100, 2) as progresso_percentual,
    (v.meta - v.valor_arrecadado) as faltam_para_meta,
    
    (SELECT COUNT(*) FROM vaquinha_doacoes vd WHERE vd.id_vaquinha = v.id_vaquinha) as total_doadores,
    (SELECT COUNT(*) FROM vaquinha_doacoes vd WHERE vd.id_vaquinha = v.id_vaquinha AND vd.status = 'confirmada') as doacoes_confirmadas

-- ligação entre tabelas
FROM vaquinha v
INNER JOIN paciente p ON v.id_paciente = p.id_paciente
WHERE v.status = 'ativa'
ORDER BY v.data_criacao DESC;

INSERT INTO administradores (nome, cpf, cargo, email, id_campanha) 
VALUES ('Admin Teste', '12345678901', 'Coordenador', 'admin@teste.com', 1);

INSERT INTO doador (nome, cpf, senha, data_nascimento, telefone, id_doacoes)
VALUES ('Maria Silva', '98765432100', 'senha123', '1985-05-15', '(11) 9999-8888', 1);

INSERT INTO paciente (nome, cpf, tipo_doenca, data_nascimento, telefone)
VALUES ('João Santos', '12312312300', 'Cancer', '1990-08-20', '(11) 7777-6666');

INSERT INTO campanha (tipo, nome, data_inicio, data_fim)
VALUES ('Doação', 'Campanha de Inverno', '2024-01-01', '2024-12-31');

INSERT INTO doacoes (id_doador, data_doacao, tipo_doacao, valor, status)
VALUES (DEFAULT, '2024-01-15', 'valor', 100.00, 'Concluída');

INSERT INTO ong (id_ong, nome, cnpj, email, telefone, endereco, area_atuacao)
Values (DEFAULT, 'Ajuda social', '12345678998765', 'ajudasocial@teste.com', '(81) 9999-8888', 'Assistência Social');

-- Inserir o evento "Corrida Para Ajudar Ryan"
INSERT INTO eventos (titulo, descricao, endereco, cidade, estado, cep, data_evento, valor_inscricao, imagem_url
) VALUES (
    'Corrida Para Ajudar Ryan',
    'Ryan, aos 10 anos, encara uma condição rara que o mantém em um leito. Sua luta por um tratamento inovador é a esperança de muitos, mas o tempo corre e um futuro abreviado. Cada dia é um passo de fé...',
    'Rua do Sol',
    'Natal',
    'RN',
    '54505-334',
    '2025-10-24',
    5.80,
    '../imgs/Foto02.png');

INSERT INTO eventos (titulo, descricao, endereco, cidade, estado, cep, data_evento, valor_inscricao, imagem_url
) VALUES (
    'Bingo do agasalho',
    'O Bingo do Agasalho une diversão e solidariedade. Doe um agasalho em bom estado e receba cartelas para jogar. Ajude-nos a aquecer um coração de quem enfrenta o frio, garantindo mais calor, dignidade e esperança neste inverno. 5 reais por cartela',
	'Rua Treze de Maio',
    'Natal',
    'SC',
    '54505-334',
    '2025-10-23',
    5.00,
    '../imgs/bingo.png');

INSERT INTO eventos (titulo, descricao, endereco, cidade, estado, cep, data_evento, valor_inscricao, imagem_url
) VALUES (
    'Futebol solidario',
    'Sabe aquele valor sobrando que não vai te fazer falta faça uma doação e venha fazer parte dessa partida cheia de emoções e ajude a defender pessoas que estão em situação de vulnerabilidade',
	'Av beberibe',
    'Recife',
    'PE',
    '52130-255',
    '2025-10-30',
    5.00,
	'../imgs/Foto05.png');

INSERT INTO paciente (nome, tipo_doenca, data_nascimento, cpf, foto_perfil) VALUES
('Mariana', 'Retina', '1990-05-15', '11111111111', '../imgs/Foto_Paciente_tatiane.png'),
('Gilberto', 'Prótese', '1985-08-20', '22222222222', '../imgs/Foto_Paciente_gilberto.png'),
('Luiz', 'Retina', '1978-12-10', '33333333333', '../imgs/Foto_Paciente_luiz.png');

-- Inserir vaquinhas
INSERT INTO vaquinha (nome_vaquinha, meta, causa, id_paciente) VALUES
('Ajude Mariana no Tratamento', 50000.00, 'Mariana enfrenta um desafio na retina e precisa da sua ajuda. Sua doação é vital para o tratamento dela. Juntos, podemos iluminar o caminho e dar a Mariana a chance de enxergar um futuro melhor.', 3),
('Prótese para Gilberto', 25000.00, 'A sua ajuda é a esperança de Gilberto. Com sua doação para uma prótese, podemos ajudá-lo a recuperar não só o movimento, mas também a sua autonomia e confiança. Doe e transforme uma vida!', 4),
('Cirurgia de Retina para Luiz', 35000.00, 'Sua doação pode devolver a visão a Luiz. Ele luta contra um problema grave na retina, e sua ajuda é o farol que ele precisa para enxergar um futuro. Doe esperança. Doe luz. Doe agora.', 5);

INSERT INTO doador (nome, telefone, senha, email, data_nascimento, cpf, endereco) VALUES
('Ana Silva', '(11) 99999-1111', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ana.silva@email.com', '1985-03-15', '44444444444', 'Rua das Flores, 123 - São Paulo, SP'),
('Carlos Oliveira', '(11) 99999-2222', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'carlos.oliveira@email.com', '1990-07-22', '55555555555', 'Av. Paulista, 1000 - São Paulo, SP'),
('Mariana Santos', '(11) 99999-3333', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'mariana.santos@email.com', '1988-11-30', '66666666666', 'Rua Augusta, 500 - São Paulo, SP'),
('Roberto Lima', '(11) 99999-4444', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'roberto.lima@email.com', '1992-05-10', '77777777777', 'Alameda Santos, 200 - São Paulo, SP'),
('Fernanda Costa', '(11) 99999-5555', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'fernanda.costa@email.com', '1987-09-18', '88888888888', 'Rua Oscar Freire, 800 - São Paulo, SP');

-- Adicionar algumas ongs
INSERT INTO ong (nome, cnpj, email, telefone, endereco, area_atuacao) VALUES
('Ame o proximo', '2345670000765', 'ameoproximo@teste.com', '(81) 99555-8888', 'Assistência Social'),
('Pets ong', '2345670000888', 'petsong@teste.com', '(31) 99777-8889', 'proteção aos animais'),
('Lar dos idosos', '2345670000897', 'laddosidosos@teste.com', '(11) 99555-8989', 'Abrigo'),
('Adote pet', '2345670003753', 'adotepet@teste.com', '(21) 99535-8888', 'Abrigo de animais'),
('mundo bem', '2345670004834', 'mundobem@teste.com', '(34) 99758-8898', 'Meio ambiente'),
('Amor no mundo', '2345670009999', 'ameoproximoamornomundo@teste.com', '(11) 99555-3434', 'Assistência Social'),
('Igreja fazer o bem', '2345670002856', 'igrejafazerobem@teste.com', '(21) 99555-1725', 'Outros'),
('toda forma de amor', '2345670003542', 'todaformadeamor@teste.com', '(81) 99587-9999', 'Assistência Social'),
('Plantando amor', '2345670000769', 'plantandoamor@teste.com', '(31) 99789-8881', 'Meio ambiente'),
('Lar feliz', '2345670044237', 'larfeliz@teste.com', '(91) 99534-1829', 'Abrigo'),
('Selva verde', '2345678900123', 'selvaverde@teste.com', '(82) 9555-8258', 'Meio ambiente');

-- Adicionar algumas doações de exemplo
INSERT INTO vaquinha_doacoes (id_vaquinha, id_doador, valor_doacao, mensagem, status) VALUES
(7, 1, 1500.00, 'Força Mariana!', 'confirmada'),
(8, 4, 800.00, 'Melhoras!', 'confirmada'),
(8, 3, 2000.00, 'Vamos ajudar o Gilberto!', 'confirmada'),
(9, 5, 1200.00, 'Que Luiz recupere a visão!', 'confirmada');

-- Trigger para atualizar valor_arrecadado automaticamente
DELIMITER //

CREATE TRIGGER after_vaquinha_doacao_insert 
AFTER INSERT ON vaquinha_doacoes
FOR EACH ROW
BEGIN
    -- Somente atualiza se a doação for confirmada
    IF NEW.status = 'confirmada' THEN
        UPDATE vaquinha 
        SET valor_arrecadado = valor_arrecadado + NEW.valor_doacao,
            data_atualizacao = CURRENT_TIMESTAMP
        WHERE id_vaquinha = NEW.id_vaquinha;
    END IF;
END//

DELIMITER ;
--
select * from vw_doacoes_completas;
select * from vw_vaquinhas_completas;

select * from doador;
select * from vaquinha;
select * from vaquinha_doacoes;
select * from paciente;
select * from doacoes;

SELECT 
    v.id_vaquinha,
    v.nome_vaquinha,
    COUNT(vd.id_doacao) as total_doacoes,
    GROUP_CONCAT(vd.id_doacao) as ids_doacoes
FROM vaquinha v
LEFT JOIN vaquinha_doacoes vd ON v.id_vaquinha = vd.id_vaquinha AND vd.status = 'confirmada'
GROUP BY v.id_vaquinha;

update paciente set foto1 = "../imgs/Rectangle 97.png" where id_paciente = 3;
update paciente set foto2 = "../imgs/Rectangle 98.png" where id_paciente = 3;
update paciente set foto3= "../imgs/Rectangle 99.png" where id_paciente = 3;
update paciente set foto4 = "../imgs/Rectangle 100.png" where id_paciente = 3;

update doador set avatar = "../imgs/Avatar1_tatiane.png" where id_doador = 1;
update doador set avatar = "../imgs/Avatar03-tatiane.png" where id_doador = 3;
update doador set avatar= "../imgs/Avatar2_tatiane.png" where id_doador = 4;
update doador set avatar = "../imgs/Avatar04tatiane.png" where id_doador = 5;
update doador set avatar= "../imgs/Avatar_Giberto_01.png" where id_doador = 6;
update doador set avatar = "../imgs/Avatar_gilberto02.png" where id_doador = 7;

delete from vaquinha_doacoes where id_vaquinha < 10;

update vaquinha set valor_arrecadado = 00 where id_vaquinha = 7;
update vaquinha set valor_arrecadado = 00 where id_vaquinha = 8;
update vaquinha set valor_arrecadado = 00 where id_vaquinha = 9;

SELECT COUNT(*) as total_eventos FROM eventos WHERE status = 'ativo';

SELECT *, DATE_FORMAT(data_evento, '%d/%m/%Y') as data_formatada 
FROM eventos 		
WHERE status = 'ativo'
ORDER BY data_evento ASC;