<?php
// cadastrarFuncionario.php
session_start();

try {
    // Receber dados do formulário
    $nome = $_POST['nome'] ?? '';
    $servico1 = $_POST['servico1'] ?? null;
    $servico2 = $_POST['servico2'] ?? null;
    $servico3 = $_POST['servico3'] ?? null;

    // Receber dias/horários selecionados (JSON)
    $diasHorarios = json_decode($_POST['diasHorarios'] ?? '[]', true);
    if (!$diasHorarios) $diasHorarios = [];

    // Receber e armazenar a foto como BLOB (apenas para teste, não salva)
    $fotoInfo = '';
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK){
        $fotoInfo = "Arquivo recebido: " . $_FILES['foto']['name'] . " | Tamanho: " . $_FILES['foto']['size'] . " bytes";
    } else {
        $fotoInfo = "Nenhuma foto enviada";
    }

    // Exibir os dados recebidos
    echo "<b>Nome:</b> $nome<br>";
    echo "<b>Serviços selecionados:</b> $servico1, $servico2, $servico3<br>";
    echo "<b>Dias/Horários selecionados:</b> " . implode(", ", $diasHorarios) . "<br>";
    echo "<b>Foto:</b> $fotoInfo<br>";

} catch (Exception $e) {
    http_response_code(500);
    echo "Erro ao processar os dados: " . $e->getMessage();
}
?>
