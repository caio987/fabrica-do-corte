<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Cadastro</title>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="../index.html"><img src="../img/logo.png" alt=""></a></li>
                <li><a href="../#" class="links">Barbearias</a></li>
                <li><a href="../#" class="links">Agendamentos</a></li>
                <li><a href="../#" class="links">Quem somos</a></li>
                <li><a href="../escolherCadastro.html" class="links">Cadastrar</a></li>
                <li><a href="../#" class="links">Conta</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <form action="" method='POST'>
            <h2>Cadastro</h2>
            <fieldset id="cliente">
                <input type="text" placeholder="Nome:" id="nome" name="nome"><br>

                <input type="text" placeholder="Sobrenome:" id="sobrenome" name="sobrenome"><br>

                <input type="email" placeholder="E-mail" id="email" name="email"><br>

                <input type="password" placeholder="Senha:" name="senha" id="senha"><br>

                <input type="password" placeholder="Confirmar Senha:" name="confirmar" id="confirmar"><br>

                <div class="caixaInput">
                        <label for="localizacao">Estado</label><br><br>
                        <select name="localizacao" id="localizacao" required>
                            <option value="">Selecione o estado</option>
                            <option value="AC">Acre</option>
                            <option value="AL">Alagoas</option>
                            <option value="AP">Amapá</option>
                            <option value="AM">Amazonas</option>
                            <option value="BA">Bahia</option>
                            <option value="CE">Ceará</option>
                            <option value="DF">Distrito Federal</option>
                            <option value="ES">Espírito Santo</option>
                            <option value="GO">Goiás</option>
                            <option value="MA">Maranhão</option>
                            <option value="MT">Mato Grosso</option>
                            <option value="MS">Mato Grosso do Sul</option>
                            <option value="MG">Minas Gerais</option>
                            <option value="PA">Pará</option>
                            <option value="PB">Paraíba</option>
                            <option value="PR">Paraná</option>
                            <option value="PE">Pernambuco</option>
                            <option value="PI">Piauí</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="RN">Rio Grande do Norte</option>
                            <option value="RS">Rio Grande do Sul</option>
                            <option value="RO">Rondônia</option>
                            <option value="RR">Roraima</option>
                            <option value="SC">Santa Catarina</option>
                            <option value="SP">São Paulo</option>
                            <option value="SE">Sergipe</option>
                            <option value="TO">Tocantins</option>
                        </select>
                    </div>

                <button type="submit" name='submit' id="submit">Cadastrar</button>
                <p>Já possuí um cadastro? <a href="login.php">Clique aqui</a> para logar</p>
            </fieldset>
        </form>
    </main>

    <footer class ="footerFixo">
        <a href="#"><img src="../img/icons/github.png" alt=""><span>GitHub</span></a>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>

<?php
    if(isset($_POST['submit']))
    {
    //     print_r($_POST['nome']);
    //     print_r('<br>');
    //     print_r($_POST['sobrenome']);
    //     print_r('<br>');
    //     print_r($_POST['email']);
    //     print_r('<br>');
    //     print_r($_POST['localizacao']);
    //     print_r('<br>');
        include_once('config.php');

        $nome = $_POST['nome'];
        $sobrenome = $_POST['sobrenome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $localizacao = $_POST['localizacao'];

        $result = mysqli_query($conn, 
        "INSERT INTO cliente(nome, sobrenome, email, senha, localizacao) 
         VALUES ('$nome', '$sobrenome', '$email', '$senha', '$localizacao')"
    );
    }
?>

