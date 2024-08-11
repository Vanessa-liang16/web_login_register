<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fileManage";

$conn = new mysqli($servername, $username, $password, $dbname);
header('Content-Type: application/json');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);
$filename = $data['filename'];

$delete_file = $conn->prepare("DELETE FROM files WHERE filename = ?");
$delete_file->bind_param("s", $filename);
$delete_file->execute();

if (unlink("uploads/" . $filename)) {
    echo json_encode(["status" => "success", "message" => "File deleted successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to delete file."]);
}

$conn->close();
?>
