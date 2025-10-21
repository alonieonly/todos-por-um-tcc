<?php
    require_once '../app/config/conex.php';
    require_once '../app/service/DoadorService.php';
    
    try {
        $database = new Database();
        $pdo = $database->getConnection();
        $vaquinhaService = new DoadorService($pdo);
        
        // Coletar dados do formulário
        $dadosVaquinha = [
            'nome' => $_POST['nome'] ?? '',
            'senha' => $_POST['senha'] ?? "",
            'data_nascimento' => $_POST['data_nascimento'] ?? '',
            'cpf' => $_POST['cpf'] ?? "" // Você pode ajustar isso
            'email' => $_POST['email'] ?? "" // Você pode ajustar isso
        ];
        
        // Validar dados
        if (empty($dadosVaquinha['nome']) || empty($dadosVaquinha['senha']) || empty($dadosVaquinha['data_nascimento']) || empty($dadosVaquinha['cpf']) || empty($dadosVaquinha['email'])) {
            throw new Exception("Todos os campos obrigatórios devem ser preenchidos.");
        }

        // Criar vaquinha
        $sucesso = $vaquinhaService->cadastrarDoador($dadosVaquinha);
        
        if ($sucesso) {
            $mensagem = "Vaquinha criada com sucesso!";
            $tipoMensagem = "success";
        } else {
            throw new Exception("Erro ao criar vaquinha.");
        }
        
    } catch (Exception $e) {
        $mensagem = $e->getMessage();
        $tipoMensagem = "error";
    }

?>