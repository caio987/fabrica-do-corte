<?php 
require_once 'config.php';

try {
    $consulta = $pdo->query("SELECT id_estabelecimento, nome_estabelecimento, logo_barbearia FROM estabelecimento");
    $linhas = $consulta->fetchAll(PDO::FETCH_ASSOC); // ✅ pega tudo de uma vez
    $dados = [];

    foreach ($linhas as $row) {
        if (!empty($row['logo_barbearia'])) {
            $row['logo'] = 'data:image/png;base64,' . base64_encode($row['logo_barbearia']);
        } else {
            $row['logo'] = null;
        }

        unset($row['logo_barbearia']);
        $dados[] = $row;
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($dados, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => $e->getMessage()]);
}
?>
