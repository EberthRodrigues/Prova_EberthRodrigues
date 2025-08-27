<?php
    require_once 'includes/cabecalho.php';
    require_once 'conexao.php';

    // VERIFICA SE O fornecedor TEM PERMISSAO DE adm
    if($_SESSION['perfil'] != 1) {
        echo "<script> alert('Acesso Negado!'); window.location.href='principal.php'; </script>";
        exit();
    }

    // INCIALIZA AS VARIAVEIS
    $fornecedores = null;

    // BUSCA TODOS OS fornecedores CADASTRADOS EM ORDEM ALFABETICA
    $query = "SELECT * FROM fornecedor ORDER BY nome_fornecedor ASC";
    
    $stmt = $pdo -> prepare($query);
    $stmt -> execute();
    $fornecedores = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    // SE UM id FOR PASSADO VIA GET, EXCLUI O fornecedor
    if(isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id_fornecedor = $_GET['id'];

        // EXCLUI O fornecedor DO BANCO DE DADOS
        $query = "DELETE FROM fornecedor WHERE id_fornecedor = :id";

        $stmt = $pdo -> prepare($query);
        $stmt -> bindParam(":id", $id_fornecedor, PDO::PARAM_INT);
        
        if($stmt -> execute()) {
            echo "<script> alert('fornecedor excluido com sucesso!'); window.location.href='excluir_fornecedor.php'; </script>";
        } else {
            echo "<script> alert('Erro ao excluir fornecedor!'); </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir fornecedor</title>

    <link rel="stylesheet" href="styles.css?v=2">
</head>
<body>
    <h2>Excluir fornecedor</h2>

    <?php if(!empty($fornecedores)): ?>
        <table border>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Endereço</th>
                <th>Telefone</th>
                <th>Email</th>
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
                        <a href="excluir_fornecedor.php?id=<?= htmlspecialchars($fornecedor['id_fornecedor']) ?>" onclick="return confirm('Você tem certea que deseja excluí-lo?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum fornecedor encontrado</p>
    <?php endif; ?>

    <a href="principal.php"> Voltar</a>
</body>
</html>