function carregarAtivos(page = 1) {
  mostrarSpinner();

  $.get(`fetch_ativos.php?page=${page}`, function (res) {
    esconderSpinner();

    if (!res || typeof res !== 'object' || !res.html) {
      exibirMensagem('error', 'Resposta inválida do servidor.');
      return;
    }

    $('#area_ativos').hide().html(res.html).fadeIn(200);
    gerarPaginacaoAtivos(res.total_pages, page);
  }, 'json').fail(function () {
    esconderSpinner();
    exibirMensagem('error', 'Erro ao carregar registros ativos.');
  });
}

function gerarPaginacaoAtivos(totalPages, currentPage) {
  const $paginacao = $('#paginacao_ativos');
  $paginacao.empty();

  const maxVisible = 3;
  let startPage = Math.max(1, currentPage - Math.floor(maxVisible / 2));
  let endPage = startPage + maxVisible - 1;

  if (endPage > totalPages) {
    endPage = totalPages;
    startPage = Math.max(1, endPage - maxVisible + 1);
  }

  // Botão "Anterior"
  if (currentPage > 1) {
    const anterior = $(`
      <li class="page-item">
        <a href="#" class="page-link" data-page="${currentPage - 1}" aria-label="Anterior">&laquo;</a>
      </li>
    `);
    anterior.on('click', function (e) {
      e.preventDefault();
      carregarAtivos(currentPage - 1);
    });
    $paginacao.append(anterior);
  }

  // Page items visíveis
  for (let i = startPage; i <= endPage; i++) {
    const active = i === currentPage ? 'active' : '';
    const item = $(`
      <li class="page-item ${active}">
        <a href="#" class="page-link" data-page="${i}" aria-label="Página ${i}">${i}</a>
      </li>
    `);
    item.on('click', function (e) {
      e.preventDefault();
      carregarAtivos(i);
    });
    $paginacao.append(item);
  }

  // Botão "Próxima"
  if (currentPage < totalPages) {
    const proxima = $(`
      <li class="page-item">
        <a href="#" class="page-link" data-page="${currentPage + 1}" aria-label="Próxima">&raquo;</a>
      </li>
    `);
    proxima.on('click', function (e) {
      e.preventDefault();
      carregarAtivos(currentPage + 1);
    });
    $paginacao.append(proxima);
  }
}

$(document).ready(function () {
  carregarAtivos();
});
