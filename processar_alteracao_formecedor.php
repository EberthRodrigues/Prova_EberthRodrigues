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
    $id_usuario= $_POST['id_usuario'];
    $nome= $_POST['nome'];
    $email= $_POST['email'];
    $id_perfil= $_POST['id_perfil'];
    $nova_senha= !empty($_POST['$nova_senha']) ? password_hash($_POST['nova_senha'], PASSWORD_DEFAULT): NULL;

    // Atualiza os dados do usuario
    if  ($nova_senha){
        $sql = "UPDATE usuario SET nome = :nome, email = :email, id_perfil = :id_perfil , senha =:senha WHERE id_usuario =:id_usuario";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':senha', $nova_senha);
        } else {
            $query = "UPDATE usuario SET nome = :nome, email = :email, id_perfil = :id_perfil WHERE id_usuario = :id_usuario";

            $stmt = $pdo -> prepare($query);
        }

        $stmt -> bindParam(":nome", $nome);
        $stmt -> bindParam(":email", $email);
        $stmt -> bindParam(":id_perfil", $id_perfil);
        $stmt -> bindParam(":id_usuario", $id_usuario);

        if($stmt -> execute()) {
            echo "<script> alert('Usuário alterado com sucesso!'); window.location.href='buscar_usuario.php'; </script>";
        } else {
            echo "<script> alert('Erro ao atualizar usuário!'); window.location.href='alterar_usuario.php'; </script>";
        }
    }
?>