<?php
include 'conexao.php';

$id = $_POST['id'];
$nome = $_POST['nome'];
$servicos = json_decode($_POST['servicos'], true);
$diasHorarios = json_decode($_POST['diasHorarios'], true);

if (!empty($_FILES['foto']['name'])) {
  $fotoPath = 'uploads/' . basename($_FILES['foto']['name']);
  move_uploaded_file($_FILES['foto']['tmp_name'], $fotoPath);
  $stmt = $pdo->prepare("UPDATE funcionarios SET nome = ?, foto = ? WHERE id_funcionario = ?");
  $stmt->execute([$nome, $fotoPath, $id]);
} else {
  $stmt = $pdo->prepare("UPDATE funcionarios SET nome = ? WHERE id_funcionario = ?");
  $stmt->execute([$nome, $id]);
}

$pdo->prepare("DELETE FROM funcionario_servico WHERE id_funcionario = ?")->execute([$id]);
$stmtServ = $pdo->prepare("INSERT INTO funcionario_servico (id_funcionario, id_servico) VALUES (?, ?)");
foreach ($servicos as $s) $stmtServ->execute([$id, $s]);

$pdo->prepare("DELETE FROM funcionario_disponibilidade WHERE id_funcionario = ?")->execute([$id]);
$stmtDias = $pdo->prepare("INSERT INTO funcionario_disponibilidade (id_funcionario, id_disponibilidade) VALUES (?, ?)");
foreach ($diasHorarios as $d) $stmtDias->execute([$id, $d]);

echo "Funcionário atualizado com sucesso!";
