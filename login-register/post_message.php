<?php
header('Content-Type: application/json');
require 'database_file.php'; 

session_start(); 

$data = json_decode(file_get_contents('php://input'), true);

$title = $data['title'];
$content = $data['content'];
$author_id = $_SESSION['user_id'];

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit;
}

$created_at = date('Y-m-d H:i:s');
$sql = "INSERT INTO messages (title, content, author_id,created_at) VALUES (?, ?, ?,?)";
$stmt = $pdo->prepare($sql);
if ($stmt->execute([$title, $content, $author_id, $created_at])) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Error posting message']);
}
?>
