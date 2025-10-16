<?php
class PacientesService {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getAllPacientes() {
        try {
            $sql = "SELECT *
                    FROM paciente 
                    ORDER BY nome ASC";
            
            echo "<!-- SQL: " . $sql . " -->"; // DEBUG
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "<!-- Total de resultados: " . count($resultados) . " -->"; // DEBUG
            
            return $resultados;
            
        } catch (Exception $e) {
            error_log("Erro no PacientesService: " . $e->getMessage());
            echo "<!-- Erro: " . $e->getMessage() . " -->"; // DEBUG
            return [];
        }
    }
    
    // GET - Evento específico
    public function getPacienteById($id) {
        $sql = "SELECT * FROM pacientes WHERE id_paciente = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // POST - Criar evento
    public function criarEvento($dados) {
        $sql = "INSERT INTO paciente (nome, tipo_doenca, data_nascimento, cpf,
                foto_perfil, foto1, foto2, foto3, foto4)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $dados['nome'], $dados['tipo_doenca'], $dados['data_nascimento'],
            $dados['cpf'], $dados['foto_perfil'], $dados['foto1'],
            $dados['foto2'], $dados['foto3'], $dados['foto4']
        ]);
    }
    
    // PUT - Atualizar evento
    public function atualizarEvento($id, $dados) {
        $sql = "UPDATE paciente SET 
                nome = ?, foto_perfil = ?, foto1 = ?, foto2 = ?, 
                foto3 = ?, foto4 - ?
                WHERE id_paciente = ?";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $dados['nome'], $dados['foto_perfil'], $dados['foto1'],
            $dados['foto2'], $dados['foto3'], $dados['foto4'], $id
        ]);
    }
}
?>