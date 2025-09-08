<?php require 'db.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Gerenciamento de Registros</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
  <h3 class="mb-4">Gerenciar Registros</h3>

  <!-- Mensagens do sistema -->
  <div id="mensagem_sistema"></div>

  <!-- Spinner de carregamento -->
  <div id="spinner" style="display:none;" aria-label="Carregando...">
    <div class="text-center"><div class="spinner-border text-primary"></div></div>
  </div>

  <!-- Filtros -->
  <div class="row mb-3">
    <div class="col-md-4">
      <input type="text" id="filtro_palavra" class="form-control" placeholder="Buscar por título..." aria-label="Buscar por título">
    </div>
    <div class="col-md-3">
      <input type="date" id="filtro_data" class="form-control" aria-label="Filtrar por data">
    </div>
    <div class="col-md-2">
      <button id="btn_filtrar" class="btn btn-outline-primary w-100" aria-label="Aplicar filtros">Filtrar</button>
    </div>
    <div class="col-md-3">
      <a href="exportar_csv.php" class="btn btn-outline-success w-100" aria-label="Exportar registros em CSV">Exportar CSV</a>
    </div>
  </div>

  <!-- Tabela de registros -->
  <table class="table table-bordered table-hover align-middle">
    <thead class="table-light">
      <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Status</th>
        <th>Data</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>

  <!-- Paginação -->
  <nav>
    <ul id="paginacao" class="pagination justify-content-center"></ul>
  </nav>
</div>

<!-- Modal de edição -->
<div class="modal fade" id="modal_editar" tabindex="-1" aria-labelledby="modal_editar_label" aria-hidden="true">
  <div class="modal-dialog">
    <form id="form_editar" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_editar_label">Editar Registro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="editar_id">
        <div class="mb-3">
          <label class="form-label">Título</label>
          <input type="text" name="titulo" id="editar_titulo" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Conteúdo</label>
          <textarea name="conteudo" id="editar_conteudo" class="form-control" rows="4" required></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Salvar alterações</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal de visualização -->
<div class="modal fade" id="modal_visualizar" tabindex="-1" aria-labelledby="modal_visualizar_label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_visualizar_label">Visualizar Registro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <p><strong>Título:</strong> <span id="visualizar_titulo"></span></p>
        <p><strong>Conteúdo:</strong><br><span id="visualizar_conteudo"></span></p>
        <p><strong>Status:</strong> <span id="visualizar_status" class="fw-bold"></span></p>
        <p><strong>Data de criação:</strong> <span id="visualizar_data"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="assets/js/spinner.js"></script>
<script src="assets/js/mensagens.js"></script>
<script src="assets/js/gerenciamento.js"></script>
<script src="assets/js/filtros.js"></script>

</body>
</html>
