<?php
header('Content-Type: application/json');

// Conexão com o banco (ajuste conforme seu XAMPP)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "seu_banco"; // <-- coloque aqui o nome do seu banco no phpMyAdmin

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    echo json_encode(["erro" => "Falha na conexão: " . $conn->connect_error]);
    exit;
}

// Faz a consulta para pegar todos os estabelecimentos
$sql = "SELECT nome_estabelecimento, localizacao, telefone_estabelecimento, apresentacao, logo_barbearia, foto_estabelecimento 
        FROM estabelecimentos"; // <-- ajuste o nome da tabela se for diferente

$result = $conn->query($sql);

$dados = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Corrige os campos de imagem (caso estejam no formato base64)
        $row['foto'] = str_replace('type:', 'data:', $row['foto_estabelecimento']);
        $row['logo'] = str_replace('type:', 'data:', $row['logo_barbearia']);

        $dados[] = $row;
    }
}

// Fecha a conexão
$conn->close();

// Retorna como JSON
echo json_encode($dados);
exit;
?>
