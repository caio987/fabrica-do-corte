<?php
include 'conexao.php';

// Recebe os dados enviados pelo JavaScript
$id = $_POST['id'];
$nome = $_POST['nome'];
$servicos = json_decode($_POST['servicos'], true);
$diasHorarios = json_decode($_POST['diasHorarios'], true);

// ===============================
//  ATUALIZAÇÃO DO FUNCIONÁRIO
// ===============================

// Se foi enviada uma nova foto
if (!empty($_FILES['foto']['name'])) {
    // Lê o conteúdo binário da imagem
    $fotoBinario = file_get_contents($_FILES['foto']['tmp_name']);

    // Atualiza nome e foto (campo BLOB)
    $stmt = $pdo->prepare("UPDATE funcionarios SET nome = ?, foto = ? WHERE id_funcionario = ?");
    $stmt->bindParam(1, $nome);
    $stmt->bindParam(2, $fotoBinario, PDO::PARAM_LOB);
    $stmt->bindParam(3, $id);
    $stmt->execute();
} else {
    // Atualiza apenas o nome (mantém a foto antiga)
    $stmt = $pdo->prepare("UPDATE funcionarios SET nome = ? WHERE id_funcionario = ?");
    $stmt->execute([$nome, $id]);
}

// ===============================
//  ATUALIZAÇÃO DOS SERVIÇOS
// ===============================

// Remove os serviços antigos
$stmtDeleteServ = $pdo->prepare("DELETE FROM funcionario_servico WHERE id_funcionario = ?");
$stmtDeleteServ->execute([$id]);

// Insere os novos serviços selecionados
if (!empty($servicos)) {
    $stmtServ = $pdo->prepare("INSERT INTO funcionario_servico (id_funcionario, id_servico) VALUES (?, ?)");
    foreach ($servicos as $s) {
        $stmtServ->execute([$id, $s]);
    }
}

// ===============================
//  ATUALIZAÇÃO DAS DISPONIBILIDADES
// ===============================

// Remove as disponibilidades antigas
$stmtDeleteDisp = $pdo->prepare("DELETE FROM funcionario_disponibilidade WHERE id_funcionario = ?");
$stmtDeleteDisp->execute([$id]);

// Insere as novas disponibilidades selecionadas
if (!empty($diasHorarios)) {
    $stmtDias = $pdo->prepare("INSERT INTO funcionario_disponibilidade (id_funcionario, id_disponibilidade) VALUES (?, ?)");
    foreach ($diasHorarios as $d) {
        $stmtDias->execute([$id, $d]);
    }
}

// ===============================
//  FINALIZAÇÃO
// ===============================

echo "Funcionário atualizado com sucesso!";
