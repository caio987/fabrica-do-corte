<?php
    require_once 'config.php';
    session_start();

    $id_agendamento = $_SESSION['id_agendamento'];
    try {
        //Pegar informações da disponibilidade do estabelecimento
        $consulta = $pdo->prepare("SELECT * FROM disponibilidade WHERE id_estabelecimento = :id_agendamento");
        $consulta->bindParam('id_agendamento', $id_agendamento);
        $consulta->execute();
        $disponibilidade = $consulta->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($disponibilidade);
    } catch (PDOException $e) {
        echo json_encode($e->getMessage());
    }

?>