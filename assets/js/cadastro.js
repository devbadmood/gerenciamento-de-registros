$(document).ready(function () {
  $('#form_registro').on('submit', function (e) {
    e.preventDefault();

    const dados = $(this).serialize();
    mostrarSpinner();

    $.post('cadastrar.php', dados, function (res) {
      esconderSpinner();

      if (!res || typeof res !== 'object') {
        exibirMensagem('error', 'Resposta inválida do servidor.');
        return;
      }

      exibirMensagem(res.status, res.message);

      if (res.status === 'success') {
        $('#form_registro')[0].reset();
        $('#status_toggle').prop('checked', true);
        $('#status_hidden').val('Ativo');
        $('#status_feedback')
          .removeClass('text-danger')
          .addClass('text-success')
          .html('Registro será iniciado como <strong>Ativo</strong>.');
        setTimeout(() => carregarAtivos(), 300);
      }
    }, 'json').fail(function () {
      esconderSpinner();
      exibirMensagem('error', 'Erro ao enviar o formulário.');
    });
  });

  $('#status_toggle').change(function () {
    const checked = $(this).prop('checked');
    const status = checked ? 'Ativo' : 'Inativo';
    const classe = checked ? 'text-success' : 'text-danger';
    $('#status_hidden').val(status);
    $('#status_feedback')
      .removeClass('text-success text-danger')
      .addClass(classe)
      .html(`Registro será iniciado como <strong>${status}</strong>.`);
  });

  if ($('#area_ativos').length) {
    carregarAtivos();
  }
});
