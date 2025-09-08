<?php
require 'db.php';

$titulo   = $_POST['titulo'] ?? '';
$conteudo = $_POST['conteudo'] ?? '';
$status   = $_POST['status'] ?? 'Inativo';

if (trim($titulo) === '' || trim($conteudo) === '') {
    echo "Erro: Título e conteúdo são obrigatórios.";
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO registros (titulo, conteudo, status) VALUES (:titulo, :conteudo, :status)");
    $stmt->execute([
        ':titulo' => $titulo,
        ':conteudo' => $conteudo,
        ':status' => $status
    ]);
    echo "Registro inserido com sucesso.";
} catch (PDOException $e) {
    echo "Erro ao inserir: " . $e->getMessage();
}
?>
