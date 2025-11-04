<?php
include_once 'config.php'; // ajuste conforme o nome do seu arquivo de conexão

$consulta = $pdo->query("SELECT dia FROM disponibilidade");
$datas = [];

while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
    $datas[] = $row['dia'];
}

echo json_encode($datas);
?>
