<?php
    require_once "config.php";
    session_start();
    $id = $_SESSION['id'];
    $tipo = $_SESSION['tipo'];
    if ($tipo = 'Cliente') {
        try {
            $consulta = $pdo->query("SELECT * FROM cliente WHERE id = $id");
            
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

?>