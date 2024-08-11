<?php
require_once('database.php');

if (isset($_GET['full_name'])) {
    $full_name = $_GET['full_name'];

    $sql = "SELECT * FROM users WHERE full_name=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $full_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);


    mysqli_stmt_close($stmt);
}

mysqli_close($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit information</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Edit</h2>
        <?php if ($user): ?>
        <form action="update.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">

            <div class="form-group">
                <input type="text" class="form-control" name="full_name" placeholder="Full Name" value="<?php echo htmlspecialchars($user['full_name']); ?>">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo htmlspecialchars($user['email']); ?>">
            </div>
            <div class="form-group">
                <select class="form-control" name="gender" id="gender">
                    <option value="" disabled>Select gender</option>
                    <option value="male" <?php if ($user['gender'] == 'male') echo 'selected'; ?>>Male</option>
                    <option value="female" <?php if ($user['gender'] == 'female') echo 'selected'; ?>>Female</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" name="color" id="color">
                    <option value="" disabled>Select your favorite color</option>
                    <option value="red" <?php if ($user['color'] == 'red') echo 'selected'; ?>>Red</option>
                    <option value="green" <?php if ($user['color'] == 'green') echo 'selected'; ?>>Green</option>
                    <option value="blue" <?php if ($user['color'] == 'blue') echo 'selected'; ?>>Blue</option>
                    <option value="yellow" <?php if ($user['color'] == 'yellow') echo 'selected'; ?>>Yellow</option>
                    <option value="black" <?php if ($user['color'] == 'black') echo 'selected'; ?>>Black</option>
                    <option value="white" <?php if ($user['color'] == 'white') echo 'selected'; ?>>White</option>
                </select>
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Update" name="submit">
            </div>
        </form>
        <?php else: ?>
            <p>No user found.</p>
        <?php endif; ?>
    </div>
</body>
</html>