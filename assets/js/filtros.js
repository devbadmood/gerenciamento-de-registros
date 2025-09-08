$(document).ready(function () {
  // Aplicar filtros
  $('#btn_filtrar').on('click', function () {
    const palavra = $('#filtro_palavra').val().trim();
    const data = $('#filtro_data').val().trim();
    carregarPagina(1, palavra, data);
  });

  // Enter no campo de busca
  $('#filtro_palavra').on('keypress', function (e) {
    if (e.which === 13) {
      e.preventDefault();
      $('#btn_filtrar').click();
    }
  });

  // Mudança na data
  $('#filtro_data').on('change', function () {
    $('#btn_filtrar').click();
  });

  // Limpar filtros
  $('#btn_limpar').on('click', function () {
    $('#filtro_palavra').val('');
    $('#filtro_data').val('');
    carregarPagina(1); // sem filtros
  });
});
