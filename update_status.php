<?php
require 'db.php';
require 'helpers.php';

$id     = isset($_POST['id']) && is_numeric($_POST['id']) ? (int)$_POST['id'] : 0;
$status = $_POST['status'] ?? '';

if ($id <= 0 || !in_array($status, ['Ativo', 'Inativo'])) {
    respostaJson('error', 'Dados inválidos.');
}

try {
    $stmt = $pdo->prepare("UPDATE registros SET status = :status WHERE id = :id");
    $stmt->execute([':status' => $status, ':id' => $id]);
    respostaJson('success', "Status atualizado para $status.");
} catch (PDOException $e) {
    respostaJson('error', 'Erro ao atualizar: ' . $e->getMessage());
}
