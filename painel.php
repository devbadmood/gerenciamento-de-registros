<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Painel de Registros</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-body-secondary">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1">Gerenciador de Registros</span>
    <div class="d-flex ms-auto gap-2">
      <a href="index.php" class="btn btn-outline-secondary btn-sm rounded-0">Registrar</a>
      <a href="historico.php" class="btn btn-outline-info btn-sm rounded-0" aria-label="Visualizar histórico de edições">
        <i class="bi bi-clock-history"></i> Histórico
      </a>

      <a href="painel.php" class="btn btn-outline-success btn-sm rounded-0" aria-label="Ver gráficos analíticos">
        <i class="bi bi-bar-chart-line"></i> Gráficos
      </a>
    </div>
  </div>
</nav>
<div class="container">
  

  <h5>Registros por Dia</h5>
  <canvas id="grafico_registros" width="600" height="300"></canvas>
<!-- Content here -->
</div>
  <script>
    fetch('grafico_dados.php')
      .then(res => res.json())
      .then(data => {
        const labels = data.map(item => item.dia);
        const valores = data.map(item => item.total);

        new Chart(document.getElementById('grafico_registros'), {
          type: 'bar',
          data: {
            labels: labels,
            datasets: [{
              label: 'Registros',
              data: valores,
              backgroundColor: 'rgba(54, 162, 235, 0.6)'
            }]
          }
        });
      });
  </script>
</body>
</html>
