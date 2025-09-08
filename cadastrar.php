<?php
require 'db.php';
require 'helpers.php';

// Sanitização e validação
$titulo   = trim($_POST['titulo'] ?? '');
$conteudo = trim($_POST['conteudo'] ?? '');
$status   = $_POST['status'] === 'Inativo' ? 'Inativo' : 'Ativo'; // padrão seguro

if ($titulo === '' || $conteudo === '') {
    respostaJson('error', 'Título e conteúdo são obrigatórios.');
}

// Verificação de duplicidade
$stmt = $pdo->prepare("SELECT COUNT(*) FROM registros WHERE titulo = :titulo");
$stmt->execute([':titulo' => $titulo]);
if ($stmt->fetchColumn() > 0) {
    respostaJson('error', 'Já existe um registro com este título.');
}

// Inserção segura
try {
    $stmt = $pdo->prepare("INSERT INTO registros (titulo, conteudo, status) VALUES (:titulo, :conteudo, :status)");
    $stmt->execute([
        ':titulo' => $titulo,
        ':conteudo' => $conteudo,
        ':status' => $status
    ]);
    respostaJson('success', 'Registro inserido com sucesso.');
} catch (PDOException $e) {
    respostaJson('error', 'Erro ao inserir: ' . $e->getMessage());
}
