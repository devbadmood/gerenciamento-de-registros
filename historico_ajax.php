<?php
require 'db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
  echo '<div class="alert alert-danger">ID inválido.</div>';
  exit;
}

$stmt = $pdo->prepare("
  SELECT h.*, r.titulo AS titulo_atual 
  FROM historico_edicoes h
  LEFT JOIN registros r ON h.registro_id = r.id
  WHERE h.registro_id = :id
  ORDER BY h.editado_em DESC
");
$stmt->execute([':id' => $id]);
$historico = $stmt->fetchAll();

if (!$historico) {
  echo '<div class="alert alert-warning">Nenhum histórico encontrado para este registro.</div>';
  exit;
}

foreach ($historico as $item) {
  echo '<div class="card mb-3">
    <div class="card-header bg-light">
      <strong>Editado em:</strong> ' . date('d/m/Y H:i', strtotime($item['editado_em'])) . '
    </div>
    <div class="card-body">
      <p><strong>Título anterior:</strong> ' . htmlspecialchars($item['titulo_anterior']) . '</p>
      <p><strong>Conteúdo anterior:</strong><br>' . $item['conteudo_anterior'] . '</p>
      <hr>
      <p class="text-muted"><strong>Título atual:</strong> ' . htmlspecialchars($item['titulo_atual'] ?? 'Registro removido') . '</p>
    </div>
  </div>';
}
