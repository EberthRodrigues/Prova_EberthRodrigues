<?php
    session_start();
    require_once 'conexao.php';
    
    // Garante que o usuario esteja logado
    if (isset(['id_usuario'])){
        echo "<script> alert('Acesso negado!') <script>"
        exit();
    }


?>