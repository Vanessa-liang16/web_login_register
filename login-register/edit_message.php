<?php
header('Content-Type: application/json');
require 'database_file.php';

session_start(); 

$data = json_decode(file_get_contents('php://input'), true);
$message_id = $data['message_id'];
$title = $data['title']; // Ensure this key is passed in the request
$content = $data['content'];
$author_id = $_SESSION['user_id'];

$sql = "SELECT author_id FROM messages WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$message_id]);
$message = $stmt->fetch(PDO::FETCH_ASSOC);

if ($message && $message['author_id'] == $author_id) {
    // 更新消息
    $sql = "UPDATE messages SET title = ?, content = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$title, $content, $message_id])) {
        echo json_encode(['success' => true]);
    } else {
        $errorInfo = $stmt->errorInfo();
        echo json_encode(['success' => false, 'error' => 'Error updating message: ' . $errorInfo[2]]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
}
?>

