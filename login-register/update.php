<?php
require_once('database.php');

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $color = $_POST['color'];

    $sql = "UPDATE users SET full_name=?, gender=?, email=?, color=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssi', $full_name, $gender, $email, $color, $id);

    if (mysqli_stmt_execute($stmt)) {
        // 更新成功后，可以重定向到其他页面
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
