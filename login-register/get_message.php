<?php

session_start();
header('Content-Type: application/json');
ob_clean();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User is not logged in']);
    exit;
}
    
require 'database_file.php'; 

$current_user_id = $_SESSION['user_id'];

try {
    // Fetch messages
    $sql = "SELECT m.id, m.title, m.content, m.created_at, m.author_id, a.name AS author_name, 
                   (SELECT COUNT(*) FROM replies r WHERE r.message_id = m.id) AS reply_count
            FROM messages m
            JOIN authors a ON m.author_id = a.id
            ORDER BY m.created_at DESC";
    $stmt = $pdo->query($sql);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($messages === false) {
        throw new Exception('Error fetching messages');
    }

    // Fetch replies
    foreach ($messages as &$message) {
        $message_id = $message['id'];
        $sql = "SELECT r.id, r.content, r.created_at, a.name AS author_name, r.author_id
                FROM replies r
                JOIN authors a ON r.author_id = a.id
                WHERE r.message_id = ?
                ORDER BY r.created_at ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$message_id]);
        $message['replies'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    echo json_encode(['current_user_id' => $current_user_id, 'messages' => $messages]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

?>
