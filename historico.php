<?php
require 'db.php';

$stmt = $pdo->query("
  SELECT h.*, r.titulo AS titulo_atual 
  FROM historico_edicoes h
  LEFT JOIN registros r ON h.registro_id = r.id
  ORDER BY h.editado_em DESC
");
$historico = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Histórico de Edições</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1">Gerenciador de Registros</span>
    <div class="d-flex ms-auto gap-2">
      <a href="index.php" class="btn btn-outline-secondary btn-sm rounded-0">Registrar</a>
      <a href="historico.php" class="btn btn-outline-info btn-sm rounded-0" aria-label="Visualizar histórico de edições">
        <i class="bi bi-clock-history"></i> Histórico
      </a>

      <a href="painel.php" class="btn btn-outline-success btn-sm rounded-0" aria-label="Ver gráficos analíticos">
        <i class="bi bi-bar-chart-line"></i> Gráficos
      </a>
    </div>
  </div>
</nav>


<div class="container mt-4">
  <h3 class="mb-4">Histórico de Edições</h3>

  <?php if (count($historico) === 0): ?>
    <div class="alert alert-warning">Nenhum histórico de edição encontrado.</div>
  <?php else: ?>
    <?php foreach ($historico as $item): ?>
      <div class="card mb-3 shadow-sm">
        <div class="card-header bg-white">
          <strong>Registro #<?= $item['registro_id'] ?></strong> — Editado em <?= date('d/m/Y H:i', strtotime($item['editado_em'])) ?>
        </div>
        <div class="card-body">
          <p><strong>Título anterior:</strong> <?= htmlspecialchars($item['titulo_anterior']) ?></p>
          <p><strong>Conteúdo anterior:</strong><br><?= $item['conteudo_anterior'] ?></p>
          <hr>
          <p class="text-muted"><strong>Título atual:</strong> <?= htmlspecialchars($item['titulo_atual'] ?? 'Registro removido') ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>
</body>
</html>
