<?php
function respostaJson($status, $mensagem, $dados = []) {
    header('Content-Type: application/json; charset=utf-8');

    // Garante que o status seja apenas 'success' ou 'error'
    $status = ($status === 'success') ? 'success' : 'error';

    echo json_encode([
        'status' => $status,
        'message' => $mensagem,
        'data' => $dados
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}
