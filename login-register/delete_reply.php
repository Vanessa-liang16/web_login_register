<?php
header('Content-Type: application/json');
require 'database_file.php'; 

session_start(); 

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];
$author_id = $_SESSION['user_id'];

// Check if the user is the author of the reply
$sql = "SELECT author_id FROM replies WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$reply = $stmt->fetch(PDO::FETCH_ASSOC);

if ($reply && $reply['author_id'] == $author_id) {
    $sql = "DELETE FROM replies WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$id])) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error deleting reply']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
}
?>
