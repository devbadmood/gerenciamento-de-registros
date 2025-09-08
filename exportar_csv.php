<?php
require 'db.php';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=registros.csv');

$output = fopen('php://output', 'w');
fputcsv($output, ['ID', 'Título', 'Conteúdo', 'Status', 'Criado em', 'Atualizado em']);

$stmt = $pdo->query("SELECT * FROM registros ORDER BY id DESC");
while ($row = $stmt->fetch()) {
    fputcsv($output, [
        $row['id'],
        $row['titulo'],
        $row['conteudo'],
        $row['status'],
        $row['criado_em'],
        $row['atualizado_em'] ?? ''
    ]);
}
fclose($output);
