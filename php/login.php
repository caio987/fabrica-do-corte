<?php
    require_once'config.php';

    //Iniciar a sessão
    session_start();
    //Vereficar se os dados foram enviados via POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //Pegar os dados enviados
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        
        //Pegar com os dados de proprietário
        try {
        $consulta_p = $pdo->prepare("SELECT id_estabelecimento,nome_proprietario,email_proprietario,senha_proprietario FROM estabelecimento WHERE email_proprietario = :email");
        $consulta_p->bindParam(':email',$email);
        $consulta_p->execute();
        $usuario_p = $consulta_p->fetch(PDO::FETCH_ASSOC);

        //Pegar os dados do cliente
        $consulta_c = $pdo->prepare("SELECT id_cliente,nome,email,senha FROM cliente WHERE email = :email");
        $consulta_c->bindParam(':email',$email);
        $consulta_c->execute();
        $usuario_c = $consulta_c->fetch(PDO::FETCH_ASSOC);
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
            header("location: ../html/index.html");
        }else if($usuario_c && password_verify($senha, $usuario_c['senha'])){
            $tipo = 'Cliente';
            $_SESSION['id'] = $usuario_c['id_cliente'];
            $_SESSION['usuario'] = $usuario_c['nome'];
            $_SESSION['email'] = $usuario_c['email'];
            $_SESSION['tipo'] = $tipo;
            echo $_SESSION['id'];
            echo $_SESSION['usuario'];
            echo $_SESSION['email'];
            echo $_SESSION['tipo'];
            header("location: ../html/index.html");
        }else{
            echo 'ERRO: Usuário ou senha incorretos';
        }
        } catch (PDOException $e) {
            $mensagem = $e->getMessage();
            echo $mensagem;
        }
    }
?>
