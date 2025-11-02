<?php
require_once 'config.php';
session_start();
header('Content-Type: application/json; charset=utf-8');

$id = $_SESSION['id'];

try {
    $agendamentos = [];

    if (isset($_SESSION['tipo'])) {

        if ($_SESSION['tipo'] === 'Cliente') {
            $stmt = $pdo->prepare("
                SELECT 
                    ag.id_agendamento,
                    e.nome_estabelecimento,
                    e.foto_estabelecimento,
                    e.localizacao,
                    f.nome AS nome_funcionario,
                    f.foto,
                    c.nome AS nome_cliente,
                    d.dia,
                    d.horario,
                    s.nome_servico,
                    s.preco
                FROM agendamento AS ag
                JOIN cliente AS c ON ag.id_cliente = c.id_cliente
                JOIN disponibilidade AS d ON ag.id_disponibilidade = d.id_disponibilidade
                JOIN funcionarios AS f ON ag.id_funcionario = f.id_funcionario
                JOIN agendamento_servico AS ags ON ag.id_agendamento = ags.id_agendamento
                JOIN servico AS s ON ags.id_servico = s.id_servico
                JOIN estabelecimento AS e ON f.id_estabelecimento = e.id_estabelecimento
                WHERE ag.id_cliente = :id
                ORDER BY ag.id_agendamento
            ");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dados as $row) {
                $idAg = $row['id_agendamento'];
                if (!isset($agendamentos[$idAg])) {
                    $foto = !empty($row['foto_estabelecimento']) ? str_replace('type:', 'data:', $row['foto_estabelecimento']) : null;
                    $fotoBarbeiro = !empty($row['foto']) ? str_replace('type:', 'data:', $row['foto']) : null;

                    $agendamentos[$idAg] = [
                        'tipo'=>'Cliente',
                        'id_agendamento' => $idAg,
                        'estabelecimento' => $row['nome_estabelecimento'],
                        'localizacao' => $row['localizacao'],
                        'foto' => $foto,
                        'foto_barbeiro' => $fotoBarbeiro,
                        'cliente' => $row['nome_cliente'] ?? null,
                        'funcionario' => $row['nome_funcionario'],
                        'dia' => $row['dia'],
                        'horario' => $row['horario'],
                        'servicos' => []
                    ];
                }
                $agendamentos[$idAg]['servicos'][] = [
                    'nome_servico' => $row['nome_servico'],
                    'preco' => $row['preco']
                ];
            }

        } elseif ($_SESSION['tipo'] === 'Proprietário') {
            $stmt = $pdo->prepare("
                SELECT 
                    ag.id_agendamento,
                    c.nome AS nome_cliente,
                    f.nome AS nome_funcionario,
                    f.foto,
                    d.dia,
                    d.horario,
                    s.nome_servico,
                    s.preco
                FROM agendamento AS ag
                JOIN cliente AS c ON ag.id_cliente = c.id_cliente
                JOIN disponibilidade AS d ON ag.id_disponibilidade = d.id_disponibilidade
                JOIN funcionarios AS f ON ag.id_funcionario = f.id_funcionario
                JOIN agendamento_servico AS ags ON ag.id_agendamento = ags.id_agendamento
                JOIN servico AS s ON ags.id_servico = s.id_servico
                JOIN estabelecimento AS e ON f.id_estabelecimento = e.id_estabelecimento
                WHERE e.id_estabelecimento = :id
                ORDER BY ag.id_agendamento
            ");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dados as $row) {
                $idAg = $row['id_agendamento'];
                if (!isset($agendamentos[$idAg])) {
                    $fotoBarbeiro = !empty($row['foto']) ? str_replace('type:', 'data:', $row['foto']) : null;

                    $agendamentos[$idAg] = [
                        'tipo'=>'Proprietário',
                        'id_agendamento' => $idAg,
                        'foto_barbeiro' => $fotoBarbeiro,
                        'cliente' => $row['nome_cliente'] ?? null,
                        'funcionario' => $row['nome_funcionario'],
                        'dia' => $row['dia'],
                        'horario' => $row['horario'],
                        'servicos' => []
                    ];
                }
                $agendamentos[$idAg]['servicos'][] = [
                    'nome_servico' => $row['nome_servico'],
                    'preco' => $row['preco']
                ];
            }
        }
    }

    // Retorna o JSON UNICO para todos os tipos
    echo json_encode(array_values($agendamentos), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    echo json_encode(['erro' => $e->getMessage()]);
}
