<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

// Carrega credenciais
$configPath = __DIR__ . '/config.php';
if (!file_exists($configPath)) {
    http_response_code(500);
    echo json_encode(['error' => 'Configuração do banco não encontrada.']);
    exit;
}
require_once $configPath;

// Conexão PDO
try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro de conexão com o banco.']);
    exit;
}

// --- Rotas ---

// GET ?slug=xxx → post completo
if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];
    $stmt = $pdo->prepare('SELECT id, slug, title, date, author, summary, image, tags, content FROM posts WHERE slug = :slug');
    $stmt->execute(['slug' => $slug]);
    $post = $stmt->fetch();

    if (!$post) {
        http_response_code(404);
        echo json_encode(['error' => 'Post não encontrado.']);
        exit;
    }

    $post['tags'] = json_decode($post['tags']);
    echo json_encode($post);
    exit;
}

// GET ?tag=xxx → lista filtrada por tag
if (isset($_GET['tag'])) {
    $tag = $_GET['tag'];
    $stmt = $pdo->prepare(
        'SELECT id, slug, title, date, author, summary, image, tags
         FROM posts
         WHERE JSON_CONTAINS(tags, JSON_QUOTE(:tag))
         ORDER BY date DESC'
    );
    $stmt->execute(['tag' => $tag]);
    $posts = $stmt->fetchAll();

    foreach ($posts as &$p) {
        $p['tags'] = json_decode($p['tags']);
    }

    echo json_encode($posts);
    exit;
}

// GET (sem parâmetros) → lista de todos os posts (sem content)
$stmt = $pdo->query(
    'SELECT id, slug, title, date, author, summary, image, tags
     FROM posts
     ORDER BY date DESC'
);
$posts = $stmt->fetchAll();

foreach ($posts as &$p) {
    $p['tags'] = json_decode($p['tags']);
}

echo json_encode($posts);
