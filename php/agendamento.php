<?php
    require_once 'config.php';
    session_start();
    $input = json_decode(file_get_contents('php://input'), true);
    $idTipo = $_SESSION['tipo'];
    //ids    
    //id_cliente
    $idCliente = $_SESSION['id'];
    //id_funcionario
    $idFuncionario = $input['id_funcionario'];
    //id_disponibilidade
    $idDisponibilidade = $_SESSION ['id_disponibilidade'];
    //id_servico
    $idServico = $input['id_servico'];

         if ($_SESSION['tipo'] == 'Cliente') {
             try {
                $consulta = $pdo->prepare("INSERT INTO agendamento id_cliente, id_funcionario, id_disponibilidade VALUES (:id_cliente, :id_funcionario, :id_disponibilidade)");
             } catch (\Throwable $th) {
                //throw $th;
             }
             
             
             
             
             //Agendamento_servico
     
             //id_agendamento
    }else{
        echo 'TEste';

    }
?>