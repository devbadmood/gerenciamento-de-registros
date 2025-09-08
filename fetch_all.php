<?php
require 'db.php';

$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$palavra = trim($_GET['palavra'] ?? '');
$data = trim($_GET['data'] ?? '');

$sql = "SELECT * FROM registros WHERE 1";
$count_sql = "SELECT COUNT(*) FROM registros WHERE 1";
$params = [];

if ($palavra !== '') {
    $sql .= " AND titulo LIKE :palavra";
    $count_sql .= " AND titulo LIKE :palavra";
    $params[':palavra'] = "%$palavra%";
}

if ($data !== '') {
    $sql .= " AND DATE(criado_em) = :data";
    $count_sql .= " AND DATE(criado_em) = :data";
    $params[':data'] = $data;
}

$sql .= " ORDER BY id DESC LIMIT :start, :limit";
$stmt = $pdo->prepare($sql);
foreach ($params as $key => $val) {
    $stmt->bindValue($key, $val);
}
$stmt->bindValue(':start', $start, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();
$registros = $stmt->fetchAll();

$count_stmt = $pdo->prepare($count_sql);
foreach ($params as $key => $val) {
    $count_stmt->bindValue($key, $val);
}
$count_stmt->execute();
$total = $count_stmt->fetchColumn();
$total_pages = ceil($total / $limit);

$html = '';
if (count($registros) === 0) {
    if ($palavra !== '') {
        $html = '<tr><td colspan="5" class="text-center text-muted">Nenhum registro com o título "<strong>' . htmlspecialchars($palavra) . '</strong>" foi encontrado.</td></tr>';
    } elseif ($data !== '') {
        $html = '<tr><td colspan="5" class="text-center text-muted">Nenhum registro encontrado na data <strong>' . htmlspecialchars($data) . '</strong>.</td></tr>';
    } else {
        $html = '<tr><td colspan="5" class="text-center text-muted">Nenhum registro disponível.</td></tr>';
    }
} else {
    foreach ($registros as $row) {
        $checked = ($row["status"] === "Ativo") ? "checked" : "";
        $statusClass = ($row["status"] === "Ativo") ? "text-success" : "text-danger";

        $html .= '<tr>
          <td>' . htmlspecialchars($row["id"]) . '</td>
          <td>' . htmlspecialchars($row["titulo"]) . '</td>
          <td>
            <div class="form-check form-switch">
              <input class="form-check-input status_toggle" type="checkbox" role="switch"
                data-id="' . $row["id"] . '" ' . $checked . '>
            </div>
            <div id="status_feedback_' . $row["id"] . '" class="form-text ' . $statusClass . '">
              Status atual: <strong>' . $row["status"] . '</strong>.
            </div>
          </td>
          <td>' . htmlspecialchars($row["criado_em"]) . '</td>
          <td>
            <button class="btn btn-sm btn-outline-info visualizar"
              data-id="' . $row["id"] . '"
              data-titulo="' . htmlspecialchars($row["titulo"]) . '"
              data-conteudo="' . htmlspecialchars($row["conteudo"]) . '"
              data-status="' . $row["status"] . '"
              data-data="' . $row["criado_em"] . '">Visualizar</button>
            <button class="btn btn-sm btn-outline-warning editar"
              data-id="' . $row["id"] . '"
              data-titulo="' . htmlspecialchars($row["titulo"]) . '"
              data-conteudo="' . htmlspecialchars($row["conteudo"]) . '">Editar</button>
            <button class="btn btn-sm btn-outline-danger delete" data-id="' . $row["id"] . '">Excluir</button>
          </td>
        </tr>';
    }
}

echo json_encode([
  'html' => $html,
  'total_pages' => $total_pages
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
