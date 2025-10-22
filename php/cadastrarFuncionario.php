<?php
require_once './config.php';
session_start();

// Verifica se o usuário (estabelecimento) está logado
if (!isset($_SESSION['id'])) {
    $mensagem = 'Sessão expirada. Faça login novamente.';
    header("location: ../html/login.html?mensagem=" . urlencode($mensagem));
    exit;
}

$id_estabelecimento = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // Pegando dados básicos
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
    $servicos = json_decode($_POST['servicos'] ?? '[]', true);
    $diasHorarios = json_decode($_POST['diasHorarios'] ?? '[]', true);
    $foto = '';

    // --- Tratamento da imagem ---
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $tipo = $_FILES['foto']['type'];
        $caminho = $_FILES['foto']['tmp_name'];
        $conteudo = file_get_contents($caminho);
        $foto = 'type:' . $tipo . ';base64,' . base64_encode($conteudo);
    }

    try {
        // --- Inicia transação ---
        $pdo->beginTransaction();

        // 1️⃣ Cadastrar funcionário
        $inserirFuncionario = $pdo->prepare("INSERT INTO funcionarios (id_estabelecimento, nome, foto)
            VALUES (:id_estabelecimento, :nome, :foto)
        ");
        $inserirFuncionario->bindParam(':id_estabelecimento', $id_estabelecimento);
        $inserirFuncionario->bindParam(':nome', $nome);
        $inserirFuncionario->bindParam(':foto', $foto);
        $inserirFuncionario->execute();

        $id_funcionario = $pdo->lastInsertId();

        // 2️⃣ Vincular serviços selecionados
        if (!empty($servicos)) {
            $inserirServico = $pdo->prepare("INSERT INTO servico_funcionario (id_funcionario, id_servico)
                VALUES (:id_funcionario, :id_servico)
            ");
            foreach ($servicos as $id_servico) {
                $inserirServico->bindParam(':id_funcionario', $id_funcionario);
                $inserirServico->bindParam(':id_servico', $id_servico);
                $inserirServico->execute();
            }
        }

        // 3️⃣ Vincular disponibilidades selecionadas
        if (!empty($diasHorarios)) {
            $inserirDisp = $pdo->prepare("INSERT INTO disponibilidade_funcionario (id_funcionario, id_disponibilidade)
                VALUES (:id_funcionario, :id_disponibilidade)
            ");
            foreach ($diasHorarios as $id_disp) {
                $inserirDisp->bindParam(':id_funcionario', $id_funcionario);
                $inserirDisp->bindParam(':id_disponibilidade', $id_disp);
                $inserirDisp->execute();
            }
        }

        // --- Tudo certo, confirma ---
        $pdo->commit();

        $mensagem = 'Funcionário cadastrado com sucesso!';
        header("location: ../html/funcionarios.html?mensagem=" . urlencode($mensagem));
        exit;

    } catch (PDOException $e) {
        $pdo->rollBack();

        $mensagem = 'Erro ao cadastrar funcionário: ' . $e->getMessage();
        header("location: ../html/gerenciaEstabelecimento.html?mensagem=" . urlencode($mensagem));
        echo "Cadastro feito com sucesso";
        exit;
    }
} else {
    $mensagem = 'Método inválido.';
    header("location: ../html/gerenciaEstabelecimento.html?mensagem=" . urlencode($mensagem));
    echo "Cadastro não realizado";
    exit;
}
?>
