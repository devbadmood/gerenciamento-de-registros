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

    // Atualizar status
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

    // Excluir registro
    $('.delete').off('click').on('click', function () {
      const id = $(this).data('id');
      if (confirm('Deseja excluir este registro?')) {
        $.post('delete.php', { id }, function (res) {
          exibirMensagem(res.status, res.message);
          carregarPagina(page, palavra, data);
        }, 'json');
      }
    });

    // Editar registro
    $('.editar').off('click').on('click', function () {
      $('#editar_id').val($(this).data('id'));
      $('#editar_titulo').val($(this).data('titulo'));
      $('#editar_conteudo').val($(this).data('conteudo'));

      const modal = new bootstrap.Modal(document.getElementById('modal_editar'));
      modal.show();
    });

    // Visualizar registro
$('.visualizar').off('click').on('click', function () {
  console.log('Título:', $(this).data('titulo')); // Verifique se aparece corretamente

  const titulo = $(this).data('titulo');
  const conteudo = $(this).data('conteudo');
  const texto = typeof conteudo === 'string' ? conteudo : String(conteudo);

  $('#visualizar_titulo').text(typeof titulo === 'string' ? titulo : String(titulo));
  $('#visualizar_conteudo').html(texto.replace(/\n/g, '<br>'));
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

  const maxVisible = 5;
  let startPage = Math.max(1, currentPage - Math.floor(maxVisible / 2));
  let endPage = startPage + maxVisible - 1;

  if (endPage > totalPages) {
    endPage = totalPages;
    startPage = Math.max(1, endPage - maxVisible + 1);
  }

  if (currentPage > 1) {
    $paginacao.append(`
      <li class="page-item">
        <a href="#" class="page-link" data-page="${currentPage - 1}" aria-label="Anterior">&laquo;</a>
      </li>
    `);
  }

  for (let i = startPage; i <= endPage; i++) {
    const active = i === currentPage ? 'active' : '';
    const item = $(`
      <li class="page-item ${active}">
        <a href="#" class="page-link" data-page="${i}" aria-label="Página ${i}">${i}</a>
      </li>
    `);
    item.on('click', function (e) {
      e.preventDefault();
      carregarPagina(i, palavra, data);
    });
    $paginacao.append(item);
  }

   if (currentPage < totalPages) {
    $paginacao.append(`
      <li class="page-item">
        <a href="#" class="page-link" data-page="${currentPage + 1}" aria-label="Próxima">&raquo;</a>
      </li>
    `);
  }
}

$(document).ready(function () {
  carregarPagina();

  $('#btn_filtrar').on('click', function () {
    const palavra = $('#filtro_palavra').val();
    const data = $('#filtro_data').val();
    carregarPagina(1, palavra, data);
  });

  $('#btn_limpar').on('click', function () {
    $('#filtro_palavra').val('');
    $('#filtro_data').val('');
    carregarPagina(1);
  });

  $('#filtro_palavra').on('keypress', function (e) {
    if (e.which === 13) {
      e.preventDefault();
      $('#btn_filtrar').click();
    }
  });

  $('#filtro_data').on('change', function () {
    $('#btn_filtrar').click();
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
