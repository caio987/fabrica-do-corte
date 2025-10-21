<?php
session_start();
require_once 'config.php';

$nome = $_POST['nome'] ?? '';
$servicos = isset($_POST['servicos']) ? json_decode($_POST['servicos'], true) : [];
$diasHorarios = isset($_POST['diasHorarios']) ? json_decode($_POST['diasHorarios'], true) : [];
$horariosSelecionados = isset($_POST['horariosSelecionados']) ? json_decode($_POST['horariosSelecionados'], true) : [];

$fotoInfo = '';
if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK){
    $fotoInfo = "📁 Nome: " . $_FILES['foto']['name'] . "<br>" .
                "📏 Tamanho: " . round($_FILES['foto']['size']/1024,2) . " KB<br>" .
                "🧠 Tipo: " . $_FILES['foto']['type'] . "<br>" .
                "<img src='data:" . $_FILES['foto']['type'] . ";base64," . base64_encode(file_get_contents($_FILES['foto']['tmp_name'])) . "' style='max-width:150px;margin-top:10px;'>";
} else {
    $fotoInfo = "Nenhuma foto enviada";
}

echo "<h2>Funcionário Cadastrado</h2>";
echo "<b>Nome:</b> $nome<br>";
echo "<b>Serviços selecionados:</b> " . implode(", ", array_filter($servicos)) . "<br>";
echo "<b>Dias/Horários (IDs) selecionados:</b> " . (!empty($diasHorarios) ? implode(", ", $diasHorarios) : "Nenhum selecionado") . "<br>";
echo "<b>Horários do calendário selecionados:</b> " . (!empty($horariosSelecionados) ? implode(", ", $horariosSelecionados) : "Nenhum selecionado") . "<br>";
echo "<b>Foto recebida:</b><br>$fotoInfo<br>";


try {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $inserir = $pdo->prepare("INSERT INTO funcionarios VALUES ");
    }
} catch (\Throwable $th) {
    //throw $th;
}
?>
