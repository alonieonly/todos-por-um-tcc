<?php
class DoadorService {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

     // POST - Criar evento
    public function cadastrarDoador($dados) {
        $sql = "INSERT INTO doador 
                (nome, telefone, senha, endereco, data_nascimento, cpf, email, avatar) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $dados['nome'], "0000-0000", $dados['senha'],"Rua mariano procopio 97",
            $dados['data_nascimento'], $dados["cpf"], $dados['email'], ""
        ]);
    }

     // POST - Criar evento
    public function canLogin($dados) {
        try {
            $sql = "SELECT * FROM doador WHERE email = ? AND senha = ?";
            
            echo "<!-- SQL: " . $sql . " -->"; // DEBUG
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                $dados['email'],
                $dados['senha']
            ]);
            
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "<!-- Total de resultados: " . count($resultados) . " -->"; // DEBUG
            
            return count($resultados) > 0;
            
        } catch (Exception $e) {
            error_log("Erro no EventoService: " . $e->getMessage());
            echo "<!-- Erro: " . $e->getMessage() . " -->"; // DEBUG
            return [];
        }
    }
}
?>