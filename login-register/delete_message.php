<?php
header('Content-Type: application/json');
require 'database_file.php'; 

session_start(); 

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];
$author_id = $_SESSION['user_id'];

// Check if the user is the author
$sql = "SELECT author_id FROM messages WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$message = $stmt->fetch(PDO::FETCH_ASSOC);

if ($message && $message['author_id'] == $author_id) {
    $sql = "DELETE FROM messages WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$id])) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error deleting message']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
}
?>
