<?php
$conn = new mysqli("localhost", "root", "", "ativar-desativar-registro-v0.1");

$result = $conn->query("SELECT * FROM registros WHERE status = 'Ativo' ORDER BY id DESC");

echo '<h4>Registros Ativos</h4>';
echo '<table class="table table-bordered">
<tr><th>ID</th><th>Título</th><th>Conteúdo</th><th>Status</th><th>Data</th><th>Ações</th></tr>';

while($row = $result->fetch_assoc()){
  echo '<tr>
    <td>'.$row["id"].'</td>
    <td>'.$row["titulo"].'</td>
    <td>'.$row["conteudo"].'</td>
    <td>'.$row["status"].'</td>
    <td>'.$row["criado_em"].'</td>
    <td>
      <input type="checkbox" class="status_toggle" data-id="'.$row["id"].'" checked
        data-toggle="toggle" data-on="Ativo" data-off="Inativo"
        data-onstyle="success" data-offstyle="danger">
      <button class="btn btn-danger btn-sm delete" data-id="'.$row["id"].'">Excluir</button>
    </td>
  </tr>';
}

echo '</table>';
$conn->close();
?>
