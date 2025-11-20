<?php
include_once 'config.php';

try {
    // Consulta para pegar todos os registros de 'disponibilidade' onde 'dia' é menor que a data atual
    $consulta = $pdo->query("SELECT * FROM disponibilidade WHERE dia < CURDATE()");
    
    // Pega todos os resultados da consulta
    $linha = $consulta->fetchAll(PDO::FETCH_ASSOC);

    foreach ($linha as $e) {

        // Obtém o ID da disponibilidade
        $id_disponibilidade = $e['id_disponibilidade'];

        // Usando prepared statement para evitar injeção de SQL — pega agendamentos vinculados
        $stmtAgendamentos = $pdo->prepare("SELECT * FROM agendamento WHERE id_disponibilidade = :id_disponibilidade");
        $stmtAgendamentos->bindParam(':id_disponibilidade', $id_disponibilidade, PDO::PARAM_INT);
        $stmtAgendamentos->execute();
        
        // Pega todos os agendamentos relacionados
        $pegarAgendamento = $stmtAgendamentos->fetchAll(PDO::FETCH_ASSOC);

        // Verifica se há agendamentos relacionados
        foreach ($pegarAgendamento as $agendamento) {

            // Obtém o ID do agendamento
            $id_agendamento = $agendamento['id_agendamento'];

            // Exclui os serviços associados ao agendamento
            $stmtDeleteServicos = $pdo->prepare("DELETE FROM agendamento_servico WHERE id_agendamento = :id_agendamento");
            $stmtDeleteServicos->bindParam(':id_agendamento', $id_agendamento, PDO::PARAM_INT);
            $stmtDeleteServicos->execute();

            // Exclui o agendamento
            $stmtDeleteAgendamento = $pdo->prepare("DELETE FROM agendamento WHERE id_agendamento = :id_agendamento");
            $stmtDeleteAgendamento->bindParam(':id_agendamento', $id_agendamento, PDO::PARAM_INT);
            $stmtDeleteAgendamento->execute();
        }

        // Exclui disponibilidade do funcionário
        $deletaDisponibilidadeFuncionario = $pdo->prepare("DELETE FROM disponibilidade_funcionario WHERE id_disponibilidade = :id_disponibilidade");
        $deletaDisponibilidadeFuncionario->bindParam(':id_disponibilidade', $id_disponibilidade);
        $deletaDisponibilidadeFuncionario->execute();

        // Exclui disponibilidade
        $excluirDisponibilidade = $pdo->prepare("DELETE FROM disponibilidade WHERE id_disponibilidade = :id_disponibilidade");
        $excluirDisponibilidade->bindParam(':id_disponibilidade', $id_disponibilidade);
        $excluirDisponibilidade->execute();
    }

} catch (PDOException $e) {
    echo 'ERRO: ' . $e->getMessage();
}
?>
