<?php
require 'db.php';

$conteudo_edicao = '';
$titulo_edicao = '';
$id_edicao = isset($_GET['editar_id']) ? (int)$_GET['editar_id'] : 0;

if ($id_edicao > 0) {
    $stmt = $pdo->prepare("SELECT titulo, conteudo FROM registros WHERE id = :id");
    $stmt->execute([':id' => $id_edicao]);
    $registro = $stmt->fetch();

    if ($registro) {
        $titulo_edicao = $registro['titulo'];
        $conteudo_edicao = $registro['conteudo'];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Gerenciamento de Registros</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="dist/ui/trumbowyg.min.css">
</head>
<body class="bg-body-secondary">

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1">Gerenciador de Registros</span>
    <div class="d-flex ms-auto">
      <a href="index.php" class="btn btn-outline-secondary btn-sm rounded-0">Registrar</a>
    </div>
  </div>
</nav>

<div class="container mt-2">
  <h5 class="mb-2">Registros</h5>
  <div id="mensagem_sistema"></div>
  <div id="spinner" style="display:none;">
    <div class="text-center"><div class="spinner-border text-primary"></div></div>
  </div>

  <div class="row mb-3">
    <div class="btn-group btn-group-sm" role="group">
      <input type="text" id="filtro_palavra" class="form-control form-control-sm" placeholder="Buscar por título...">
      <input type="date" id="filtro_data" class="form-control form-control-sm">
      <button id="btn_filtrar" class="btn btn-outline-primary w-100">Filtrar</button>
      <button id="btn_limpar" class="btn btn-outline-secondary w-50">Limpar</button>
      <a href="exportar_csv.php" class="btn btn-outline-success w-50">Exportar CSV</a>
    </div>
  </div>

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

  <nav>
    <ul id="paginacao" class="pagination justify-content-center pagination-sm"></ul>
  </nav>
</div>

<!-- Modal de edição -->
<div class="modal fade" id="modal_editar" tabindex="-1" aria-labelledby="modal_editar_label" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <form id="form_editar" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_editar_label">Editar Registro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="editar_id" value="<?= $id_edicao ?>">
        <div class="mb-3">
          <label class="form-label">Título</label>
          <input type="text" name="titulo" id="editar_titulo" class="form-control" required value="<?= htmlspecialchars($titulo_edicao) ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Conteúdo</label>
          <textarea name="conteudo" id="editar_conteudo" class="form-control" rows="10" required><?= $conteudo_edicao ?></textarea>
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
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_visualizar_label">Visualizar Registro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
<script src="dist/trumbowyg.min.js"></script>
<script src="dist/langs/pt_br.min.js"></script>
<script src="dist/plugins/upload/trumbowyg.upload.min.js"></script>
<script src="//rawcdn.githack.com/RickStrahl/jquery-resizable/0.35/dist/jquery-resizable.min.js"></script>
<script src="dist/plugins/resizimg/trumbowyg.resizimg.min.js"></script>

<script src="assets/js/spinner.js"></script>
<script src="assets/js/mensagens.js"></script>
<script src="assets/js/gerenciamento.js"></script>
<script src="assets/js/filtros.js"></script>

<script>
  // Inicializa Trumbowyg dinamicamente ao abrir o modal
  document.addEventListener('shown.bs.modal', function (event) {
    const modal = event.target;
    if (modal.id === 'modal_editar') {
      const $editor = $('#editar_conteudo');

      if ($editor.hasClass('trumbowyg-editor')) {
        $editor.trumbowyg('destroy');
      }

      $editor.trumbowyg({
        lang: 'pt_br',
        autogrow: true,
        btns: [
          ['viewHTML'],
          ['undo', 'redo'],
          ['formatting'],
          ['strong', 'em', 'del'],
          ['superscript', 'subscript'],
          ['link'],
          ['insertImage'],
          ['upload'],
          ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
          ['unorderedList', 'orderedList'],
          ['horizontalRule'],
          ['removeformat'],
          ['fullscreen']
        ],
        plugins: {
          upload: {
            serverPath: './upload.php',
            fileFieldName: 'image',
            headers: {
              'Authorization': 'Client-ID xxxxxxxxxxxx'
            },
            urlPropertyName: 'file'
          },
          resizimg: {
            minSize: 64,
            step: 16
          }
        }
      });
    }
  });

  // Abre o modal automaticamente se editar_id estiver na URL
  $(document).ready(function () {
    const params = new URLSearchParams(window.location.search);
    if (params.has('editar_id')) {
      const modal = new bootstrap.Modal(document.getElementById('modal_editar'));
      modal.show();
    }
  });
</script>

</body>
</html>
