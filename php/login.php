<?php
ob_start();
session_start();
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Verifica na tabela barbeiros
    $sqlBarbeiro = "SELECT * FROM barbeiros WHERE email = '$email' AND senha = '$senha'";
    $resultBarbeiro = $conn->query($sqlBarbeiro);

    if ($resultBarbeiro->num_rows > 0) {
        $_SESSION['usuario'] = $email;
        $_SESSION['tipo'] = 'barbeiro';
        header("Location: pagina.php");
        exit();
    }

    // Verifica na tabela cliente
    $sqlCliente = "SELECT * FROM cliente WHERE email = '$email' AND senha = '$senha'";
    $resultCliente = $conn->query($sqlCliente);

    if ($resultCliente->num_rows > 0) {
        $_SESSION['usuario'] = $email;
        $_SESSION['tipo'] = 'cliente';
        header("Location: ../index.html");
        exit();
    }

    // Se não encontrou em nenhuma tabela
    $erro = "Email ou senha incorretos.";
}
?>

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
        <?php if (!empty($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
        <form method="POST" action="">
            <h2>Login</h2>
            <fieldset id="cliente">
                <input type="text" name="usuario" placeholder="E-mail" required><br><br>

                <input type="password" name="senha" placeholder="Senha" required><br><br>

                <button type="submit" value="Entrar">Entrar</button>
                <p>Não possuí uma conta? <a href="../escolherCadastro.html">Clique aqui</a> para se cadastrar</p>
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
<?php ob_end_flush(); ?>
