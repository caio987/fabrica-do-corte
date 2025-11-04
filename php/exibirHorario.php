<?php
    require_once 'config.php';
    $input = json_decode(file_get_contents("php://input"), true);
    $dia = $input['dia'];
    try {
        $consulta = $pdo->prepare("SELECT id_disponibilidade,horario FROM disponibilidade WHERE dia = :dia");
        $consulta->bindParam(':dia', $dia);
        $consulta->execute();
        $horario = $consulta->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($horario);
    } catch (\Throwable $th) {
        //throw $th;
    }
?>