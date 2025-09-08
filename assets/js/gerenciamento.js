function carregarPagina(page = 1, palavra = '', data = '') {
  mostrarSpinner();

  $.get(`fetch_all.php?page=${page}&palavra=${encodeURIComponent(palavra)}&data=${encodeURIComponent(data)}`, function (res) {
    esconderSpinner();

    if (!res || typeof res !== 'object' || !res.html) {
      exibirMensagem('error', 'Erro ao carregar registros.');
      return;
    }

    $('table tbody').html(res.html);
    gerarPaginacao(res.total_pages, page, palavra, data);

    // Eventos: status
    $('.status_toggle').off('change').on('change', function () {
      const id = $(this).data('id');
      const novoStatus = $(this).prop('checked') ? 'Ativo' : 'Inativo';
      const feedbackId = '#status_feedback_' + id;

      $.post('update_status.php', { id, status: novoStatus }, function (res) {
        $(feedbackId)
          .removeClass('text-success text-danger')
          .addClass(novoStatus === 'Ativo' ? 'text-success' : 'text-danger')
          .html(`Status atualizado para <strong>${novoStatus}</strong>.`);
        exibirMensagem(res.status, res.message);
      }, 'json');
    });

    // Eventos: excluir
    $('.delete').off('click').on('click', function () {
      const id = $(this).data('id');
      if (confirm('Deseja excluir este registro?')) {
        $.post('delete.php', { id }, function (res) {
          exibirMensagem(res.status, res.message);
          carregarPagina(page, palavra, data);
        }, 'json');
      }
    });

    // Eventos: editar
    $('.editar').off('click').on('click', function () {
      $('#editar_id').val($(this).data('id'));
      $('#editar_titulo').val($(this).data('titulo'));
      $('#editar_conteudo').val($(this).data('conteudo'));

      const modal = new bootstrap.Modal(document.getElementById('modal_editar'));
      modal.show();
    });

    // Eventos: visualizar
    $('.visualizar').off('click').on('click', function () {
      $('#visualizar_titulo').text($(this).data('titulo'));
      $('#visualizar_conteudo').html($(this).data('conteudo').replace(/\n/g, '<br>'));
      $('#visualizar_status')
        .text($(this).data('status'))
        .removeClass('text-success text-danger')
        .addClass($(this).data('status') === 'Ativo' ? 'text-success' : 'text-danger');
      $('#visualizar_data').text($(this).data('data'));

      const modal = new bootstrap.Modal(document.getElementById('modal_visualizar'));
      modal.show();
    });
  }, 'json').fail(function () {
    esconderSpinner();
    exibirMensagem('error', 'Falha na comunicação com o servidor.');
  });
}

function gerarPaginacao(totalPages, currentPage, palavra, data) {
  const $paginacao = $('#paginacao');
  $paginacao.empty();

  for (let i = 1; i <= totalPages; i++) {
    const active = i === currentPage ? 'active' : '';
    const item = $(`
      <li class="page-item ${active}">
        <a href="#" class="page-link" data-page="${i}" aria-label="Página ${i}">${i}</a>
      </li>
    `);
    item.on('click', function (e) {
      e.preventDefault();
      carregarPagina($(this).find('.page-link').data('page'), palavra, data);
    });
    $paginacao.append(item);
  }
}

$(document).ready(function () {
  carregarPagina();

  $('#btn_filtrar').on('click', function () {
    const palavra = $('#filtro_palavra').val();
    const data = $('#filtro_data').val();
    carregarPagina(1, palavra, data);
  });

  $('#form_editar').on('submit', function (e) {
    e.preventDefault();
    mostrarSpinner();

    $.post('editar.php', $(this).serialize(), function (res) {
      esconderSpinner();
      exibirMensagem(res.status, res.message);

      if (res.status === 'success') {
        const palavra = $('#filtro_palavra').val();
        const data = $('#filtro_data').val();
        carregarPagina(1, palavra, data);
        bootstrap.Modal.getInstance(document.getElementById('modal_editar')).hide();
      }
    }, 'json').fail(function () {
      esconderSpinner();
      exibirMensagem('error', 'Erro ao salvar alterações.');
    });
  });
});
