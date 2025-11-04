<?php
    require_once 'config.php';
    session_start();
    if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Cliente') {
        $id_recebido = json_decode(file_get_contents("php://input"), true);
        $id_estabelecimento = $id_recebido['id'];
        $id_cliente = $_SESSION['id'];

        try {
            $consulta = $pdo->query("SELECT * FROM estabelecimentos_salvos WHERE id_cliente = $id_cliente AND  id_estabelecimento = $id_estabelecimento");
            if ($consulta) {
                echo "Estabelecimento já salvo";
                exit;   
            }
            $estabelecimentoSalvo = $pdo->prepare("INSERT INTO estabelecimentos_salvos (id_cliente, id_estabelecimento) VALUES (:id_cliente, :id_estabelecimento)");
            $estabelecimentoSalvo->bindParam(':id_cliente', $id_cliente);
            $estabelecimentoSalvo->bindParam(':id_estabelecimento', $id_estabelecimento);
            $estabelecimentoSalvo->execute();
            echo 'Estabelecimento salvo com sucesso';
            exit;
        } catch (PDOException $e) {
            echo 'ERRO: ', $e->getMessage();
            exit;
        }
    }else{
        echo 'É necessário estar logado como cliente para salvar o estabelecimento';
        exit;
    }
?>