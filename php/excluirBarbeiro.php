<?php
    require_once 'config.php';
    $id = $_GET['id'];
    try {
        $deletarFuncionario_servico = $pdo->prepare("DELETE FROM servico_funcionario WHERE id_funcionario = :id");
    $deletarFuncionario_servico->bindParam(':id', $id);
    $deletarFuncionario_servico->execute();
        $deletarFuncionario_disponibilidade = $pdo->prepare("DELETE FROM disponibilidade_funcionario WHERE id_funcionario = :id");
    $deletarFuncionario_disponibilidade->bindParam(':id', $id);
    $deletarFuncionario_disponibilidade->execute();
    $deletarFuncionario = $pdo->prepare("DELETE FROM funcionarios WHERE id_funcionario = :id");
    $deletarFuncionario->bindParam(':id', $id);
    $deletarFuncionario->execute();
    echo 'Funcionario deletado';
    } catch (PDOException $e) {
        echo 'ERRO ao deletar funcionario. Verefique se este funcionário n esta com algum agendamento';
        // echo 'ERRO: '. $e->getMessage();
    }

?>