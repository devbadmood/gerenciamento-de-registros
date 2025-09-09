<?php
require 'db.php';
require 'helpers.php';

// Captura e validação dos dados
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$titulo = trim($_POST['titulo'] ?? '');
$conteudo = trim($_POST['conteudo'] ?? '');

// Validação básica
if ($id <= 0 || $titulo === '' || $conteudo === '') {
    respostaJson('error', 'Todos os campos são obrigatórios.');
}

// Opcional: sanitização leve (remova se quiser preservar tudo)
function limparConteudo($html) {
    // Permite tags comuns de formatação e código
    return strip_tags($html, '<p><br><strong><em><ul><ol><li><a><img><h1><h2><h3><blockquote><pre><code>');
}

// Se quiser preservar tudo que o Trumbowyg envia, com responsabilidade, comente a linha abaixo:
$conteudo = limparConteudo($conteudo);

try {
    $stmt = $pdo->prepare("
        UPDATE registros 
        SET titulo = :titulo, conteudo = :conteudo, atualizado_em = NOW() 
        WHERE id = :id
    ");
    $stmt->execute([
        ':titulo' => $titulo,
        ':conteudo' => $conteudo,
        ':id' => $id
    ]);

    respostaJson('success', 'Registro atualizado com sucesso.');
} catch (PDOException $e) {
    respostaJson('error', 'Erro ao atualizar: ' . $e->getMessage());
}
