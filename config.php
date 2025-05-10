<?php
$host = 'localhost';
$db = 'filemanager';
// $user = 'filemanager_admin';
// $pass = '_WvBfm(i_p1$'; // Your MySQL password
$user = 'root';
$pass = 'shakil'; // Your MySQL password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    // echo "Connected successfully";
    // You can uncomment the above line for debugging purposes
    // but remember to remove it in production code
}
?>
