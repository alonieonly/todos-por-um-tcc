<?php
class VaquinhaService {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getAllVaquinhasAtivas() {
        try {
            $sql = "SELECT *,
            DATE_FORMAT(data_criacao, '%d/%m/%Y') as data_criacao,
            DATE_FORMAT(nascimento_paciente, '%d/%m/%Y') as nascimento_paciente
            FROM vw_vaquinhas_completas";
            
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

    public function getDoadoresVaquinha($id_vaquinha, $limit = 4) {
        try {
            //$limit = (int)$limit;

            $sql = "SELECT 
                        vd.valor_doacao,
                        vd.mensagem,
                        vd.data_doacao,
                        vd.anonima,
                        CASE 
                            WHEN vd.anonima = 'sim' THEN 'Anônimo'
                            ELSE d.nome 
                        END as nome_doador,
                        CASE 
                            WHEN vd.anonima = 'sim' THEN '../imgs/avatar_anonimo.png'
                            ELSE d.avatar 
                        END as avatar_doador
                    FROM vaquinha_doacoes vd
                    LEFT JOIN doador d ON vd.id_doador = d.id_doador
                    WHERE vd.id_vaquinha = ? 
                    AND vd.status = 'confirmada'
                    ORDER BY vd.data_doacao DESC
                    LIMIT 4";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id_vaquinha]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            error_log("Erro ao buscar doadores: " . $e->getMessage());
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