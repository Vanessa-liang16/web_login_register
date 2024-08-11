<?php
session_start();
if(isset($_SESSION["user"])){
    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <div><h2>Register<h2></div>
        <?php
        #print_r($_POST);
        if(isset($_POST["submit"])){
            $fullName = isset($_POST["full_name"]) ? $_POST["full_name"] : '';
            $email = isset($_POST["email"]) ? $_POST["email"] : '';
            $password = isset($_POST["password"]) ? $_POST["password"] : '';
            $passwordRepeat = isset($_POST["repeat_password"]) ? $_POST["repeat_password"] : '';
            $gender = isset($_POST["gender"]) ? $_POST["gender"] : '';
            $color = isset($_POST["color"]) ? $_POST["color"] : '';
            
            $passwordHash=password_hash($password,PASSWORD_DEFAULT);

            $errors=array();

            if (empty($fullName) || empty($email) || empty($password) || empty($passwordRepeat) || empty($gender) || empty($color)) {
                array_push($errors, "All fields are required");
            }
            require_once "database.php";
            $sql="SELECT * FROM users WHERE email='$email'";
            $result=mysqli_query($conn,$sql);
            $rowCount=mysqli_num_rows($result);
            if($rowCount>0){
                array_push($errors,"Email Already exists!  <a href='login.php'>Login here</a>");
                
            }

            if(count($errors)>0){
                foreach($errors as $error){
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            }else{
                //insert the data into database
                require_once "database.php";
                $passwordHash = password_hash($password, PASSWORD_DEFAULT); // Encrypt the password
                $sql="INSERT INTO users (full_name,	email,password,gender,color) VALUES ( ?, ?, ?, ?, ? )";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt=mysqli_stmt_prepare($stmt,$sql);
                if($prepareStmt){
                    mysqli_stmt_bind_param($stmt,"sssss",$fullName,$email,$passwordHash,$gender,$color);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'>You are Register successfully.</div>";
                    header("Location: login.php");
                    
                }else{
                    die("something went wrong");
                }
            }
        }
        ?>
        <form action="registration.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="full_name" placeholder="Full Name:">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password:">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="repeat_password" placeholder="Repeat Password:">
            </div>
            <div class="form-group">
                <select class="form-control" name="gender" id="gender">
                    <option value="" disabled selected>Select gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" name="color" id="color">
                    <option value="" disabled selected>Select your favorite color</option>
                    <option value="red">Red</option>
                    <option value="green">Green</option>
                    <option value="blue">Blue</option>
                    <option value="yellow">Yellow</option>
                    <option value="black">Black</option>
                    <option value="white">White</option>
                </select>
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
                <a href="login.php">Already have Account? Go to Login</a>
            </div>
        </form>
    </div>
</body>
</html>