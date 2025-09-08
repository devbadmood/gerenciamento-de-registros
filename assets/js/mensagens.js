function exibirMensagem(tipo, texto, duracao = 5000) {
  const classe = tipo === 'success' ? 'alert-success' : 'alert-danger';

  const mensagem = $(`
    <div class="alert ${classe} alert-dismissible fade" role="alert" style="opacity:0; transform:translateY(-10px); transition:all 0.5s ease;">
      ${texto}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
  `);

  $('#mensagem_sistema').html(mensagem);

  // Animação de entrada
  setTimeout(() => {
    mensagem.addClass('show');
    mensagem.css({ opacity: 1, transform: 'translateY(0)' });
  }, 50);

  // Expiração automática
  setTimeout(() => {
    mensagem.removeClass('show');
    mensagem.css({ opacity: 0, transform: 'translateY(-10px)' });

    // Remoção após animação
    setTimeout(() => mensagem.remove(), 500);
  }, duracao);
}

