<?php
session_start();

try {
    // Receber dados do formulário
    $nome = $_POST['nome'] ?? '';
    $servico1 = $_POST['servico1'] ?? '';
    $servico2 = $_POST['servico2'] ?? '';
    $servico3 = $_POST['servico3'] ?? '';

    // Dias/horários selecionados (checkboxes)
    $diasHorarios = $_POST['diasHorarios'] ?? [];
    if(!is_array($diasHorarios)) $diasHorarios = [];

    // Horários selecionados no calendário
    $horariosSelecionados = $_POST['horariosSelecionados'] ?? [];
    if(!is_array($horariosSelecionados)) $horariosSelecionados = [];

    // Foto recebida
    $fotoInfo = '';
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK){
        $fotoInfo = "📁 Nome: " . $_FILES['foto']['name'] . "<br>" .
                    "📏 Tamanho: " . round($_FILES['foto']['size']/1024, 2) . " KB<br>" .
                    "🧠 Tipo: " . $_FILES['foto']['type'] . "<br>" .
                    "<img src='data:" . $_FILES['foto']['type'] . ";base64," . base64_encode(file_get_contents($_FILES['foto']['tmp_name'])) . "' style='max-width:150px; margin-top:10px;'>";
    } else {
        $fotoInfo = "Nenhuma foto enviada";
    }

    // Exibir resultados
    echo "<h2>Funcionário Cadastrado</h2>";
    echo "<b>Nome:</b> $nome<br>";
    echo "<b>Serviços selecionados:</b> " . implode(", ", array_filter([$servico1, $servico2, $servico3])) . "<br>";
    echo "<b>Dias/Horários (checkboxes) selecionados:</b> " . (!empty($diasHorarios) ? implode(", ", $diasHorarios) : "Nenhum selecionado") . "<br>";
    echo "<b>Horários do calendário selecionados:</b> " . (!empty($horariosSelecionados) ? implode(", ", $horariosSelecionados) : "Nenhum selecionado") . "<br>";
    echo "<b>Foto recebida:</b><br>$fotoInfo<br>";

} catch (Exception $e) {
    http_response_code(500);
    echo "Erro ao processar os dados: " . $e->getMessage();
}
?>
