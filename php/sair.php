<?php
//inicia a sessão e depois deleta
    session_start();
    session_destroy();
    //Redireciona para a tela inicial
    header("location: ../html/index.html");
    exit;
?> 