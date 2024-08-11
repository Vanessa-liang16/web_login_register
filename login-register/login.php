<?php
session_start();
require_once "database.php";

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        
        if ($user) {
            if (password_verify($password, $user["password"])) {
               
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["full_name"] = $user["full_name"];
            
                
                if ($email === 'Admin@gmail.com') {
                    
                    header("Location: Admin.php");
                    
                } else {
                    
                    header("Location: index.php");
                    
                }
                exit();
                
            } else {
                $error = "Password does not match";
            }
        } else {
            $error = "Email does not match";
        }
        mysqli_stmt_close($stmt);
    } else {
        $error = "Failed to prepare the SQL statement";
    }
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <form action="login.php" method="post">
            <div><h2>Login<h2></div>
            <div class="form-group">
                <input type="email" placeholder="Enter Email:" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter Password:" name="password" class="form-control" required>
            </div>
            <div class="form-bnt">
                <input type="submit" name="login" value="Login" class="btn btn-primary">
                <a href="registration.php">Don't have Account? Go to register</a>
            </div>
        </form>
        <?php if (isset($error)) { echo "<p class='text-danger'>$error</p>"; } ?>
    </div>
</body>
</html>
