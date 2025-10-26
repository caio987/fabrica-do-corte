<?php
require_once 'config.php';
header("Content-Type: application/json");
session_start();

if(!isset($_SESSION['id_agendamento'])){
    echo json_encode([]);
    exit;
}

$id_cadastrado = $_SESSION['id_agendamento'];

try {
    $consulta = $pdo->prepare("SELECT * FROM servico WHERE id_estabelecimento = :id");
    $consulta->bindParam(':id', $id_cadastrado);
    $consulta->execute();
    $servicos = $consulta->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($servicos);
} catch(PDOException $e) {
    echo json_encode(['erro' => $e->getMessage()]);
}
?>
