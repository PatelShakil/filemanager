<?php
include 'includes/auth.php';
include 'config.php';

$title = trim($_POST['title']);
$target_dir = "uploads/";
$file = $_FILES['file'];
$filename = basename($file["name"]);
$category = trim($_POST['category']);
$target_file = $target_dir . $filename;

if (move_uploaded_file($file["tmp_name"], $target_file)) {
    $stmt = $conn->prepare("INSERT INTO files (title, filename,category) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $filename,$category);
    $stmt->execute();
    header("Location: dashboard.php");
} else {
    echo "Error uploading file.";
}
?>
