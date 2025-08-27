<?php
require_once 'includes/cabecalho.php';
require_once 'conexao.php';

// verifica se o usuário tem permissão (Administrador)
if ($_SESSION['perfil'] != 1) {
    echo "Acesso negado";  
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_fornecedor = $_POST['nome_fornecedor'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $contato = $_POST['contato'];
    $id_funcionario_registro = $_SESSION['id_usuario']; // supondo que o usuário logado seja o registrador

    $sql = "INSERT INTO fornecedor (nome_fornecedor, endereco, telefone, email, contato, id_funcionario_registro) VALUES (:nome_fornecedor, :endereco, :telefone, :email, :contato, :id_funcionario_registro)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":nome_fornecedor", $nome_fornecedor);
    $stmt->bindParam(":endereco", $endereco);
    $stmt->bindParam(":telefone", $telefone);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":contato", $contato);
    $stmt->bindParam(":id_funcionario_registro", $id_funcionario_registro);

    if ($stmt->execute()) {
        echo "<script>alert('Fornecedor cadastrado com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar fornecedor!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cadastrar Fornecedor</title>
<link rel="stylesheet" href="styles.css?v=2">
</head>
<body>

<h2>Cadastrar Fornecedor</h2>
<form action="cadastro_fornecedor.php" method="POST">
    <label for="nome_fornecedor">Nome do Fornecedor: </label>
    <input type="text" name="nome_fornecedor" id="nome_fornecedor" pattern="[A-Za-zÀ-ÿ ]+" title="Apenas letras e espaços são permitidos." required>

    <label for="endereco">Endereço: </label>
    <input type="text" name="endereco" id="endereco" required>

    <label for="telefone">Telefone: </label>
    <input type="text" name="telefone" id="telefone" required>

    <label for="email">Email: </label>
    <input type="email" name="email" id="email" required>

    <label for="contato">Contato: </label>
    <input type="text" name="contato" id="contato" pattern="[A-Za-zÀ-ÿ ]+" title="Apenas letras e espaços são permitidos." required>

    <button type="submit">Cadastrar</button><br>
    <button type="reset">Cancelar</button>
</form>

<script>
// Impede números e símbolos nos campos de nome e contato
const nomeInput = document.getElementById('nome_fornecedor');
nomeInput.addEventListener('input', function() {
    this.value = this.value.replace(/[^A-Za-zÀ-ÿ ]/g, '');
});

const contatoInput = document.getElementById('contato');
contatoInput.addEventListener('input', function() {
    this.value = this.value.replace(/[^A-Za-zÀ-ÿ ]/g, '');
});
</script>


<script>

const telefoneInput = document.getElementById('telefone');

telefoneInput.addEventListener('input', function(e) {
    let x = this.value.replace(/\D/g, ''); 
    if (x.length > 11) x = x.slice(0, 11); 

    let formatted = '';
    if (x.length > 0) formatted += '(' + x.substring(0, 2);
    if (x.length >= 3) formatted += ') ' + x.substring(2, 7);
    if (x.length >= 8) formatted += '-' + x.substring(7, 11);

    this.value = formatted;
});
</script>


<a href="principal.php">Voltar</a>

</body>
</html>