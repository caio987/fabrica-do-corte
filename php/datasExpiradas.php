<?php
    // include_once 'config.php';

    // // Consulta para pegar todos os registros de 'disponibilidade' onde 'dia' é maior que a data atual
    // $consulta = $pdo->query("SELECT * FROM disponibilidade WHERE dia > CURDATE()");
    
    // // Pega todos os resultados da consulta
    // $linha = $consulta->fetchAll(PDO::FETCH_ASSOC);
    
    // foreach ($linha as $e) {
    //     // Obtém o ID da disponibilidade
    //     $id_disponibilidade = $e['id_disponibilidade'];
    //     //Deletar Disponibilidade Funcionário
    //     $pegar = $pdo
    //     // Usando prepared statement para evitar injeção de SQL
    //     $stmtAgendamentos = $pdo->prepare("SELECT * FROM agendamento WHERE id_disponibilidade = :id_disponibilidade");
    //     $stmtAgendamentos->bindParam(':id_disponibilidade', $id_disponibilidade, PDO::PARAM_INT);
    //     $stmtAgendamentos->execute();

    //     // Pega todos os agendamentos relacionados
    //     $pegarAgendamento = $stmtAgendamentos->fetchAll(PDO::FETCH_ASSOC);

    //     // Verifica se há agendamentos
    //     foreach ($pegarAgendamento as $agendamento) {
    //         // Obtém o ID do agendamento
    //         $id_agendamento = $agendamento['id_agendamento'];

    //         // Exclui os serviços associados ao agendamento
    //         $stmtDeleteServicos = $pdo->prepare("DELETE FROM agendamento_servico WHERE id_agendamento = :id_agendamento");
    //         $stmtDeleteServicos->bindParam(':id_agendamento', $id_agendamento, PDO::PARAM_INT);
    //         $stmtDeleteServicos->execute();

    //         // Exclui o agendamento
    //         $stmtDeleteAgendamento = $pdo->prepare("DELETE FROM agendamento WHERE id_agendamento = :id_agendamento");
    //         $stmtDeleteAgendamento->bindParam(':id_agendamento', $id_agendamento, PDO::PARAM_INT);
    //         $stmtDeleteAgendamento->execute();

    //         // Opcional: Imprime mensagem de confirmação
    //         // echo "Agendamento ID $id_agendamento e seus serviços foram excluídos.<br>";
    //     }

    // }
?>
