<?php
    require_once 'config.php';
    session_start();
    $input = json_decode(file_get_contents('php://input'), true);
    if (isset($_SESSION['tipo'])) {
            $idTipo = $_SESSION['tipo'];
    }
    //ids    
    //id_cliente
    if (isset($_SESSION['id'])) {
        $idCliente = $_SESSION['id'];
    }
    //id_funcionario
    $idFuncionario = $input['id_funcionario'];
    //id_disponibilidade
    $idDisponibilidade = $_SESSION ['id_disponibilidade'];
    //id_servico
    $idServico = $input['id_servico'];

         if (isset( $_SESSION['tipo'])) {
             try {
                if ($_SESSION['tipo'] == 'Cliente') {
                    $consulta = $pdo->prepare("INSERT INTO agendamento (id_cliente, id_funcionario, id_disponibilidade) VALUES (:id_cliente, :id_funcionario, :id_disponibilidade)");
                    $consulta->bindParam(":id_cliente", $idCliente);
                    $consulta->bindParam(":id_funcionario", $idFuncionario);
                    $consulta->bindParam(":id_disponibilidade", $idDisponibilidade);
                    $consulta->execute();
                    echo 'Agendamento realizado com sucesso';
                    
                }else{
                    echo 'Um estabelecimento não pode realizar um agendamento';
                }
             } catch (PDOException $e) {
                echo 'ERRO: '. $e->getMessage();
             }
             
             
             
             
             //Agendamento_servico
     
             //id_agendamento
    }else{
        echo 'Nenhum usuário logado';

    }
?>