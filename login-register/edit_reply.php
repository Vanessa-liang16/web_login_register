<?php
header('Content-Type: application/json');
require 'database_file.php'; 

session_start(); 

$data = json_decode(file_get_contents('php://input'), true);
$reply_id = $data['reply_id'];
$content = $data['content'];
$author_id = $_SESSION['user_id'];

// 检查用户是否是回复的作者
$sql = "SELECT author_id FROM replies WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$reply_id]);
$reply = $stmt->fetch(PDO::FETCH_ASSOC);

if ($reply && $reply['author_id'] == $author_id) {
    // 更新回复
    $sql = "UPDATE replies SET content = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
   
    if ($stmt->execute([$content, $reply_id])) {
        // 手動json
        $response = '{"success":true}';
        echo $response;
    } else {
       
        $response = '{"success":false, "error":"Error updating reply"}';
        echo $response;
    }
} else {
    
    $response = '{"success":false, "error":"Unauthorized"}';
    echo $response;
}
?>


