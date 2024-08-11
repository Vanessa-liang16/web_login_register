<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fileManage";

$conn = new mysqli($servername, $username, $password, $dbname);
header('Content-Type: application/json');

if ($conn->connect_error) {
    $error_message = "Connection failed: " . $conn->connect_error;
    $json_response = '{"status": "error", "message": "' . $error_message . '"}';
    echo $json_response;
    exit();
}

$sql = "SELECT filename, filesize, upload_time FROM files";
$result = $conn->query($sql);

$files = [];
while ($row = $result->fetch_assoc()) {
    $files[] = $row;
}

$json_response = '{"files": [';
$file_count = count($files);
for ($i = 0; $i < $file_count; $i++) {
    $json_response .= '{';
    $json_response .= '"filename": "' . $files[$i]['filename'] . '", ';
    $json_response .= '"filesize": ' . $files[$i]['filesize'] . ', ';
    $json_response .= '"upload_time": "' . $files[$i]['upload_time'] . '"';
    $json_response .= '}';
    if ($i < $file_count - 1) {
        $json_response .= ', ';
    }
}
$json_response .= ']}';

echo $json_response;

$conn->close();
?>


