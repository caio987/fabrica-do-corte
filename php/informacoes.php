<?php
require_once "config.php";
session_start();
header('Content-Type: application/json');

// Verifica sessão
if (!isset($_SESSION['id']) || !isset($_SESSION['tipo'])) {
    echo json_encode(["erro" => "Usuário não autenticado"]);
    exit;
}

$id = $_SESSION['id'];
$tipo = $_SESSION['tipo'];

try {
    if ($tipo === 'Cliente') {
        $stmt = $pdo->prepare("SELECT * FROM cliente WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode([
            "dados" => $resultado,
            "tipo" => $tipo
        ]);
        exit;

    } else if ($tipo === 'Proprietário') {
        $stmt = $pdo->prepare("SELECT * FROM estabelecimento WHERE id_estabelecimento = :id");
        $stmt->execute(['id' => $id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Ajusta fotos se existirem
        if (isset($resultado['foto_estabelecimento'])) {
            $resultado['foto'] = str_replace('type:', 'data:', $resultado['foto_estabelecimento']);
        } else {
            $resultado['foto'] = null;
        }

        if (isset($resultado['logo_barbearia'])) {
            $resultado['logo'] = str_replace('type:', 'data:', $resultado['logo_barbearia']);
        } else {
            $resultado['logo'] = null;
        }

        echo json_encode([
            "dados" => $resultado,
            "tipo" => $tipo
        ]);
        exit;
    }

} catch (PDOException $e) {
    echo json_encode(["erro" => "ERRO: " . $e->getMessage()]);
}
?>
