<?php
        require_once 'includes/cabecalho.php';
        require_once 'conexao.php';

// VERIFICA SE O USUARIO TEM PERMISSAO DE adm
if ($_SESSION['perfil'] != 1) {
    echo "<script> alert('Acesso Negado!'); window.location.href='principal.php'; </script>";
    exit();
}

// INCIALIZA AS VARIAVEIS
$fornecedor = null;

// SE O FORMULARIO FOR ENVIADO, BUSCA O USUARIO PELO id OU PELO nome
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['busca_fornecedor'])) {
        $busca = trim($_POST['busca_fornecedor']);

        // VERIFICA SE A BUSCA É UM id OU UM nome
        if (is_numeric($busca)) {
            $query = "SELECT * FROM fornecedor WHERE id_fornecedor = :busca";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":busca", $busca, PDO::PARAM_INT);
        } else {
            $query = "SELECT * FROM fornecedor WHERE nome_fornecedor LIKE :busca_nome_fornecedor";

            $stmt = $pdo->prepare($query);
            $stmt->bindValue(":busca_nome_fornecedor", $busca, PDO::PARAM_STR);
        }

        $stmt->execute();
        $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);

        // SE O USUARIO NÃO FOR ENCONTRADO, EXIBE UM ALERTA
        if (!$fornecedor) {
            echo "<script> alert('Fornecedor não encontrado!'); </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css?v=2">
    <title>Alterar Fornecedor</title>
    <!-- Certifique-se de que o JavaScript está sendo carregando  corretamente -->
</head>

<body>
    <h2>Alterar fornecedor</h2>

    <!--Formulario para buscar usuarios-->
    <form action="alterar_fornecedor.php" method="POST">
        <label for="busca_fornecedor">Digite o id ou nome do fornecedor:</label>
        <input type="text" id="busca_fornecedor" name="busca_fornecedor" required onkeyup="buscarSugestoes()">

        <div id="sugestoes"></div>
        <button type="submit">Buscar</button>

    </form>

    <?php if ($fornecedor): ?>
        <form action="processar_alteracao_usuario.php" method="POST">

            <input type="hidden" name="id_fornecedor" value="<?= htmlspecialchars($fornecedor['id_fornecedor']) ?>">

            <label for="nome_fornecedor">Nome_fornecedor:</label>
            <input type="text" id="nome_fornecedor" name="nome_fornecedor" value="<?= htmlspecialchars($fornecedor['nome_fornecedor']) ?>" required>

            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" value="<?= htmlspecialchars($fornecedor['endereco']) ?>" required>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" value="<?= htmlspecialchars($fornecedor['telefone']) ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($fornecedor['email']) ?>" required>

            <label for="contato">contato:</label>
            <input type="text" id="contato" name="contato" value="<?= htmlspecialchars($fornecedor['contato']) ?>" required>

            <label for="id_funcionario_registro">Perfil:</label>
            <select name="id_funcionario_registro" id="id_funcionario_registro">
                <option value="1" <?= $fornecedor['id_funcionario_registro'] == 1 ? 'selected' : '' ?>>Administrador</option>
                <option value="2" <?= $fornecedor['id_funcionario_registro'] == 2 ? 'selected' : '' ?>>Secretária</option>
                <option value="3" <?= $fornecedor['id_funcionario_registro'] == 3 ? 'selected' : '' ?>>Almoxarife</option>
                <option value="4" <?= $fornecedor['id_funcionario_registro'] == 4 ? 'selected' : '' ?>>Cliente</option>

            </select>
            <!-- Se o fornecedor logado for ADM, exibir opção de alterar senha -->

            <?php if ($_SESSION['perfil'] == 1): ?>
                <label for="nova_senha">Nova senha</label>
                <input type="password" id="nova_senha" name="nova_senha">
            <?php endif; ?>
            <button type="submit">Alterar</button> <br>
            <button type="reset">Cancelar</button>

        </form>

    <?php endif; ?>
    <a href="principal.php">Voltar</a>
  

</body>

</html>