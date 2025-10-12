<?php
class VaquinhaService {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getAllVaquinhasAtivas() {
        try {
            $sql = "SELECT * FROM vw_vaquinhas_completas";
            
            echo "<!-- SQL: " . $sql . " -->"; // DEBUG
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "<!-- Total de resultados: " . count($resultados) . " -->"; // DEBUG
            
            return $resultados;
            
        } catch (Exception $e) {
            error_log("Erro no VaquinhaService: " . $e->getMessage());
            echo "<!-- Erro: " . $e->getMessage() . " -->"; // DEBUG
            return [];
        }
    }
    
    // GET - Vaquinha específica
    public function getVaquinhaById($id) {
        $sql = "SELECT * FROM vaquinha WHERE id_vaquinha = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // POST - Criar Vaquinha
    public function criarVaquinha($dados) {
        $sql = "INSERT INTO vaquinha 
                (nome_vaquinha, causa, meta, id_paciente) 
                VALUES (?, ?, ?, ?)";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $dados['nome_vaquinha'], $dados['causa'], $dados['meta'],
            $dados['valor_arrecadado'], $dados['id_paciente']
        ]);
    }
    
    // PUT - Atualizar Vaquinha
    public function atualizarVaquinha($id, $dados) {
        $sql = "UPDATE vaquinha SET 
                nome_vaquinha = ?, causa = ?, meta = ?
                WHERE id_Vaquinha = ?";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $dados['nome_vaquinha'], $dados['causa'], $dados['meta'], $id
        ]);
    }
    
    // DELETE - Concluir Vaquinha
    public function concluirVaquinha($id) {
        $sql = "UPDATE vaquinha SET status = 'concluida' WHERE id_vaquinha = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    // DELETE - Cancelar Vaquinha
    public function cancelarVaquinha($id) {
        $sql = "UPDATE vaquinha SET status = 'cancelada' WHERE id_vaquinha = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>