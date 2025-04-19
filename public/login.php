<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $query = $pdo->prepare('SELECT * FROM usuarios WHERE email = :email');
    $query->execute(['email' => $email]);
    $usuario = $query->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_tipo'] = $usuario['tipo'];
        header('Location: index.php');
        exit();
    } else {
        $erro = 'Email ou senha incorretos';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($erro)) { echo "<p>$erro</p>"; } ?>
    <form method="POST">
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Senha:</label>
        <input type="password" name="senha" required><br>
        <button type="submit">Entrar</button>
    </form>
    <p><a href="register.php">Cadastrar</a></p>
</body>
</html>
