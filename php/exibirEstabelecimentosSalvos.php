<?php
require_once 'config.php';
session_start();
header("Content-Type: application/json");

if (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'Cliente') {
    $id = $_SESSION['id'];

    try {
        $consulta = $pdo->prepare("SELECT 
                es.id_estabelecimento_salvo,
                es.id_estabelecimento,
                e.nome_estabelecimento,
                e.localizacao,
                e.foto_estabelecimento,
                e.logo_barbearia,
                e.apresentacao
            FROM estabelecimentos_salvos AS es
            JOIN estabelecimento e
              ON es.id_estabelecimento = e.id_estabelecimento
            WHERE es.id_cliente = :id
        ");
        $consulta->execute([':id' => $id]);
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

        foreach ($resultado as &$e) {
            if (!empty($e['foto_estabelecimento'])) {
                $e['foto_estabelecimento'] = str_replace('type:', 'data:', $e['foto_estabelecimento']);
                $e['logo_barbearia'] = str_replace('type:', 'data:', $e['logo_barbearia']);
            } else {
                $e['foto_estabelecimento'] = null;
                $e['logo_barbearia'] = null;
            }
        }

        echo json_encode($resultado);
    } catch (PDOException $e) {
        echo json_encode(['erro' => $e->getMessage()]);
    }
}
?>
