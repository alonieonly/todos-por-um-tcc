<?php
class EventoService {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getAllEventosAtivos() {
        try {
            $sql = "SELECT *, 
                    DATE_FORMAT(data_evento, '%d/%m/%Y') as data_formatada
                    FROM eventos 
                    WHERE status = 'ativo'
                    ORDER BY data_evento ASC";
            
            echo "<!-- SQL: " . $sql . " -->"; // DEBUG
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "<!-- Total de resultados: " . count($resultados) . " -->"; // DEBUG
            
            return $resultados;
            
        } catch (Exception $e) {
            error_log("Erro no EventoService: " . $e->getMessage());
            echo "<!-- Erro: " . $e->getMessage() . " -->"; // DEBUG
            return [];
        }
    }
    
    // GET - Evento específico
    public function getEventoById($id) {
        $sql = "SELECT * FROM eventos WHERE id_evento = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // POST - Criar evento
    public function criarEvento($dados) {
        $sql = "INSERT INTO eventos 
                (titulo, descricao, endereco, cidade, estado, cep, data_evento, 
                 hora_evento, valor_inscricao, imagem_url, id_administrador) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $dados['titulo'], $dados['descricao'], $dados['endereco'],
            $dados['cidade'], $dados['estado'], $dados['cep'],
            $dados['data_evento'], $dados['hora_evento'], $dados['valor_inscricao'],
            $dados['imagem_url'], $dados['id_administrador']
        ]);
    }
    
    // PUT - Atualizar evento
    public function atualizarEvento($id, $dados) {
        $sql = "UPDATE eventos SET 
                titulo = ?, descricao = ?, endereco = ?, data_evento = ?, 
                valor_inscricao = ?
                WHERE id_evento = ?";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $dados['titulo'], $dados['descricao'], $dados['endereco'],
            $dados['data_evento'], $dados['valor_inscricao'], $id
        ]);
    }
    
    // DELETE - Inativar evento
    public function cancelarEvento($id) {
        $sql = "UPDATE eventos SET status = 'cancelado' WHERE id_evento = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    // Incrementar participante
    public function incrementarParticipante($id_evento) {
        $sql = "UPDATE eventos 
                SET participantes_inscritos = participantes_inscritos + 1 
                WHERE id_evento = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id_evento]);
    }
}
?>