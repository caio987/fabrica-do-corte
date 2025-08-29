<?php
ob_start();
session_start();
include("config.php");

if (!isset($_SESSION['usuario']) || $_SESSION['tipo'] !== 'barbeiro') {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['usuario'];

$sql = "SELECT * FROM barbeiros WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $dados = $result->fetch_assoc();
} else {
    echo "Usuário não encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Página do Barbeiro</title>
</head>
<body>
    <h1>Bem-vindo, <?php echo htmlspecialchars($dados['nome']); ?>!</h1>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($dados['email']); ?></p>
    <p><strong>Telefone:</strong> <?php echo htmlspecialchars($dados['telefone']); ?></p>
    <p><strong>Localização:</strong> <?php echo htmlspecialchars($dados['localizacao']); ?></p>
    <p><strong>Data de Nascimento:</strong> <?php echo htmlspecialchars($dados['data_nacimento']); ?></p>
    <p><strong>Nome do Estabelecimento:</strong> <?php echo htmlspecialchars($dados['nome_estabelecimento']); ?></p>

    <?php if (!empty($dados['foto_estabelecimento'])): ?>
        <p><strong>Foto do Estabelecimento:</strong></p>
        <img src="data:image/jpeg;base64,<?php echo base64_encode($dados['foto_estabelecimento']); ?>" width="200" alt="Foto">
    <?php else: ?>
        <p>Sem imagem disponível.</p>
    <?php endif; ?>
</body>
</html>

<?php ob_end_flush(); ?>
