<?php require 'db.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Gerenciador de Registros</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1">Gerenciador de Registros</span>
    <div class="d-flex ms-auto">
      <a href="gerenciamento.php" class="btn btn-outline-secondary" aria-label="Ir para gerenciamento">Gerenciar Registros</a>
    </div>
  </div>
</nav>



<div class="container mt-3">
  <div id="mensagem_sistema"></div>

  <!-- Spinner de carregamento -->
  <div id="spinner" style="display:none;" aria-label="Carregando...">
    <div class="text-center"><div class="spinner-border text-primary"></div></div>
  </div>
</div>



<!-- Conteúdo principal -->
<div class="container-fluid mt-5">
  <div class="row">
    <!-- Formulário de cadastro -->
    <div class="col-md-8 mb-4">
      <h4>Cadastro de Registro</h4>
      <form id="form_registro">
        <div class="mb-3">
          <label class="form-label">Título</label>
          <input type="text" name="titulo" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Conteúdo</label>
          <textarea name="conteudo" class="form-control" rows="5" required></textarea>
        </div>
        <div class="form-check mb-2">
          <input class="form-check-input" type="checkbox" id="status_toggle" checked aria-label="Status inicial">
          <label class="form-check-label" for="status_toggle">Status Inicial</label>
          <input type="hidden" name="status" id="status_hidden" value="Ativo">
        </div>
        <div id="status_feedback" class="form-text text-success mb-3">
          Registro será iniciado como <strong>Ativo</strong>.
        </div>
        <button type="submit" class="btn btn-primary" aria-label="Cadastrar registro">Cadastrar</button>
      </form>
    </div>

    <!-- Área de registros ativos -->
    <div class="col-md-4">
      <h4>Registros Ativos</h4>
      <div id="area_ativos"></div>
      <nav class="mt-3">
        <ul id="paginacao_ativos" class="pagination justify-content-center"></ul>
      </nav>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="assets/js/spinner.js"></script>
<script src="assets/js/mensagens.js"></script>
<script src="assets/js/ativos.js"></script>
<script src="assets/js/cadastro.js"></script>

</body>
</html>
