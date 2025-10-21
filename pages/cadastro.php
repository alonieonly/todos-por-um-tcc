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
            'senha' => $_POST['senha'] ?? '',
            'data_nascimento' => $_POST['data_nascimento'] ?? '',
            'cpf' => $_POST['cpf'] ?? '', // Você pode ajustar isso
            'email' => $_POST['email'] ?? '', // Você pode ajustar isso
        ];
        
        // Validar dados
        if (empty($dadosVaquinha['nome']) || empty($dadosVaquinha['senha']) || empty($dadosVaquinha['data_nascimento']) || empty($dadosVaquinha['cpf']) || empty($dadosVaquinha['email'])) {
            throw new Exception("Todos os campos obrigatórios devem ser preenchidos.");
        }

        // Criar vaquinha
        $sucesso = $vaquinhaService->cadastrarDoador($dadosVaquinha);
        
        if ($sucesso) {
            header("Location: login.php");
        } else {
            throw new Exception("Erro ao criar vaquinha.");
        }
        
    } catch (Exception $e) {
        $mensagem = $e->getMessage();
        $tipoMensagem = "error";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cadastro.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="../js/navbar.js"></script>
    <title>Cadastro</title>
</head>
<body>
    <div id="navbar"></div>

    <div class="main-container">
        <div class="sub-container">
            <form class="cadastro-container" method="post" action="">
                <h1>Cadastro</h1>
                <?php if (isset($mensagem)): ?>
                    <div class="alert alert-<?php echo $tipoMensagem; ?>">
                        <?php echo htmlspecialchars($mensagem); ?>
                    </div>
                <?php endif; ?>
                <div class="cadastro-forms">
                    <div class="cadastro-form">
                        <p>
                            <label for="name">Nome</label><br>
                            <input type="text" name="nome" placeholder="Digite seu nome completo">
                        </p>
                        <p>
                            <label for="cpf">CPF</label><br>
                            <input type="text" name="cpf" placeholder="Digite aqui seu CPF">
                        </p>
                        <p>
                            <label for="email">E-mail</label><br>
                            <input type="text" name="email" placeholder="Digite seu e-mail aqui">
                        </p>
                        <p>
                            <label for="senha">Senha</label><br>
                            <input type="password" name="senha" placeholder="Digite aqui sua senha">  
                        </p>
                        <p>
                            <label for="data">Data de nascimento</label><br>
                            <input type="date" name="data_nascimento" placeholder="Digite aqui seu CEP">
                        </p>

                    </div>
                    <div class="laudo-container">
                        <div class="file-input">
                            <p>
                                <label for="laudo">Envie aqui seu laudo médico</label><br>
                                <input name="laudo" type="file">
                            </p>
                        </div>
                    </div>
                </div>
                <button type="submit">Cadastrar</button>
            </form>
        </div>
    </div>
</body>
</html>