<?php
require 'db.php';

$stmt = $pdo->query("SELECT DATE(criado_em) as dia, COUNT(*) as total FROM registros GROUP BY dia ORDER BY dia ASC");
$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($dados);
