<?php
require_once "database.php";

$query = isset($_GET['query']) ? trim($_GET['query']) : '';
$logs = [];

if ($query) {
    $query = '%' . $query . '%';
    $sql = "SELECT member_name, execution_time, record FROM logs WHERE member_name LIKE ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)) {
            $logs[] = $row;
        }
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($logs);
?>
