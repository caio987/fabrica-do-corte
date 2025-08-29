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
        <form action="barbeiro.php" method="POST" enctype="multipart/form-data">
            <h2>Cadastro</h2>
            <fieldset style="border: none;">
                <div id="barbearia">
                    <div class="caixaInput">
                        <label for="nome">Nome Completo</label><br>
                        <input type="text" name="nome">
                    </div>

                    <div class="caixaInput">
                        <label for="nome_estabelecimento">Nome do Estabelecimento</label>
                        <input type="text" name="nome_estabelecimento" id="nome_estabelecimento">
                    </div>

                    <div class="caixaInput">
                        <label for="data_nascimento">Data de Nascimento</label>
                        <input type="date" name="data_nascimento" id="data_nascimento" required>
                    </div>


                    <div class="caixaInput">
                        <label for="email">E-mail profissional</label>
                        <input type="email" name="email" id="email">
                    </div>

                    <div class="caixaInput">
                        <label for="telefone">Telefone:</label>
                        <input type="tel" name="telefone" id="telefone">
                    </div>

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

                    <div class="caixaInput">
                        <label for="senha">Senha:</label>
                        <input type="password" name="senha" id="senha">
                    </div>

                    <div class="caixaInput">
                        <label for="confirmarSenha">Confirmar senha:</label>
                        <input type="password" name="confirmarSenha" id="confirmarSenha">
                    </div>
                </div>

                <label for="imagem">Foto do Estabelecimento</label>
                <label for="imagem" class="botaoArquivo">Selecionar imagem</label>
                <input type="file" id="imagem" name="imagem" accept="image/*" required style="display: none;">

                <!-- <label for="imagem">Foto do Estabelecimento</label><br>
                <input type="file" name="imagem" id="imagem" accept="image/*" required> -->

                <button type="submit">Enviar</button>
                <p>Já possuí um cadastro? <a href="login.php">Clique aqui</a> para logar</p>
            </fieldset>
        </form>
    </main>

    <footer class="footerFixo">
        <a href="#"><img src="img/icons/github.png" alt=""><span>GitHub</span></a>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>

<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "fabrica_do_corte";

$conn = new mysqli($host, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['nome'], $_POST['senha'], $_POST['confirmarSenha'], $_POST['telefone'], $_POST['localizacao'], $_POST['email'], $_POST['data_nascimento'], $_POST['nome_estabelecimento'], $_FILES['imagem'])
        && is_uploaded_file($_FILES['imagem']['tmp_name'])
    ) {
        $nome = $_POST['nome'];
        $senha_usuario = $_POST['senha'];
        $telefone = $_POST['telefone'];
        $localizacao = $_POST['localizacao'];
        $email = $_POST['email'];
        $data_nacimento = $_POST['data_nascimento']; // respeita o nome da coluna do banco
        $nome_estabelecimento = $_POST['nome_estabelecimento'];
        $imagem = file_get_contents($_FILES['imagem']['tmp_name']); // pega conteúdo binário

        // Prepare statement
        $stmt = $conn->prepare("INSERT INTO barbeiros (
            nome, senha, telefone, localizacao, email, data_nacimento, nome_estabelecimento, foto_estabelecimento
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        // Importante: passe a variável da imagem como string vazia temporária
        $stmt->bind_param("ssssssss", $nome, $senha_usuario, $telefone, $localizacao, $email, $data_nacimento, $nome_estabelecimento, $imagem);
        $stmt->send_long_data(7, $imagem); // índice 7 = 8º parâmetro

        if ($stmt->execute()) {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            title: 'Cadastro Confirmado',
            text: '✅ Cadastro realizado com sucesso!',
            icon: 'success'
        });
    </script>";
} else {
    $erro = addslashes($stmt->error); 
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            title: 'Erro ao Cadastrar',
            text: '❌ Erro ao cadastrar: $erro',
            icon: 'error'
        });
    </script>";
}


        $stmt->close();
        $conn->close();
    } else {
        echo "⚠️ Todos os campos, inclusive a imagem, são obrigatórios.";
    }
}
?>
