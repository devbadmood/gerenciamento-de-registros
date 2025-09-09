<?php
require 'db.php';

// Ativar exibição de erros para debug (remova em produção)
ini_set('display_errors', 1);
error_reporting(E_ALL);

$limit = 5;
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

try {
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
        $mensagem = 'Nenhum registro disponível.';
        if ($palavra !== '') {
            $mensagem = 'Nenhum registro com o título "<strong>' . htmlspecialchars($palavra, ENT_QUOTES) . '</strong>" foi encontrado.';
        } elseif ($data !== '') {
            $mensagem = 'Nenhum registro encontrado na data <strong>' . htmlspecialchars($data, ENT_QUOTES) . '</strong>.';
        }

        $html = '<tr><td colspan="5" class="text-center text-muted">' . $mensagem . '</td></tr>';
    } else {
        foreach ($registros as $row) {
            $checked = ($row["status"] === "Ativo") ? "checked" : "";
            $statusClass = ($row["status"] === "Ativo") ? "text-success" : "text-danger";

            $html .= '<tr>
                <td>' . htmlspecialchars($row["id"]) . '</td>
                <td>' . htmlspecialchars($row["titulo"], ENT_QUOTES) . '</td>
                <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input status_toggle" type="checkbox" role="switch"
                            data-id="' . $row["id"] . '" ' . $checked . '>
                    </div>
                    <div id="status_feedback_' . $row["id"] . '" class="form-text ' . $statusClass . '">
                        Status atual: <strong>' . htmlspecialchars($row["status"]) . '</strong>.
                    </div>
                </td>
                <td>' . htmlspecialchars($row["criado_em"]) . '</td>
                <td>
                    <div class="btn-group btn-group-sm float-end" role="group">
                        <button class="btn btn-outline-info visualizar"
                            data-id="' . $row["id"] . '"
                            data-titulo="' . htmlspecialchars($row["titulo"], ENT_QUOTES) . '"
                            data-conteudo="' . htmlspecialchars($row["conteudo"], ENT_QUOTES) . '"
                            data-status="' . htmlspecialchars($row["status"]) . '"
                            data-data="' . htmlspecialchars($row["criado_em"]) . '">Visualizar</button>

                        <button class="btn btn-outline-warning editar"
                            data-id="' . $row["id"] . '"
                            data-titulo="' . htmlspecialchars($row["titulo"], ENT_QUOTES) . '"
                            data-conteudo="' . $row["conteudo"] . '">Editar</button>

                        <button class="btn btn-outline-danger delete"
                            data-id="' . $row["id"] . '">Excluir</button>

                        <button class="btn btn-outline-secondary historico"
                            data-id="' . $row["id"] . '">Histórico</button>
                    </div>
                </td>
            </tr>';
        }
    }

    echo json_encode([
        'html' => $html,
        'total_pages' => $total_pages
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} catch (PDOException $e) {
    echo json_encode([
        'html' => '<tr><td colspan="5" class="text-danger text-center">Erro: ' . $e->getMessage() . '</td></tr>',
        'total_pages' => 0
    ]);
}
