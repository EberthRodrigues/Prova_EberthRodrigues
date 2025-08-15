<?php
    session_start();
    require_once 'conexao.php';
    
    // verifica se o usuario tem permição
    // Supondo que o peril seja ADM

    if ($_SESSION['perfil']!= 1){
        echo "Acesso negado";  
         exit();
    }

    if ($_SERVER["REQUEST_METHOD"]== "POST"){
        $nome = $_SESSION['nome'];
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $id_perfil = $_POST['id_perfil'];

        $sql = "INSERT INTO usuario (nome, email, senha, id_perfil) VALUES (:nome,:email, :senha, :id_perfil)";
        $stmtPerfil = $pdo->prepare($sql);
        $stmtPerfil->bindParam(':nome', $nome);
        $stmtPerfil->bindParam(':email', $email);
        $stmtPerfil->bindParam(':senha', $senha);
        $stmtPerfil->bindParam(':id_perfil', $id_perfil);

        if ($stmtPerfil->execute()) {

        };

    }

?>