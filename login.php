<?php
session_start();
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST('email');
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuario WHERE email=:email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        // Login bem sucedido, define variaveis de sessao
        $_SESSION['usuario'] = $usuario['nome'];
        $_SESSION['perfil'] = $usuario['id_perfil'];
        $_SESSION['id_usuario'] = $usuario['id_usuario'];

        //Verifica s a senha é temporaria
        if ($usuario['senha_temporaria']) {
            // redireciona para a troca da senha temporaria
            header("Location: alterar_senha.php");
            exit();
        } else {
            // Redireciona para a pagina principal
            header("Location: principal.php");
            exit();
        }
    } else {
        // Login invalido
        echo "<script> alert('E-mail ou sehnha incorretos'); window.location.href='login.php';  <script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css"> <!-- importa o css dentro da pasta -->
</head>
<body>
    <h2> Login </h2>
    <form action="login.php" method="POST">
        <label for="email" >E-mail</label>
            <input type="email" id="email" name="email" required><br>

        <label for="senha" >Senha</label>
            <input type="password" id="senha" name="senha" required><br>

            <button type="submit" href="#">Entrar</button>
    </form>

    <p><a href="recuperar_senha.php"> Esqueci minha senha?</a></p>


</body>
</html>