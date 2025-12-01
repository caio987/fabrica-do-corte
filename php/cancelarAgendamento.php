<?php
    require_once 'config.php';

    $id = $_GET['id'];
    
    try {
        $excluirAgendamentoServico = $pdo->prepare("DELETE FROM agendamento_servico WHERE id_agendamento = :id");
        $excluirAgendamentoServico->bindParam(':id', $id);
        $excluirAgendamentoServico->execute();
        
        $excluirAgendamento = $pdo->prepare("DELETE FROM agendamento WHERE id_agendamento = :id");
        $excluirAgendamento->bindParam(':id', $id);
        $excluirAgendamento->execute();
        echo 'Agendamento cancelado';

    } catch (PDOException $e) {
        echo 'ERRO: '. $e->getMessage();
    }
?>