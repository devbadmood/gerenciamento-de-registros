function carregarAtivos(page = 1) {
  $.get('fetch_ativos.php?page=' + page, function (html) {
    $('#area_ativos').html(html);

    $('.page-link-ativos').off('click').on('click', function (e) {
      e.preventDefault();
      const nextPage = $(this).data('page');
      carregarAtivos(nextPage);
    });
  }).fail(function () {
    exibirMensagem('error', 'Erro ao carregar registros ativos.');
  });
}
