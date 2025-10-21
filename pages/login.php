<?php
    require_once '../app/config/conex.php';
    require_once '../app/service/DoadorService.php';
    
    try {
        $database = new Database();
        $pdo = $database->getConnection();
        $vaquinhaService = new DoadorService($pdo);
        
        // Coletar dados do formulário
        $dadosVaquinha = [
            'email' => $_POST['email'] ?? '',
            'senha' => $_POST['senha'] ?? '',
        ];
        
        // Validar dados
        if (empty($dadosVaquinha['email']) || empty($dadosVaquinha['senha'])) {
            throw new Exception("Todos os campos obrigatórios devem ser preenchidos.");
        }

        // Criar vaquinha
        $sucesso = $vaquinhaService->canLogin($dadosVaquinha);
        
        if ($sucesso) {
            header("Location: pacientes.php");
        } else {
            throw new Exception("Email ou senha incorretos.");
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
    <link rel="stylesheet" href="../css/login.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="../js/navbar.js"></script>
    <title>Login</title>
</head>
<body>
    <header class="main-header">
        <div id="navbar"></div>
        
        <div class="main-container">
            <div class="sub-container">
                <div class="login-container">
                    <h1>Login</h1>
                    <?php if (isset($mensagem)): ?>
                        <div class="alert alert-<?php echo $tipoMensagem; ?>">
                            <?php echo htmlspecialchars($mensagem); ?>
                        </div>
                    <?php endif; ?>
                    <form action="" method="POST" class="login-form">
                        <p>
                            <label for="email">E-mail</label><br>
                            <input type="text" name="email" placeholder="Digite seu e-mail aqui">
                        </p>
                        <p>
                            <label for="senha">Senha</label><br>
                            <input type="password" name="senha" placeholder="Digite sua senha aqui">
                        </p>
                        <button type="submit">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    
</body>
</html>