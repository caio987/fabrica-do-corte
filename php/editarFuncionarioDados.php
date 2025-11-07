<?php
include 'config.php';

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("  SELECT f.nome, f.foto, 
         fs.id_servico AS servicos, 
         fd.id_disponibilidade AS diasHorarios
  FROM funcionarios f
  JOIN servico_funcionario fs ON fs.id_funcionario = f.id_funcionario
  JOIN disponibilidade_funcionario fd ON fd.id_funcionario = f.id_funcionario
  WHERE f.id_funcionario = ?
  GROUP BY f.id_funcionario
");
$stmt->execute([$id]);
$dados = $stmt->fetch(PDO::FETCH_ASSOC);

if ($dados) {
    $dados['servicos'] = explode(',', $dados['servicos']);
    $dados['diasHorarios'] = explode(',', $dados['diasHorarios']);
    header('Content-Type: application/json');
    echo json_encode($dados);
} else {
    echo json_encode([]);
}
