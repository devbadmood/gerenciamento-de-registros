<?php require 'db.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Gerenciador de Registros</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="dist/ui/trumbowyg.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-body-secondary">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1">Gerenciador de Registros</span>
    <div class="d-flex ms-auto gap-2">
      <a href="gerenciamento.php" class="btn btn-outline-secondary btn-sm rounded-0" aria-label="Ir para gerenciamento">
        <i class="bi bi-pencil-square"></i> Gerenciar
      </a>
      <a href="historico.php" class="btn btn-outline-info btn-sm rounded-0" aria-label="Visualizar histórico de edições">
        <i class="bi bi-clock-history"></i> Histórico
      </a>

      <a href="painel.php" class="btn btn-outline-success btn-sm rounded-0" aria-label="Ver gráficos analíticos">
        <i class="bi bi-bar-chart-line"></i> Gráficos
      </a>
    </div>
  </div>
</nav>

<div class="container mt-3">
  <div id="mensagem_sistema"></div>
  <div id="spinner" style="display:none;" aria-label="Carregando...">
    <div class="text-center"><div class="spinner-border text-primary"></div></div>
  </div>
</div>

<div class="container-fluid mt-2">
  <div class="row">
    <!-- Formulário de cadastro -->
    <div class="col-md-10 mb-4">
      <h5>Cadastro</h5>
      <form id="form_registro">
        <div class="mb-3">
          <input type="text" name="titulo" class="form-control form-control-sm rounded-0" placeholder="Título" required>
        </div>
        <div class="mb-3 bg-white">
          <textarea name="conteudo" id="trumbowyg-editor" class="form-control" rows="20" placeholder="Conteúdo" required></textarea>
        </div>
        <div class="d-grid gap-2 mx-auto float-end">
          <div class="form-check">
            <div class="input-group">
              <input class="form-check-input rounded-0" type="checkbox" id="status_toggle" checked aria-label="Status inicial">
              <input type="hidden" name="status" id="status_hidden" value="Ativo">
              <div id="status_feedback" class="form-text text-success mx-2">Iniciado <strong>Ativo</strong></div>
              <button type="submit" class="btn btn-primary btn-sm rounded-0" aria-label="Cadastrar registro">Cadastrar</button>
            </div>
          </div>
        </div>
      </form>
    </div>

    <!-- Área de registros ativos -->
    <div class="col-md-2">
      <h5>Ativos</h5>
      <div id="area_ativos"></div>
      <nav class="mt-3 rounded-0">
        <ul id="paginacao_ativos" class="pagination justify-content-center pagination-sm rounded-0"></ul>
      </nav>
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
<script src="assets/js/ativos.js"></script>
<script src="assets/js/cadastro.js"></script>

<script>
  $('#trumbowyg-editor').trumbowyg({
    lang: 'pt_br',
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
    },
    autogrow: true
  });
</script>

</body>
</html>
