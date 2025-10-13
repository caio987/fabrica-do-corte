<?php
// disponibilidade.php
require_once 'config.php';
session_start();
// Receber o JSON enviado pelo fetch
$json = file_get_contents('php://input');

// Transformar em array associativo
$data = json_decode($json, true);

if (!$data) {
    http_response_code(400);
    echo "Erro: JSON inválido";
    exit;
}

// Pegar as datas e horários
$datas = $data['datas'] ?? [];
$horarios = $data['horarios'] ?? [];
$id_estabelecimento = $_SESSION['id'];

// Apenas para teste: exibir o que chegou
echo "Datas selecionadas: " . implode(", ", $datas) . "\n";
echo "Horários selecionados: " . implode(", ", $horarios) . "\n";

try {
  

    foreach ($datas as $dataDia) {
        foreach ($horarios as $hora) {
            $stmt = $pdo->prepare("INSERT INTO disponibilidade (id_estabelecimento,dia, horario) VALUES (:id_estabelecimento,:data, :hora)");
            $stmt->execute([
                ':id_estabelecimento' => $id_estabelecimento,
                ':data' => $dataDia,
                ':hora' => $hora
            ]);
        }
    }

    echo "Agendamentos salvos com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao salvar: " . $e->getMessage();
}

?>
