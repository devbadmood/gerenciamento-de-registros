<?php
require 'db.php';

$limit = 3;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Total de registros ativos
try {
    $total_stmt = $pdo->query("SELECT COUNT(*) FROM registros WHERE status = 'Ativo'");
    $total = $total_stmt->fetchColumn();
    $total_pages = ceil($total / $limit);
} catch (PDOException $e) {
    echo json_encode([
        'html' => '<div class="alert alert-danger">Erro ao contar registros: ' . $e->getMessage() . '</div>',
        'total_pages' => 0
    ]);
    exit;
}

// Consulta paginada
try {
    $sql = "SELECT * FROM registros WHERE status = 'Ativo' ORDER BY id DESC LIMIT :start, :limit";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':start', $start, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $registros = $stmt->fetchAll();
} catch (PDOException $e) {
    echo json_encode([
        'html' => '<div class="alert alert-danger">Erro ao buscar registros: ' . $e->getMessage() . '</div>',
        'total_pages' => 0
    ]);
    exit;
}

// Montagem do HTML
$html = '<ul class="list-group mb-4">';
if (count($registros) === 0) {
    $html .= '<li class="list-group-item text-muted text-center">
                <i class="bi bi-info-circle"></i> Nenhum registro ativo encontrado.
              </li>';
} else {
    foreach ($registros as $row) {
        $html .= '<li class="list-group-item">
                    <strong>' . htmlspecialchars($row["titulo"]) . '</strong><br>
                    <small>' . nl2br(htmlspecialchars($row["conteudo"])) . '</small>
                  </li>';
    }
}
$html .= '</ul>';

// Retorno em JSON
echo json_encode([
    'html' => $html,
    'total_pages' => $total_pages
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
