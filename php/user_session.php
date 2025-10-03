<?php
session_start();

// Corrigir o header
header('Content-Type: application/json');

// Verifica se o usuário está logado
if (isset($_SESSION['id']) && isset($_SESSION['usuario']) && isset($_SESSION['tipo'])) {
    echo json_encode([
        'logado' => true,
        'nome_usuario' => $_SESSION['usuario'],
        'tipo' => $_SESSION['tipo']
    ]);
} else {
    echo json_encode(['logado' => false]);
}
?>
