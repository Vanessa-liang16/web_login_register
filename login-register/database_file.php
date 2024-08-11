<?php

$hostName="localhost";
$dbUser="root";
$dbPassword="";
$dbName="fileManage";

$conn=mysqli_connect($hostName,$dbUser,$dbPassword,$dbName);
if(!$conn){
    die("something went wrong;");
}

try {
    $pdo = new PDO("mysql:host=$hostName;dbname=$dbName", $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

?>




