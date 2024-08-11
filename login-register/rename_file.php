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
$old_filename = $data['old_filename'];
$new_filename = $data['new_filename'];

$check_duplicate = $conn->prepare("SELECT * FROM files WHERE filename = ?");
$check_duplicate->bind_param("s", $new_filename);
$check_duplicate->execute();
$result = $check_duplicate->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "New filename already exists."]);
} else {
    $update_file = $conn->prepare("UPDATE files SET filename = ? WHERE filename = ?");
    $update_file->bind_param("ss", $new_filename, $old_filename);
    $update_file->execute();

    if (rename("uploads/" . $old_filename, "uploads/" . $new_filename)) {
        echo json_encode(["status" => "success", "message" => "File renamed successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to rename file."]);
    }
}

$conn->close();
?>
