<?php
$servername = "localhost";
$username = "root";
$password = ""; // ou sua senha do MySQL, se tiver
$dbname = "fabrica_do_corte"; // nome do banco correto

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
