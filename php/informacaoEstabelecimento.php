<?php
    require_once 'config.php';
    session_start();
    if ($_SESSION['id']) {
        try {
            header("content-type: application/json");
            $id = $_SESSION['id'];
            $consulta = $pdo->prepare("SELECT * FROM servico WHERE id_estabelecimento = :id");
            $consulta->bindParam(':id', $id);
            $consulta->execute();
            $servico = $consulta->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($servico);

        } catch (PDOException $e) {
            echo 'ERRO: '. $e->getMessage();
        }
        
    }
?>