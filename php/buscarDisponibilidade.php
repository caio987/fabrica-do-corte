<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(["erro" => "Sessão inválida ou expirada"]);
    exit;
}

$id_estabelecimento = $_SESSION['id'];

try {
    $consulta = $pdo->prepare("
        SELECT *
        FROM disponibilidade 
        WHERE id_estabelecimento = :id_estabelecimento 
        ORDER BY dia, horario
    ");
    $consulta->bindParam(":id_estabelecimento", $id_estabelecimento, PDO::PARAM_INT);
    $consulta->execute();
    $disponibilidades = $consulta->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json; charset=utf-8");
    echo json_encode($disponibilidades, JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["erro" => "Erro ao buscar: " . $e->getMessage()]);
}
?>
