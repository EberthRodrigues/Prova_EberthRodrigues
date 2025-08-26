<?php
    session_start();
    require_once 'conexao.php';
    
    // verifica se o fornecedor tem permição
    // Supondo que o peril seja ADM

    if ($_SESSION['perfil']!= 1){
        echo "Acesso negado";  
            exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome_fornecedor = $_POST['nome_fornecedor'];
        $endereco = $_POST['endereco'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
        $contato = $_POST['contato'];
        $id_funcionario_registro = $_SESSION['id_usuario']; // supondo que o fornecedor logado seja o registrador
    
        $sql = "INSERT INTO fornecedor (nome_fornecedor, endereco, telefone, email,contato, id_funcionario_registro) VALUES (:nome_fornecedor,:endereco, :telefone, :email, :contato,:id_funcionario_registro)";

        $stmtPerfil = $pdo -> prepare($sql);
        
        $stmtPerfil->bindParam(":nome_fornecedor", $nome_fornecedor);
        $stmtPerfil->bindParam(":endereco", $endereco);
        $stmtPerfil->bindParam(":telefone", $telefone);
        $stmtPerfil->bindParam(":email", $email);
        $stmtPerfil->bindParam(":contato", $contato);
        $stmtPerfil->bindParam(":id_funcioario_registro", $id_funcioario_registro);

        if ($stmtPerfil->execute()) {
            echo "<script> alert('Fornecedor cadastro com sucesso!'); </script>";

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
    <title>Fornecedor</title>
    <link rel="stylesheet" href="styles.css?v=2">

</head>
<body>

<h2>Cadastrar fornecedor</h2>
<form action="cadastro_fornecedor.php" method="POST">
    <label for="nome_fornecedor">Nome: </label>
    <input type="text" name="nome" id="nome" pattern="[A-Za-zÀ-ÿ ]+" title="Apenas letras e espaços são permitidos." required>

    <label for="endereco">Endereço: </label>
    <input type="text" name="endereco" id="endereco" required>

    <label for="telefone">telefone: </label>
    <input type="text" name="telefone" id="telefone" required>

    <label for="email">Email: </label>
    <input type="email" name="email" id="email" required>

    <label for="contato">Contato: </label>
    <input type="text" name="contato" id="contato" required>

    
        <label for="id_perfil">Perfil: </label>
            <select name="id_perfil" id="id_perfil" required>
                <option value="1"> Administrador</option>
                <option value="2"> Secretaria </option>
                <option value="3"> Almoxarife </option>
                <option value="4"> Cliente</option>
            </select>
            <button type="submit">Cadastrar</button><br>
            <button type="reset">Cancelar</button>
    
    </form>
    
<script>
const nomeInput = document.getElementById('nome');

nomeInput.addEventListener('input', function() {
    this.value = this.value.replace(/[^A-Za-zÀ-ÿ ]/g, '');
});
</script>

<a href="principal.php">Voltar</a>
<script src="validacoes.js"></script>

</body>
</html>