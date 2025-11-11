<?php
    require_once 'config.php';
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        try {
            $consulta = $pdo->query('SELECT e.nome_estabelecimento FROM estabelecimentos_salvos AS es
            JOIN estabelecimento e
            ON es.id_estabelecimento = e.id_estabelecimento');
            $estabelecimento = $consulta->fetch(PDO::FETCH_ASSOC);
            if (!$consulta->rowCount() == 0) {
                echo 'Estabelecimento: '. implode($estabelecimento) .' foi excluido de agendamentos salvos';
                $excluir = $pdo->prepare('DELETE FROM estabelecimentos_salvos  WHERE id_estabelecimento_salvo = :id');
                $excluir->bindParam(':id', $id);
                $excluir->execute();
            }else{
                echo 'Nenhum estabelecimento salvo';
            }
            
        } catch (PDOException $e) {
            echo 'ERRO: '. $e->getMessage();
        }
        
    }
?>