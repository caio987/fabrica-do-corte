<?php
require_once 'config.php';
session_start();

$input = json_decode(file_get_contents('php://input'), true);

// Verificações básicas
if (!isset($_SESSION['tipo']) || !isset($_SESSION['id'])) {
    echo 'Nenhum usuário logado';
    exit;
}

$idTipo = $_SESSION['tipo'];
$idCliente = $_SESSION['id'];
$idFuncionario = $input['id_funcionario'] ?? null;
$idDisponibilidade = $_SESSION['id_disponibilidade'] ?? null;
$idServicos = $input['id_servico'] ?? []; // Pode ser único ID ou array

// Verifica tipo de usuário
if ($idTipo !== 'Cliente') {
    echo 'Um estabelecimento não pode realizar um agendamento';
    exit;
}

// Normaliza o valor — garante que seja sempre um array
if (!is_array($idServicos)) {
    $idServicos = [$idServicos];
}

try {
    // Verifica se o horário já foi agendado
    $consulta = $pdo->prepare("SELECT id_agendamento FROM agendamento WHERE id_disponibilidade = :id_disponibilidade");
    $consulta->bindParam(":id_disponibilidade", $idDisponibilidade);
    $consulta->execute();

    if ($consulta->rowCount() > 0) {
        echo "Este horário já está agendado.";
        exit;
    }

    // Cria novo agendamento
    $agendamento = $pdo->prepare("
        INSERT INTO agendamento (id_cliente, id_funcionario, id_disponibilidade) 
        VALUES (:id_cliente, :id_funcionario, :id_disponibilidade)
    ");
    $agendamento->bindParam(":id_cliente", $idCliente);
    $agendamento->bindParam(":id_funcionario", $idFuncionario);
    $agendamento->bindParam(":id_disponibilidade", $idDisponibilidade);
    $agendamento->execute();

    // Pega o ID do agendamento recém-criado
    $idAgendamento = $pdo->lastInsertId();

    // Insere os serviços vinculados
    $agendServico = $pdo->prepare("
        INSERT INTO agendamento_servico (id_agendamento, id_servico) 
        VALUES (:id_agendamento, :id_servico)
    ");

    foreach ($idServicos as $idServico) {
        // Verifica se o serviço existe
        $verificaServico = $pdo->prepare("SELECT id_servico FROM servico WHERE id_servico = :id_servico");
        $verificaServico->bindParam(":id_servico", $idServico);
        $verificaServico->execute();

        if ($verificaServico->rowCount() === 0) {
            echo "Serviço com ID $idServico não existe.<br>";
            continue;
        }

        $agendServico->bindParam(":id_agendamento", $idAgendamento);
        $agendServico->bindParam(":id_servico", $idServico);
        $agendServico->execute();
    }

    echo 'Agendamento realizado com sucesso';

} catch (PDOException $e) {
    echo 'ERRO: ' . $e->getMessage();
}
?>
