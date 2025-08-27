<?php
    require_once 'includes/cabecalho.php';
    require_once 'conexao.php';

    if($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2) {
        echo "<script> alert('Acesso negado!'); window.location.href='principal.php'; </script>";
        exit();
    }

    // INICIALIZA A VARIÁVEL PARA EVITAR ERROS
    $fornecedores = [];

    // SE O FORMULÁRIO FOR ENVIADO, BUSCA O Fornecedor PELO ID OU NOME
    if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['busca'])) {
        $busca = trim($_POST['busca']);
        
        // VERIFICA SE A BUSCA É UM NÚMERO (id) OU UM nome
        if(is_numeric($busca)) {
            $sql = "SELECT * FROM fornecedor WHERE id_fornecedor = :busca ORDER BY nome_fornecedor ASC";

            $stmt = $pdo -> prepare($sql);
            $stmt -> bindParam(":busca", $busca, PDO::PARAM_INT);
        } else {
            $sql = "SELECT * FROM fornecedor WHERE nome_fornecedor LIKE :busca_nome";

            $stmt = $pdo -> prepare($sql);
            $stmt -> bindValue(":busca_nome", "$busca%", PDO::PARAM_STR);
        }
    } else {
        $sql = "SELECT * FROM fornecedor ORDER BY nome_fornecedor ASC";

        $stmt = $pdo -> prepare($sql);
    }

    $stmt -> execute();
    $fornecedores = $stmt -> fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar fornecedor</title>
    <link rel="stylesheet" href="styles.css?v=2">


</head>
<body>
    <h2>Lista de Fornecedores</h2>

    <!-- FORMULÁRIO PARA BUSCAR Fornecedores -->
    <form action="buscar_fornecedor.php" method="POST">
        <label for="busca">Digite o ID ou NOME (opcional):</label>
        <input type="text" id="busca" name="busca">

        <button type="submit">Pesquisar</button>
    </form>

    <?php if(!empty($fornecedores)):?>

        <table border>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Endereço</th>
                <th>Telefone</th>
                <th>E-mail</th>
                <th>Contato</th>
                <th>Ações</th>
            </tr>

            
            <?php foreach($fornecedores as $fornecedor): ?>
                <tr>
                    <td> <?= htmlspecialchars($fornecedor['id_fornecedor']); ?></td>
                    <td> <?= htmlspecialchars($fornecedor['nome_fornecedor']); ?></td>
                    <td> <?= htmlspecialchars($fornecedor['endereco']); ?></td>
                    <td> <?= htmlspecialchars($fornecedor['telefone']); ?></td>
                    <td> <?= htmlspecialchars($fornecedor['email']); ?></td>
                    <td> <?= htmlspecialchars($fornecedor['contato']); ?></td>
                    <td> 
                        <a href="alterar_fornecedor.php?id=<?= htmlspecialchars($$fornecedor['id_fornecedor']) ?>">Alterar</a>
                        <a href="excluir_fornecedor.php?id=<?= htmlspecialchars($fornecedor['id_fornecedor']) ?>" onclick="return confirm('Você tem certea que deseja excluí-lo?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum fornecedor encontrado!</p>
    <?php endif; ?>

    <a href="principal.php">Voltar</a>
</body>
</html>