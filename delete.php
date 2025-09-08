<?php
require 'db.php';
require 'helpers.php';

$id = isset($_POST['id']) && is_numeric($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    respostaJson('error', 'ID inválido.');
}

try {
    $stmt = $pdo->prepare("DELETE FROM registros WHERE id = :id");
    $stmt->execute([':id' => $id]);
    respostaJson('success', 'Registro excluído com sucesso.');
} catch (PDOException $e) {
    respostaJson('error', 'Erro ao excluir: ' . $e->getMessage());
}
