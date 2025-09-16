<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    try {
        // Limpa a entrada do usuário
        $busca = filter_var($_POST['busca'], FILTER_SANITIZE_SPECIAL_CHARS);

        // Prepara a consulta com LIKE
        $consulta = $pdo->prepare("SELECT * FROM cliente WHERE nome LIKE :nome");

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
            foreach ($resultados as $cliente) {
                echo "Nome: {$cliente['nome']} ";
                echo "Sobrenome: {$cliente['sobrenome']} ";
                echo "E-mail: {$cliente['email']}<br>";
            }
        } else {
            echo "Nenhum cliente encontrado com esse nome.";
        }
    } catch (PDOException $e) {
        echo 'ERRO: ' . $e->getMessage();
    }
}
?>
