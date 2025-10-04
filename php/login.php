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
        //Transforma os dados em um array associativo
        $usuario_p = $consulta_p->fetch(PDO::FETCH_ASSOC);
        
        //Pegar os dados do cliente
        $consulta_c = $pdo->prepare("SELECT id_cliente,nome,email,senha FROM cliente WHERE email = :email");
        $consulta_c->bindParam(':email',$email);
        $consulta_c->execute();
        //Transforma os dados em um array associativo
        $usuario_c = $consulta_c->fetch(PDO::FETCH_ASSOC);
        //Verefica se o usuário é um proprietário
        if ($usuario_p && password_verify($senha, $usuario_p['senha_proprietario'])) {
            //Armazena informações do usuário na sessão para serem consultadas em outras páginas
            $tipo = 'Proprietário';
            $_SESSION['id'] = $usuario_p['id_estabelecimento'];
            $_SESSION['usuario'] = $usuario_p['nome_proprietario'];
            $_SESSION['email'] = $usuario_p['email_proprietario'];
            $_SESSION['tipo'] = $tipo;
            //Redireciona para a tela inicial
            header("location: ../html/index.html");
        //Verefica se o usuário é um cliente
        }else if($usuario_c && password_verify($senha, $usuario_c['senha'])){
             //Armazena informações do usuário na sessão para serem consultadas em outras páginas
            $tipo = 'Cliente';
            $_SESSION['id'] = $usuario_c['id_cliente'];
            $_SESSION['usuario'] = $usuario_c['nome'];
            $_SESSION['email'] = $usuario_c['email'];
            $_SESSION['tipo'] = $tipo;
            //Redireciona para a tela inicial
            header("location: ../html/index.html");
        }else{
            //Menssagem de erro caso o usuário não exista
            $mensagem = 'ERRO: Usuário ou senha incorretos';
            header("location: ../html/login.html?mensagem=".urlencode($mensagem));
        }
    } catch (PDOException $e) {
        //Menssagem de erro genérica
        $mensagem = 'ERRO '. $e->getMessage();
        header("location: ../html/login.html?mensagem=".urlencode($mensagem));
            
        }
    }
?>
