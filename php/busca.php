<?php
require_once 'config.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    try {
        //Falar para o naveador que os dados serão enviados via JSON
        // Limpa a entrada do usuário
        $busca = filter_var($_POST['busca'], FILTER_SANITIZE_SPECIAL_CHARS);

        // Prepara a consulta com LIKE
        $consulta = $pdo->prepare("SELECT * FROM estabelecimento WHERE nome_estabelecimento LIKE :nome");

        // Adiciona os curingas para o LIKE
        $nome = "%{$busca}%";

        // Passa o valor para o parâmetro
        $consulta->bindParam(':nome', $nome);

        // Executa a consulta
        $consulta->execute();

        // Busca todos os resultados
        $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

        // Exibe os resultados encontrados
        if (count($resultados) > 0) {
            // $dados  = json_encode($resultados);
            $_SESSION['resultados'] = $resultados;
            header('location: ../html/resultado.html');
        } else {
            $_SESSION['resultados'] = '';
            header('location: ../html/resultado.html');
        }
    } catch (PDOException $e) {
        echo 'ERRO: ' . $e->getMessage();
    }
}
?>
