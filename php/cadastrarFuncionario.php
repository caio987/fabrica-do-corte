<?php
// Nome do barbeiro
$nome = $_POST['nome'] ?? '';

// Serviços selecionados
$servico1 = $_POST['servico1'] ?? '';
$servico2 = $_POST['servico2'] ?? '';
$servico3 = $_POST['servico3'] ?? '';

// Foto do barbeiro
if(isset($_FILES['foto']) && $_FILES['foto']['error'] === 0){
    $fotoTmp = $_FILES['foto']['tmp_name'];
    $fotoBlob = file_get_contents($fotoTmp); // pega o conteúdo binário
    // Aqui você pode salvar $fotoBlob no banco de dados em um campo BLOB
}

// Exemplo de retorno
echo "Dados recebidos: $nome, $servico1, $servico2, $servico3, foto recebida.";
?>