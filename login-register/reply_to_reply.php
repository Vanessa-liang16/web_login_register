<?php
header('Content-Type: application/json');
require 'database_file.php'; 

session_start(); 

$data = json_decode(file_get_contents('php://input'), true);
$reply_id = $data['reply_id'];
$content = $data['content'];
$author_id = $_SESSION['user_id']; 

//insert data
$sql = "INSERT INTO replies (message_id, content, author_id, created_at) VALUES (?, ?, ?, NOW())";
$stmt = $pdo->prepare($sql);

if ($stmt->execute([$reply_id, $content, $author_id])) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Error inserting reply']);
}
?>
