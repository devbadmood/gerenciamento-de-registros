<?php
require 'db.php';

$limit = 3;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Total de registros ativos
$total_stmt = $pdo->query("SELECT COUNT(*) FROM registros WHERE status = 'Ativo'");
$total = $total_stmt->fetchColumn();
$total_pages = ceil($total / $limit);

// Consulta paginada
$sql = "SELECT * FROM registros WHERE status = 'Ativo' ORDER BY id DESC LIMIT :start, :limit";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':start', $start, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();
$registros = $stmt->fetchAll();

// Renderização
echo '<ul class="list-group mb-4">';
if (count($registros) === 0) {
    echo '<li class="list-group-item text-muted">Nenhum registro ativo encontrado.</li>';
} else {
    foreach ($registros as $row) {
        echo '<li class="list-group-item">
            <strong>' . htmlspecialchars($row["titulo"]) . '</strong><br>
            <small>' . nl2br(htmlspecialchars($row["conteudo"])) . '</small>
        </li>';
    }
}
echo '</ul>';

// Paginação
if ($total_pages > 1) {
    echo '<nav aria-label="Paginação de registros ativos"><ul class="pagination justify-content-center">';
    for ($i = 1; $i <= $total_pages; $i++) {
        $active = ($i === $page) ? 'active' : '';
        echo '<li class="page-item ' . $active . '">
                <a href="#" class="page-link page-link-ativos" data-page="' . $i . '" aria-label="Página ' . $i . '">' . $i . '</a>
              </li>';
    }
    echo '</ul></nav>';
}
