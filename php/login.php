<?php
    require_once'config.php';

    //Iniciar a sessão
    session_start();
    //Vereficar se os dados foram enviados via POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //Pegar os dados enviados
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        
        //Comparar com os dados de proprietário
        try {
            $consulta_p = $pdo->prepare("SELECT id_estabelecimento,nome_proprietario,email_proprietario,senha_proprietario FROM estabelecimento WHERE email_proprietario = :email");
        $consulta_p->bindParam(':email',$email);
        $consulta_p->execute();
        $usuario_p = $consulta_p->fetch(PDO::FETCH_ASSOC);
        if ($usuario_p && password_verify($senha, $usuario_p['senha_proprietario'])) {
            $tipo = 'Proprietário';
            $_SESSION['id'] = $usuario_p['id_estabelecimento'];
            $_SESSION['usuario'] = $usuario_p['nome_proprietario'];
            $_SESSION['email'] = $usuario_p['email_proprietario'];
            $_SESSION['tipo'] = $tipo;
            echo $_SESSION['id'];
            echo $_SESSION['usuario'];
            echo $_SESSION['email'];
            echo $_SESSION['tipo'];
        }else {
            echo 'ERRO: Usuário ou senha incorretos';
        }
        } catch (PDOException $e) {
            $mensagem = $e->getMessage();
            echo $mensagem;
        }
    }
?>
