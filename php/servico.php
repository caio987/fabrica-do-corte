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

// Pegar as servicos e horários
$servicos = $data['servico'] ?? [];
$precos = $data['preco'] ?? [];
$id_estabelecimento = $_SESSION['id'];

// Apenas para teste: exibir o que chegou
echo "Servicos: " . implode(", ", $servicos) . "\n";
echo "preços: " . implode(", ", $precos) . "\n";

try {
  

   foreach ($servicos as $i => $servico) {
    $preco = $precos[$i] ?? 0; // evita erro se faltar algum preço
    $stmt = $pdo->prepare("
        INSERT INTO servico (id_estabelecimento, nome_servico, preco) 
        VALUES (:id_estabelecimento, :servico, :preco)
    ");
    $stmt->execute([
        ':id_estabelecimento' => $id_estabelecimento,
        ':servico' => $servico,
        ':preco' => $preco
    ]);
}


    echo "Agendamentos salvos com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao salvar: " . $e->getMessage();
}

?>
