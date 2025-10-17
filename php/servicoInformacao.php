<?php
require_once'config.php';
session_start();
$id = $_SESSION['id'];
    header("content-type: application/json");
    $consulta = $pdo->query("SELECT * FROM servico WHERE id_estabelecimento = $id");
    $servicos = $consulta->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($servicos);
?>