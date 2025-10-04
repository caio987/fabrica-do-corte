<?php
require_once 'config.php';

//Confirmar se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        
        //Confirmar se a senha e a confirmação são iguais
        if($_POST['senha'] == $_POST['confirmar']){
            //Pegar as informações do formulário
            $nome = filter_var($_POST['nome'],FILTER_SANITIZE_SPECIAL_CHARS);
            $sobrenome = filter_var($_POST['sobrenome'],FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
            $senha = password_hash($_POST['senha'],PASSWORD_DEFAULT);
            //Caso o E-mail não tenha passado na validação
           if ($email) {
            //Inserindo os dados no banco de dados
                $inserir = $pdo->prepare("INSERT INTO cliente (nome,sobrenome,email,senha) VALUES (:nome,:sobrenome,:email,:senha)");
                $inserir->bindParam(':nome',$nome);
                $inserir->bindParam(':sobrenome',$sobrenome);
                $inserir->bindParam(':email',$email);
                $inserir->bindParam(':senha',$senha);
                $inserir->execute();
                //Tratamento de mensagem de cadastro realizado
                $mensagem = 'Cadastro realizado com sucesso';
                header("location: ../html/login.html?mensagem=".urlencode($mensagem));
            }else{
                //Tratamento de erro caso o E-mail seja inválido
                $mensagem = "Email Invalido";
                header("location: ../html/cliente.html?mensagem=".urlencode($mensagem));
           }
        }else{
            //Tratamento de erro caso as senhas sejam diferentes
            $mensagem = 'Senha e confirmar senha estão diferentes';
            header("location: ../html/cliente.html?mensagem=".urlencode($mensagem));
            exit;
        }
    } catch (PDOException $e) {
        //Mandar mensagem de erro que o usuário já esta cadastrado
        if($e->getCode() == 23000){
            $mensagem = "Este E-mail já está cadastrado";
            header("location: ../html/cliente.html?mensagem=".urlencode($mensagem));
                     
        }else{
            //Mensagem de erro genérica
            $mensagem = 'ERRO '. $e->getMessage();
            header("location: ../html/cliente.html?mensagem=".urlencode($mensagem));
            
        }
        exit;
    }
}
?>