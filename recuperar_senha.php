<?php
session_start();
require_once 'conexao.php';
require_once 'funcoes_email.php'; // Arquivo com as funcoes qu e geram a senha e simular envio 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST('email');

    $sql = "SELECT * FROM usuario WHERE email=:email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Gera uma senha temporaria e aleatoria 
        $senha_temporaria = gerarSenhaTemporaria();
        $senha_hash = password_hash($senha_temporaria, PASSWORD_DEFAULT);

        // Atualiza a senha do usuario no banco
        $sql = "UPDATE usuario SET senha =: senha, senha_temporaria =  TRUE WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':senha', $senha_hash);
        $stmt->bindParam(':email', $email);

        // Simula o envio do email (Grava em txt)
        simularEnvioEmail($email, $senha_temporaria);
        echo "<script> alert ('uma senha temporaria foi gerada e enviada (simulação), verifica o arquivo emails_simulados.txt);window.location.hfre='login.php'; </script>";
    } else {
        echo "<script> alert('email não encontrado'); </script>";
    }
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>
    <link rel="stylesheet" href="styles.css">
</head>+

<body>
    <h2>Recuperar senha</h2>

    <form action="recuperar_senha.php" method="POST">
        <label for="email">Digite o E-mail cadastrado</label>
        <input type="email" name="email" id="email" required>

        <button type="submit"> Enviar senha Temporaria</button>


    </form>
</body>

</html>