<?php
require 'db.php';
require 'helpers.php';

// Função opcional para sanitização leve (permite tags seguras)
function limparConteudo($html) {
    return strip_tags($html, '<p><br><strong><em><ul><ol><li><a><img><h1><h2><h3><blockquote><pre><code>');
}

// Captura e validação dos dados
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$titulo = trim($_POST['titulo'] ?? '');
$conteudo = trim($_POST['conteudo'] ?? '');

if ($id <= 0 || $titulo === '' || $conteudo === '') {
    respostaJson('error', 'Todos os campos são obrigatórios.');
}

// Se quiser preservar tudo que o Trumbowyg envia, comente a linha abaixo
$conteudo = limparConteudo($conteudo);

try {
    // Salvar histórico antes de atualizar
    $stmt = $pdo->prepare("SELECT titulo, conteudo FROM registros WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $atual = $stmt->fetch();

    if ($atual) {
        $stmt = $pdo->prepare("
            INSERT INTO historico_edicoes (registro_id, titulo_anterior, conteudo_anterior)
            VALUES (:id, :titulo, :conteudo)
        ");
        $stmt->execute([
            ':id' => $id,
            ':titulo' => $atual['titulo'],
            ':conteudo' => $atual['conteudo']
        ]);
    }

    // Atualizar registro principal
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
