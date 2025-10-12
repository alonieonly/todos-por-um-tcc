<?php
require_once '../app/controller/HomeController.php';

$controller = new HomeController();
$dados = $controller->index();

$eventos = $dados['eventos'];
$vaquinhas = $dados['vaquinhas'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doe um Agasalho</title>
    <link rel="stylesheet" href="../pages/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="../js/navbar.js"></script>
</head>

<body>
    <header>
        <div id="navbar"></div>

    </header>
    <main>
        <section class="hero">
            <div class="hero-content">
                <h4>Campanha</h4>
                <h1>Doe <img src="../imgs/LOGO_DO_TITULO.png" alt=""><br>Um Agasalho</h1>
                <a href="#" class="cta-button">Doe agora!</a>
            </div>
            <div class="donated-pieces">
                <span>+ DE 140.00 PEÇAS DOADAS</span>
            </div>
        </section>
        <section class="vakinhas-section">
            <div class="container">
                <div class="vakinhas-header">
                    <h2>Vaquınhas</h2>
                    <div class="header-icon">
                        <img src="../imgs/LOGO_VAQUINHA.png" alt="">
                    </div>
                </div>
            </div>

            <div class="carousel-container">
                <div class="vakinhas-carousel-wrapper">
                    <button class="carousel-arrow left">←</button>

                    <div class="vakinhas-list">
                        <?php if (empty($vaquinhas)): ?>
                            <div class="no-vaquinhas">
                                <h3>📦 Nenhuma vaquinha ativa no momento</h3>
                                <p>Em breve teremos novas campanhas para ajudar.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($vaquinhas as $vaquinha): ?>
                                <article class="vakinha-card">
                                    <img src="<?php echo htmlspecialchars($vaquinha['imagem_url'] ?? '../imgs/Foto_Paciente_tatiane.png'); ?>" 
                                        alt="<?php echo htmlspecialchars($vaquinha['nome_paciente']); ?>"
                                        class="vakinha-image">

                                    <div class="vakinha-content">
                                        <div class="vakinha-title-area">
                                            <h3>Ajude <br><?php echo htmlspecialchars($vaquinha['nome_paciente']); ?></h3>
                                            <span class="tag tag-blue"><?php echo htmlspecialchars($vaquinha['tipo_doenca']); ?></span>
                                        </div>
                                        <p class="vakinha-description">
                                            <?php echo htmlspecialchars($vaquinha['causa']); ?>
                                        </p>

                                        <div class="progress-info">
                                            <div class="progress-bar">
                                                <div class="progress" style="width: <?php echo min($vaquinha['progresso_percentual'], 100); ?>%"></div>
                                            </div>
                                            <div class="progress-text">
                                                <span>R$ <?php echo number_format($vaquinha['valor_arrecadado'], 2, ',', '.'); ?></span>
                                                <span><?php echo number_format($vaquinha['progresso_percentual'], 1); ?>%</span>
                                                <span>R$ <?php echo number_format($vaquinha['meta'], 2, ',', '.'); ?></span>
                                            </div>
                                        </div>

                                        <a href="../pages/Pacientes.html" class="btn-saber-mais">Saber mais!</a>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <button class="carousel-arrow right">→</button>
                </div>

                <section class="collection-points">
                    <div class="container">
                        <div class="section-title-bar">
                            <h2>Pontos de coletas para Doações</h2>
                        </div>
                        <div class="donation-types">
                            <button class="type-button active"><i class="fas fa-paw"></i> Pets</button>
                            <button class="type-button"><i class="fas fa-tshirt"></i> Roupas</button>
                            <button class="type-button"><i class="fas fa-utensils"></i> Alimentos</button>
                            <button class="type-button"><i class="fas fa-pump-soap"></i> Higiene Pessoal</button>
                        </div>
                        <div class="points-carousel">
                            <div class="arrow left-arrow">&lt;</div>
                            <div class="point-item">
                            </div>
                            <div class="point-item">
                                <img src="../imgs/AME_O_PROX.png" alt="Parceiros da ONG">
                            </div>
                            <div class="point-item">
                                <img src="../imgs/AJUDA_SOCIAL.png" alt="Apoio Social">
                            </div>
                            <div class="point-item">
                                <img src="../imgs/LAR_DOS_IDOSOS.png" alt="Lar dos Idosos">
                            </div>
                            <div class="point-item">
                                <img src="../imgs/PET_ONG.png" alt="ONG PET">
                            </div>
                            <div class="arrow right-arrow">&gt;</div>
                        </div>
                    </div>
                </div>
                </section>
                <section class="upcoming-events">
                    <div class="container">
                        <div class="section-title-bar">
                            <h2>Eventos próximos</h2>
                        </div>
                        <div class="events-container">

                            <?php if (empty($eventos)): ?>
                                <div class="no-events">
                                    <h3>📅 Nenhum evento encontrado</h3>
                                    <p>No momento não há eventos cadastrados ou ativos.</p>
                                </div>
                            <?php else: ?>
                                <?php foreach ($eventos as $evento): ?>
                                    <div class="event-card">
                                        <img src="<?php echo htmlspecialchars($evento['imagem_url'] ?? '../imgs/AJUDA_SOCIAL.png')?>" 
                                            alt="<?php echo htmlspecialchars($evento['titulo']); ?>">

                                        <div class="event-details">
                                            <h3><?php echo htmlspecialchars($evento['titulo']); ?></h3>
                                
                                            <p><i class="fas fa-map-marker-alt"></i> 
                                            <?php echo htmlspecialchars($evento['endereco']); ?>, 
                                            <?php echo htmlspecialchars($evento['cidade']); ?> - 
                                            <?php echo htmlspecialchars($evento['estado']); ?>, 
                                            <?php echo htmlspecialchars($evento['cep']); ?>
                                            </p>
                                            <p><i class="fas fa-calendar-alt"></i> <?php echo $evento['data_formatada']; ?></p>
                                            <?php if ($evento['valor_inscricao'] > 0): ?>
                                                <p><i class="fas fa-dollar-sign"></i> R$ <?php echo number_format($evento['valor_inscricao'], 2, ',', '.'); ?></p>
                                            <?php endif; ?>
                                            <div class="event-description">
                                                <p><?php echo nl2br(htmlspecialchars($evento['descricao'] ?? 'Sem descrição')); ?></p>
                                            </div>
                                            <a href="inscricao.php?id=<?php echo $evento['id_evento']; ?>" class="details-button">
                                                <?php echo ($evento['valor_inscricao'] > 0) ? 'Inscreva-se!' : 'Participe Gratuitamente!'; ?>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                    </div>
                </section>

        <section class="ongs-destaque">
            <div class="container-ongs">

                <div class="ongs-list">
                    <article class="ong-card featured">
                        <div class="ong-logo logo-ame">
                            <img src="../imgs/AME_O_PROX.png" alt="Logo Ame o Próximo">
                        </div>
                        <div class="ong-content">
                            <div class="ong-title">
                                <h3>Ame o Próximo</h3>
                                <span><img src="../imgs/Alimento l1.png" alt="Verificado"></span>
                                <span><img src="../imgs/Roupa l1.png" alt="Localização"></span>
                            </div>
                            <p class="ong-categories">Alimentos, Roupas</p>
                            <p class="ong-description">
                                A ONG Ame o Próximo nasceu de um gesto: uma simples panela de sopa feita na calçada. O
                                que era uma panela virou uma cozinha comunitária. Hoje, não entregam apenas comida, mas
                                a certeza de que ninguém está sozinho. Cada voluntário prova que amar é doação,
                                transformando a vida de muitos em esperança.
                            </p>
                        </div>
                        <div class="ong-map-area">
                            <img src="../imgs/MAPS L1.png" alt="Mapa da localização" class="map-image">
                            <a href="#" class="btn-visitar">Visitar!</a>
                        </div>
                    </article>

                    <article class="ong-card">
                        <div class="ong-logo logo-pets">
                            <img src="../imgs/PET_ONG.png" alt="Logo Pets Ong">
                        </div>
                        <div class="ong-content">
                            <div class="ong-title">
                                <h3>Pets Ong</h3>
                                <span><img src="../imgs/Pets l2.png" alt="Verificado"></span>
                            </div>
                            <p class="ong-categories">Ração, Caminhas, Brinquedos, Tapetes Higiênicos</p>
                            <p class="ong-description">
                                Somos uma ONG dedicada a transformar a vida de cães de rua e a oferecer um final de vida
                                digno para idosos e com doenças terminais. Realizamos castração e vacinação, lutamos
                                contra o abandono e o sofrimento. Cada vida importa, independente de quem seja. Junte-se
                                a nós e faça parte dessa missão.
                            </p>
                        </div>
                        <div class="ong-map-area">
                            <img src="../imgs/MAPS L1.png" alt="Mapa da localização" class="map-image">
                            <a href="#" class="btn-visitar">Visitar!</a>
                        </div>
                    </article>

                    <article class="ong-card">
                        <div class="ong-logo logo-ajuda">
                            <img src="../imgs/AJUDA_SOCIAL.png" alt="Logo Ajuda Social">
                        </div>
                        <div class="ong-content">
                            <div class="ong-title">
                                <h3>Ajuda Social</h3>
                                <span><img src="../imgs/Alimento l1.png" alt="Verificado"></span>
                                <span><img src="../imgs/Roupa l1.png" alt="Localização"></span>
                                <span><img src="../imgs/HP l2.png" alt="Localização"></span>
                            </div>
                            <p class="ong-categories">Higiene pessoal, Alimentos e roupas</p>
                            <p class="ong-description">
                                A Ajuda Social é uma organização sem fins lucrativos dedicada a oferecer suporte
                                essencial, restabelecer a dignidade e fortalecer famílias em situações de
                                vulnerabilidade. Atuamos como uma ponte sólida entre a generosidade da comunidade e as
                                necessidades daqueles que mais precisam, acreditando que todos merecem uma chance de
                                recomeçar.
                            </p>
                        </div>
                        <div class="ong-map-area">
                            <img src="../imgs/MAPS L1.png" alt="Mapa da localização" class="map-image">
                            <a href="#" class="btn-visitar">Visitar!</a>
                        </div>
                    </article>

                    <article class="ong-card">
                        <div class="ong-logo logo-idosos">
                            <img src="../imgs/LAR_DOS_IDOSOS.png" alt="Logo Lar dos Idosos">
                        </div>
                        <div class="ong-content">
                            <div class="ong-title">
                                <h3>Lar dos Idosos</h3>
                                <span><img src="../imgs/Alimento l1.png" alt="Verificado"></span>
                                <span><img src="../imgs/Roupa l1.png " alt="Localização"></span>
                                <span><img src="../imgs/HP l2.png" alt="Localização"></span>
                            </div>
                            <p class="ong-categories">Higiene pessoal, Alimentos e roupas</p>
                            <p class="ong-description">
                                O Lar dos Idosos, é um refúgio de cuidado e dignidade para a terceira idade. Oferecemos
                                um ambiente seguro e acolhedor, onde cada residente é tratado com respeito e o carinho
                                que merece. Para continuarmos nossa missão de proporcionar bem-estar e alegria, contamos
                                com a sua ajuda. Doe alimentos, itens de higiene pessoal ou seu tempo.
                            </p>
                        </div>
                        <div class="ong-map-area">
                            <img src="../imgs/MAPS L1.png" alt="Mapa da localização" class="map-image">
                            <a href="#" class="btn-visitar">Visitar!</a>
                        </div>
                    </article>

                </div>
            </div>
        </section>
        
            </div>
        </section>
    </main>

</body>

</html>