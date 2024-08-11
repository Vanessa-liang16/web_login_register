<?php
session_start();
require_once "database.php";

$data = json_decode(file_get_contents('php://input'), true);
$action = $data['action'];
$member_name = $_SESSION['user_name']; // 假设 session 中保存了用户名

logAction($conn, $member_name, $action);

function logAction($conn, $member_name, $action) {
    $sql = "INSERT INTO logs (member_name, execution_time, record) VALUES (?, NOW(), ?)";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ss', $member_name, $action);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);
?>
