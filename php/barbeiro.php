<?php
    require_once './config.php';

    //Verifica se os dados foram andados via POST
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        //Vereficar se a senha e o confirmar senha são iguais
        $senha = $_POST['senha'];
        $confirmar = $_POST['confirmar'];
        if ($senha == $confirmar) {
             //Pegar os dados enviados
            $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
            $nome_estabelecimento = filter_var($_POST['nome_estabelecimento'], FILTER_SANITIZE_SPECIAL_CHARS);
            $telefone = filter_var($_POST['telefone'], FILTER_SANITIZE_SPECIAL_CHARS);
            $localizacao = filter_var($_POST['localizacao'], FILTER_SANITIZE_SPECIAL_CHARS);
            $apresentacao = filter_var($_POST['apresentacao'], FILTER_SANITIZE_SPECIAL_CHARS);
            $foto = '';//Caso não coloque nenhuma imagem
            $logo = '';//Caso coloque nenhuma imagem
            //Verifica se a imagem existe
            if (isset($_FILES['foto']) && $_FILES['foto'] ['error'] === 0) {
                //Pegar o tipo da imagem
                $tipo = $_FILES['foto'] ['type'];
                //Pegar o caminha temporário
                $caminho = $_FILES['foto'] ['tmp_name'];
                //Pegar o conteudo da imagem
                $conteudo = file_get_contents($caminho);
                //Transformar a imagem em binário
                $foto = 'type:'. $tipo. ';base64,'. base64_encode($conteudo);
            }
            if (isset($_FILES['logo']) && $_FILES['logo'] ['error'] === 0) {
                //Pegar o tipo da imagem
                $tipo = $_FILES['logo'] ['type'];
                //Pegar o caminha temporário
                $caminho = $_FILES['logo'] ['tmp_name'];
                //Pegar o conteudo da imagem
                $conteudo = file_get_contents($caminho);
                //Transformar a imagem em binário
                $logo = 'type:'. $tipo. ';base64,'. base64_encode($conteudo);
            }
            try {
                if ($email) {
                   
                    //Inserir no banco de dados
                    $inserir = $pdo->prepare("INSERT INTO estabelecimento (nome_proprietario,email_proprietario,senha_proprietario,nome_estabelecimento,telefone_estabelecimento,localizacao,foto_estabelecimento,logo_barbearia,apresentacao) VALUES (:nome,:email,:senha,:nome_estabelecimento,:telefone,:localizacao,:foto,:logo,:apresentacao)");
                    $inserir->bindParam(':nome', $nome);
                    $inserir->bindParam(':email', $email);
                    $inserir->bindParam(':senha', $senha);
                    $inserir->bindParam(':nome_estabelecimento', $nome_estabelecimento);
                    $inserir->bindParam(':telefone', $telefone);
                    $inserir->bindParam(':localizacao', $localizacao);
                    $inserir->bindParam(':foto', $foto);
                    $inserir->bindParam(':logo', $logo);
                    $inserir->bindParam(':apresentacao', $apresentacao);
                    $inserir->execute();
                     //Tratamento de mensagem de cadastro realizado
                    $mensagem = 'Cadastro Realizado';
                    header("location: ../html/login.html?mensagem=".urlencode($mensagem). "&tipo=sucesso");  
                    exit;
                }else{
                     //Tratamento de erro caso o email seja inválido
                $mensagem = 'Email invalido';
                header("location: ../html/barbeiro.html?mensagem=".urlencode($mensagem). "&tipo=erro");  
                }
                exit;

            } catch (PDOException $e) {
                //Mandar mensagem de erro que o usuário ta cadastrado
                if ($e->getCode() == 23000) {
                    $mensagem = 'ERRO: Este E-mail ou Endereço já está cadastrado';
                    header("location: ../html/barbeiro.html?mensagem=".urlencode($mensagem). "&tipo=erro");
                      
                }else {
                    //Mandar mensagem de erro genérica
                    $mensagem = 'ERRO '. $e->getMessage();
                    header("location: ../html/barbeiro.html?mensagem=".urlencode($mensagem). "&tipo=erro");  
                }
                exit;
            }
            
            
            
        }else{
            //Mandar mensagem d erro caso as senhas sejam diferentes
            $mensagem = "Senha e confirar senha estão diferentes";
            header("location: ../html/barbeiro.html?mensagem=".urlencode($mensagem). "&tipo=erro");
            exit;
        }
        
    }
?>