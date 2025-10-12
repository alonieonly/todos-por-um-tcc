<?php
// teste_eventos.php
require_once '../app/config/conex.php';

$database = new Database();
$pdo = $database->getConnection();

echo "<h2>Debug - Eventos no Banco</h2>";

// Teste 1: Contar todos os eventos
$sql1 = "SELECT COUNT(*) as total FROM eventos";
$stmt1 = $pdo->query($sql1);
$total = $stmt1->fetch(PDO::FETCH_ASSOC);
echo "<p>Total de eventos no banco: " . $total['total'] . "</p>";

// Teste 2: Ver eventos com status ativo
$sql2 = "SELECT COUNT(*) as ativos FROM eventos WHERE status = 'ativo'";
$stmt2 = $pdo->query($sql2);
$ativos = $stmt2->fetch(PDO::FETCH_ASSOC);
echo "<p>Eventos com status 'ativo': " . $ativos['ativos'] . "</p>";

// Teste 3: Ver eventos com data futura
$sql3 = "SELECT COUNT(*) as futuros FROM eventos WHERE data_evento >= CURDATE()";
$stmt3 = $pdo->query($sql3);
$futuros = $stmt3->fetch(PDO::FETCH_ASSOC);
echo "<p>Eventos com data futura: " . $futuros['futuros'] . "</p>";

// Teste 4: Ver eventos que atendem ambos os critérios
$sql4 = "SELECT COUNT(*) as validos FROM eventos WHERE status = 'ativo' AND data_evento >= CURDATE()";
$stmt4 = $pdo->query($sql4);
$validos = $stmt4->fetch(PDO::FETCH_ASSOC);
echo "<p>Eventos ativos e com data futura: " . $validos['validos'] . "</p>";

// Teste 5: Mostrar todos os eventos detalhadamente
echo "<h3>Detalhes de TODOS os eventos:</h3>";
$sql5 = "SELECT id_evento, titulo, status, data_evento, DATE_FORMAT(data_evento, '%d/%m/%Y') as data_formatada FROM eventos ORDER BY data_evento";
$stmt5 = $pdo->query($sql5);
$todosEventos = $stmt5->fetchAll(PDO::FETCH_ASSOC);

echo "<table border='1' cellpadding='5'>";
echo "<tr><th>ID</th><th>Título</th><th>Status</th><th>Data Evento</th><th>Data Formatada</th></tr>";
foreach ($todosEventos as $evento) {
    echo "<tr>";
    echo "<td>" . $evento['id_evento'] . "</td>";
    echo "<td>" . $evento['titulo'] . "</td>";
    echo "<td>" . $evento['status'] . "</td>";
    echo "<td>" . $evento['data_evento'] . "</td>";
    echo "<td>" . $evento['data_formatada'] . "</td>";
    echo "</tr>";
}
echo "</table>";
?>