<?php
session_start();

// Diz que os dados serão enviados via JSON
header('Content-Type: application/json');

// Verifica se o usuário está logado
if (isset($_SESSION['id']) && isset($_SESSION['usuario']) && isset($_SESSION['tipo'])) {
    echo json_encode([
        //Caso o usuário esteja logado 
        'logado' => true,
        'nome_usuario' => $_SESSION['usuario'],
        'tipo' => $_SESSION['tipo']
    ]);
} else {
    //Nenhum usuário logado
    echo json_encode(['logado' => false]);
}
?>
