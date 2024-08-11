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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $filename = $_FILES['file']['name'];
        $filesize = $_FILES['file']['size'];
        $file_tmp = $_FILES['file']['tmp_name'];
        
        // Check for duplicate files
        $check_duplicate = $conn->prepare("SELECT * FROM files WHERE filename = ?");
        $check_duplicate->bind_param("s", $filename);
        $check_duplicate->execute();
        $result = $check_duplicate->get_result();
        
        if ($result->num_rows > 0) {
            // File exists, overwrite or alert user
            if (isset($_POST['overwrite']) && $_POST['overwrite'] == 'true') {
                move_uploaded_file($file_tmp, "uploads/" . $filename);
                $update_file = $conn->prepare("UPDATE files SET filesize = ?, upload_time = CURRENT_TIMESTAMP WHERE filename = ?");
                $update_file->bind_param("is", $filesize, $filename);
                $update_file->execute();
                echo json_encode(["status" => "success", "message" => "File overwritten successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "File already exists."]);
            }
        } else {
            // No duplicate, proceed with upload
            move_uploaded_file($file_tmp, "uploads/" . $filename);
            $insert_file = $conn->prepare("INSERT INTO files (filename, filesize) VALUES (?, ?)");
            $insert_file->bind_param("si", $filename, $filesize);
            $insert_file->execute();
            echo json_encode(["status" => "success", "message" => "File uploaded successfully."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to upload file."]);
    }
}

$conn->close();
?>
