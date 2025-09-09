<?php
require 'db.php';
require 'vendor/autoload.php';

use Dompdf\Dompdf;

$palavra = trim($_GET['palavra'] ?? '');
$data = trim($_GET['data'] ?? '');

$sql = "SELECT * FROM registros WHERE 1";
$params = [];

if ($palavra !== '') {
    $sql .= " AND titulo LIKE :palavra";
    $params[':palavra'] = "%$palavra%";
}
if ($data !== '') {
    $sql .= " AND DATE(criado_em) = :data";
    $params[':data'] = $data;
}

$sql .= " ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$registros = $stmt->fetchAll();

$html = '<h2>Registros</h2><table border="1" cellpadding="5" cellspacing="0" width="100%">';
$html .= '<tr><th>ID</th><th>Título</th><th>Status</th><th>Data</th></tr>';
foreach ($registros as $row) {
    $html .= '<tr>
        <td>' . $row['id'] . '</td>
        <td>' . $row['titulo'] . '</td>
        <td>' . $row['status'] . '</td>
        <td>' . $row['criado_em'] . '</td>
    </tr>';
}
$html .= '</table>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("registros.pdf", ["Attachment" => true]);
