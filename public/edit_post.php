<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    echo "Post não encontrado!";
    exit();
}

$post_id = $_GET['id'];

$query = $pdo->prepare('SELECT * FROM posts WHERE id = :id');
$query->execute(['id' => $post_id]);
$post = $query->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    echo "Post não encontrado!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];

    $query = $pdo->prepare('UPDATE posts SET titulo = :titulo, conteudo = :conteudo WHERE id = :id');
    $query->execute(['titulo' => $titulo, 'conteudo' => $conteudo, 'id' => $post_id]);

    echo "Post editado com sucesso! <a href='index.php'>Voltar para a página inicial</a>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Post</title>
</head>
<body>
    <h1>Editar Post</h1>
    <form method="POST">
        <label>Título:</label>
        <input type="text" name="titulo" value="<?= htmlspecialchars($post['titulo']) ?>" required><br>
        <label>Conteúdo:</label>
        <textarea name="conteudo" required><?= htmlspecialchars($post['conteudo']) ?></textarea><br>
        <button type="submit">Salvar alterações</button>
    </form>
    <p><a href="index.php">Voltar para a página inicial</a></p>
</body>
</html>
