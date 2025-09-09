<?php
require 'db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'ID inválido.']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT titulo, conteudo FROM registros WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $registro = $stmt->fetch();

    if ($registro) {
        echo json_encode([
            'status' => 'success',
            'titulo' => $registro['titulo'],
            'conteudo' => $registro['conteudo']
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Registro não encontrado.']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erro: ' . $e->getMessage()]);
}
