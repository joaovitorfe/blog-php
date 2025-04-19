<?php
include '../includes/db.php';

$query = $pdo->query('SELECT * FROM posts ORDER BY data_criacao DESC');
$posts = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Simples</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <h1>Blog Simples</h1>
    <a href="login.php">Login</a> | <a href="register.php">Cadastro</a>

    <h2>Posts Recentes</h2>
    <?php foreach ($posts as $post): ?>
        <div>
            <h3><a href="post.php?id=<?= $post['id'] ?>"><?= $post['titulo'] ?></a></h3>
            <p><?= substr($post['conteudo'], 0, 100) ?>...</p>
        </div>
    <?php endforeach; ?>
</body>
</html>
