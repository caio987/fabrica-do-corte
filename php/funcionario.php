<?php
    require_once 'config.php';
    session_start();
    $id = $_SESSION['id'];

    $consulta = $pdo->prepare("SELECT * FROM funcionarios WHERE id_estabelecimento = :id");
    $consulta->bindParam(':id', $id);
    $consulta->execute();

    $usuario = $consulta->fetchAll(PDO::FETCH_ASSOC);

    foreach ($usuario as &$e) {
    if (isset($e['foto'])) {
        $e['foto'] = str_replace('type:','data:',$e['foto']);
    }else { 
        $e['foto'] = [];
    }
}
    echo json_encode($usuario);
?>