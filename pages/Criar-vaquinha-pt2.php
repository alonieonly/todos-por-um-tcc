<?php
// pages/criar-vaquinha.php

// Processar o formulário quando enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../app/config/conex.php';
    require_once '../app/service/VaquinhaService.php';
    
    try {
        $database = new Database();
        $pdo = $database->getConnection();
        $vaquinhaService = new VaquinhaService($pdo);
        
        // Coletar dados do formulário
        $dadosVaquinha = [
            'nome_vaquinha' => $_POST['nome_vaquinha'] ?? '',
            'meta' => $_POST['meta'] ?? 0,
            'causa' => $_POST['causa'] ?? '',
            'id_paciente' => $_POST['id_paciente'] ?? 1 // Você pode ajustar isso
        ];
        
        // Validar dados
        if (empty($dadosVaquinha['nome_vaquinha']) || empty($dadosVaquinha['meta']) || empty($dadosVaquinha['causa'])) {
            throw new Exception("Todos os campos obrigatórios devem ser preenchidos.");
        }
        
        // Converter meta para decimal
        $dadosVaquinha['meta'] = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $dadosVaquinha['meta']));
        
        // Criar vaquinha
        $sucesso = $vaquinhaService->criarVaquinha($dadosVaquinha);
        
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
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crie sua Vaquinha</title>
    <link rel="stylesheet" href="../css/criar-vaquinha.css"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="../js/navbar.js"></script>
    <link rel="stylesheet" href="../css/Criarvaquinha-pt2.css">
</head>
<body>

    <header class="main-header">
        <div id="navbar"></div> 
    </header>

    <main class="form-section">
        <div class="form-container">
            <div class="form-intro">
                <h1>Crie sua Vaquinha</h1>
                <p>Preencha os dados corretamente e crie sua vaquinha online.</p>
            </div>
            
            <?php if (isset($mensagem)): ?>
                <div class="alert alert-<?php echo $tipoMensagem; ?>">
                    <?php echo htmlspecialchars($mensagem); ?>
                </div>
            <?php endif; ?>
            
            <form class="info-form" method="POST" action="">
                <h2 class="form-title">Seus Dados</h2>
                
                <div class="form-group">
                    <label for="nome-vaquinha">Nome da Vaquinha <span class="required">*</span></label>
                    <input type="text" id="nome-vaquinha" name="nome_vaquinha" placeholder="Campo Obrigatório" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="meta">Meta da vaquinha <span class="required">*</span></label>
                        <input type="text" id="meta" name="meta" placeholder="R$ XX,XX" required 
                               oninput="formatarMoeda(this)">
                    </div>
                    <div class="form-group">
                        <label for="causa">Causa/Ação <span class="required">*</span></label>
                        <input type="text" id="causa" name="causa" placeholder="Descreva a causa" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="id_paciente">Paciente <span class="required">*</span></label>
                    <select id="id_paciente" name="id_paciente" required>
                        <option value="">Selecione um paciente</option>
                        <?php
                        // Carregar pacientes do banco
                        if (!isset($pdo)) {
                            require_once '../app/config/conex.php';
                            $database = new Database();
                            $pdo = $database->getConnection();
                        }
                        
                        $stmt = $pdo->query("SELECT id_paciente, nome, tipo_doenca FROM paciente ORDER BY nome");
                        $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        
                        foreach ($pacientes as $paciente): ?>
                            <option value="<?php echo $paciente['id_paciente']; ?>">
                                <?php echo htmlspecialchars($paciente['nome'] . ' - ' . $paciente['tipo_doenca']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="imagens">Adicione uma ou mais imagens</label>
                    <div class="image-upload-area">
                        <div class="main-image-placeholder">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21.2 15c.7-1.2 1-2.5.7-3.9-.6-2.4-3.4-4-6.2-4.4-1.3-.2-2.6.2-3.7.9-.7.4-1.3.9-1.8 1.5l-1.2 1.2-1.2-1.2a2.3 2.3 0 0 0-3.2 0l-3.2 3.2a2.3 2.3 0 0 0 0 3.2l1.2 1.2c.5.5 1.1 1 1.8 1.5.9.6 2.1 1 3.4 1.2 2.8.4 5.6-.9 6.2-3.3.3-1.4 0-2.7-.7-3.9z"></path><path d="m7 21 4.5-4.5"></path><path d="M12.5 11.5 15 9"></path></svg>
                        </div>
                        <div class="thumb-images">
                            <div class="thumb-placeholder"></div>
                            <div class="thumb-placeholder"></div>
                            <div class="thumb-placeholder"></div>
                        </div>
                    </div>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn btn-create">Criar Vaquinha</button>
                </div>
            </form>
        </div>
    </main>

    <!-- <script>
        // Função para formatar moeda
        function formatarMoeda(input) {
            // Remove tudo que não é número
            let valor = input.value.replace(/\D/g, '');
            
            // Converte para número e formata como moeda
            valor = (valor / 100).toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            });
            
            input.value = valor;
        }

        // Formatar campo de meta ao carregar a página
        document.addEventListener('DOMContentLoaded', function() {
            const metaInput = document.getElementById('meta');
            if (metaInput.value) {
                formatarMoeda(metaInput);
            }
        });
    </script> -->

</body>
</html>