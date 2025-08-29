<?php
$conn = new mysqli("localhost", "root", "", "fabrica_do_corte");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT foto_estabelecimento FROM barbeiros WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $dados = $resultado->fetch_assoc();

        // Detecta tipo da imagem com segurança
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->buffer($dados['foto_estabelecimento']);
        header("Content-Type: $mime");

        echo $dados['foto_estabelecimento'];
    } else {
        echo "Imagem não encontrada.";
    }
} else {
    echo "ID da imagem não fornecido.";
}
?>
