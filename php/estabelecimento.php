<?php
    require_once 'config.php';
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $input = json_decode(file_get_contents("php://input"), true);
        $id = $input['id'] ?? null;
        $_SESSION['id_agendamento'] = $id;
        try {
            $consulta = $pdo->prepare("SELECT id_estabelecimento, nome_proprietario, nome_estabelecimento, telefone_estabelecimento,localizacao, logo_barbearia, foto_estabelecimento, apresentacao, telefone_estabelecimento FROM estabelecimento WHERE id_estabelecimento = :id");
            $consulta->bindParam(":id", $id);
            $consulta->execute();
            $estabelecimento = $consulta->fetch(PDO::FETCH_ASSOC);
            echo json_encode($estabelecimento);
        } catch (PDOException $e) {
            $erro = "ERRO: ". $e->getMessage();
            echo json_encode($erro);
        }
    }else{
        echo 'dado não encontrado';
    }

?>