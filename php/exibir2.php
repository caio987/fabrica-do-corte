<?php
require_once 'config.php';
header('Content-Type: application/json');

try {
    // Consulta todos os estabelecimentos
    $consulta = $pdo->query("SELECT * FROM estabelecimento");
    $dados = [];

    // Lê todos os registros
    while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
        // Corrige os campos de imagem (caso estejam no formato base64)
        $row['foto'] = str_replace('type:', 'data:', $row['foto_estabelecimento']);
        $row['logo'] = str_replace('type:', 'data:', $row['logo_barbearia']);

        $dados[] = $row;
    }

    // Retorna como JSON
    echo json_encode($dados);

} catch (PDOException $e) {
    echo json_encode(["erro" => "Erro no banco de dados: " . $e->getMessage()]);
}

exit;
?>
