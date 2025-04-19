<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $query = $pdo->prepare('INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)');
    $query->execute(['nome' => $nome, 'email' => $email, 'senha' => $senha_hash]);

    echo "Usuário cadastrado com sucesso! <a href='login.php'>Fazer login</a>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Registrar</title>
</head>
<body>
    <h1>Cadastrar</h1>
    <form method="POST">
        <label>Nome:</label>
        <input type="text" name="nome" required><br>
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Senha:</label>
        <input type="password" name="senha" required><br>
        <button type="submit">Cadastrar</button>
    </form>
    <p><a href="login.php">Já tem uma conta? Faça login</a></p>
</body>
</html>
