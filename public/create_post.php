<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $autor_id = $_SESSION['usuario_id'];

    $query = $pdo->prepare('INSERT INTO posts (titulo, conteudo, autor_id) VALUES (:titulo, :conteudo, :autor_id)');
    $query->execute(['titulo' => $titulo, 'conteudo' => $conteudo, 'autor_id' => $autor_id]);

    echo "Post criado com sucesso! <a href='index.php'>Voltar para a página inicial</a>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criar Post</title>
</head>
<body>
    <h1>Criar Novo Post</h1>
    <form method="POST">
        <label>Título:</label>
        <input type="text" name="titulo" required><br>
        <label>Conteúdo:</label>
        <textarea name="conteudo" required></textarea><br>
        <button type="submit">Criar Post</button>
    </form>
    <p><a href="index.php">Voltar para a página inicial</a></p>
</body>
</html>
