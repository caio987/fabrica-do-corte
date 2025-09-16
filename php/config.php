<?php
    //Váriaveis com as informações do banco de dados
    $host = 'localhost';
    $dbname = 'fabrica-do-corte';
    $user = 'root';
    $senha = '';

    try {
        //váriavel dsn
        $dsn = "mysql:host=$host;dbname=$dbname";
        //Linkar o banco de dados
        $pdo = new PDO($dsn,$user,$senha);
        // echo 'Banco de dados linkado';
    } catch (PDOException $e) {
        echo 'ERRO '.$e->getMessage();
    }
?>