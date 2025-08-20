<?php
    session_start();
    require_once 'conexao.php';
    
    // verifica se o usuario tem permição
    // Supondo que o peril seja ADM

    if ($_SESSION['perfil']!= 1){
        echo "Acesso negado";  
            exit();
    }

    if ($_SERVER['REQUEST_METHOD']== 'POST'){
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $id_perfil = $_POST['id_perfil'];

        $sql = "INSERT INTO usuario (nome, email, senha, id_perfil) VALUES (:nome,:email, :senha, :id_perfil)";

        $stmtPerfil = $pdo -> prepare($sql);
        
        $stmtPerfil->bindParam(":nome", $nome);
        $stmtPerfil->bindParam(":email", $email);
        $stmtPerfil->bindParam(":senha", $senha);
        $stmtPerfil->bindParam(":id_perfil", $id_perfil);

        if ($stmtPerfil->execute()) {
            echo "<script> alert('Usuario cadastro com sucesso!'); </script>";

        } else{
            echo "<script>alert('Erro ao cadastrar!'); </script>";

        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Cadastrar usuario</h2>    
    <form action="cadastro_usuario.php" method="POST">
        <label for="nome">Nome: </label>
            <input type="text" name="nome" id="nome" required>
    
        <label for="email">Email: </label>
            <input type="email" name="email" id="email" required>
    
        <label for="senha">Senha: </label>
            <input type="password" name="senha" id="senha" required>

        <label for="id_perfil">Perfil: </label>
            <select name="id_perfil" id="id_perfil" required>
                <option value="1"> Administrador</option>
                <option value="2"> Secretaria </option>
                <option value="3"> Almoxarife </option>
                <option value="4"> Cliente</option>
            </select>
            
            <button type="submit">Salvar</button>
            <button type="reset">Cancelar</button>
            
    
    </form>
<a href="principal.php">Voltar</a>
</body>
</html>