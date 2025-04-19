<?php
include '../includes/db.php';

if (!isset($_GET['id'])) {
    echo "Post não encontrado!";
    exit();
}

$post_id = $_GET['id'];

// Recuperando o post
$query = $pdo->prepare('SELECT * FROM posts WHERE id = :id');
$query->execute(['id' => $post_id]);
$post = $query->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    echo "Post não encontrado!";
    exit();
}

// Recuperando os comentários
$query = $pdo->prepare('SELECT * FROM comentarios WHERE post_id = :post_id ORDER BY data_comentario DESC');
$query->execute(['post_id' => $post_id]);
$comentarios = $query->fetchAll(PDO::FETCH_ASSOC);

// Enviando comentário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['usuario_id'])) {
        echo "Você precisa estar logado para comentar!";
        exit();
    }

    $usuario_id = $_SESSION['usuario_id'];
    $comentario = $_POST['comentario'];

    $query = $pdo->prepare('INSERT INTO comentarios (post_id, usuario_id, comentario) VALUES (:post_id, :usuario_id, :comentario)');
    $query->execute(['post_id' => $post_id, 'usuario_id' => $usuario_id, 'comentario' => $comentario]);

    header('Location: post.php?id=' . $post_id); // Recarrega a página
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($post['titulo']) ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($post['titulo']) ?></h1>
    <p><?= nl2br(htmlspecialchars($post['conteudo'])) ?></p>
    <p><a href="index.php">Voltar para a página inicial</a></p>

    <h2>Comentários</h2>
    <form method="POST">
        <textarea name="comentario" required></textarea><br>
        <button type="submit">Comentar</button>
    </form>

    <h3>Comentários:</h3>
    <?php foreach ($comentarios as $comentario): ?>
        <div>
            <p><strong>Comentário de <?= htmlspecialchars($comentario['usuario_id']) ?>:</strong></p>
            <p><?= nl2br(htmlspecialchars($comentario['comentario'])) ?></p>
        </div>
    <?php endforeach; ?>
</body>
</html>
