<?php
    session_start();
    require_once 'conexao.php';

// VERIFICA SE O fornecedor TEM PERMISSAO DE adm
if ($_SESSION['perfil'] != 1) {
    echo "<script> alert('Acesso Negado!'); window.location.href='principal.php'; </script>";
    exit();
}


// SE O FORMULARIO FOR ENVIADO, BUSCA O fornecedor PELO id OU PELO nome
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario= $_POST['id_fornecedor'];
    $nome= $_POST['endereco'];
    $nome= $_POST['telefone'];
    $nome= $_POST['email'];
    $nome= $_POST['contato'];
    $email= $_POST['email'];
    $id_funcionario_registro= !empty($_POST['$id_funcionario_registro']) ? password_hash($_POST['id_funcionario_$id_funcionario_registro'], PASSWORD_DEFAULT): NULL;

    // Atualiza os dados do fornecedor
    if  ($id_funcionario_registro){
        $sql = "UPDATE forencedor SET 
                nome_fornecedor = :nome_fornecedor,
                endereco = :endereco, 
                telefone =:telefone, email=:email,
                contato=:contato, 
                id_funcionario_registro=:id_funcionario_registro
                WHERE id_fornecedor =:id_fornecedor";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':senha', $id_funcionario_registro);
        } else {
            $query = "UPDATE usuario SET
            nome_fornecedor = :nome_fornecedor,
            endereco = :endereco,
            telefone =:telefone,
            email=:email, 
            contato=:contato,
            id_funcionario_registro=:id_funcionario_registro
            WHERE id_fornecedor = :id_fornecedor";

            $stmt = $pdo -> prepare($query);
        }

        $stmt -> bindParam(":nome_fornecedor", $nome);
        $stmt -> bindParam(":endereco", $email);
        $stmt -> bindParam(":telefone", $telefone);
        $stmt -> bindParam(":email", $email);
        $stmt -> bindParam(":contato", $contato);
        $stmt -> bindParam(":id_funcionario_registro", $id_funcionario_registro);

        if($stmt -> execute()) {
            echo "<script> alert('fornecedor alterado com sucesso!'); window.location.href='buscar_usuario.php'; </script>";
        } else {
            echo "<script> alert('Erro ao atualizar fornecedor!'); window.location.href='alterar_usuario.php'; </script>";
        }
    }
?>