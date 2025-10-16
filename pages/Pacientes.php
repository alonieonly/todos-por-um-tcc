<?php
require_once '../app/controller/VaquinhaController.php';

$controller = new VaquinhaController();
$vaquinhas = $controller->getVaquinhas();

// DEBUG DAS VAQUINHAS
echo "<!-- DEBUG VAQUINHAS: ";
echo "Total de vaquinhas: " . count($vaquinhas) . "\n";
foreach ($vaquinhas as $index => $vaq) {
    echo "Vaquinha $index - ID: " . ($vaq['id_vaquinha'] ?? 'N/A') . " - Nome: " . ($vaq['nome_paciente'] ?? 'N/A') . "\n";
}
echo " -->";

foreach ($vaquinhas as $vaquinha):
    // DEBUG DOS DOADORES
    $doadores = $controller->getDoadores($vaquinha['id_vaquinha']);
    echo "<!-- DEBUG DOADORES para Vaquinha ID " . $vaquinha['id_vaquinha'] . ": ";
    echo "Total de doadores: " . count($doadores) . "\n";
    print_r($doadores);
    echo " -->";
endforeach
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="../js/navbar.js"></script>
    <title>Pacientes</title>
</head>
<head>
    <div id="navbar"></div>
</head>
<body>
    <section class="campaign-details-section">
    <div class="campaign-container">
        <?php foreach ($vaquinhas as $vaquinha): ?>
            <?php
                // Buscar doadores para esta vaquinha específica
                $doadores = $controller->getDoadores($vaquinha['id_vaquinha']);
            ?>
            <article class="campaign-card">
                <div class="campaign-header">
                    <img src="<?php echo htmlspecialchars($vaquinha['foto_paciente']); ?>" alt="" class="campaign-main-image">
                    <div class="campaign-info">
                        <h2><?php echo htmlspecialchars($vaquinha['nome_paciente']); ?></h2>
                        <p class="campaign-meta">📅 <?php echo htmlspecialchars($vaquinha['nascimento_paciente']); ?></p>
                        <p class="campaign-description">
                            <?php echo htmlspecialchars($vaquinha['causa']); ?>
                        </p>
                        <div class="progress-area">
                            <span class="progress-label">Recebido:</span>
                            <div class="progress-bar">
                                <div class="progress-bar-fill" style="width: <?php echo min($vaquinha['progresso_percentual'], 100); ?>%;">
                                    <span class="progress-amount"><?php echo min($vaquinha['progresso_percentual'], 100); ?>%</span>
                                </div>
                            </div>
                            <span class="progress-percentage">R$ <?php echo number_format($vaquinha['valor_arrecadado'], 2, ',', '.'); ?></span>
                        </div>
                        <a href="#" class="btn-donate">Doe aqui!</a>
                    </div>
                </div>
                <div class="campaign-body">
                    <div class="photo-gallery">
                        <h4>Outras Fotos</h4>
                        <div class="photo-grid">
                            <img src="<?php echo htmlspecialchars($vaquinha['foto1']); ?>" alt="Foto da galeria 1">
                            <img src="<?php echo htmlspecialchars($vaquinha['foto2']); ?>" alt="Foto da galeria 2">
                            <img src="<?php echo htmlspecialchars($vaquinha['foto3']); ?>" alt="Foto da galeria 3">
                            <img src="<?php echo htmlspecialchars($vaquinha['foto4']); ?>" alt="Foto da galeria 4">
                        </div>
                    </div>
                    <div class="donors-list">
                        <h4>Doadores Recentes</h4>
                        <ul class="donor-items">
                            <?php if (empty($doadores)): ?>
                                    <li class="no-donors">
                                        <p>Nenhuma doação ainda. Seja o primeiro a doar!</p>
                                    </li>
                            <?php else: ?>
                                <?php foreach ($doadores as $doador): ?>
                                    <li class="donor-item">
                                        <img src="<?php echo htmlspecialchars($doador['avatar_doador'] ?? '../imgs/avatar_anonimo.png'); ?>" 
                                                alt="Avatar do doador" class="donor-avatar">
                                        <div class="donor-info">
                                            <span class="donor-name"><?php echo htmlspecialchars($doador['nome_doador']); ?></span>
                                            <span class="donor-action">Doou</span>
                                            <span class="donor-amount">R$ <?php echo number_format($doador['valor_doacao'], 2, ',', '.'); ?></span>
                                        </div>
                                        <?php if (!empty($doador['mensagem'])): ?>
                                            <div class="donor-message">
                                                "<?php echo htmlspecialchars($doador['mensagem']); ?>"
                                            </div>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
        <article class="campaign-card">
            <div class="campaign-header">
                <img src="../imgs/Foto_Paciente_gilberto.png" alt="Gilberto Ruiz Lacerda" class="campaign-main-image">
                <div class="campaign-info">
                    <h2>Gilberto Ruiz Lacerda</h2>
                    <p class="campaign-meta">📅 23/05/1991 ( 34 Anos)</p>
                    <p class="campaign-description">
                       A batalha pela minha visão é diária. A esperança de ver meus filhos crescerem me dá força, mas o tratamento de retina tem um custo que não venço sozinho. Sua ajuda é a minha luz.
                    </p>
                    <div class="progress-area">
                        <span class="progress-label">Recebido:</span>
                        <div class="progress-bar">
                            <div class="progress-bar-fill" style="width: 70%;">
                                <span class="progress-amount">R$ 350,00</span>
                            </div>
                        </div>
                        <span class="progress-percentage">70% 🔄</span>
                    </div>
                    <a href="#" class="btn-donate">Doe aqui!</a>
                </div>
            </div>
             <div class="campaign-body">
                <div class="photo-gallery">
                    <h4>Outras Fotos</h4>
                    <div class="photo-grid">
                        <img src="../imgs/GIlberto_01.png" alt="Foto da galeria 1">
                        <img src="../imgs/Gilberto_02.png" alt="Foto da galeria 2">
                        <img src="../imgs/Gilberto_03.png" alt="Foto da galeria 3">
                        <img src="../imgs/gilberto_04.png" alt="Foto da galeria 4">
                    </div>
                </div>
                <div class="donors-list">
                    <h4>Doadores Recentes</h4>
                    <ul class="donor-items">
                         <li class="donor-item">
                            <img src="../imgs/Avatar_Giberto_01.png" alt="Avatar do doador" class="donor-avatar">
                            <div class="donor-info">
                                <span class="donor-name">Carlei Martin</span>
                                <span class="donor-action">Doou</span>
                                <span class="donor-amount">R$ 50,00</span>
                            </div>
                        </li>
                         <li class="donor-item">
                            <img src="../imgs/Avatar_gilberto02.png" alt="Avatar do doador" class="donor-avatar">
                            <div class="donor-info">
                                <span class="donor-name">Mavi Pontes</span>
                                <span class="donor-action">Doou</span>
                                <span class="donor-amount">R$ 5,00</span>
                            </div>
                        </li>
                         <li class="donor-item">
                            <img src="../imgs/Avatar_gilberto_03.png" alt="Avatar do doador" class="donor-avatar">
                            <div class="donor-info">
                                <span class="donor-name">Alicia Marques</span>
                                <span class="donor-action">Doou</span>
                                <span class="donor-amount">R$ 85,00</span>
                            </div>
                        </li>
                         <li class="donor-item">
                            <img src="../imgs/Avatar_gilberto04.png" alt="Avatar do doador" class="donor-avatar">
                            <div class="donor-info">
                                <span class="donor-name">Theo Lorenzo</span>
                                <span class="donor-action">Doou</span>
                                <span class="donor-amount">R$ 50,00</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </article>

        <article class="campaign-card">
            <div class="campaign-header">
                <img src="../imgs/Foto_Paciente_luiz.png" alt="Luiz Lima Ferraz" class="campaign-main-image">
                <div class="campaign-info">
                    <h2>Luiz Lima Ferraz</h2>
                    <p class="campaign-meta">📅 16/04/1958 ( 67 Anos)</p>
                    <p class="campaign-description">
                       A batalha contra o câncer de cólon é diária. Meus sonhos me dão força, mas o tratamento tem um custo que não venço sozinho. Sua ajuda é minha esperança.
                    </p>
                    <div class="progress-area">
                        <span class="progress-label">Recebido:</span>
                        <div class="progress-bar">
                            <div class="progress-bar-fill" style="width: 70%;">
                                <span class="progress-amount">R$ 70.000</span>
                            </div>
                        </div>
                        <span class="progress-percentage">70% 🔄</span>
                    </div>
                    <a href="#" class="btn-donate">Doe aqui!</a>
                </div>
            </div>
             <div class="campaign-body">
                <div class="photo-gallery">
                    <h4>Outras Fotos</h4>
                    <div class="photo-grid">
                        <img src="../imgs/Luiz_foto1.png" alt="Foto da galeria 1">
                        <img src="../imgs/Luiz_foto02.png" alt="Foto da galeria 2">
                        <img src="../imgs/Luiz_foto_03.png" alt="Foto da galeria 3">
                        <img src="../imgs/luiz_foto04.png" alt="Foto da galeria 4">
                    </div>
                </div>
                <div class="donors-list">
                    <h4>Doadores Recentes</h4>
                    <ul class="donor-items">
                         <li class="donor-item">
                            <img src="../imgs/Avatar_foto_91.png" alt="Avatar do doador" class="donor-avatar">
                            <div class="donor-info">
                                <span class="donor-name">Julio Matias</span>
                                <span class="donor-action">Doou</span>
                                <span class="donor-amount">R$ 500,00</span>
                            </div>
                        </li>
                         <li class="donor-item">
                            <img src="../imgs/avatar_foto_02.png" alt="Avatar do doador" class="donor-avatar">
                            <div class="donor-info">
                                <span class="donor-name">Hatword Fidiric</span>
                                <span class="donor-action">Doou</span>
                                <span class="donor-amount">R$ 29,00</span>
                            </div>
                        </li>
                         <li class="donor-item">
                            <img src="../imgs/avatarLUIz03.png" alt="Avatar do doador" class="donor-avatar">
                            <div class="donor-info">
                                <span class="donor-name">Rita Fagundes</span>
                                <span class="donor-action">Doou</span>
                                <span class="donor-amount">R$ 5,00</span>
                            </div>
                        </li>
                         <li class="donor-item">
                            <img src="../imgs/avatar04luiz.png" alt="Avatar do doador" class="donor-avatar">
                            <div class="donor-info">
                                <span class="donor-name">Katia Quin</span>
                                <span class="donor-action">Doou</span>
                                <span class="donor-amount">R$ 90,00</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </article>

    </div>
</section>
</body>
</html>