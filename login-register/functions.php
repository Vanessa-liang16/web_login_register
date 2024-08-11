<?php
require_once 'database.php';
function display_data(){
    global $conn;
    $query="SELECT full_name,gender,email,color FROM users";
    $result=mysqli_query($conn,$query);

    return $result;
}

?>