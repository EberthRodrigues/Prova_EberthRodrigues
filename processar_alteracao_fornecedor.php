<?php
    session_start();
    require_once 'conexao.php';

// VERIFICA SE O USUARIO TEM PERMISSAO DE adm
if ($_SESSION['perfil'] != 1) {
    echo "<script> alert('Acesso Negado!'); window.location.href='principal.php'; </script>";
    exit();
}


// SE O FORMULARIO FOR ENVIADO, BUSCA O USUARIO PELO id OU PELO nome
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_fornecedor= $_POST['id_fornecedor'];
    $nome_fornecedor= $_POST['nome_fornecedor'];
    $endereco= $_POST['endereco'];
    $telefone= $_POST['telefone'];
    $email= $_POST['email'];
    $contato= $_POST['contato'];
    $id_perfil= $_POST['id_perfil'];
    $nova_senha= !empty($_POST['$nova_senha']) ? password_hash($_POST['nova_senha'], PASSWORD_DEFAULT): NULL;

    // Atualiza os dados do usuario
    if  ($nova_senha){
        $sql = "UPDATE fornecedor SET nome_fornecedor = :nome_fornecedor, endereco = :endereco,telefone = :telefone, email = :email, contato =:contato, id_perfil = :id_perfil , senha =:senha WHERE id_fornecedor =:id_fornecedor";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':senha', $nova_senha);
        } else {
            $query = "UPDATE usuario SET nome_fornecedor = :nome_fornecedor, endereco = :endereco, id_perfil = :id_perfil WHERE id_fornecedor = :id_fornecedor";

            $stmt = $pdo -> prepare($query);
        }

        $stmt -> bindParam(":nome_fornecedor", $nome_fornecedor);
        $stmt -> bindParam(":endereco", $endereco);
        $stmt -> bindParam(":id_perfil", $id_perfil);
        $stmt -> bindParam(":id_fornecedor", $id_fornecedor);

        if($stmt -> execute()) {
            echo "<script> alert('Usuário alterado com sucesso!'); window.location.href='buscar_usuario.php'; </script>";
        } else {
            echo "<script> alert('Erro ao atualizar usuário!'); window.location.href='alterar_usuario.php'; </script>";
        }
    }
?>