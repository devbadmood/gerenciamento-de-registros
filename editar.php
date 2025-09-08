<?php
require 'db.php';
require 'helpers.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$titulo = trim($_POST['titulo'] ?? '');
$conteudo = trim($_POST['conteudo'] ?? '');

if ($id <= 0 || $titulo === '' || $conteudo === '') {
    respostaJson('error', 'Todos os campos são obrigatórios.');
}

try {
    $stmt = $pdo->prepare("UPDATE registros SET titulo = :titulo, conteudo = :conteudo WHERE id = :id");
    $stmt->execute([
        ':titulo' => $titulo,
        ':conteudo' => $conteudo,
        ':id' => $id
    ]);
    respostaJson('success', 'Registro atualizado com sucesso.');
} catch (PDOException $e) {
    respostaJson('error', 'Erro ao atualizar: ' . $e->getMessage());
}
