<?php
include 'includes/auth.php';
include 'config.php';

$id = intval($_GET['id']);
$res = $conn->query("SELECT filename FROM files WHERE id = $id");
if ($res->num_rows) {
    $row = $res->fetch_assoc();
    unlink("uploads/" . $row['filename']);
    $conn->query("DELETE FROM files WHERE id = $id");
}
header("Location: dashboard.php");
?>
