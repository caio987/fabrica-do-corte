<?php
session_start();
//Dizer para o navegador que os dados serão enviados via JSON
header('Content-type: application/json');
//Armazenar os dados 
$resultados = $_SESSION['resultados'] ?? [];
//Percorrer os dados e alterar a informação de type para data
foreach ($resultados as &$e) {
    if (isset($e['foto_estabelecimento'])&& isset($e['logo_barbearia'])) {
        $e['foto'] = str_replace('type:','data:',$e['foto_estabelecimento']);
        $e['logo'] = str_replace('type:','data:',$e['logo_barbearia']);
    }else {
        $e['foto'] = [];
        $e['logo'] = [];
    }
}
echo json_encode($resultados);
exit;