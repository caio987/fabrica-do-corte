<?php
require_once 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    try {

        // PROPRIETÁRIO
        $consulta_p = $pdo->prepare("
            SELECT id_estabelecimento,nome_proprietario,email_proprietario,senha_proprietario 
            FROM estabelecimento 
            WHERE email_proprietario = :email
        ");
        $consulta_p->bindParam(':email', $email);
        $consulta_p->execute();
        $usuario_p = $consulta_p->fetch(PDO::FETCH_ASSOC);

        // CLIENTE
        $consulta_c = $pdo->prepare("
            SELECT id_cliente,nome,email,senha 
            FROM cliente 
            WHERE email = :email
        ");
        $consulta_c->bindParam(':email', $email);
        $consulta_c->execute();
        $usuario_c = $consulta_c->fetch(PDO::FETCH_ASSOC);


        // LOGIN PROPRIETÁRIO
        if ($usuario_p && password_verify($senha, $usuario_p['senha_proprietario'])) {

            $_SESSION['id'] = $usuario_p['id_estabelecimento'];
            $_SESSION['usuario'] = $usuario_p['nome_proprietario'];
            $_SESSION['email'] = $usuario_p['email_proprietario'];
            $_SESSION['tipo'] = "Proprietário";

            $mensagem = "Usuário logado com sucesso";
            header("location: ../html/index.html?mensagem=" . urlencode($mensagem) . "&tipo=sucesso");
            exit;
        }

        // LOGIN CLIENTE
        else if ($usuario_c && password_verify($senha, $usuario_c['senha'])) {

            $_SESSION['id'] = $usuario_c['id_cliente'];
            $_SESSION['usuario'] = $usuario_c['nome'];
            $_SESSION['email'] = $usuario_c['email'];
            $_SESSION['tipo'] = "Cliente";

            $mensagem = "Login realizado";
            header("location: ../html/index.html?mensagem=" . urlencode($mensagem) . "&tipo=sucesso");
            exit;
        }

        // ERRO: email ou senha inválidos
        else {
            $mensagem = "ERRO: Usuário ou senha incorretos";
            header("location: ../html/login.html?mensagem=" . urlencode($mensagem) . "&tipo=erro");
            exit;
        }

    } catch (PDOException $e) {

        $mensagem = "ERRO: " . $e->getMessage();
        header("location: ../html/login.html?mensagem=" . urlencode($mensagem) . "&tipo=erro");
        exit;
    }
}
?>
