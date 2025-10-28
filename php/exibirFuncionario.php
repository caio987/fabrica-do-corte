<?php
session_start();
header('Content-Type: application/json');
require_once 'config.php'; // conexão PDO

// Verifica se o estabelecimento foi definido
if (!isset($_SESSION['id_agendamento'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Estabelecimento não definido.'
    ]);
    exit;
}
$id_estabelecimento = $_SESSION['id_agendamento'];

// Recebe JSON do front
$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['id_servico'], $data['dia'], $data['horario'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Dados incompletos.'
    ]);
    exit;
}

$id_servico = $data['id_servico']; // array de IDs de serviço
$dia = $data['dia'];
$horario = $data['horario'];

try {
    // 🔹 Busca o id_disponibilidade correspondente ao dia e horário
    $sqlDisp = "SELECT id_disponibilidade FROM disponibilidade WHERE dia = ? AND horario = ?";
    $stmtDisp = $pdo->prepare($sqlDisp);
    $stmtDisp->execute([$dia, $horario]);
    $disp = $stmtDisp->fetch(PDO::FETCH_ASSOC);

    if (!$disp) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Nenhuma disponibilidade encontrada para o dia e horário selecionados.'
        ]);
        exit;
    }

    $id_disponibilidade = $disp['id_disponibilidade'];

    // 🔹 Cria placeholders para os IDs de serviços
    $placeholders = implode(',', array_fill(0, count($id_servico), '?'));

    // 🔹 Busca funcionários que:
    // - São do estabelecimento
    // - Fazem pelo menos UM dos serviços selecionados
    // - Estão disponíveis naquele horário
    $sql = "
        SELECT DISTINCT f.id_funcionario, f.nome, f.foto
        FROM funcionarios f
        JOIN servico_funcionario sf ON f.id_funcionario = sf.id_funcionario
        JOIN disponibilidade_funcionario df ON f.id_funcionario = df.id_funcionario
        WHERE f.id_estabelecimento = ?
        AND sf.id_servico IN ($placeholders)
        AND df.id_disponibilidade = ?
    ";

    $stmt = $pdo->prepare($sql);
    $params = array_merge([$id_estabelecimento], $id_servico, [$id_disponibilidade]);
    $stmt->execute($params);
    $funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$funcionarios) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Nenhum funcionário disponível.'
        ]);
        exit;
    }

    // 🔹 Converte foto (BLOB) para Base64
    foreach ($funcionarios as &$f) {
        if (!empty($f['foto'])) {
               $f['foto'] = str_replace('type:','data:',$f['foto']);
        } else {
            $f['foto'] = '';
        }
    }

    echo json_encode([
        'status' => 'success',
        'data' => $funcionarios
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Erro ao buscar funcionários: ' . $e->getMessage()
    ]);
}
?>
